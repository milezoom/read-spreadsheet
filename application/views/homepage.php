<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('form');
?>
<br/>
<div class="container box-block">
    <?php
        if($is_token_exists)
        {
            echo "<h4>Token exist, see list of your spreadsheet with button below.</h4><br/>";
            echo form_open('Homepage/lists');
            echo form_submit('submit','List File','class="btn btn-primary btn-block"');
            echo form_close();
        } else {
            echo "<h4>Missing token, please authorize this app with button below.</h4><br/>";
            echo form_open('Homepage/authorize');
            echo form_submit('submit','Authorize','class="btn btn-danger btn-block"');
            echo form_close();
        }
    ?>
</div>
