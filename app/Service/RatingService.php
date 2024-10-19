<?php

namespace MoView\Service;
use MoView\Config\Database;
use MoView\Domain\Anime;
use MoView\Domain\Rating;
use MoView\Exception\ValidationException;
use MoView\Model\UserGetCurrentRatingRequest;
use MoView\Model\UserGetCurrentRatingResponse;
use MoView\Model\UserRatingAnimeRequest;
use MoView\Repository\AnimeRepository;
use MoView\Repository\RatingRepository;
use MoView\Repository\UserRepository;

class RatingService
{
    public RatingRepository $ratingRepository;
    public UserRepository $userRepository;
    public AnimeRepository $animeRepository;

    public function __construct(RatingRepository $ratingRepository, AnimeRepository $animeRepository, UserRepository $userRepository)
    {
        $this->ratingRepository = $ratingRepository;
        $this->animeRepository = $animeRepository;
        $this->userRepository = $userRepository;
    }

    public function ratingAnime(UserRatingAnimeRequest $request): void
    {
        $this->validateUserRatingAnimeRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->userId);

            if ($user == null) {
                throw new ValidationException('User not found');
            }

            $anime = $this->animeRepository->findById($request->animeId);

            if ($anime == null) {
                $anime = new Anime();
                $anime->id = $request->animeId;
                $anime->title = $request->animeTitle;
                $this->animeRepository->save($anime);
            }

            $rating = new Rating();
            $rating->userId = $user->id;
            $rating->animeId = $anime->id;
            $rating->rating = $request->rating;

            $data = $this->ratingRepository->findRating($rating);

            if ($data == null) {
                $this->ratingRepository->save($rating);
            } else {
                $this->ratingRepository->update($rating);
            }

            Database::commitTransaction();

        } catch (ValidationException $e) {
            //log error
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validateUserRatingAnimeRequest(UserRatingAnimeRequest $request): void
    {
        if (empty($request->animeId || empty($request->userId) || empty($request->rating))) {
            throw new ValidationException("animeId, userId, and rating are required");
        }
    }

    public function currentRating(UserGetCurrentRatingRequest $request): UserGetCurrentRatingResponse
    {
        $this->validateUserGetCurrentRatingRequest($request);

        try {
            // Inisialisasi Rating
            $rating = new Rating();
            $rating->userId = $request->userId;
            $rating->animeId = $request->animeId;

            // Ambil data rating user dan rata-rata rating anime
            $data = $this->ratingRepository->findRating($rating);
            $score = $this->ratingRepository->avgRating($request->animeId);

            // Siapkan response
            $response = new UserGetCurrentRatingResponse();
            $response->rating = $data;
            $response->score = $score;

            return $response;
        } catch (Exception $e) {
            // Log error jika ada
            error_log($e->getMessage());
            throw $e;
        }
    }

    private function validateUserGetCurrentRatingRequest(UserGetCurrentRatingRequest $request): void
    {
        // Pisahkan pengecekan antara animeId dan userId agar lebih jelas
        if (empty($request->animeId)) {
            throw new ValidationException("Anime ID is required");
        }

        if (empty($request->userId)) {
            throw new ValidationException("User ID is required");
        }
    }

}