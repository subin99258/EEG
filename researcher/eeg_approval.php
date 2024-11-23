<?php include '../view/header.php'; ?>

<main>
    <style>
        :root {
            --col1: #FFB448; /* Highlight color */
            --col2: #3C2D4D; /* Form background */
            --col3: #EDEDEA; /* Body background */
            --col11: #FFC77D; /* Hover color */
            --col12: #645D7B; /* Input background */
            --text-color: #333;
            --error-color: #ff4444; /* Bright red for error visibility */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--col3);
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 750px;
            margin: 40px auto;
            padding: 20px;
            background-color: var(--col2);
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            text-align: center;
            color: var(--col3);
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 0 10px;
        }

        label {
            color: var(--col3);
            font-size: 14px;
        }

        input[type="text"], input[type="email"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid var(--col11);
            background-color: var(--col12);
            color: var(--text-color);
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: var(--col1);
            color: var(--col2);
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: var(--col11);
        }

        .terms {
            font-size: 14px;
            color: var(--text-color);
            background-color: var(--col3);
            padding: 15px;
            border-radius: 8px;
            overflow-y: auto;
        }

        .error-message {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            main {
                margin: 20px;
                padding: 15px;
            }

            .terms {
                font-size: 12px;
                padding: 10px;
            }

            h1, h2, h3 {
                font-size: 18px;
                color: #EDEDEA;
            }

            button[type="submit"] {
                padding: 10px;
                font-size: 14px;
            }

            form {
                gap: 10px;
            }

            label {
            color: var(--col3);
            font-size: 14px;
        }





        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const firstNameField = document.getElementById('first_name');
            const lastNameField = document.getElementById('last_name');
            const emailField = document.getElementById('email');

            firstNameField.addEventListener('input', function() {
                const firstNameError = document.getElementById('first_name_error');
                if (firstNameField.value.length < 2) {
                    firstNameError.textContent = 'First name must be at least 2 characters';
                } else {
                    firstNameError.textContent = '';
                }
            });

            lastNameField.addEventListener('input', function() {
                const lastNameError = document.getElementById('last_name_error');
                if (lastNameField.value.length < 2) {
                    lastNameError.textContent = 'Last name must be at least 2 characters';
                } else {
                    lastNameError.textContent = '';
                }
            });

            emailField.addEventListener('input', function() {
                const emailError = document.getElementById('email_error');
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(emailField.value)) {
                    emailError.textContent = 'Please enter a valid email address';
                } else {
                    emailError.textContent = '';
                }
            });
        });

        function checkTerms(event) {
            const checkBox = document.getElementById('agree');
            const agreeError = document.getElementById('agree_error');

            if (!checkBox.checked) {
                agreeError.textContent = 'Please agree to the terms before proceeding.';
                event.preventDefault();
                return false;
            }
            agreeError.textContent = '';

            const title = "<?php echo urlencode($_SESSION['eeg_title']); ?>";
            const eegLink = "<?php echo urlencode($_SESSION['eeg_link']); ?>";
            const eegID = "<?php echo urlencode($_SESSION['eeg_id']); ?>";
            window.location.href = "downloadPage.php?title=" + title + "&eegLink=" + eegLink + "&eegID=" + eegID;
            return true;
        }
    </script>

    <form action="." method="post" onsubmit="return checkTerms(event);">
        <input type="hidden" name="action" value="eeg_agree">

        <h1>EEG Download</h1>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required minlength="2" maxlength="50" placeholder="Enter your first name">
        <span id="first_name_error" class="error-message"></span>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required minlength="2" maxlength="50" placeholder="Enter your last name">
        <span id="last_name_error" class="error-message"></span>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email address">
        <span id="email_error" class="error-message"></span>

        <h2>EEG Data - Terms and Conditions</h2>
        <div class="terms">
            <p>Terms and Conditions for Responsible Use of Medical Data</p>
            <ol>
                <li><strong>Data Access and Use:</strong> Access to medical data provided through this platform is granted solely for legitimate research and educational purposes.</li>
                <li><strong>Confidentiality:</strong> Users are required to maintain strict confidentiality regarding any identifiable medical data accessed through this platform.</li>
                <li><strong>Ethical Considerations:</strong> Users agree to conduct their activities with integrity and respect for the rights and welfare of individuals whose medical data is accessed.</li>
                <li><strong>Responsibility:</strong> Users acknowledge that they are solely responsible for their use of medical data accessed through this platform.</li>
                <li><strong>Accountability:</strong> Users agree to cooperate fully in any investigations or audits related to the use of medical data accessed through this platform.</li>
            </ol>
            <p><strong>Termination of Access:</strong> The platform provider reserves the right to suspend or terminate user access to medical data at any time and for any reason.</p>
            <p><em>By accessing and using medical data through this platform, users acknowledge their acceptance of these terms and agree to abide by them in their entirety.</em></p>
        </div>

        <h3>Do you agree to the above terms and conditions?</h3>
        <label for="agree">
            <input type="checkbox" id="agree" required> I agree
        </label>
        <span id="agree_error" class="error-message"></span>

        <button type="submit">Submit</button>
    </form>
</main>

<?php include '../view/footer.php'; ?>
