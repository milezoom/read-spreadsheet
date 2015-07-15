<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Homepage</title>
    </head>
    <body>
        <p>
            Before writing to spreadsheet in your Drive, please authorize this app using button below.
        </p>
        <div>
            <?php
                echo form_open('Homepage/authorize');
                echo form_submit('submit','Authorize','class="btn btn-default"');
                echo form_close();
            ?>
        </div>
    </body>
</html>
