<?php include '../view/header.php'; ?>
<main>
  <style>
    /* Table Styling */
    #researchers-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
        background-color: #FFD8A2;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #researchers-table th, #researchers-table td {
        padding: 12px 15px;
        text-align: center;
    }

    #researchers-table th {
        background-color: #3C2D4D;
        color: white;
    }

    #researchers-table tr {
        border-bottom: 1px solid #ccc;
    }

    #researchers-table tr:nth-child(even) {
        background-color: #FFC77D;
    }

    #researchers-table tr:hover {
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
        display: grid;
        grid-template-columns: 150px auto;
        gap: 10px 20px; 
        align-items: center;
    }

    .input[type=submit] {
        background-color: #3C2D4D;
	color: white;
	width: 8px; 
        padding:0px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
	width:200px;
    }
     h1 {
            text-align: center;
            color:  #645D7B;
            margin-bottom: 20px;
            font-size: 2em;
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

  <h1>Researchers</h1>

  <!-- Search Option -->
  <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding: 10px;">
    <input type="text" id="search-box" placeholder="Search by Username or Organisation..." onkeyup="filterTable()" style="width: 35%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;">
  </div>

  <!-- Table Wrapper for Responsive Design -->
  <div class="table-wrapper">
    <table id="researchers-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) : ?>
            <tr class="main-row" data-username="<?php echo htmlspecialchars($user['username']); ?>" data-organisation="<?php echo htmlspecialchars($user['organisation']); ?>" style="cursor: pointer;">
                <td><?php echo htmlspecialchars($user['userID']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['resTitle']); ?></td>
                <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                <td><?php echo htmlspecialchars($user['lastName']); ?></td>
            </tr>

            <!-- Hidden row with email, organisation, user privilege, profile, and action -->
            <tr class="details-row" id="details-<?php echo htmlspecialchars($user['userID']); ?>">
                <td colspan="5" style="text-align: left; padding: 15px;">
                    <div class="expanded-content">
                        <strong>Email:</strong>
                        <span><?php echo htmlspecialchars($user['email']); ?></span>

                        <strong>Organisation:</strong>
                        <span><?php echo htmlspecialchars($user['organisation']); ?></span>

                        <strong>User Privilege:</strong>
                        <span><?php echo htmlspecialchars($user['userRole']); ?></span>

                        <strong>Full Profile:</strong>
                        <span><?php echo htmlspecialchars($user['profile']); ?></span>

                        <strong>Action:</strong>
                        <div>
                            <form action="index.php" method="post" style="display: inline;">
                                <input type="hidden" name="action" value="edit_user">
                                <input type="hidden" name="userID" value="<?php echo htmlspecialchars($user['userID']); ?>">
                                <input type="submit" class="button" value="Edit User" style="width: 150px;">
                            </form>
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

<!-- JavaScript for search and click-to-toggle behavior -->
<script>
// Toggle expand/collapse behavior with color change
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.main-row');
    rows.forEach(row => {
        const rowId = row.querySelector('td').innerText;  // Use ID cell for details row ID
        const detailsRow = document.getElementById('details-' + rowId);

        row.addEventListener('click', function() {
            detailsRow.classList.toggle('expanded');
            row.classList.toggle('clicked');

            if (detailsRow.classList.contains('expanded')) {
                detailsRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
});

// Search functionality
function filterTable() {
    const searchInput = document.getElementById('search-box').value.toLowerCase();
    const rows = document.querySelectorAll('.main-row');

    rows.forEach(row => {
        const username = row.getAttribute('data-username').toLowerCase();
        const organisation = row.getAttribute('data-organisation').toLowerCase();

        row.style.display = username.includes(searchInput) || organisation.includes(searchInput) ? '' : 'none';
    });
}
</script>
