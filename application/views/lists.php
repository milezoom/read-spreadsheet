<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('form');
?>
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
                Worksheet Name (ID)
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($sheetList as $key => $value) {
                $worksheets = implode(',', $wsList[$key]);
                echo '<tr>';
                echo '<td>'.$key.'</td>';
                echo '<td>'.$value.'</td>';
                echo '<td>'.$worksheets.'</td>';
                echo '</tr>';
            }
        ?>
    </tbody>
</table>
<hr/>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h3 class="text-center">
            <b>
                Put query result to spreadsheet.
            </b><br/>
            <small>You need to re-authorize for this function, if you never use this function before.</small>
        </h3>
        <?php
            echo form_open('Spreadsheet/writeFromQuery');
            echo '<div class="form-group">';
            echo form_label('Spreadsheet Name', 'sheetname');
            echo form_input('sheetname', '', 'class="form-control" placeholder="ex. report-17-August"');
            echo '</div>';
            echo '<div class="form-group">';
            echo form_label('Query to be executed', 'query');
            echo form_input('query', '', 'class="form-control" placeholder="put your query here"');
            echo '</div>';
            echo form_submit('submit', 'Execute', 'class="btn btn-primary text-center"');
            echo form_close();
        ?>
    </div>
</div>
<br/>
