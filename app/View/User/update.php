<?php if(isset($model['error'])) : ?>
    <div>
        <?= $model['error']; ?>
    </div>
<?php endif; ?>
<div>
    <form method="post"  action="/users/update">
        <input type="text" name="id" placeholder="id" disabled value="<?= $model['user']['id'] ?? '' ?>" >
        <input type="text" name="name" placeholder="name" value="<?= $model['user']['name'] ?? '' ?>">
        <button type="submit">update</button>
    </form>
</div>
