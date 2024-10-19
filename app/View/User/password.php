
<div>
    <form method="post"  action="/users/password">
        <input type="text" name="id" placeholder="id" disabled value="<?= $model['user']['id'] ?? '' ?>" >
        <input type="password" name="oldPassword" placeholder="old password">
        <input type="password" name="newPassword" placeholder="new password" >

        <button type="submit">update</button>
    </form>
</div>
