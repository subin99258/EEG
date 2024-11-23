<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$LogDir = __DIR__ . '/../errors/logs/';
$headerLogFile = $LogDir . 'header_error.log';
ini_set('error_log', $headerLogFile);

try {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>EEG Data and Publication</title>
        <link rel="stylesheet" type="text/css" href="/main.css">
        <script src="https://kit.fontawesome.com/5b50e2fea3.js" crossorigin="anonymous"></script>
        <style>
            :root {
                --col1: #FFB448; /* Highlight color */
                --col2: #3C2D4D; /* Form background */
                --col3: #EDEDEA; /* Body background */
                --col11: #FFC77D; /* Hover color */
                --col12: #645D7B; /* Input background */
                --col21: #FFD8A2;
                --col22: #8D879B;
            }

            body {
                background-color: var(--col3);
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            /* Header Section */
            .header {
                background-color: var(--col2);
                color: var(--col1);
                display: flex;
                justify-content: space-evenly;
                align-items: center;
                flex-wrap: wrap;
            }

            .header-left {
                display: flex;
                align-items: center;
                
            }

            .header-left img {
                max-width: 50px;
                height: auto;
            }

            .header-left h1 {
                margin: 0;
                font-size: 1.5em;
                color: #EDEDEA;
            }

            .menu-toggle {
                display: none;
                font-size: 1.5em;
                cursor: pointer;
                color: var(--col1);
            }

            /* Navigation Menu */
            .nav {
                display: flex;
                justify-content: flex-end;
                gap: 15px;
                list-style-type: none;
                padding: 0;
                margin: 0;
                flex-grow: 1;
                transition: max-height 0.3s ease, opacity 0.3s ease;
                max-height: none;
                opacity: 1;
                overflow: hidden;
            }

            .nav.show {
                max-height: 500px;
                opacity: 1;
            }

            .nav-item {
                text-decoration: none;
                color: var(--col1);
                font-size: 1.1em;
                padding: 8px 15px;
                border-radius: 5px;
                background-color: var(--col2);
                transition: background-color 0.3s ease, color 0.3s ease;
                white-space: nowrap;
            }

            .nav-item:hover {
                background-color: var(--col11);
                color: var(--col2);
            }

            /* Buttons Section */
            .header-buttons {
                display: flex;
                gap: 10px;
                align-items: center;
                flex-wrap: wrap;
            }

            .signup-btn,
            .signin-btn {
                padding: 8px 16px;
                font-size: 1em;
                border-radius: 5px;
                cursor: pointer;
                border: none;
                background-color: var(--col1);
                color: var(--col2);
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .signup-btn:hover {
                background-color: var(--col11);
            }

            .signin-btn:hover {
                background-color: var(--col11);
                color: var(--col2);
            }

            /* Dropdown for Sign In */
            .dropdown {
                display: none;
                position: absolute;
                top: 100%;
                right: 0;
                background-color: var(--col3);
                border-radius: 5px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .dropdown a {
                color: var(--col2);
                padding: 10px;
                text-decoration: none;
                display: block;
            }

            .dropdown a:hover {
                background-color: var(--col21);
                color: var(--col1);
            }

            .signin-wrapper:hover .dropdown {
                display: block;
            }

            /* Responsive Design */
            @media screen and (max-width: 768px) {
                .header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .menu-toggle {
                    display: block;
                }

                .nav {
                    display: none;
                    flex-direction: column;
                    gap: 10px;
                    width: 100%;
                    text-align: center;
                    background-color: var(--col2);
                    padding: 10px;
                    max-height: 0;
                    opacity: 0;
                    overflow: hidden;
                }

                .nav.show {
                    display: flex;
                    max-height: 500px;
                    opacity: 1;
                }

                .nav-item {
                    width: 100%;
                    text-align: center;
                }
            }
        </style>
    </head>

    <body>
        <header class="header">
            <div class="header-left">
                <img alt="University of Southern Queensland" 
                     src="https://unisq.edu.au/Content/USQ/Charlie/Images/unisq-logo-acronym-white.svg" 
                     style="max-width: 100px; height: auto; display: block; margin-right: 50px;">
                <h1>EEG Data and Publication</h1>
            </div>

            <div class="menu-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>

            <nav>
                <ul class="nav" id="navMenu">
                    <li><a class="nav-item" href="/index.php">Home</a></li>
                    <li><a class="nav-item" href="/eeg/">EEG</a></li>
                    <li><a class="nav-item" href="/publications/">Publications</a></li>
                    <?php
                    if (isset($_SESSION['userRole'])) {
                        if ($_SESSION['userRole'] == 0) {
                            echo '<li><a class="nav-item" href="/manager/">Manager</a></li>';
                        } elseif ($_SESSION['userRole'] == 2 || $_SESSION['userRole'] == 1) {
                            echo '<li><a class="nav-item" href="/researcher/">Researcher</a></li>';
                        }
                    }
                    ?>
                    <li><a class="nav-item" href="/contactUs/">Contact Us</a></li>
                    <li><a class="nav-item" href="/About/">About Us</a></li>
                </ul>
            </nav>

            <div class="header-buttons">
                <?php
                if (isset($_SESSION['userRole'])) {
                    echo '<span class="welcome" style="color: var(--col1);">Logged in as: ' . htmlspecialchars($_SESSION['username']) . '</span>';
                    echo '<a class="logout-button" href="../logout.php" style="color: var(--col1); text-decoration: none;">Logout</a>';
                } else {
                    echo '
                        <button class="signup-btn" onclick="window.location.href=\'/researcher/researcher_registration.php\'">Sign Up</button>
                        <div class="signin-wrapper">
                            <button class="signin-btn">Sign In</button>
                            <div class="dropdown">
                                <a href="/manager/manager_login.php">Manager</a>
                                <a href="/researcher/researcher_login.php">Researcher</a>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </header>

        <script>
            function toggleMenu() {
                const navMenu = document.getElementById("navMenu");
                navMenu.classList.toggle("show");
            }
        </script>
    </body>
    </html>
    <?php
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage(), 3, $headerLogFile);
    include('../errors/error.php');
}
?>
