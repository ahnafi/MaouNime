<link rel="stylesheet" href="profile.css">
<?php
$user = $model['user'] ?? [];

include_once __DIR__ . "/../Components/navbar.php";
?>

<<<<<<< HEAD
<div class="container-fluid">
    <div class="row px-5 py-5">
        <div class="col-md-6 col-12 d-flex justify-content-center px-3 align-items-center py-lg-5">
            <form method="post" action="/users/update" class="col-lg-8 col-md-10">
                <h1 class="display-5 mb-3">
                    Profile</h1>
                <p class="lead mb-4">Welcome to your profile page! </p>
                <div class="form-floating mb-3">
                    <input type="text" id="username" class="form-control" name="id" placeholder="Username"
                           value="<?= $user['id'] ?>" readonly>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="name"
                           value="<?= $user['name'] ?>">
                    <label for="name">Name</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Update</button>
                </div>
            </form>
        </div>
        <div class="col-md-6 col-12 d-flex justify-content-center px-3 align-items-center py-lg-5">
            <form method="post" action="/users/password" class="col-lg-8 col-md-10">
                <p class="lead mb-4 mt-5">
                    Here, you can update your personal information to
                    ensure your account is always up-to-date and secure.
                </p>
                <div class="form-floating mb-3">
                    <input type="password" required class="form-control" id="password" name="oldPassword"
                           placeholder="Old Password">
                    <label for="password">Old Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" required class="form-control" id="newPassword" name="newPassword"
                           placeholder="Password">
                    <label for="newPassword">New Password</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Update Password</button>
                </div>
            </form>
        </div>
=======
<div class="profile">
    <h2>Profil Account</h2>
    <img src="img2.jpg" alt="">
    <div class="hello">
    Hello <?= $model['user']['name'] ?? '' ?>
    </div>
    <a href="/users/update">update profile</a>
    <a href="/users/password">update password</a>
    <a href="/users/logout">logout</a>
    <a href="/">home</a>
</div>

<div class="container min-vh-100">
    <div class="row">
        <h2>Watchlist</h2>
>>>>>>> 97f0b73d82c6c90c1775fd9e9618fafcb7ccaae5
    </div>
</div>
