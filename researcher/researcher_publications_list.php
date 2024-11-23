<?php include '../view/header.php'; ?>
<main>
  <h1>Publications</h1>

 <!-- Search box outside the table -->
    <div style="text-align: right; margin-right: 40px; margin-bottom: 10px;">
        <input type="text" id="searchInput" placeholder="Search by Title..." style="width: 30%; padding: 5px;">
    </div>

    <table id="dataTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Download/View Publication</th>
                <th>Download/View Linked EEG Data</th>
            </tr>
        </thead>
        <tbody>
        </tr>

        <!-- Set string length for truncation -->
        <?php $truncateLength = 75;?>
	
        <?php if (!empty($publications)) : ?>
                <?php 
                // Sort publications by title
                usort($publications, function($a, $b) {
                    return strcmp(strtolower($a['date']), strtolower($b['date']));
                });
                
		?>

           <?php foreach ($publications as $publication) : ?>
            <tr>
                <td><?php echo htmlspecialchars($publication['date']); ?></td> <!-- Display row number as ID -->
                        <td><?php echo htmlspecialchars($publication['pubTitle']); ?></td>
                        <td class="description-cell" data-full-description="<?php echo htmlspecialchars($publication['pubDesc']); ?>">
                            <?php 
                            $truncatedDesc = htmlspecialchars(substr($publication['pubDesc'], 0, $truncateLength));
                            echo $truncatedDesc . (strlen($publication['pubDesc']) > $truncateLength ? "..." : ""); 
                            ?>
                        </td>
                         
                <!-- Include elipsis if required -->
                <?php 
                    if (strlen($publication['pubDesc']) >= $truncateLength) {
                        echo "</td>";
                    }
                    else {
                        echo "</td>";
                    }
                ?>

                <?php $researcherName = getResearcherName($publication['userID']) ?>

                <td><?php echo htmlspecialchars($researcherName); ?></td>


                <td><form action="." method="post">
                    <input type="hidden" name="action" value="DLpub">
                    <input type="hidden" name="pubToDL"
                       value="<?php echo htmlspecialchars($publication['pubID']); ?>">
                    <input type="hidden" name="researcher"
                       value="<?php echo htmlspecialchars($researcherName); ?>">
                    <input type="hidden" name="title"
                       value="<?php echo htmlspecialchars($publication['pubTitle']); ?>">
                    <input type="submit" value="Download">
                    </form>
                </td>
                <td>
                    <?php if ($publication['eegID'] !== null) : ?>
                        <form action="." method="post">
                            <input type="hidden" name="action" value="DLLinkedEeg">
                            <input type="hidden" name="eegToDL" value="<?php echo htmlspecialchars($publication['eegID']); ?>">
                            <input type="hidden" name="researcher"
                                    value="<?php echo htmlspecialchars($researcherName); ?>">                            
                            <input type="submit" value="View EEG">
                        </form>
                    <?php else : ?>
                        No Linked EEG Data
                    <?php endif; ?>
                </td>
        </tr>
        <?php endforeach; ?>
	 <?php else: ?>
                <tr>
                    <td colspan="5">No publications found.</td>
                </tr>
            <?php endif; ?>

    </table>
        </tbody>
    </table>
<script>
        // Search function to filter by title
        function filterByTitle() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toLowerCase();
            table = document.getElementById('dataTable');
            tr = table.getElementsByTagName('tr');

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }       
            }
        }

        // Trigger the search function when typing
        document.getElementById('searchInput').addEventListener('keyup', filterByTitle);

        // Expand full description on hover
        document.addEventListener('DOMContentLoaded', function() {
            var rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(function(row) {
                var descriptionCell = row.querySelector('.description-cell');
                var fullDescription = descriptionCell.getAttribute('data-full-description');

                row.addEventListener('mouseover', function() {
                    descriptionCell.textContent = fullDescription;
                    descriptionCell.classList.add('expanded-description');
                });

                row.addEventListener('mouseout', function() {
                    var truncatedDesc = fullDescription.substr(0, 75);
                    descriptionCell.textContent = truncatedDesc + (fullDescription.length > 75 ? "..." : "");
                    descriptionCell.classList.remove('expanded-description');
                });
            });
        });
    </script>


</main>
<?php include '../view/footer.php'; ?>
