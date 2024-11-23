<?php include '../view/header.php'; ?>
<main>
  <style>
    h1 {
        text-align: center;
        color: #8D879B;
    }

    .search-bar {
        display: flex;
        justify-content: center;
        margin: 20px auto;
    }

    .search-bar input[type="text"] {
        width: 80%;
        max-width: 600px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    #eeg-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
        background-color: #FFD8A2;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #eeg-table th, #eeg-table td {
        padding: 12px 15px;
        text-align: center;
    }

    #eeg-table th {
        background-color: #3C2D4D;
        color: white;
    }

    #eeg-table tr {
        border-bottom: 1px solid #ccc;
    }

    #eeg-table tr:nth-child(even) {
        background-color: #FFC77D;
    }

    #eeg-table tr:hover {
        background-color: #FFE5B4;
    }

    .details-row {
        display: none;
        background-color: #e0e0e0;
        transition: all 0.3s ease;
    }

    .details-row.expanded {
        display: table-row;
    }

    .expanded-content {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
        text-align: left;
    }

    .button {
        background-color: #3C2D4D;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-align: left;
        max-width:min-content;
    }

    .button:hover {
        background-color: #FFC77D;
        color: #3C2D4D;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .main-row.clicked {
        background-color: #FFE5B4;
    }
  </style>

  <h1>EEG Data</h1>

  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search EEG data...">
  </div>

  <div class="table-wrapper">
    <table id="eeg-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($eeg_datas as $eeg_data) : ?>
            <!-- Main Row -->
            <tr class="main-row" data-id="<?php echo htmlspecialchars($eeg_data['eegID']); ?>">
                <td><?php echo htmlspecialchars($eeg_data['eegTitle']); ?></td>
                <td><?php echo htmlspecialchars(substr($eeg_data['eegDesc'], 0, 75)); ?>...</td>
                <td><?php echo htmlspecialchars(getResearcherName($eeg_data['userID'])); ?></td>
            </tr>

            <!-- Details Row -->
            <tr class="details-row" id="details-<?php echo htmlspecialchars($eeg_data['eegID']); ?>">
                <td colspan="3">
                    <div class="expanded-content">
                        <div><strong>Title:</strong> <?php echo htmlspecialchars($eeg_data['eegTitle']); ?></div>
                        <div><strong>Full Description:</strong> <?php echo htmlspecialchars($eeg_data['eegDesc']); ?></div>
                        <div>
                            <strong>Download EEG Data:</strong>
                            <form action="." method="post">
                                <input type="hidden" name="action" value="DLeeg">
                                <input type="hidden" name="eegID" value="<?php echo htmlspecialchars($eeg['eegID']); ?>">
                                <input type="hidden" name="researcher" value="<?php echo htmlspecialchars($eeg['userID']); ?>">
                                <input type="hidden" name="eegLink" value="<?php echo htmlspecialchars($eeg['eegPath']); ?>">
                                <input type="hidden" name="eegTitle" value="<?php echo htmlspecialchars($eeg['eegTitle']); ?>">
                                <input type="submit" class="button" value="Download">
                            </form>
                        </div>
                        <div>
                            <strong>View Linked Publication:</strong>
                            <?php if ($eeg_data['pubID'] !== null) : ?>
                                <form action="." method="post">
                                    <input type="hidden" name="action" value="DLLinkedpub">
                                    <input type="hidden" name="pubToDL" value="<?php echo htmlspecialchars($eeg_data['pubID']); ?>">
                                    <input type="submit" class="button" value="View Publication">
                                </form>
                            <?php else : ?>
                                <span>No Linked Publication</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</main>
<?php include '../view/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle expand/collapse rows
    const rows = document.querySelectorAll('.main-row');
    rows.forEach(row => {
        const detailsId = row.getAttribute('data-id');
        const detailsRow = document.getElementById('details-' + detailsId);
        row.addEventListener('click', function () {
            if (detailsRow.classList.contains('expanded')) {
                detailsRow.classList.remove('expanded');
                row.style.backgroundColor = '';
            } else {
                document.querySelectorAll('.details-row.expanded').forEach(expandedRow => {
                    expandedRow.classList.remove('expanded');
                    document.querySelector('.main-row.clicked')?.classList.remove('clicked');
                });
                detailsRow.classList.add('expanded');
                row.style.backgroundColor = '#FFE5B4';
                row.classList.add('clicked');
                detailsRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    // Filter table by search input
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        const tableRows = document.querySelectorAll('#eeg-table tbody .main-row');
        tableRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const textContent = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            if (textContent.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
