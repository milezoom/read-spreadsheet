<?php $this->load->helper('url'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Site name ::
        <?php echo $this->pageTitle; ?>
    </title>
</head>

<body>
    <div id="wrapper" class="container">
        <h4><b><?php echo $this->headerText; ?></b></h4>
        <div class="content">
            {body}
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            echo "&copy; ".date("Y");
            ?>
        </div>
    </footer>
</body>

</html>
