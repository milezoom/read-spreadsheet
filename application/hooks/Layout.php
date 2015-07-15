<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends CI_Hooks {
    function show_layout()
    {
        global $OUT;

        $this->CI =& get_instance();
        $output = $this->CI->output->get_output();

        if($this->CI->layout == "Yes") {
            $layoutName = $this->CI->layoutName;

            $default = BASEPATH .'../application/layouts/'.$layoutName.'.php';

            $layout = $this->CI->load->file($default,true);

            $layout = str_replace("{body}", $output, $layout);

            $title = NULL;
            if(isset($this->CI->title)) {
                $title = $this->CI->title;
                $title = " | ".ucfirst($title);
            }

            $layout = str_replace("{title}",$title,$layout);
        } else {
            $layout = $output;
        }

        $OUT->_display($layout);
    }
}
?>
