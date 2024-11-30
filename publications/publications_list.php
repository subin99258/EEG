<?php include '../view/header.php'; ?>
<main>
    <div class="blurb">
        <h1>Publications</h1>
        
    </div>

    <!-- Search and Sort UI -->
    <div class="search-sort-container">
        <input type="text" id="search-box" placeholder="Search by Author or Title..." onkeyup="filterTable()">
        <select id="sort-by" onchange="sortTable()">
            <option value="title">Sort by Title</option>
            <option value="author">Sort by Author</option>
            <option value="date">Sort by Date</option>
        </select>
    </div>

    <style>
form {width: 15%;
       display: grid;
    gap: 15px;
}
  body {
            font-family: Arial, sans-serif;
           background-color: #EBE8FC; 
        color:  #3C2D4D;
            margin: 0;
            padding: 0px;
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
        
        .search-sort-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
        }

        #search-box {
            width: 30%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #sort-by {
            width: 25%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Table Styling */
        #publications-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #FFD8A2;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #publications-table th, #publications-table td {
            padding: 12px 15px;
            text-align: center;
        }

        #publications-table th {
            background-color: #3C2D4D;
            color: white;
        }

        #publications-table tr {
            border-bottom: 1px solid #ccc;
        }

        #publications-table tr:nth-child(even) {
            background-color: #FFC77D;
        }

        #publications-table tr.main-row:hover {
            cursor: pointer;
            background-color: #FFE5B4; 
        }

        /* Expanded Details Row */
        .details-row {
            display: none;
            transition: all 0.3s ease;
        }

        .details-row.expanded {
            display: table-row;
        }

        .details-row td {
            text-align: left;
            padding: 15px;
        }

        
        .expanded-content {
            display: grid;
            grid-template-columns: 150px auto;
            gap: 10px;
        }

        .expanded-content strong {
            text-align: right;
        }

        /* Button Styling */
        .button {
            background-color: #3C2D4D;
	    width: 10%;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #FFC77D;
            color: #3C2D4D;
        }
        

        /* Responsive Table Wrapper */
        .table-wrapper {
            overflow-x: auto;
        }

        
        .main-row.clicked {
            background-color: #FFE5B4;
        }
    </style>

    <!-- Table for Publications -->
    <div class="table-wrapper">
        <table id="publications-table">
            <thead>
                <tr>
                   
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th> 
                </tr>
            </thead>
            <tbody>
            <?php foreach ($publications as $publication) : ?>
               <tr class="main-row" 
     data-title="<?php echo htmlspecialchars($publication['pubTitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
     data-author="<?php echo htmlspecialchars(getResearcherName($publication['userID']) ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
     data-date="<?php echo htmlspecialchars($publication['pubDate'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <td><?php echo htmlspecialchars($publication['pubTitle']); ?></td>
                    <td><?php $researcherName = getResearcherName($publication['userID']); echo htmlspecialchars($researcherName); ?></td>
                    <td><?php echo htmlspecialchars($publication['pubDate']); ?></td> <!-- Display the date -->
                </tr>

                <!-- Hidden row with additional details -->
                <tr class="details-row" id="details-<?php echo htmlspecialchars($publication['pubTitle']); ?>">
                    <td colspan="4">
                        <div class="expanded-content">
                            <strong>Description:</strong>
                            <span><?php echo htmlspecialchars($publication['pubDesc']); ?></span>

                            <strong>Link:</strong>
                            <form action="." method="post">
                                <input type="hidden" name="action" value="downloadPublication">
                                <input type="hidden" name="publicationToDL" value="<?php echo htmlspecialchars($publication['pubID']); ?>">
				 <input type="hidden" name="researcher" value="<?php $researcherName = getResearcherName($publication['userID']); 
				echo htmlspecialchars($researcherName); ?>">
                                <input type="submit" class="button" value="Download">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="blurb">
    
        <p>
            Welcome to our EEG Data Publications Hub, your gateway to scholarly insights and findings in EEG research. Dive into a curated collection of publications that explore EEG datasets, meticulously compiled and anonymized to uphold academic rigor and integrity. Discover studies delving into brainwave patterns across diverse cognitive tasks, neurological disorders, and sleep studies, offering valuable insights into the complexities of human cognition and brain function.
        </p>
    </div>
</main>
<?php include '../view/footer.php'; ?>

<!-- JavaScript for search, sort, and click-to-toggle behavior -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.main-row');

    // Click to toggle expand/collapse and change color
    rows.forEach(row => {
        const rowId = row.getAttribute('data-title');
        const detailsRow = document.getElementById('details-' + rowId);

        row.addEventListener('click', function() {
            if (detailsRow.classList.contains('expanded')) {
                detailsRow.classList.remove('expanded');
                row.classList.remove('clicked');
            } else {
                detailsRow.classList.add('expanded');
                row.classList.add('clicked');

                // Scroll to the expanded row and center it on the screen
                detailsRow.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    });
});

// Search Functionality
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

// Sort Functionality
function sortTable() {
    const sortBy = document.getElementById('sort-by').value;
    const table = document.getElementById('publications-table');
    const rows = Array.from(table.querySelectorAll('tbody .main-row'));

    rows.sort((a, b) => {
        let valA, valB;

        if (sortBy === 'title') {
            valA = a.getAttribute('data-title').toLowerCase();
            valB = b.getAttribute('data-title').toLowerCase();
        } else if (sortBy === 'author') {
            valA = a.getAttribute('data-author').toLowerCase();
            valB = b.getAttribute('data-author').toLowerCase();x    
        } else if (sortBy === 'date') {
            valA = a.getAttribute('data-date');
            valB = b.getAttribute('data-date');
        }

        return valB.localeCompare(valA);
    });

    rows.forEach(row => table.querySelector('tbody').appendChild(row));
}
</script>
