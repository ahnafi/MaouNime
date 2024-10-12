<?php

$anime = $model['anime']['data'] ?? [];
$comments = $model['comments'] ?? [];

// navbar taruh di awal php biar gak error
include_once __DIR__ . "/../Components/navbar.php";
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
      <p><strong>Score:</strong> <?= $anime['score'] ?></p>
      <p><strong>Synopsis:</strong> <?= $anime['synopsis'] ?></p>

      <!-- Watchlist Button -->
      <form action="/watchlist/add" method="POST">
        <input type="hidden" name="anime_id" value="<?= $anime['mal_id'] ?>">
        <button type="submit" class="btn btn-primary">Add to Watchlist</button>
      </form>

      <!-- Comments Section -->
      <div class="mt-4">
        <h4>Comments</h4>
          <form action="/anime/comment" method="POST" class="mb-3" onsubmit="return validateComment()">
              <!-- Hidden input for anime ID -->
              <input type="hidden" name="animeId" value="<?= htmlspecialchars($anime['mal_id'], ENT_QUOTES, 'UTF-8') ?>">

              <!-- Hidden input for anime title -->
              <input type="hidden" name="animeTitle" value="<?= htmlspecialchars($anime['title'], ENT_QUOTES, 'UTF-8') ?>">

              <div class="form-group">
                  <label for="comment">Add a Comment:</label>
                  <textarea class="form-control" id="comment" name="comment" rows="3" maxlength="500" required></textarea>
              </div>

              <button type="submit" class="btn btn-secondary">Submit Comment</button>
          </form>


          <!-- Display Existing Comments -->
        <?php if (!empty($comments)): ?>
          <ul class="list-group">
            <?php foreach ($comments as $comment): ?>
              <li class="list-group-item d-flex justify-content-between">
                  <p>
                <strong><?= htmlspecialchars($comment->userId) ?>:</strong>
                <?= htmlspecialchars($comment->comment) ?> </p>
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