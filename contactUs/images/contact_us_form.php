<?php include '../view/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #3C2D4D;
            position: relative;
            overflow: auto; /* Prevents scrollbars caused by absolute positioning */
        }

        /* Main container */
        .contact-container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align both sections to the top */
            flex-wrap: wrap;
            min-height: 100vh;
            padding: 20px;
            position: relative; /* Relative positioning for the overlay */
        }



        /* Shared styles for Contact Info and Form */
        .contact-section {
            flex: 1;
            max-width: 600px; /* Set the maximum width for both sections */
            background: #3C2D4D;
            padding: 40px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            position: relative; /* Relative positioning for z-index */
            z-index: 3; /* Place the section above the overlay */
	    margin-bottom: 20px;
        }

        /* Contact Info Section */
        .contact-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .contact-info h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
		 background: #8D879B;
        }

        .contact-info p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 20px;
        }

        .info-item i {
            color: #007BFF;
            font-size: 22px;
            margin-right: 15px;
            vertical-align: middle;
        }

        .info-item p {
            display: inline-block;
            font-size: 16px;
        }

        /* Contact Form Section */
        .contact-form h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%; /* Set width to 100% */
            padding: 15px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .contact-form textarea {
            height: 100px; /* Increase the height of the message box */
            resize: vertical; /* Allow users to resize it vertically if needed */
        }

        .contact-form input[type="submit"] {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border: none;
            width: 75%;
        }

        .contact-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Hover effects */
        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #007BFF;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
                align-items: stretch;
            }

            .contact-section {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="contact-container">
    <!-- Contact Information -->
    <div class="contact-section contact-info">
        <h2>Contact Us</h2>
        <p>University of Southern Queensland EEG Research</p>

<div class="info-item">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <p>West Street, Toowoomba Queensland 4350</p>
        </div>
 <div class="info-item">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <p>1800 269 500</p>
        </div>
  <div class="info-item">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <p>contact@yourwebsite.com</p>
        </div>
</div>

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

</body>
</html>
<?php include '../view/footer.php'; ?>

