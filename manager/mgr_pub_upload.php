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

    

    <!-- Style for responsive form -->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
           background-color: #3C2D4D; /* Changed to var(--col1) for a vibrant background */
        color: var(--col2);
            margin: 0;
            padding: 0px;
        }



        h1 {
            text-align: center;
            color: #EDEDEA;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #EDEDEA;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
         
            font-size: 14px;
            color: #333;
        }

        input[type="date"],
        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
         
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
        }

        input[type="submit"] {
            background-color: #645D7B;
            color: white;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #5a506c;
        }

        input[type="reset"] {
            background-color: #FFC77D;
            color: white;
        }

        input[type="reset"]:hover {
            background-color: #e6b06c;
        }

        @media (max-width: 600px) {
            form {
                padding: 10px;
            }

            input[type="submit"],
            input[type="reset"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<main>
    <h1>Publications Upload Form</h1>
    <form action="." method="post" id="aligned" enctype="multipart/form-data">
        <input type="hidden" name="action" value="publication_upload">

        
 <label for="date">Date:</label>
        <input type="date" id="date" name="date">
        <label for="pub_title">Title:</label>
        <input type="text" id="pub_title" name="pub_title">

        <label for="pub_description">Description:</label>
        <textarea id="pub_description" name="pub_description" rows="5" placeholder="Enter your description here..."></textarea>
        
        <label for="eegID">Linked EEG Data:</label>
        <select name="eegID" id="eegID">
            <option value="0">No EEG Data linked</option>
            <option value="upload">I want to upload new EEG Data</option>
            <?php foreach ($approvedEEG as $EEG) : ?>
                <option value="<?php echo htmlspecialchars($EEG['eegID']); ?>"><?php echo htmlspecialchars($EEG['eegTitle']); ?></option>
            <?php endforeach; ?>
            <!-- Dynamic options would be here -->
        </select>

        <label for="pubToUpload">Select file to upload:</label>
        <input type="file" name="pubToUpload" id="pubToUpload">

        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </form>
</main>

</body>
</html>

<?php include '../view/footer.php'; ?>
