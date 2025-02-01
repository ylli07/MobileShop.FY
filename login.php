<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
    <script>
        function validateForm(event) {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var usernamePattern = /^[a-zA-Z0-9]+$/;
            var passwordPattern = /^[a-zA-Z0-9]+$/;
            
            if (!usernamePattern.test(username)) {
                alert("Username mund të përmbajë vetëm shkronja dhe numra.");
                event.preventDefault(); 
                return false;
            }
            
            if (!passwordPattern.test(password)) {
                alert("Password mund të përmbajë vetëm shkronja dhe numra.");
                event.preventDefault(); 
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="klasa-login">
        <h1>Login</h1>
        <?php if(isset($_GET['error'])): ?>
            <p class="error">Username ose password i gabuar!</p>
        <?php endif; ?>
        <form action="login_process.php" method="POST" onsubmit="return validateForm(event)">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Shkruani username-in" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Shkruani password-in" required>
            
            <button type="submit">Login</button>
            <p class="signup-link">Nuk keni një llogari? <a href="signup.php">Regjistrohu</a></p>
        </form>
    </div>
</body>
</html>


