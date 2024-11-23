<?php 
include '../view/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EEG Data</title>
    <style>
        /* Container to ensure footer stays at the bottom */
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
            color: #333;
        }

        /* Search form styling */
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

        /* Responsive table */
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

            /* Labels for each data cell on smaller screens */
          
            td:nth-of-type(1)::before { content: "Title"; }
            td:nth-of-type(2)::before { content: "Description"; }
            td:nth-of-type(3)::before { content: "Author"; }
            td:nth-of-type(4)::before { content: "Approval Status"; }
            td:nth-of-type(5)::before { content: "Action"; }
        }

        /* Form buttons */
        input[type="submit"] {
            padding: 8px 12px;
            border: none;
            background-color: #3C2D4D;
            color: #FFB448;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin-top: 5px;
        }

        input[type="submit"]:hover {
            background-color: #645D7B;
        }

        /* Footer styling to stay at the bottom */
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
    <h1>EEG Data</h1>
    
    <!-- Live Search Field -->
    <div class="search-container">
        <input type="text" id="searchInput" onkeyup="liveSearch()" placeholder="Search EEG data...">
    </div>

    <!-- Data Table -->
    <table id="dataTable">
        <thead>
            <tr>
              
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Approval Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $truncateLength = 75; ?>
            <?php foreach ($eegs as $eeg) : ?>
                <tr>
                   
                    <td><?php echo htmlspecialchars($eeg['eegTitle']); ?></td>
                    <td><?php echo htmlspecialchars(substr($eeg['eegDesc'], 0, $truncateLength)); ?>
                        <?php if (strlen($eeg['eegDesc']) >= $truncateLength) {
                            echo "...</td>";
                        } else {
                            echo "</td>";
                        } ?>
        
                    <?php $researcherName = getResearcherName($eeg['userID']); ?>

                    <td><?php echo htmlspecialchars($researcherName); ?></td>
                    <td><?php echo $eeg['approved'] == 1 ? 'Approved' : 'Awaiting Approval'; ?></td>
                    <td>
                      <?php if ($eeg['approved'] == 0) : ?>  
                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="approve_eeg">
                            <input type="hidden" name="eegID" value="<?php echo htmlspecialchars($eeg['eegID']); ?>">
                            <input type="submit" value="Approve">
                        </form>
                      <?php endif; ?>

                        <form action="index.php" method="post">
                            <input type="hidden" name="action" value="delete_eeg">
                            <input type="hidden" name="eegID" value="<?php echo htmlspecialchars($eeg['eegID']); ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include '../view/footer.php'; ?>

</body>
</html>
