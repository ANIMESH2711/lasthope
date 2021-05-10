<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_activity_log {

    public $ldb;

    function __construct() {
        $CI = & get_instance();
        $this->ldb = $CI->load->database('logdata', TRUE);

    }

    function activity_logger(array $input_log_data = array()) {
        /*
        $insert = 'INSERT INTO activity_log SET';
        $column = array();
        if(!empty($input_log_data) AND is_array($input_log_data))
        {
            if(count(array_filter($input_log_data)) != count($input_log_data)) { return false; }
            foreach($input_log_data as $key => $val)
            {
                $column[] = " " . $key . " = '" . $val . "'";
            }
            $insert .= join(', ',$column);
        }
        $this->ldb->query($insert);
        */
        $log_content = implode(" | ", $input_log_data);
        $log = $log_content.PHP_EOL;
        file_put_contents('/logs/log_'.date("Y-m-d").'.txt', $log, FILE_APPEND);
        return true;
    }

    function getClassFunction($clsFun) {
        $query = 'SELECT id FROM bid_log_trail WHERE class_function = "' . $clsFun . '" AND is_active = 1;';
        return $this->ldb->query($query)->row();
    }
    

}
