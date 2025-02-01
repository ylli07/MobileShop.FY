<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - F&Y Mobile Shop</title>
    <link rel="stylesheet" href="simple-nav.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        

        .klasa-login {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            margin: 40px auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            color: white;
            font-size: 16px;
            margin-bottom: 5px;
        }

        input {
            padding: 12px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #45a049;
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .login-link {
            text-align: center;
            color: white;
            margin-top: 20px;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        @media screen and (min-width: 1200px) {
            .klasa-login {
                padding: 40px;
                max-width: 500px;
            }

            h1 {
                font-size: 32px;
            }

            input, button {
                padding: 14px;
                font-size: 18px;
            }
        }

        @media screen and (max-width: 768px) {
            .klasa-login {
                width: 95%;
                padding: 25px;
                margin: 30px auto;
            }

            h1 {
                font-size: 26px;
                margin-bottom: 25px;
            }

            input, button {
                padding: 11px;
                font-size: 15px;
            }

            label {
                font-size: 15px;
            }
        }

        @media screen and (max-width: 480px) {
            .klasa-login {
                width: 98%;
                padding: 20px;
                margin: 20px auto;
            }

            h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            form {
                gap: 12px;
            }

            input, button {
                padding: 10px;
                font-size: 14px;
            }

            label {
                font-size: 14px;
            }

            .login-link {
                font-size: 14px;
            }
        }

        @media screen and (max-width: 320px) {
            .klasa-login {
                padding: 15px;
            }

            h1 {
                font-size: 22px;
            }

            input, button {
                padding: 8px;
                font-size: 13px;
            }

            label {
                font-size: 13px;
            }
        }
    </style>
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
    <?php include 'simple-nav.php'; ?>
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
            <p class="login-link">Keni një llogari? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>