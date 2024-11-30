<?php include '../view/header.php'; ?>

<style>
    :root {
        --col1: #FFB448; 
        --col2: #3C2D4D; 
        --col3: #EDEDEA; 

        --col11: #FFC77D; 
        --col12: #645D7B; 

        --col21: #FFD8A2;
        --col22: #8D879B;

        --text: var(--col1); 
    }


    body {

           
           background-color: #EBE8FC; 
            color:  #3C2D4D;
          
            padding: 0px;
        
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    
        font-family: Arial, sans-serif;
    }

    main {
        flex-grow: 1; 
        padding: 50px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center; 
    }

    main h1 {
        font-size: 2.5em;
        color: var(--col1);
        margin-bottom: 20px;
    }

    
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .grid-item {
        background-color: var(--col2);
        color: var(--col21);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .grid-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        background-color: var(--col11);
    }

    
    .grid-item h4 {
        font-size: 1.5em;
        margin-bottom: 15px;
        color: var(--col1);
        transition: color 0.3s;
    }

    .grid-item:hover h4 {
        color: var(--col2);
    }

    .grid-item p {
        font-size: 1em;
        color: var(--col22);
    }

    
</style>

<main>
    <h1>What We Offer</h1>
    <div class="grid-container">
        <div class="grid-item">
            <h4>EEG Data Analysis</h4>
            <p>Access a vast collection of EEG datasets with robust analysis tools to uncover new insights in brainwave research.</p>
        </div>
        <div class="grid-item">
            <h4>Latest Publications</h4>
            <p>Explore the most recent findings and research papers published in the field of EEG and neuroscience.</p>
        </div>
        <div class="grid-item">
            <h4>Collaborate with Experts</h4>
            <p>Join a growing community of researchers and collaborate on groundbreaking EEG research projects.</p>
        </div>
    </div>
</main>

<?php include '../view/footer.php'; ?>
