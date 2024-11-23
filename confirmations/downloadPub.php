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

        b, strong {
            color: var(--btn-color);
            font-size: 18px;
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

        @media (max-width: 600px) {
            .blurb {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            p, b, strong {
                font-size: 16px;
            }
        }
    </style>

    <div class="blurb">
        <h1>Download Publication</h1>
        <p>Please use the below link to access the requested publication:</p>

        <!-- Display publication title, author, description, and date -->
        <b>Publication Title: 
            <?php 
            // Check if $pubTitle is set, otherwise display a default message
            echo htmlspecialchars($title ?? 'Publication title unavailable'); 
            ?>
        </b>
        <br><br>
        <strong>Author:</strong> 
        <?php 
        // Check if $researcher is set, otherwise display a default message
        echo htmlspecialchars($researcher ?? 'Unknown researcher'); 
        ?>
        <br>
        <strong>Description:</strong> 
        <?php 
        // Check if $pubDesc is set, otherwise display a default message
        echo htmlspecialchars($pubDesc ?? 'Description unavailable'); 
        ?>
        <br>
        <strong>Publication Date:</strong> 
        <?php 
        // Check if $pubDate is set, otherwise display a default message
        echo htmlspecialchars($pubDate ?? 'Date unavailable'); 
        ?>

        <br><br>
<a href="<?php echo htmlspecialchars($pubLink ?? 'Date unavailable'); ?>" 
   target="_blank"
   style="display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007bff; text-decoration: none; border-radius: 5px;">
   Download File
</a>
         </div>
</main>

<?php include '../view/footer.php'; ?>

<script>
function downloadButton() {
    // PHP processing: replace "../" with the desired path and echo it as a JS-safe string
    const pubLink = "<?php 
        // Ensure proper path replacement in PHP
        $updatedPath = str_replace(' ..', 'C:\\xampp\\htdocs', $pubLink ?? '#'); 
        echo htmlspecialchars($updatedPath); 
    ?>";

    // Debug: Print pubLink to the browser console to ensure it is correct
    console.log('pubLink:', pubLink);  // Will print to the  

    // Show an alert to check if the value of pubLink is correct
    alert('pubLink is: ' + pubLink);

    // If the pubLink is valid and not '#', open it in a new window
    if (pubLink !== '#') {
       window.open(filePath, '_blank');  // Open the link in a new tab/window
    } else {
        alert('Publication link is unavailable.');  // Alert if the link is not available
    }
}
</script>