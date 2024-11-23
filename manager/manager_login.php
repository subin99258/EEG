<?php include '../view/header.php'; ?>

<main style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: calc(100vh - 60px); padding: 20px;">
    <style>
        :root {
            --col1: #FFB448; /* Highlight color */
            --col2: #3C2D4D; /* Form background */
            --col3: #EDEDEA; /* Body background */

            --col11: #FFC77D; /* Hover color */
            --col12: #645D7B; /* Input background */

            --col21: #FFD8A2;
            --col22: #8D879B;

            --text: var(--col1); /* Text color */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--col3);
            margin: 0;
            padding: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: var(--col2);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: var(--text);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form label {
            color: var(--text);
            font-size: 14px;
        }

        form input[type="text"], 
        form input[type="password"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid var(--col11);
            background-color: var(--col12);
            font-size: 14px;
            width: 100%;
        }

        form input[type="submit"] {
            background-color: var(--col1);
            color: var(--col2);
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
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
        }

        .valid-message {
            color: green;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            form input[type="text"], 
            form input[type="password"] {
                font-size: 14px;
            }

            form input[type="submit"] {
                font-size: 14px;
            }
        }
    </style>

    
    <!-- Container for the login form -->
    <div class="login-container">
        <h1>Manager Login</h1>

        <!-- Login Form -->
        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" value="manager_login">

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Enter your email" required>
            <span id="email-error" class="error-message"></span>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <span id="password-error" class="error-message"></span>

            <input type="submit" value="Login">
        </form>
    </div>
</main>

<?php include '../view/footer.php'; ?>
