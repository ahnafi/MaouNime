<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-12 d-flex justify-content-center px-3 min-vh-100 align-items-center">
            <form method="post"
                  action="<?= isset($_GET['redirect']) ? '/users/login?redirect=' . $_GET['redirect'] : '/users/login' ?>"
                  class="col-lg-8 col-md-10">
                <h1 class="display-5 mb-3">Login</h1>
                <p class="lead mb-4">Welcome Back!</p>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="id" placeholder="Username"
                           value="<?= $_POST['id'] ?? '' ?>">
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">login</button>
                </div>
                <div class="text-center mb-3">
                    <p class="small">Don't have account?
                        <a href="/users/register" class="register-link">Register Now</a>
                    </p>
                </div>

                <div class="text-center">
                    <p class="terms-text">
                        By using MaoNime, you agree to our Privacy Policy and Terms of Use.
                        <br>Copyright © 2024 MaoNime All rights reserved.
                    </p>
                </div>
            </form>
        </div>
        <div class="col-md-6 d-none d-md-block p-3 px-5 align-content-center">
            <img src="/images/login.webp" alt="image of frieren party" class="img-fluid rounded-4">
        </div>
    </div>
</div>

<style>
    .terms-text {
        font-size: 12px;
        color: #888;
    }
</style>