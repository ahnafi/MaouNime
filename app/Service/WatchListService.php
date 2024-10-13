<?php 

namespace MoView\Service;

use MoView\Config\Database;
use MoView\Domain\Anime;
use MoView\Exception\ValidationException;
use MoView\Model\UserCreateWatchListRequest;
use MoView\Model\UserCreateWatchListResponse;
use MoView\Model\UserDeleteWatchlistRequest;
use MoView\Model\UserProfileWatchlistRequest;
use MoView\Model\UserProfileWatchlistResponse;
use MoView\Model\UserUpdateWatchlistRequest;
use MoView\Model\UserUpdateWatchlistResponse;
use MoView\Repository\AnimeRepository;
use MoView\Repository\UserRepository;
use MoView\Repository\WatchListRepository;
use MoView\Domain\WatchList;

class WatchListService {
    public WatchListRepository $watchListRepository;
    public AnimeRepository $animeRepository;
    public UserRepository $userRepository;

    public function __construct(WatchListRepository $watchListRepository,AnimeRepository $animeRepository,UserRepository $userRepository)
    {
        $this->watchListRepository = $watchListRepository;
        $this->animeRepository = $animeRepository;
        $this->userRepository = $userRepository;
    }

    public function createWatchList(UserCreateWatchListRequest $request): UserCreateWatchListResponse {
        $this->validateUserCreateWatchListRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->userId);

            if ($user == null) {
              throw new ValidationException('User not found');
            }

            $anime = $this->animeRepository->findById($request->animeId);

            if($this->watchListRepository->getWatchListByUserIdAndAnimeId($request->userId, $request->animeId)){
                throw new ValidationException('Anime already in watchlist');
            }

            if ($anime == null) {
                $anime = new Anime();
                $anime->id = $request->animeId;
                $anime->title = $request->animeTitle;
                $this->animeRepository->save($anime);
            }

            $watchList = new WatchList();
            $watchList->userId = $user->id;
            $watchList->animeId = $anime->id;
            $watchList->status = $request->status;
            $watchList->img = $request->img;

            $watchList = $this->watchListRepository->save($watchList);

            $response = new UserCreateWatchListResponse();
            $response->watchList = $watchList;
            Database::commitTransaction();
            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validateUserCreateWatchListRequest(UserCreateWatchListRequest $request):void {
        if(empty($request->userId) || empty($request->animeId) || empty($request->status) || empty($request->img)) {
            throw new ValidationException("error cannot add watchlist");
        }
    }

    public function fetchUserWatchlist(UserProfileWatchlistRequest $request): ?UserProfileWatchlistResponse {
        $this->validateWatchlistRequest($request);
    
        $watchlistItems = $this->watchListRepository->getWatchListByUserId($request->userId);
        
        if (!$watchlistItems) {
            return null;
        }
    
        $watchlistData = [];
        
        foreach ($watchlistItems as $item) {
            $anime = $this->animeRepository->findById($item->animeId);
            $item->animeTitle = $anime->title;
            $watchlistData[] = $item;
        }
    
        $response = new UserProfileWatchlistResponse();
        $response->watchList = $watchlistData;
        
        return $response;
    }
    
    private function validateWatchlistRequest(UserProfileWatchlistRequest $request): void {
        if (empty($request->userId)) {
            throw new ValidationException("User ID is required to fetch the watchlist.");
        }
    }
    

    public function updateWatchList(UserUpdateWatchlistRequest $request):UserUpdateWatchlistResponse {
        $this->validateUserUpdateWatchListRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->userId);

            if ($user == null) {
              throw new ValidationException('User not found');
            }

            $anime = $this->animeRepository->findById($request->animeId);

            if ($anime == null) {
                throw new ValidationException('Anime not found');
            }

            $watchList = $this->watchListRepository->getWatchListByUserIdAndAnimeId($user->id, $anime->id);

            if ($watchList == null) {
                throw new ValidationException('Watchlist not found');
            }

            $watchList->status = $request->status;

            $this->watchListRepository->updateStatus($watchList->status,$watchList->id);

            $response = new UserUpdateWatchlistResponse();
            $response->watchList = $watchList;
            Database::commitTransaction();
            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validateUserUpdateWatchListRequest(UserUpdateWatchlistRequest $request):void {
        if(empty($request->userId) || empty($request->animeId) || empty($request->status) || empty($request->watchListId)) {
            throw new ValidationException("error cannot update watchlist");
        }
    }

    public function deleteWatchList(UserDeleteWatchlistRequest $request): void {
        try {
            Database::beginTransaction();

            if ($this->animeRepository->findById($request->animeId) == null) {
                throw new ValidationException('Anime not found');
            }

            $watchList = $this->watchListRepository->getWatchListByUserIdAndAnimeId($request->userId, $request->animeId);

            if ($watchList == null) {
                throw new ValidationException('Watchlist not found');
            }
            
            $this->watchListRepository->deleteById($watchList->id);
            Database::commitTransaction();
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function deleteAllWatchList(): void {
        $this->watchListRepository->deleteAll();
    }
}