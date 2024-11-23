<?php 
include '../view/header.php'; ?>
<main>
    <style>
        :root {
            --col1: #FFB448; /* Primary color */
            --col2: #3C2D4D; /* Background color */
            --col3: #EDEDEA; /* Text background */
            --btn-hover: #FFC77D; /* Button hover color */
            --btn-color: #3C2D4D; /* Button text color */
            --text-color: #3C2D4D; /* Main text color */
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--col2);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px); /* Subtract header/footer */
            background-color: var(--col3);
        }

        .blurb {
            max-width: 600px;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: var(--col1);
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        b {
            color: var(--btn-color);
            font-size: 20px;
            display: block;
            margin: 10px 0;
        }

        button {
            background-color: var(--col1);
            color: var(--btn-color);
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--btn-hover);
        }

        .centre {
            display: inline-block;
            text-align: center;
        }

    </style>

<?$pubID = filter_input(INPUT_POST, 'DownloadEEG', FILTER_VALIDATE_INT);

?>

    <div class="blurb">
        <h1>Download Publication</h1>
        <p>Please use the link below to access the requested publication:</p>
        <b><?php echo htmlspecialchars($eegTitle); ?></b> authored by <?php echo htmlspecialchars($researcher); ?>
        <br><br>
        <button onclick="downloadButton()" class="centre">Click to download</button>
    </div>
</main>

<?php include '../view/footer.php'; ?>

<script>
function downloadButton() {
        window.open("<?php echo htmlspecialchars($_SESSION['eegLink']); ?>");
}
</script>
