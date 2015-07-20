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
        <?php
            foreach ($sheetList as $key => $value) {
                $worksheets = implode(',', $wsList[$key]);
                $string = 'Spreadsheet: <b>'.$key.'</b> with ID="<b>'.$value.'</b>"';
                $string .= " with worksheet id's: <b>".$worksheets.'</b>';
                echo $string;
            }
            echo '<br/>';
        ?>
        <br/><hr/>
        <h3 class="text-center">
            <b>
                Update spreadsheet.
            </b>
        </h3>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
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
                echo form_submit('submit', 'Update', 'class="btn btn-primary btn-block"');
                echo form_close();
                ?>
            </div>
        </div>
    </body>
</html>
