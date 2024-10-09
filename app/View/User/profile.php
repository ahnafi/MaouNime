<?php
?>

<div>
  hello <?= $model['user']['name'] ?? ''?>
  <a href="/users/update">update profile</a>
  <a href="/users/password">update password</a>
  <a href="/users/logout">logout</a>
  <a href="/">home</a>
</div>
