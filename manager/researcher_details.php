<?php include '../view/header.php'; ?>
<main>
    <style>
        :root {
            --col1: #FFB448; /* Highlight color */
            --col2: #3C2D4D; /* Form background */
            --col3: #EDEDEA; /* Body background */
            --col11: #FFC77D; /* Hover color */
             /* Input background */
            --col21: #FFD8A2;
            --col22: #8D879B;
            --text-color: var(--col1); /* Text color */
            --button-color: #007BFF; /* Default button color */
            --button-hover-color: #0056b3; /* Button hover color */
        }

        /* Set body and HTML layout */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--col3);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Centering container in main */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            padding: 20px;
        }

        /* Dedicated container for the research details form */
        .research-details-container {
            width: 100%;
            max-width: 600px;
            background-color: var(--col2);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: var(--col21);
        }

        h1 {
            text-align: center;
            color: var(--col1);
            margin-bottom: 20px;
            font-size: 2em;
        }

        /* Form styling */
        form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        label {
            color: var(--col1);
            font-size: 1rem;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid var(--col11);
            background-color: var(--col12);
            color: var(--col1);
            font-size: 1rem;
        }

        button[type="submit"] {
            background-color: var(--col1);
            color: white;
            border: none;
            padding: 15px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        button[type="submit"]:hover {
            background-color: var(--col21);
        }

        ul {
            font-size: 0.9rem;
            color: var(--col21);
            background-color: var(--col12);
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            line-height: 1.5;
        }

        ul li {
            margin-bottom: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .research-details-container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8em;
            }

            input[type="text"], input[type="email"], button[type="submit"] {
                font-size: 1rem;
            }
        }

        /* Footer styling */
        footer {
            padding: 10px;
            background-color: var(--col2);
            color: white;
            text-align: center;
            width: 100%;
        }
    </style>

    <div class="research-details-container">
        <h1>Researcher User Details</h1>
        <form action="." method="post">
            <input type="hidden" name="action" value="update_user">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['userID']); ?>">

            <label>User ID: <?php echo htmlspecialchars($user['userID']); ?></label>

            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user['username']); ?>">

            <label for="res_title">Title:</label>
            <input type="text" id="res_title" name="res_title" value="<?php echo htmlspecialchars($user['resTitle']); ?>">

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['firstName']); ?>">

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['lastName']); ?>">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

            <label for="organisation">Organisation:</label>
            <input type="text" id="organisation" name="organisation" value="<?php echo htmlspecialchars($user['organisation']); ?>">

            <label for="profile">Profile:</label>
            <input type="text" id="profile" name="profile" value="<?php echo htmlspecialchars($user['profile']); ?>">

            <label for="user_role">User Privilege Level:</label>
            <input type="text" id="user_role" name="user_role" value="<?php echo htmlspecialchars($user['userRole']); ?>">

            <ul>
                <li><strong>Note:</strong> User Privilege Levels</li>
                <li>Level 0 - Management user</li>
                <li>Level 1 - Can only view publications and data (cannot upload)</li>
                <li>Level 2 - View and upload publications and data</li>
            </ul>

            <button type="submit">Update</button>
        </form>
    </div>
</main>

<?php include '../view/footer.php'; ?>
