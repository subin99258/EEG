<?php include '../view/header.php'; ?>
<main>
    <style>
        /* Same CSS as before, using your color scheme */
        :root {
            --col1: #FFB448;
            --col2: #3C2D4D;
            --col3: #EDEDEA;

            --col11: #FFC77D;
            --col12: #645D7B;

            --col21: #FFD8A2;
            --col22: #8D879B;

            --text: var(--col1);
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--col3);
            margin: 0;
            padding: 0;
        }

        main {
            padding: 50px 20px;
            display: flex;
            justify-content: center;
        }

        form {
            background-color: var(--col2);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            color: var(--text);
        }

        form h1 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--text);
        }

        form label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            color: var(--text);
        }

        form input[type="text"], 
        form input[type="password"], 
        form input[type="email"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid var(--col11);
            border-radius: 5px;
            background-color: var(--col12);
            color: var(--text);
        }

        form input[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--col1);
            color: var(--col2);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: var(--col11);
        }

        form input[type="submit"]:active {
            background-color: var(--col12);
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .valid-message {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            form {
                padding: 30px 20px;
            }

            form h1 {
                font-size: 24px;
            }

            form input[type="text"], 
            form input[type="password"], 
            form input[type="email"], 
            form textarea {
                font-size: 14px;
            }

            form input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>

    <script>
        // Password validation while typing
        document.addEventListener("DOMContentLoaded", function() {
            const passwordField = document.querySelector('input[name="password"]');
            const confirmPasswordField = document.querySelector('input[name="password_confirm"]');
            const emailField = document.querySelector('input[name="email"]');
            const errorMessage = document.getElementById('password-error');
            const emailError = document.getElementById('email-error');

            // Validate password match
            confirmPasswordField.addEventListener("input", function() {
                if (passwordField.value !== confirmPasswordField.value) {
                    errorMessage.textContent = "Passwords do not match!";
                    errorMessage.classList.add("error-message");
                } else {
                    errorMessage.textContent = "Passwords match!";
                    errorMessage.classList.remove("error-message");
                    errorMessage.classList.add("valid-message");
                }
            });

            // Validate email format
            emailField.addEventListener("input", function() {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value)) {
                    emailError.textContent = "Invalid email format!";
                    emailError.classList.add("error-message");
                } else {
                    emailError.textContent = "Valid email!";
                    emailError.classList.remove("error-message");
                    emailError.classList.add("valid-message");
                }
            });

            // General password strength validation
            passwordField.addEventListener("input", function() {
                const password = passwordField.value;
                const minLength = password.length >= 12;
                const hasUpper = /[A-Z]/.test(password);
                const hasLower = /[a-z]/.test(password);
                const hasDigit = /[0-9]/.test(password);
                const hasSpecial = /[\W]/.test(password);

                let strengthMessage = "Password must be at least 12 characters, including uppercase, lowercase, digit, and special character.";
                if (minLength && hasUpper && hasLower && hasDigit && hasSpecial) {
                    strengthMessage = "Password is strong!";
                }

                errorMessage.textContent = strengthMessage;
                if (minLength && hasUpper && hasLower && hasDigit && hasSpecial) {
                    errorMessage.classList.remove("error-message");
                    errorMessage.classList.add("valid-message");
                } else {
                    errorMessage.classList.add("error-message");
                    errorMessage.classList.remove("valid-message");
                }
            });
        });
    </script>

    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="add_researcher">

        <h1>Research Registration</h1>

        <label>Username:</label>
        <input type="text" name="user_name" required minlength="3" maxlength="50" placeholder="Enter your username">

        <label>Title:</label>
        <input type="text" name="res_title" required minlength="3" maxlength="100" placeholder="Enter your research title">

        <label>First Name:</label>
        <input type="text" name="first_name" required minlength="2" maxlength="50" placeholder="Enter your first name">

        <label>Last Name:</label>
        <input type="text" name="last_name" required minlength="2" maxlength="50" placeholder="Enter your last name">

        <label>Email:</label>
        <input type="email" name="email" required placeholder="Enter your email address">
        <span id="email-error" class="error-message"></span>

        <label>Password (Min 12 characters including Upper, Lower, Digit, and Special):</label>
        <input type="password" name="password" required minlength="12" placeholder="Enter your password">

        <label>Confirm Password:</label>
        <input type="password" name="password_confirm" required placeholder="Confirm your password">
        <span id="password-error" class="error-message"></span>

        <label>Organisation:</label>
        <input type="text" name="organisation" required minlength="2" maxlength="100" placeholder="Enter your organisation">

        <label>Profile:</label>
        <textarea name="profile" rows="4" cols="50" required placeholder="Enter your profile"></textarea>

        <input type="submit" value="Submit">
    </form>
</main>
<?php include '../view/footer.php'; ?>
