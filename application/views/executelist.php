<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<h4>
    Sorry, your query result is too long.
</h4>
<h6>
    We split your query result into few rows and  you can insert it manually.<br/>
    Please press each button bellow to insert query result into the spreadsheet.
</h6>
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
                echo '<button type="button" id="buttonexecute';
                echo $i;
                echo '" class="btn btn-primary" onclick="window.open('."'".$urls[$i]."')".'">Execute</button>';
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
