<?php include '../view/header.php'; ?>
<main>
    <style>
        :root {
     --col1: #FFB448;
            --col2: #3C2D4D;
            --col3: #EDEDEA;

            --col11: #FFC77D;
            --col12: #645D7B;

            --col21: #FFD8A2;
            --col22: #8D879B;

            --text: #D8F3DC;
        }

        /* General Reset and Body Styling */
        * { box-sizing: border-box; margin: 0; padding: 0; }
         body {
            font-family: Arial, sans-serif;
           background-color: var(--col2); /* Changed to var(--col1) for a vibrant background */
        color:  #3C2D4D;
            margin: 0;
            padding: 0px;
        }



        .form-container {
            max-width: 700px;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
        }

        /* Title Styling */
        .form-container h1 {
            font-size: 30px;
            color: #FFB448; /* Primary color */
            margin-bottom: 30px;
            text-align: center;
        }

        /* Label Styling */
        .form-container label {
            display: block;
            font-size: 14px;
            color: #3C2D4D; /* Dark text for contrast */
            margin-bottom: 8px;
            font-weight: 600;
        }

        /* Input Fields Styling */
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container textarea {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #3C2D4D;
            background-color: #EDEDEA;
            font-size: 16px;
            color: #3C2D4D;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="email"]:focus,
        .form-container textarea:focus {
            border-color: #FFB448; /* Highlight color */
            outline: none;
        }

        /* Submit Button Styling */
        .form-container button[type="submit"] {
            background-color: #FFB448; /* Button background */
            color: #3C2D4D; /* Button text color */
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .form-container button[type="submit"]:hover {
            background-color: #FFC77D; /* Button hover color */
        }

        /* Link Styling */
        .form-container a {
            color: #FFB448; /* Link color */
            text-decoration: none;
            font-weight: 600;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        /* Note List Styling */
        .form-container ul {
            font-size: 14px;
            color: #333;
            margin-top: 20px;
            list-style: disc;
            padding-left: 20px;
        }

        .form-container ul li {
            margin-bottom: 10px;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .form-container {
                padding: 25px;
            }
            .form-container h1 {
                font-size: 26px;
            }
            .form-container input[type="text"],
            .form-container input[type="email"],
            .form-container textarea {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .form-container h1 {
                font-size: 22px;
            }
            .form-container input[type="text"],
            .form-container input[type="email"],
            .form-container textarea,
            .form-container button[type="submit"] {
                font-size: 16px;
            }
        }
    </style>

    <div class="form-container">
        <h1>Researcher User Details</h1>

        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" value="update_user">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($researcher['userID']); ?>">

            <label>User ID: <?php echo htmlspecialchars($researcher['userID']); ?></label>

            <label>User Name:</label>
            <input type="text" name="user_name" value="<?php echo htmlspecialchars($researcher['username']); ?>" required>

            <label>Title:</label>
            <input type="text" name="res_title" value="<?php echo htmlspecialchars($researcher['resTitle']); ?>" required>

            <label>First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($researcher['firstName']); ?>" required>

            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($researcher['lastName']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($researcher['email']); ?>" required>

            <label>Organisation:</label>
            <input type="text" name="organisation" value="<?php echo htmlspecialchars($researcher['organisation']); ?>">

            <label>Profile:</label>
            <textarea name="profile" rows="4" placeholder="Enter your profile details here..."><?php echo htmlspecialchars($researcher['profile']); ?></textarea>

            <label>Your User Privilege Level: <?php echo htmlspecialchars($researcher['userRole']); ?></label>

            <button type="submit">Update</button>

            <ul>
                <li>Note: User Privilege Levels (Please contact the manager using Contact Us to change your user privilege level)</li>
                <li>Level 1 - Can only view publications and data (cannot upload)</li>
                <li>Level 2 - View and upload publications and data</li>
            </ul>

            <div><a href="../contactUs/contact_us_form.php">Contact Us</a></div>
        </form>
    </div>
</main>

<?php include '../view/footer.php'; ?>
