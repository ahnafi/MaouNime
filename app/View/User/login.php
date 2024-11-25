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

<<<<<<< HEAD
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
=======
    <style>
        /* Custom CSS untuk penyesuaian */
        .login-container {
            min-height: 100vh;
            background-color: rgb(240, 248, 255);
        }

        .login-image {
            object-fit: cover;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            max-height: 100%;
        }

        .custom-input {
            background: #e4e9ec;
            border: none;
            border-radius: 15px;
            transition: 0.3s ease;
        }

        .custom-input:focus {
            background-color: transparent;
            border: 1px solid #1503b3;
        }

        .custom-btn {
            background: #1503b3;
            border: none;
            border-radius: 15px;
            transition: 0.3s ease;
        }

        .custom-btn:hover {
            background-color: transparent;
            border: 2px solid #1503b3;
            color: #1503b3;
        }

        .register-link {
            color: #1503b3;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .terms-text {
            font-size: 12px;
            color: #888;
        }

        @media (max-width: 768px) {
            .login-image {
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
                border-top-right-radius: 0;
                box-shadow: 0px 6px 10px rgba(62, 62, 62, 0.2);
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row login-container">
            <div class="col-md-6 d-none d-md-block p-0 max-vh-100">
                <img src="/images/img1.jpg" alt="Login Image" class="img-fluid login-image w-100">
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="login-box w-75">
                    <h1 class="display-5 mb-3">Login</h1>
                    <p class="lead mb-4">Welcome Back!</p>
                    
                    <form method="post" 
                          action="<?= isset($_GET['redirect']) ? '/users/login?redirect=' . $_GET['redirect'] : '/users/login' ?>">
                        <div class="mb-3">
                            <input type="text" 
                                   name="id" 
                                   class="form-control custom-input" 
                                   placeholder="Enter your username" 
                                   value="<?= $_POST['id'] ?? '' ?>" 
                                   required>
                        </div>
                        <div class="mb-3">
                            <input type="password" 
                                   name="password" 
                                   class="form-control custom-input" 
                                   placeholder="Enter your password" 
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 custom-btn mb-3">Login</button>
                    </form>
                    
                    <div class="text-center mb-3">
                        <p class="small">Don't have account? <a href="/users/register" class="register-link">Register Now</a></p>
                    </div>
                    
                    <div class="text-center">
                        <p class="terms-text">
                            By using MaoNime, you agree to our Privacy Policy and Terms of Use.
                            <br>Copyright © 2024 MaoNime All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

>>>>>>> 97f0b73d82c6c90c1775fd9e9618fafcb7ccaae5
