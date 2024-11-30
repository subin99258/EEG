<?php include './view/header.php'; ?>
<main class="homepage">
  <!-- Introduction Section -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EEG Data Platform</title>
  
</head>

<body>
<style>
/* Basic reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
}

/* Header Adjustment */
.header {
    position: relative;
    z-index: 10;
}

/* Hero Section */
.hero {
    background: url('/img/usq1.jpg') no-repeat center center;
    background-size: cover;
	position: relative; 
    display: inline-block;
    color:#3C2D4D;
	
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60vh; 
    text-align: center;
    flex-direction: column;
    padding: 20px;
    margin-top: 20px; 
    z-index: 1; 
}

.hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.5); 
    z-index: 1;
    pointer-events: none; 
}


.hero * {
    position: relative;
    z-index: 2;
}


.hero h1 {
    font-size: 3em;
    margin-bottom: 110px;
    color: #3C2D4D;
}

.hero h2 {
    font-size: 1.3em;
    margin-bottom: 100px;
    color: #4C2D4D;
}

.hero p {
    font-size: 1.2em;
     margin-bottom: 20px;

}


.cta-button {
    background: #3C2D4D;
    color: #FFB448;
    padding: 15px 30px;
    border: none;
    border-radius: 50px;
    font-size: 1.1em;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s ease;
}

.cta-button:hover {
    background: #FFC77D;
    color: #3C2D4D;
}

/* Features Section */
.features {
    padding: 50px 20px;
    text-align: center;
}

.features h2 {
    font-size: 2.5em;
    margin-bottom: 30px;
}

/* Feature Cards */
.feature-cards {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.feature-card {
    background: #3C2D4D;
    color: #FFB448;
    border-radius: 10px;
    padding: 20px;
    margin: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    flex-basis: 30%;
    opacity: 0; /* Animation effect */
    transform: translateY(20px); /* Animation */
    transition: opacity 0.5s ease, transform 0.5s ease;
}

/* Animation Classes */
.animate-fade {
    animation: fadeIn 1s forwards;
}

.animate-slide {
    animation: slideIn 1s forwards;
}

.animate-fade-up {
    animation: fadeInUp 0.8s forwards;
}

/* Keyframe Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero {
        padding: 15px;
        min-height: 50vh;
        font-size: 1rem;
        margin-top: 50px; 
    }

    .hero h1 {
        font-size: 2.5em;
    }

    .hero p {
        font-size: 1em;
    }

    .feature-card {
        flex-basis: 80%;
    }
}

@media (max-width: 480px) {
    .hero {
        padding: 10px;
        min-height: 40vh;
        margin: 0px;
        padding: 0px;
    }

    .hero h1 {
        font-size: 2em;
    }

    .hero p {
        font-size: 0.9em;
    }
    
    .cta-button {
        font-size: 0.9em;
        padding: 10px 20px;
    }
}

/* Footer Section */
footer {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: white;
}
</style>

<!-- Hero Section -->
<section class="hero">
    <h1 class="animate-fade">Welcome to Our EEG Data Platform</h1>
  
    
    <div class="feature-cards">
        <div class="feature-card animate-fade-up">
            <h3>Data Sharing</h3>
            <p>Access a large collection of EEG data for analysis.</p>
        </div>
        <div class="feature-card animate-fade-up">
            <h3>Collaboration</h3>
            <p>Connect with researchers around the world.</p>
        </div>
        <div class="feature-card animate-fade-up">
            <h3>Analysis Tools</h3>
            <p>Utilize state-of-the-art tools for EEG data analysis.</p>
        </div>
    </div>
    <a href="/about" class="cta-button animate-fade">Explore Features</a>
</section>

<?php include './view/footer.php'; ?>
</body>
</html>