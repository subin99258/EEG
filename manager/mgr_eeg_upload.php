<?php require '../model/database.php'; ?>
<?php include '../view/header.php'; ?>
<?php include '../model/researcher_db.php'; ?>
<?php include '../model/publications_db.php'; ?>
<?php $approvedPub = get_approved_publications(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Publications Upload Form</title>

    <!-- Custom Styles -->
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

        body {
            font-family: Arial, sans-serif;
           background-color: var(--col2); /* Changed to var(--col1) for a vibrant background */
        color: var(--col2);
            margin: 0;
            padding: 0px;
        }

        h1 {
            text-align: center;
            color: var(--col3);
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--col3);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: var(--col2);
        }

        input[type="date"],
        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            border: 1px solid var(--col22);
            border-radius: 4px;
            background-color: var(--col3);
            color: var(--col2);
        }

        input[type="submit"],
        input[type="reset"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"] {
            background-color: var(--col12);
            color: var(--text);
        }

        input[type="submit"]:hover {
            background-color: var(--col22);
        }

        input[type="reset"] {
            background-color: var(--col11);
            color: var(--text);
        }

        input[type="reset"]:hover {
            background-color: var(--col21);
        }

        textarea::placeholder {
            color: var(--col22);
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
    </style>
</head>
<body>
<main>
    <h1>EEG Data Upload Form</h1>
    <form action="." method="post" id="eegForm" enctype="multipart/form-data">
        <input type="hidden" name="action" value="eeg_upload">

        <!-- Date Input -->
        <label for="eegDate">Date:</label>
        <input type="date" id="eegDate" name="eegDate">

        <!-- Title Input -->
        <label for="eeg_title">Title:</label>
        <input type="text" id="eeg_title" name="eeg_title" placeholder="Enter title">

        <!-- Description Input -->
        <label for="eeg_description">Description:</label>
        <textarea id="eeg_description" name="eeg_description" rows="5" placeholder="Enter your description here..."></textarea>

        <!-- Linked Publication Dropdown -->
        <label for="pubID">Linked Publication:</label>
        <select name="pubID" id="pubID">
            <option value="0">No Publication linked</option>
            <option value="upload">I want to upload a new Publication</option>
            <?php foreach ($approvedPub as $pub) : ?>
                <option value="<?php echo htmlspecialchars($pub['pubID']); ?>">
                    <?php echo htmlspecialchars($pub['pubTitle']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- File Upload -->
        <label for="eegToUpload">Select data file to upload:</label>
        <input type="file" name="eegToUpload" id="eegToUpload">

        <!-- Submit and Reset Buttons -->
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>
</main>
</body>
</html>
