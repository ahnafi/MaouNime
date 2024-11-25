<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 d-none d-md-block p-3 px-5 align-content-center">
            <img src="/images/register.webp" alt="image of Dungeon meshi party" class="img-fluid rounded-4">
        </div>
        <div class="col-md-6 col-12 d-flex justify-content-center px-3 min-vh-100 align-items-center">
            <form method="post" action="/users/register" class="col-lg-8 col-md-10" onsubmit="validatePasswords(event)">
                <h1 class="display-5 mb-3">Register</h1>
                <p class="lead mb-4">Be part of maounime, get lots of features by registering</p>
                <div class="form-floating mb-3">
                    <input type="text" id="username" class="form-control" name="id" placeholder="Username"
                           value="<?= $_POST['id'] ?? '' ?>">
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="name"
                           value="<?= $_POST['name'] ?? '' ?>">
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="verifPassword" name="verifpassword"
                           placeholder="Password">
                    <label for="verifPassword">Verify Password</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Register</button>
                </div>
                <div class="text-center mb-3">
                    <p>Already have account? <a href="/users/login">Login</a></p>
                </div>

                <div class="text-center">
                    <p class="terms-text">
                        By using MaoNime, you agree to our Privacy Policy and Terms of Use.
                        <br>Copyright © 2024 MaoNime All rights reserved.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .terms-text {
        font-size: 12px;
        color: #888;
    }
</style>

<script>
    function validatePasswords(event) {
        const password = document.getElementById('password').value;
        const verifPassword = document.getElementById('verifPassword').value;
        if (password !== verifPassword) {
            Swal.fire("Passwords do not match!");
            event.preventDefault();
        }
    }
</script>