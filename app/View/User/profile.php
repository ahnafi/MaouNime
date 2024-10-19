<?php

$watchlists = $model['watchlist'] ?? [];
include_once __DIR__ . "/../Components/navbar.php";
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
              <form action="/users/watchlist/delete" method="post" onsubmit="return handleDelete(event)">
                <input type="hidden" name="animeId" value="<?= $item->animeId ?>">
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg> Remove
                </button>
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

  function alertConfirm() {
      return Swal.fire({
          title: "Perhatian",
          text: "Apakah kamu ingin menghapus Watchlist ini?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Iya",
          cancelButtonText: "Batal"
      }).then((result) => {
          return result.isConfirmed; // Hanya mengembalikan true jika pengguna mengklik "Iya"
      });
  }
  async function handleDelete(event) {
      event.preventDefault(); // Mencegah form submit langsung
      const confirmed = await alertConfirm(); // Tunggu hasil konfirmasi
      if (confirmed) {
          event.target.submit(); // Submit form jika dikonfirmasi
      }
  }

</script>