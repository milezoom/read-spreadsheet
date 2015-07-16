<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('form');
?>
<!-- Commented out for development process --><!--
<p>
    Before writing to spreadsheet in your Drive, please authorize this app using button below.
</p>
<div>
    <?php
        //echo form_open('Homepage/authorize');
        //echo form_submit('submit', 'Authorize', 'class="btn btn-default"');
        //echo form_close();
    ?>
</div>
-->
<br/>
<h4 class="text-center">
    Login using email/password or Sign your email using form below.
</h4>
<div class="container well box-block">
    <?php
        echo form_open('');
        echo '<div class="form-group">';
        echo '<label for="email">Email</label>';
        echo '<input type="email" class="form-control" id="email">';
        try {
            if (!empty($error_email)) {
                echo '<div class="alert alert-danger" role="alert">'.$error_email.'</div>';
            }
        } catch (Exception $e) {
        }
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="password">Password</label>';
        echo '<input type="password" class="form-control" id="password">';
        try {
            if (!empty($error_email)) {
                echo '<div class="alert alert-danger" role="alert">'.$error_pass.'</div>';
            }
        } catch (Exception $e) {
        }
        echo '</div>';
        echo form_submit('submit', 'Login', 'class="btn btn-danger btn-block"');
        echo '<br/>';
        echo form_close();
        echo form_open('Homepage/signup');
        echo form_submit('submit', 'Sign Email', 'class="btn btn-primary btn-block"');
        echo form_close();
    ?>
</div>
