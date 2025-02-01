<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Form</title>
    <link rel="stylesheet" href="login.css">
    <script>
        function validateForm(event) {
            var fullname = document.getElementById('fullname').value;
            var email = document.getElementById('email').value;
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var confirm_password = document.getElementById('confirm_password').value;

            var fullnamePattern = /^[a-zA-Z\s]+$/;
            var usernamePattern = /^[a-zA-Z0-9]+$/;
            var passwordPattern = /^[a-zA-Z0-9]+$/;

            if (!fullnamePattern.test(fullname)) {
                alert("Emri mund të përmbajë vetëm shkronja dhe hapësira.");
                event.preventDefault();
                return false;
            }

            if (!email) {
                alert("Ju lutem shkruani një email të vlefshëm.");
                event.preventDefault();
                return false;
            }

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

            if (password !== confirm_password) {
                alert("Passwordet nuk përputhen!");
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="klasa-login">
        <h1>Regjistrohu</h1>
        <form action="register_process.php" method="POST" onsubmit="return validateForm(event)">
            <label for="fullname">Emri i plotë</label>
            <input type="text" id="fullname" name="fullname" placeholder="Shkruani emrin e plotë" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Shkruani email-in" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Zgjidhni një username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Krijoni një password" required>

            <label for="confirm_password">Konfirmo Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Rishkruani password-in" required>

            <button type="submit">Regjistrohu</button>
            <p class="login-link">Keni një llogari? <a href="login.html">Login</a></p>
        </form>
    </div>
</body>
</html>