<?php
function truncate($string, $length = 100, $ellipsis = '...')
{
    if (strlen($string) <= $length) {
        return $string;
    }
    $truncated = substr($string, 0, $length - strlen($ellipsis));
    return $truncated . $ellipsis;
}

$user = $model['user'] ?? [];

$watchlists = $model['watchlist'] ?? [];
include_once __DIR__ . "/../Components/navbar.php";
?>

<!--<div>-->
<!--    hello --><?php //= $model['user']['name'] ?? '' ?>
<!--    <a href="/users/update">update profile</a>-->
<!--    <a href="/users/password">update password</a>-->
<!--    <a href="/users/logout">logout</a>-->
<!--    <a href="/">home</a>-->
<!--</div>-->

<div class="container min-vh-100">
    <div class="row py-4">
        <h2>Watchlist</h2>
    </div>
    <?php if (empty($watchlists)): ?>
        <div class="row">
            <p>No anime in your watchlist yet? <a href="/anime/search?type=tv&order_by=score&sort=desc">Discover new
                    anime to watch!</a></p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Anime</th>
                    <th scope="col">Options</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($watchlists as $item): ?>
                    <tr>
                        <td class="d-flex align-items-lg-start gap-2 flex-wrap flex-lg-nowrap">
                            <img src="<?= $item->img ?>" alt="<?= $item->animeTitle ?>"
                                 class="img-fluid rounded-2" width="150">
                            <a href="/anime/detail/<?= $item->animeId ?>"
                               class="link-body-emphasis text-decoration-none">
                                <p class="h5 d-none d-md-block text-decoration-underline">
                                    <?= truncate($item->animeTitle, 50) ?></p>
                                <p class="d-none d-lg-block pe-3">
                                    <?= truncate($item->synopsis, 200) ?>
                                </p>
                            </a>
                            <a href="/anime/detail/<?= $item->animeId ?>">
                                <p class="d-inline-block d-md-none link-body-emphasis text-decoration-underline">
                                    <?= $item->animeTitle ?>
                                </p>
                            </a>
                        </td>
                        <td class="w-50 ">
                            <div class="d-flex flex-column gap-2">
                                <!-- Dropdown status -->
                                <form id="watchlistForm-<?= $item->animeId ?>" action="/users/watchlist/update"
                                      method="post">
                                    <select name="status" class="form-select form-select-sm"
                                            aria-label="Default select example"
                                            onchange="submitForm(<?= $item->animeId ?>)">
                                        <option value="watching" <?= $item->status === 'watching' ? 'selected' : '' ?>>
                                            Watching
                                        </option>
                                        <option value="completed" <?= $item->status === 'completed' ? 'selected' : '' ?>>
                                            Completed
                                        </option>
                                        <option value="plan to watch" <?= $item->status === 'plan to watch' ? 'selected' : '' ?>>
                                            Plan to Watch
                                        </option>
                                    </select>
                                    <input type="hidden" name="animeId" value="<?= $item->animeId ?>">
                                    <input type="hidden" name="watchListId" value="<?= $item->id ?>">
                                </form>
                                <!-- Tombol Hapus -->
                                <form action="/users/watchlist/delete" method="post"
                                      onsubmit="return handleDelete(event)">
                                    <input type="hidden" name="animeId" value="<?= $item->animeId ?>">
                                    <button type="submit" class="btn btn-danger btn-sm mt-2 px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<style>
    .form-select {
        max-width: fit-content;
    }
</style>
<script>
    function submitForm(animeId) {
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
            return result.isConfirmed;
        });
    }

    async function handleDelete(event) {
        event.preventDefault();
        const confirmed = await alertConfirm();
        if (confirmed) {
            event.target.submit();
        }
    }

</script>
