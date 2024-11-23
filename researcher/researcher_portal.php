<?php include '../view/header.php'; ?>
<style>
   
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #EDEDEA;
    }

    header {
        padding-bottom: 20px; 
    }

    main {
        flex: 1; 
        padding-top: 30px; 
        padding-bottom: 30px; 
    }

    footer {
        padding-top: 20px; 
        background-color: #f1f1f1; 
        text-align: center;
    }

    .card-deck {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        
        
    }

    .card {
        text-align: center;
    }

    .card-button {
        width: 200px; /* Fixed width */
        height: 250px; /* Fixed height */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: var(--col1);
        color: var(--text);
        border: none;
        border-radius: 10px;
        padding: 20px;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        background-color: var(--col11);
    }

    .card-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        margin-bottom: 15px;
        border-radius: 50%; 
    }

    .card-content h3 {
        font-size: 16px;
        font-weight: bold;
        color: var(--col2);
        margin: 0;
        text-align: center;
    }
</style>

<main>
    <div class="card-deck">
        <!-- Profile Management -->
        <div class="card">
            <a href="index.php?action=list_researcher" class="card-button">
                <img src="/img/pp.png" alt="Profile Icon" class="card-image">
                <div class="card-content">
                    <h3>Profile Management</h3>
                </div>
            </a>
        </div>

        <!-- View/Download EEG -->
        <div class="card">
            <a href="index.php?action=list_eeg" class="card-button">
                <img src="/img/view.jfif" alt="View EEG Icon" class="card-image">
                <div class="card-content">
                    <h3>View/Download EEG</h3>
                </div>
            </a>
        </div>

        <!-- Upload EEG Data -->
        <div class="card">
            <a href="eeg_upload.php" class="card-button">
                <img src="/img/up.jpg" alt="Upload EEG Icon" class="card-image">
                <div class="card-content">
                    <h3>Upload EEG Data</h3>
                </div>
            </a>
        </div>

        <!-- Upload Publications -->
        <div class="card">
            <a href="publication_upload.php" class="card-button">
                <img src="/img/up.png" alt="Upload Publications Icon" class="card-image">
                <div class="card-content">
                    <h3>Upload Publications</h3>
                </div>
            </a>
        </div>
    </div>
</main>



<?php include '../view/footer.php'; ?>
