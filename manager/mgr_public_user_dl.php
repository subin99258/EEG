<?php 
include '../view/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public User Downloads</title>
    <style>
      
        body, html {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main {
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #3C2D4D;
        }

       
        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 60%;
            max-width: 300px;
            border-radius: 4px;
            border: 1px solid #3C2D4D;
            font-size: 1em;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3C2D4D;
            color: #fff;
        }

        td {
            color: #3C2D4D;
        }

        /* Responsive table design */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 15px;
                border-bottom: 1px solid #ddd;
            }

            td {
                border: none;
                padding-left: 50%;
                position: relative;
            }

            td::before {
                position: absolute;
                top: 15px;
                left: 15px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                color: #3C2D4D;
            }

           
            td:nth-of-type(1)::before { content: "Download ID"; }
            td:nth-of-type(2)::before { content: "Title"; }
            td:nth-of-type(3)::before { content: "EEG ID"; }
            td:nth-of-type(4)::before { content: "Requester Name"; }
            td:nth-of-type(5)::before { content: "Email"; }
            td:nth-of-type(6)::before { content: "Request Date"; }
        }

       
        footer {
            padding: 10px;
            background-color: #3C2D4D;
            color: white;
            text-align: center;
        }
    </style>
    <script>
        // JavaScript function to filter table rows based on input
        function liveSearch() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                row.style.display = rowText.includes(filter) ? '' : 'none';
            });
        }
    </script>
</head>
<body>

<main>
    <h1>Public User Downloads</h1>
    
    <!-- Live Search Field -->
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="liveSearch()" placeholder="Search downloads...">
    </div>

    <!-- Data Table -->
    <table id="dataTable">
        <thead>
            <tr>
                <th>Download ID</th>
                <th>Title</th>
                <th>EEG ID</th>
                <th>Requester Name</th>
                <th>Email</th>
                <th>Request Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($publicUsers as $user) : ?>
                <?php
                    $timestamp = new DateTime($user['viewed_time']);
                    $formattedDateTime = $timestamp->format('d-m-y H:i');
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['downloadedID']); ?></td>
                    <td><?php echo htmlspecialchars($user['eegTitle'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>

                    <td><?php echo htmlspecialchars($user['eegID']); ?></td>
                    <td><?php echo htmlspecialchars($user['firstName']) . ' ' . htmlspecialchars($user['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    <td><?php echo htmlspecialchars($formattedDateTime); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include '../view/footer.php'; ?>

</body>
</html>
