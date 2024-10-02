<?php if(isset($model['error'])) : ?>
    <div>
        <?= $model['error']; ?>
    </div>
<?php endif; ?>
<div>
    halaman register

    <form method="post" action="/users/login">
        <input type="text" name="id" placeholder="id" value="<?= $_POST['id'] ?? '' ?>" >
        <input type="password" name="password" placeholder="password">
        <button type="submit">login</button>
    </form>
</div>