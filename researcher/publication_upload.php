<?php require '../model/database.php'; ?> 
<?php include '../view/header.php'; ?>
<?php include '../model/researcher_db.php'; ?>
<?php include '../model/eeg_db.php'; ?>
<?php $approvedEEG = get_approved_eegs(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Publications Upload Form</title>

    <!-- jQuery and jQuery UI for Date Picker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Style for responsive form -->
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
           background-color: #3C2D4D; /* Changed to var(--col1) for a vibrant background */
        color:  var(--col2);
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
    <h1>Publications Upload Form</h1>
    <form action="." method="post" id="aligned" enctype="multipart/form-data">
        <input type="hidden" name="action" value="publication_upload">

        <label for="date">Date:</label>
        <input type="date" id="date" name="pubDate">

        <label for="pub_title">Title:</label>
        <input type="text" id="pub_title" name="pub_title">

        <label for="pub_description">Description:</label>
        <textarea id="pub_description" name="pub_description" rows="5" placeholder="Enter your description here..."></textarea>

        <label for="eegID">Linked EEG Data:</label>
        <select name="eegID" id="eegID">
            <option value="0">No EEG Data linked</option>
            <option value="upload">I want to upload new EEG Data</option>
            <?php foreach ($approvedEEG as $eeg) : ?>
                <option value="<?php echo htmlspecialchars($eeg['eegID']); ?>">
                    <?php echo htmlspecialchars($eeg['eegTitle']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="pubToUpload">Select file to upload:</label>
        <input type="file" name="pubToUpload" id="pubToUpload">

        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>
</main>

<?php include '../view/footer.php'; ?>

</body>
</html>
