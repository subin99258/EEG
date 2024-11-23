<?php include '../view/header.php'; ?>
<main>
  <style>
  
   body {
            font-family: Arial, sans-serif;
           background-color: #EBE8FC; /* Changed to var(--col1) for a vibrant background */
        color:  #3C2D4D;
            margin: 0;
            padding: 0px;
        }

    /* Table Styling */
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

    /* Hover Effect */
    #eeg-table tr:hover {
        background-color: #FFE5B4;
    }

    /* Expanded Details Row */
    .details-row {
        display: none;
        background-color: #e0e0e0;
        transition: all 0.3s ease;
    }

    .details-row.expanded {
        display: table-row;
    }

    /* Aligning expanded row data with headings on the left and data on the right */
    .expanded-content {
        display: grid;
        grid-template-columns: 150px auto;
        gap: 10px;
    }

    /* Align the Action button inline */
    .expanded-content .action {
        display: flex;
        align-items: center;
    }

    /* Button Styling */
    .button {
        background-color: #3C2D4D;
        color: white;
        display: inline-block;
        padding: 8px 15px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 0; 
    }

    .button:hover {
        background-color: #FFC77D;
        color: #3C2D4D;
    }

/* Flex container for the action and button */
div[style*="display: flex"] {
    align-items: center;
    gap: 10px; /* Adds the 10px gap between "Action" and the button */
    margin: 0;
    padding-top: 10px; /* Adjusts vertical padding for alignment */
}

.button {
    background-color: #3C2D4D;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #FFC77D;
    color: #3C2D4D;
}


    /* Responsive Table Wrapper */
    .table-wrapper {
        overflow-x: auto;
    }

    /* Clicked/Expanded Row Background Color Change */
    .main-row.clicked {
        background-color: #FFE5B4;
    }

    .action {
    display: inline-block;
    margin-left: 10px;
  
}


    .blurb {
        color: #FFB448;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        flex-direction: column;
        padding: 20px;
    }

    .blurb h1 {
        font-size: 3em;
        margin-bottom: 10px;
        color: #3C2D4D;
    }

    .blurb p {
        font-size: 1.2em;
        margin-bottom: 30px;
    }
  </style>

<div class="blurb">
    <h1>EEG Data</h1>
    
  </div>

  <!-- Search and Sort Options -->
  <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding: 10px;">
    <input type="text" id="search-box" placeholder="Search by Author or Title..." onkeyup="filterTable()" style="width: 30%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;">
    <select id="sort-by" onchange="sortTable()" style="width: 25%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;">
      <option value="title">Sort by Title</option>
      <option value="author">Sort by Author</option>
      <option value="date">Sort by Date</option>
    </select>
  </div>

  <!-- Table Wrapper for Responsive Design -->
  <div class="table-wrapper">
    <table id="eeg-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Author</th>
                
            </tr>
        </thead>
        <tbody>
        <?php if (empty($eegArray)) : ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px; color: #555;">Empty</td>
            </tr>
        <?php else: ?>
        <?php foreach ($eegArray as $eeg) : ?>
            <tr class="main-row" data-date="<?php echo htmlspecialchars($eeg['eegDate']); ?>" data-title="<?php echo htmlspecialchars($eeg['eegTitle']); ?>" data-author="<?php echo htmlspecialchars(getResearcherName($eeg['userID'])); ?>"  style="cursor: pointer;">
                 <td><?php echo htmlspecialchars($eeg['eegDate']); ?></td>
                <td><?php echo htmlspecialchars($eeg['eegTitle']); ?></td>
                <td><?php $researcherName = getResearcherName($eeg['userID']); echo htmlspecialchars($researcherName); ?></td>
               
            </tr>

            <!-- Hidden row with additional details -->
            <tr class="details-row" id="details-<?php echo htmlspecialchars($eeg['eegTitle']); ?>">
                <td colspan="4" style="text-align: left; padding: 15px;">
                    <div class="expanded-content">
                        <strong>Description:</strong>
                        <span><?php echo htmlspecialchars($eeg['eegDesc']); ?></span>
                        
                        <strong>EEG Data Sample:</strong>
                        <a href="<?php echo htmlspecialchars($eeg['eegPath']); ?>" target="_blank" style="color: #3C2D4D; text-decoration: underline;">View Sample</a>
                        
                        <strong>Linked Publication:</strong>
                        <?php if ($eeg['pubID'] !== null) : ?>
                            <a href="<?php echo htmlspecialchars(getPubLink($eeg['pubID'])); ?>" target="_blank" style="color: #3C2D4D; text-decoration: underline;"><?php echo htmlspecialchars(getPubTitle($eeg['pubID'])); ?></a>
                        <?php else : ?>
                            <span>No Linked Publication</span>
                        <?php endif; ?>
                    
                        <? $_SESSION['pubTitle'] = $title;
        $_SESSION['eegTitle'] = $eegTitle;
              $_SESSION['eegLink'] = $eeLink;
        $_SESSION['researcher'] = $researcher;
        $_SESSION['backTo'] = './index.php';

        // Redirect to downloadPub.php
        include('../confirmations/downloadEeg.php');
