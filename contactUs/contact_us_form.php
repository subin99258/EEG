<?php include '../view/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern Contact Us Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --col1: #FFB448; /* Highlight color */
            --col2: #3C2D4D; /* Form background */
            --col3: #EDEDEA; /* Body background */
            --col11: #FFC77D; /* Hover color */
            --col12: #645D7B; /* Input background */
            --col21: #FFD8A2;
            --col22: #8D879B;
            --text-color: var(--col1); /* Text color */
            --button-color: #007BFF; /* Default button color */
            --button-hover-color: #0056b3; /* Button hover color */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
   background: url('/img/usq1.jpg') no-repeat center center;
             background-size: cover;
	position: relative; /* Make the overlay position relative to this container */
    display: inline-block;
            color: var(--text-color);
            position: relative;
background-color: rgba(255, 255, 255, 0.5);
 background-blend-mode: overlay;
        }

        /* New wrapper to center contact section */
        .contact-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Main contact container with equal height for children */
        .contact-container {
            display: flex;
            justify-content: space-between;
            align-items: stretch; /* Ensures equal height */
            flex-wrap: wrap;
            width: 100%;
            max-width: 1200px;
            gap: 20px;
        }

        /* Contact sections with equal width and height */
        .contact-section {
            flex: 1 1 45%;
            max-width: 500px;
            background: var(--col2);
            color: var(--col21);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Spreads content vertically */
        }

        /* Contact Info Section */
        .contact-info h2, .contact-form h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--col1);
        }

        .contact-info p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 20px;
            color: var(--col21);
        }

        .info-item i {
            color: var(--col1);
            font-size: 22px;
            margin-right: 15px;
            vertical-align: middle;
        }

        .info-item p {
            display: inline-block;
            font-size: 16px;
        }

        /* Contact Form Section */
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid var(--col11);
            border-radius: 4px;
            background-color: var(--col12);
            color: var(--col1);
            outline: none;
            transition: border-color 0.3s ease;
        }

        .contact-form textarea {
            height: 100px;
            resize: vertical;
        }

        .contact-form input[type="submit"] {
            background-color: var(--col1);
            color: white;
            cursor: pointer;
            border: none;
            width: 75%;
            padding: 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            align-self: center; /* Centers the button horizontally */
        }

        .contact-form input[type="submit"]:hover {
            background-color: var(--col21);
        }

        /* Hover effects */
        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: var(--button-color);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
                align-items: center;
            }

            .contact-section {
                width: 100%;
                max-width: 600px;
            }
        }
    </style>
</head>
<body>

<div class="contact-wrapper">
    <div class="contact-container">
        <!-- Contact Information -->
        <div class="contact-section contact-info">
            <h2>Contact Us</h2>
            <p>Get in touch with us to explore collaborative opportunities, support, and insights in EEG and neuroscience research.</p>

            <div class="info-item">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <p>West Street, Toowoomba. 4350</p>
            </div>

            <div class="info-item">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <p>1800 678 345 </p>
            </div>

            <div class="info-item">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <p>contact@yourwebsite.com</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-section contact-form">
            <h2>Send Message</h2>
            <form action="." method="POST">
                <input type="hidden" name="action" value="Submit">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" rows="5" placeholder="Type your message..." required></textarea>
                <input type="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>

</body>
</html>
<?php include '../view/footer.php'; ?>
