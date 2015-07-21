<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Homepage</title>
    </head>
    <body>
        <h3>
            Below is/are spreadsheet(s) on your Drive.
        </h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Spreadsheet ID
                    </th>
                    <th>
                        Available Worksheet ID
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($sheetList as $key => $value) {
                        $worksheets = implode(',', $wsList[$key]);
                        echo "<tr>";
                        echo "<td>".$key."</td>";
                        echo "<td>".$value."</td>";
                        echo "<td>".$worksheets."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <hr/>
        <div class="row">
            <div class="col-md-6 content-left">
                <h3 class="text-center">
                    <b>
                        Update spreadsheet.
                    </b>
                </h3>
                <?php
                echo form_open('Testing/update');
                echo '<div class="form-group">';
                echo form_label('Spreadsheet ID', 'sheetid');
                echo form_input('sheetid', '', 'class="form-control" placeholder="ex. 1LX2q....."');
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Worksheet ID', 'worksid');
                echo form_input('worksid', '', 'class="form-control" placeholder="ex. od6"');
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Cell ID', 'cellid');
                echo form_input('cellid', '', 'class="form-control" placeholder="ex. A2"');
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Updated Value', 'upvalue');
                echo form_input('upvalue', '', 'class="form-control" placeholder="input value here"');
                echo '</div>';
                echo form_submit('submit', 'Update', 'class="btn btn-primary text-center"');
                echo form_close();
                ?>
            </div>
            <div class="col-md-6 content-right">
                <h3 class="text-center">
                    <b>
                        Write to new spreadsheet.
                    </b><br/>
                    <small>You need to re-authorize for this function, if you never use this function before.</small>
                </h3>
                <?php
                echo form_open('Testing/write');
                echo '<div class="form-group">';
                echo form_label('Spreadsheet Name', 'sheetname');
                echo form_input('sheetname', '', 'class="form-control" placeholder="ex. report-17-August"');
                echo '</div>';
                echo '<div class="form-group">';
                echo form_label('Value to be written', 'writevalue');
                echo form_input('writevalue', '', 'class="form-control" placeholder="separate multiple value with underscore (_)"');
                echo '</div>';
                echo form_submit('submit', 'Write', 'class="btn btn-primary text-center"');
                echo form_close();
                ?>
            </div>
        </div>
    </body>
</html>
