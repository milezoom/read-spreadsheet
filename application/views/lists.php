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
            Below is/are spreadsheet(s) on your Drive.
        </p>
        <div>
            <?php
                print_r($list);
            ?>
        </div>
    </body>
</html>
