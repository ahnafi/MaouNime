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

<<<<<<< HEAD
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
=======
<link rel="stylesheet" href="/style/register.css">
<div class="container">
    <div class="left">
        <div class="login-box">
            <h1>Register</h1>
            <p>Welcome!</p>
            <form id="form-register" method="post" action="/users/register">
                <input type="text" name="id" placeholder="Enter your username" value="<?= $_POST['id'] ?? '' ?>" required>
                <input type="text" name="name" placeholder="Enter your name" value="<?= $_POST['name'] ?? '' ?>" required>
                <input type="password" name="password1" id="password1" placeholder="Enter your password" required>
                <input type="password" name="password2" id="password2" placeholder="Confirm your password" required>
                <button type="submit">Register</button>
            </form>
            <div class="register">
                <p>Already have account? <a href="/users/login">Login</a></p>
            </div>
            <div class="terms">
                <p>By using MaoNime, you agree to our Privacy Policy and Terms of Use.
                <br>Copyright © 2024 MaoNime All rights reserved.</p>
            </div>
        </div>
    </div>
    <div class="right">
        <img src="/images/img2.jpg" alt="">
    </div>  
</div>       
</div>

<script>
document.getElementById("form-register").onsubmit = function(event) {
    var pw1 = document.getElementById("password1").value;
    var pw2 = document.getElementById("password2").value;
    
    if (pw1 !== pw2) {
        alert("Passwords do not match.");
        event.preventDefault();
    }
};
</script>

>>>>>>> 97f0b73d82c6c90c1775fd9e9618fafcb7ccaae5
