
<div>
    halaman login

    <form method="post"
          action="<?= isset($_GET['redirect']) ? '/users/login?redirect=' . $_GET['redirect'] : '/users/login' ?>">
        <input type="text" name="id" placeholder="id" value="<?= $_POST['id'] ?? '' ?>">
        <input type="password" name="password" placeholder="password">
        <button type="submit">login</button>
    </form>
</div>