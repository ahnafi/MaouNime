<?php

namespace MoView\Service;

use MoView\Config\Database;
use MoView\Domain\Anime;
use MoView\Domain\Comment;
use MoView\Exception\ValidationException;
use MoView\Model\UserCommentAnimeRequest;
use MoView\Model\UserDeleteCommentRequest;
use MoView\Repository\AnimeRepository;
use MoView\Repository\CommentRepository;
use MoView\Repository\UserRepository;

class CommentService
{
    public CommentRepository $commentRepository;
    public UserRepository $userRepository;
    public AnimeRepository $animeRepository;

    public function __construct(CommentRepository $commentRepository, UserRepository $userRepository, AnimeRepository $animeRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->animeRepository = $animeRepository;
    }

    public function createComment(UserCommentAnimeRequest $commentRequest): void
    {
        $this->validateUserCommentAnimeRequest($commentRequest);

        try {
            Database::beginTransaction();

            // Cek apakah user ada di database
            $user = $this->userRepository->findById($commentRequest->userId);
            if ($user == null) {
                throw new ValidationException('User not found');
            }

            // Cek apakah anime sudah ada di database
            $anime = $this->animeRepository->findById($commentRequest->animeId);
            if ($anime == null) {
                // Jika anime belum ada, simpan anime baru
                $anime = new Anime();
                $anime->id = $commentRequest->animeId;
                $anime->title = $commentRequest->animeTitle;
                $this->animeRepository->save($anime);
            }

            // Buat komentar baru
            $comment = new Comment();
            $comment->comment = $commentRequest->comment;
            $comment->userId = $user->id;
            $comment->animeId = $anime->id;
            $comment->commentedAt = $commentRequest->commentedAt;

            // Simpan komentar
            $this->commentRepository->save($comment);

            Database::commitTransaction();
        } catch (\Exception $err) {
            Database::rollbackTransaction();
            throw $err; // Lempar kembali exception jika ada error
        }
    }

    private function validateUserCommentAnimeRequest(UserCommentAnimeRequest $commentRequest): void
    {
        // Validasi comment
        if (empty(trim($commentRequest->comment))) {
            throw new ValidationException("Comment cannot be empty");
        }

        // Validasi userId
        if (empty($commentRequest->userId)) {
            throw new ValidationException("User ID cannot be null");
        }

        // Validasi animeId
        if (empty($commentRequest->animeId) || trim($commentRequest->animeId) == "") {
            throw new ValidationException("Anime ID cannot be empty");
        }

        // Validasi animeTitle (opsional, jika ingin memvalidasi title)
        if (empty($commentRequest->animeTitle) || trim($commentRequest->animeTitle) == "") {
            throw new ValidationException("Anime title cannot be empty");
        }

        if (strlen($commentRequest->comment) > 500) {
            throw new ValidationException("Comment cannot be longer than 500 characters");
        }
    }

    public function getCommentByAnimeId(int $animeId): ?array
    {
        // Validasi ID anime
        $this->validateAnimeId($animeId);

        // Ambil komentar dari repository
        $comments = $this->commentRepository->getCommentByAnimeId($animeId);

        // Jika tidak ada komentar, kembalikan null
        if (empty($comments)) {
            return null;
        }

        return $comments;
    }

    private function validateAnimeId(int $animeId): void
    {
        if ($animeId <= 0) {
            throw new ValidationException("Invalid Anime ID");
        }
    }

    public function deleteComment(UserDeleteCommentRequest $request): void
    {
        $this->validateUserDeleteCommentRequest($request);

        try {

            Database::beginTransaction();

            // Mencari user berdasarkan ID
            $user = $this->userRepository->findById($request->userId);

            // Jika user tidak ditemukan
            if ($user == null) {
                throw new ValidationException('User not found');
            }

            // Mencari anime berdasarkan ID
            $anime = $this->animeRepository->findById($request->animeId);

            // Jika anime tidak ditemukan
            if ($anime == null) {
                throw new ValidationException('Anime not found');
            }

            // Mencari komentar berdasarkan ID
            $comment = $this->commentRepository->getCommentById($request->id);

            if($comment == null){
                throw new ValidationException('Comment not found');
            }

            if($comment->userId !== $user->id){
                throw new ValidationException('You can not delete this comment');
            }

            $this->commentRepository->deleteById($request->id);

            Database::commitTransaction();

        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }


    private function validateUserDeleteCommentRequest(UserDeleteCommentRequest $commentRequest): void
    {
        if (empty(trim($commentRequest->userId))) {
            throw new ValidationException("User ID cannot be null");

        }
        if (empty(trim($commentRequest->animeId))) {
            throw new ValidationException("Anime ID cannot be null");
        }

        if (empty($commentRequest->id)) {
            throw new ValidationException("Comment ID cannot be null");
        }
    }


}