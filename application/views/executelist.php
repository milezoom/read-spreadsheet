<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<h3>
    Sorry, your query result is too long, so we need to breakdown into few rows and executed it manually.<br/>
    Please press each button bellow to insert query result into the spreadsheet.
</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                Rows:
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            for($i = 0; $i < count($rowcount); $i++){
                echo "<tr>";
                echo "<td>";
                echo $rowcount[$i];
                echo "</td>";
                echo "<td>";
                echo '<button type="button" class="btn btn-primary" onclick="window.open('."'".$urls[$i]."')".'">Execute</button>';
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
