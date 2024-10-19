<?php

use MoView\App\Flasher;

$anime = $model['anime']['data'] ?? [];
$comments = $model['comments'] ?? [];
$rating = $model['rating']->rating ?? null;
$score = $model['rating']->score ?? null;
$localScore = $rating->rating ?? 0;

// navbar taruh di awal php biar gak error
include_once __DIR__ . "/../Components/navbar.php";

Flasher::FLASH();
?>

<div class="container mt-5">

    <?php if (isset($model['anime']["status"])): ?>

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error</strong> Anime is not found.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <!-- Poster Anime -->
            <img src="<?= $anime['images']['webp']['large_image_url'] ?>" alt="<?= $anime['title'] ?>"
                 class="img-fluid rounded">
        </div>
        <div class="col-md-8">
            <!-- Detail Anime -->
            <h2><?= $anime['title'] ?></h2>
            <p><strong>Type:</strong> <?= $anime['type'] ?></p>
            <p><strong>Status:</strong> <?= $anime['status'] ?></p>
            <p><strong>Episodes:</strong> <?= $anime['episodes'] ?></p>
            <p><strong>Global Score:</strong> <?= $anime['score'] ?></p>
            <p><strong>Score:</strong> <?= $score ?? '0' ?></p>
            <p><strong>Synopsis:</strong> <?= $anime['synopsis'] ?></p>

            <?php if (isset($model['user'])) : ?>
                <div class="d-flex gap-3">
                    <!-- Watchlist Button -->
                    <form action="/anime/watchlist" method="POST">
                        <input type="hidden" name="animeId" value="<?= $anime['mal_id'] ?>">
                        <input type="hidden" name="img" value="<?= $anime['images']['webp']['image_url'] ?>">
                        <input type="hidden" name="animeTitle" value="<?= $anime['title'] ?>">
                        <button type="submit" class="btn btn-primary">Add to Watchlist</button>
                    </form>

                    <form action="/anime/rating" method="post" id="ratingForm" class="col-2">
                        <select name="rating" class="form-select" aria-label="Default select example"
                                onchange="submitRatingForm()">
                            <option value="10" <?= $localScore === 10 ? 'selected' : '' ?>>10</option>
                            <option value="9" <?= $localScore === 9 ? 'selected' : '' ?>>9</option>
                            <option value="8" <?= $localScore === 8 ? 'selected' : '' ?>>8</option>
                            <option value="7" <?= $localScore === 7 ? 'selected' : '' ?>>7</option>
                            <option value="6" <?= $localScore === 6 ? 'selected' : '' ?>>6</option>
                            <option value="5" <?= $localScore === 5 ? 'selected' : '' ?>>5</option>
                            <option value="4" <?= $localScore === 4 ? 'selected' : '' ?>>4</option>
                            <option value="3" <?= $localScore === 3 ? 'selected' : '' ?>>3</option>
                            <option value="2" <?= $localScore === 2 ? 'selected' : '' ?>>2</option>
                            <option value="1" <?= $localScore === 1 ? 'selected' : '' ?>>1</option>
                            <?php if ($localScore == 0) : ?>
                                <option value="0" selected>0</option>
                            <?php endif; ?>
                        </select>
                        <input type="hidden" name="animeId" value="<?= $anime["mal_id"] ?>">
                        <input type="hidden" name="animeTitle" value="<?= $anime["title"] ?>">
                    </form>
                </div>
            <?php endif; ?>
            <!-- Comments Section -->
            <div class="mt-4">
                <h4>Comments</h4>
                <?php if (isset($model['user'])) : ?>
                    <form action="/anime/comment" method="POST" class="mb-3" onsubmit="return validateComment()">
                        <!-- Hidden input for anime ID -->
                        <input type="hidden" name="animeId"
                               value="<?= htmlspecialchars($anime['mal_id'], ENT_QUOTES, 'UTF-8') ?>">

                        <!-- Hidden input for anime title -->
                        <input type="hidden" name="animeTitle"
                               value="<?= htmlspecialchars($anime['title'], ENT_QUOTES, 'UTF-8') ?>">

                        <div class="form-group ">
                            <label for="comment">Add a Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" maxlength="500"
                                      required></textarea>
                        </div>

                        <button type="submit" class="btn btn-secondary my-2">Submit Comment</button>
                    </form>
                <?php endif; ?>

                <!-- Display Existing Comments -->
                <?php if (!empty($comments)): ?>
                    <ul class="list-group">
                        <?php foreach ($comments as $comment): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <p>
                                    <strong><?= htmlspecialchars($comment->userId) ?>:</strong>
                                    <?= htmlspecialchars($comment->comment) ?>
                                </p>
                                <span><?= $comment->commentedAt ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function submitRatingForm() {
        document.getElementById('ratingForm').submit();
    }

    function validateComment() {
        const commentField = document.getElementById('comment');
        const commentLength = commentField.value.length;

        if (commentLength > 500) {
            alert('Comment cannot exceed 500 characters.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>