?>
                        <div style="display: flex; align-items: center; margin-top: 10px; gap: 10px;">
    <strong>Action:</strong>
    <form action="." method="post" style="margin: 0;">
        <input type="hidden" name="action" value="downloadEEG">
             <input type="hidden" name="eegID" value="<?php echo htmlspecialchars($eeg['eegID']); ?>">
                            <input type="hidden" name="researcher" value="<?php echo htmlspecialchars($eeg['userID']); ?>">
                            <input type="hidden" name="eegLink" value="<?php echo htmlspecialchars($eeg['eegPath']); ?>">
                            <input type="hidden" name="eegTitle" value="<?php echo htmlspecialchars($eeg['eegTitle']); ?>">
        <input type="submit" class="button" value="Request Download">
    </form>
</div>


                    
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
  </div>

  <div class="blurb">
    
    <p>
        Explore our EEG Data Repository, a premier resource for accessing high-quality EEG datasets tailored for academic research. Discover meticulously curated datasets anonymized to ensure rigor and integrity, ideal for investigating brainwave dynamics across various cognitive tasks, sleep patterns, and neurological conditions.
        <br><br>
        Start your exploration today and contribute to neuroscientific discovery with our comprehensive EEG datasets, available for academic use.
    </p>
  </div>
</main>
<?php include '../view/footer.php'; ?>

<!-- JavaScript for search, sort, and click-to-toggle behavior -->
<script>
// Toggle expand/collapse behavior with color change and scroll to center
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.main-row');

    rows.forEach(row => {
        const rowTitle= row.getAttribute('data-title');
        const detailsRow = document.getElementById('details-' + rowTitle);

        row.addEventListener('click', function() {
            if (detailsRow.classList.contains('expanded')) {
                detailsRow.classList.remove('expanded');
                row.style.backgroundColor = '';  // Reset color
            } else {
                detailsRow.classList.add('expanded');
                row.style.backgroundColor = '#FFE5B4';  // Change color on expand

                detailsRow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    });
});

// Search functionality
function filterTable() {
    const searchInput = document.getElementById('search-box').value.toLowerCase();
    const rows = document.querySelectorAll('.main-row');

    rows.forEach(row => {
        const title = row.getAttribute('data-title').toLowerCase();
        const author = row.getAttribute('data-author').toLowerCase();

        if (title.includes(searchInput) || author.includes(searchInput)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Sort functionality
function sortTable() {
    const sortBy = document.getElementById('sort-by').value;
    const table = document.getElementById('eeg-table');
    const rows = Array.from(table.querySelectorAll('tbody .main-row'));

    rows.sort((a, b) => {
        let valA, valB;

        if (sortBy === 'title') {
            valA = a.getAttribute('data-title').toLowerCase();
            valB = b.getAttribute('data-title').toLowerCase();
        } else if (sortBy === 'author') {
            valA = a.getAttribute('data-author').toLowerCase();
            valB = b.getAttribute('data-author').toLowerCase();
        } else if (sortBy === 'date') {
            valA = a.getAttribute('data-date');
            valB = b.getAttribute('data-date');
        }

        return valB.localeCompare(valA);
    });

    rows.forEach(row => table.querySelector('tbody').appendChild(row));
}
</script>
