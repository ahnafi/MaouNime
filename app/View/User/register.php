<?php

use MoView\App\Flasher;
Flasher::FLASH();

?>
<div>
    halaman register

    <form method="post"  action="/users/register">
        <input type="text" name="id" placeholder="id" value="<?= $_POST['id'] ?? '' ?>" >
        <input type="text" name="name" placeholder="name" value="<?= $_POST['name'] ?? '' ?>">
        <input type="password" name="password" placeholder="password">
        <button type="submit">register</button>
    </form>
</div>