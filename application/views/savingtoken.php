<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
        if ($is_exists === true) {
            echo '<p>Token retrieved successfully. List file using button below.</p>';
        } else {
            echo '<p>Failed to save token.</p>';
        }
        ?>
    </p>
    <div>
        <?php
            echo form_open('Testing');
            echo form_submit('submit', 'List File');
            echo form_close();
        ?>
    </div>
</body>
</html>
