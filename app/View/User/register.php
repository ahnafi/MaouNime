
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

