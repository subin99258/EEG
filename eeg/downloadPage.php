<?php include '../view/header.php'; ?>
<main>
    <h1>Download EEG Data</h1>
    <p>
        Please use the below link to access the requested EEG Data:
    </p>

    <?php 
        $title =  $_SESSION['eeg_title'];
        $eegLink = $_SESSION['eeg_link'];
    ?>

    <b><?php echo htmlspecialchars($title); ?></b>
    </br></br>
    <a href="<?php echo htmlspecialchars($eegLink);?>">Click to download</a>
    </br>
</main>