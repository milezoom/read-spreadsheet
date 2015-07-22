<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('form');
?>
<br/>
<div class="container">
    <?php
        if($is_token_exists)
        {
            echo '<h4 class="text-center">Token exist, see list of your spreadsheet with button below.</h4><br/>';
            echo '<div class="box-block">';
            echo form_open('Homepage/lists');
            echo form_submit('submit','List File','class="btn btn-primary btn-block"');
            echo form_close();
            echo '</div>';
        } else {
            echo '<h4 class="text-center">Missing token, please authorize this app with button below.</h4><br/>';
            echo '<div class="box-block">';
            echo form_open('Homepage/authorize');
            echo form_submit('submit','Authorize','class="btn btn-danger btn-block"');
            echo form_close();
            echo '</div>';
        }
    ?>
</div>
