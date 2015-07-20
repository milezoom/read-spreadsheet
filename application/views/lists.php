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
                print_r($sslist);
            ?>
        </div>
        <br>
        <div>
            <?php
                print_r($wslist);
            ?>
        </div>
        <br>
        <div>
            <?php
                print_r($wsdlist);
            ?>
        </div>
        <br>
        <div>
            <?php
                print_r($wsclist);
            ?>
        </div>
    </body>
</html>
