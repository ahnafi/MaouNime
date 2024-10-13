<?php

$watchlists = $model['watchlist'] ?? [];

?>

<div>
  hello <?= $model['user']['name'] ?? '' ?>
  <a href="/users/update">update profile</a>
  <a href="/users/password">update password</a>
  <a href="/users/logout">logout</a>
  <a href="/">home</a>
</div>

<div class="container">
  <div class="row">
    <h2>
      Watchlist
    </h2>
  </div>
  <?php if (empty($watchlists)): ?>
    <div class="row">
      <p>No watchlist found</p>
    </div>
  <?php else: ?>
    <table class="row">
      <thead class="col-12">
        <tr class="row">
          <th class="col-md-8">Anime</th>
          <th class="col-md-2">Status</th>
          <th class="col-md-2">Action</th>
        </tr>
      </thead>
      <tbody class="col-12">
        <?php foreach ($watchlists as $item): ?>
          <tr class="row my-2">
            <td class="col-md-8 d-flex gap-3">
              <img src="<?= $item->img ?>" alt="<?= $item->animeTitle ?>" width="200">
              <h3>
                <a href="/anime/detail/<?= $item->animeId ?>">
                  <?= $item->animeTitle ?>
                </a>
              </h3>
            </td>
            <td class="col-md-2">
              <form id="watchlistForm-<?= $item->animeId ?>" action="/users/watchlist/update" method="post">
                <select name="status" class="form-select" aria-label="Default select example"
                  onchange="submitForm(<?= $item->animeId ?>)">
                  <option value="watching" <?= $item->status === 'watching' ? 'selected' : '' ?>>Sedang Ditonton</option>
                  <option value="completed" <?= $item->status === 'completed' ? 'selected' : '' ?>>Selesai Ditonton</option>
                  <option value="plan to watch" <?= $item->status === 'plan to watch' ? 'selected' : '' ?>>Akan Ditonton
                  </option>
                </select>
                <input type="hidden" name="animeId" value="<?= $item->animeId ?>">
                <input type="hidden" name="watchListId" value="<?= $item->id ?>">
              </form>
            </td>
            <td class="col-md-2">
              <form action="/users/watchlist/delete" method="post">
                <input type="hidden" name="animeId" value="<?= $item->animeId ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<script>
  function submitForm(animeId) {
    // Submit form yang sesuai berdasarkan animeId
    document.getElementById(`watchlistForm-${animeId}`).submit();
  }
</script>