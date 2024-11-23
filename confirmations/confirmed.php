<?php
// Ensure $confirmation is set before including the header
include '../view/header.php';
?>
<!DOCTYPE html>
<html lang="en">


<body>
    <div class="confirmation-container">
        <div class="confirmation-card">
            <h1 style="font-size: 2.5em; color: #3C2D4D; margin-bottom: 20px; text-align: center;">Thank You!</h1>
            <h2 style="font-size: 1.5em; color: #132D4D; margin-bottom: 30px; text-align: center;">
                <?php
                // Output the confirmation message in the body
                echo $confirmation;
                ?>
            </h2>
        </div>
    </div>
</body>
</html>
<?php include '../view/footer.php'; ?>
