<?php include '../view/header.php'; ?>
<main>
    <h1>Database Error</h1>
    <p>There was an error connecting to the database.</p>
    <p>Error message: <?php echo htmlspecialchars($error_message); ?></p>
</main>
<?php include '../view/footer.php'; ?>