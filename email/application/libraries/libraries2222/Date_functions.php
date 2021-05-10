<?php 
/* Date_Functions library contains the method related to date/time operations * 
 * @since : 28 May 2015
 * @package: date_functions.php */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Date_Functions 
{    
    /**
     * Return current datetime to set into database
     * @param type $datetime
     * @return type 
     */
    function current_db_datetime() {
        $datestring = "Y-m-d H:i:s";
        $time = time();
	return date($datestring, $time); 
    }
    
    /**
     * Return changed date format to set into database
     * @param type $datetime
     * @return type 
     */
    function change_date_format($date = "") {        
        $datestring = "Y-m-d H:i:s";
        $newDate = date($datestring, strtotime($date));
        return $newDate;
    }
    
    /**
     * Return format of date field only to set into database
     * @param type $date
     * @return type 
     */
    function change_only_date_format($date = "") {        
        $datestring = "Y-m-d";
        $newDate = date($datestring, strtotime($date));
        return $newDate;
    }

    /**
     * Return display date format 
     * Date format like MM-DD-YYY 
     * @param type $datetime
     * @return type 
     */
    function get_dateFormat($datetime) {
        $datestring = "m/d/Y";        
        return date($datestring, strtotime($datetime));
    }
    
    /**
     * Return display date format 
     * Date format like DD-MM-YYY 
     * @param type $datetime
     * @return type 
     */
    function get_custom_dateFormat($datetime) {
        $datestring = "d/m/Y";        
        return date($datestring, strtotime($datetime));
    }
    /*
     * @Description : used for return current time
     * @Param : none
     * @Return time
     */
    function get_current_time(){                   
        return date('h:i A', time());
    }
}
?>