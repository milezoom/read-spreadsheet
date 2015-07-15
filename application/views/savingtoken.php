<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Saving Token</title>
</head>
<body>
    <p>
        <?php
        if($is_exists === TRUE){
            echo "Token saved successfully.";
        } else {
            echo "Failed to save token.";
        }
        ?>
    </p>
    <div>
        <?php
            echo form_open('Testing');
            echo form_submit('submit','List File');
            echo form_close();
        ?>
    </div>
</body>
</html>
