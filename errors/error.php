<?php 
include '../view/header.php'; 
// Ensure $errors array is defined to avoid undefined variable warnings
$errors = $errors ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the error box on the page */
        .centered-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-box {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border: 1px solid #dc3545;
            border-radius: 8px;
            background-color: #f8d7da;
        }
        .error-box h3 {
            color: #721c24;
            font-size: 30px;
        }
        .error-box ul li {
            font-size: 20px;
            color: #721c24;
        }
        .btn-primary {
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="centered-box">
    <div class="error-box">
        <h3 class="text-center">Error!</h3>
        <!-- Error messages -->
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="text-center mt-3">
            <!-- Optional custom string -->
            <?php 
            $string = $string ?? ''; 
            if (!empty($string)): ?>
                <p><?php echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <!-- Back button -->
            <a href="<?php echo htmlspecialchars($_SESSION['backTo'] ?? 'javascript:history.back()', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Go Back</a>
        </div>
    </div>
</div>
</body>
</html>
