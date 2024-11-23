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

        /* Scope styles to researcher section */
        .researcher-section {
            background-color: var(--col3);
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh; /* Covers most of the screen */
        }

        .researcher-section .centre {
            text-align: center;
            background-color: var(--col2);
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 90%; /* Adjust width to be responsive */
            margin: auto;
        }

        .researcher-section h1 {
            font-size: 2rem;
            color: var(--text);
            margin-bottom: 20px;
        }

        .researcher-section p {
            font-size: 1.1rem;
            color: var(--text);
            margin: 20px 0;
        }

        .researcher-section a {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--col1);
            color: var(--col2);
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            margin: 10px 0;
        }

        .researcher-section a:hover {
            background-color: var(--col11);
        }

        .researcher-section a:active {
            background-color: var(--col12);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .researcher-section {
                padding: 30px 15px;
            }

            .researcher-section .centre {
                padding: 35px;
            }

            .researcher-section h1 {
                font-size: 1.8rem;
            }

            .researcher-section p,
            .researcher-section a {
                font-size: 0.95rem;
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            .researcher-section .centre {
                padding: 25px;
            }

            .researcher-section h1 {
                font-size: 1.6rem;
            }

            .researcher-section p {
                font-size: 0.9rem;
            }

            .researcher-section a {
                font-size: 0.85rem;
                padding: 8px 16px;
            }
        }
    </style>

    <div class="researcher-section">
        <div class="centre">   
            <h1>Researchers</h1>
            <a href="researcher_login.php">Login</a>
            <p>Want to register to upload your publications or EEG data?</p>
            <a href="researcher_registration.php">Sign up here!</a>
        </div>
    </div>
</main>
<?php include '../view/footer.php'; ?>
