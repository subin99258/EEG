<?php include '../view/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Menu</title>
    <style>
        /* Define new color scheme */
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

        /* Body and general styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: var(--col3);
            color: var(--text);
        }

        main {
            display: flex;
            justify-content: center;
            padding: 20px;
            min-height: calc(100vh - 100px); 
        }

        .mgmtMenu {
            max-width: 1200px;
            width: 100%;
            margin: 20px auto;
            padding: 30px;
            background-color: var(--col2);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            color: var(--col3);
            text-align: center;
        }

        h1 {
            color: #EDEDEA;
            margin: 0px;
            font-size: 1.8em;
            
          
        }

        .section-container {
            display: flex;
            justify-content: space-between; 
            gap: 20px; 
            flex-wrap: wrap; 
        }

        
        .card {
            background-color: var(--col1);
            color: var(--col2);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            flex: 1 1 calc(33.333% - 20px); 
            max-width: calc(33.333% - 20px); 
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            height: 50vh;
            flex-direction: column; 
            align-items: center; 
            gap: 5vh; 
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }

        
        button, input[type="submit"] {
            background-color: var(--col12);
            color: var(--col1);
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            width: 100%; 
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        form {
            width: 100%; 
            display: flex;
            justify-content: center; 
        }

        
        button:hover, input[type="submit"]:hover {
            background-color: var(--col2);
            transform: translateY(-3px); 
        }

        
        footer {
            padding: 10px;
            background-color: var(--col2);
            color: var(--col3);
            text-align: center;
            position: relative;
        }

        /* Responsive adjustments for mobile screens */
        @media (max-width: 900px) {
            .section-container {
                justify-content: center; 
            }

            .card {
                flex: 1 1 100%; 
                max-width: 100%;
                height: fit-content;
            }
        }

        @media (max-width: 600px) {
            button, input[type="submit"] {
                font-size: 12px; 
                padding: 8px 10px;
            }

            h1 {
                font-size: 1.6em;
            }

            h2 {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>

<main>
    <div class="mgmtMenu">
        <h1>Management Menu</h1>

        <div class="section-container">
            <div class="card">
                <h2>EEG Data Management</h2>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="list_eeg">
                    <input type="submit" value="View/Edit EEG">
                </form>
                <form action="mgr_eeg_upload.php" method="get">
                    <button type="submit">Upload EEG Data</button>
                </form>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="public_user_downloads">
                    <input type="submit" value="Public EEG Requests">
                </form>
            </div>

            <div class="card">
                <h2>Publications Management</h2>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="list_publications">
                    <input type="submit" value="View/Edit Publications">
                </form>
                <form action="mgr_pub_upload.php" method="get">
                    <button type="submit">Upload Publications</button>
                </form>
            </div>

            <div class="card">
                <h2>User Management</h2>
                <form action="index.php" method="post">
                    <input type="hidden" name="action" value="list_users">
                    <input type="submit" value="User Management">
                </form>
            </div>
        </div>
    </div>
</main>

<?php include '../view/footer.php'; ?>

</body>
</html>
