<?php
/* Common_Functions library contains the method related to common operations. * 
 * @since : 27 May 2015
 * @package: common_functions.php */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common_Functions
{       
    public  $ci ;    
    public  $set_arr_data="" ;
    
    public function __construct() {
        $this->ci = & get_instance();                          
        $this->ci->load->database();
        $this->load_all_settings();
        $this->no_cache();            
        $this->ci->load->helper('cookie');     
        set_cookie(array("name"=>"base_url", "value" => base_url(),"expire"=>3600));
    }
    
    /**
     * to load dynamic settings from database into CI config array
     */
    function load_all_settings(){                
        $query = $this->ci->db->get("configuration");
        $all_settings = $query->result();
        if(!empty($all_settings)){
            foreach ($all_settings as $setting){
                $this->ci->config->set_item($setting->key, $setting->value);
            }
        }
    }
    
    
    /*
     * @Description : used for manage window back management
     * @Param :none
     * @Return : none;
     */
    private function no_cache(){
        $this->ci->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->ci->output->set_header('Pragma: no-cache');
        $this->ci->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");        
    }
    
   
   /*
     *@Description :  function is used for create an message box for success error
     *@Param : $type , $msg
     *@Return:$alert_html
     */
   public function get_alert_html($type, $msg,$show_alert_type='') {
        if (empty($type) || empty($msg))
            return "";

        $alert_class = "";
        $alert_heading = "";
        switch ($type) {
            case "success":
                $alert_class = "alert-success";
                $alert_heading = ($show_alert_type != 0) ? "Success!&nbsp;" : "";
                break;
            case "error":
                $alert_class = "alert-danger";
                $alert_heading = ($show_alert_type != 0) ? "Error!&nbsp;" : "";
                break;
            case "info":
                $alert_class = "alert-info";
                $alert_heading = "Info!&nbsp;";
                break;
            case "warning":
                $alert_class = "alert-warning";
                $alert_heading = "Warning!&nbsp;";
                break;
        }
        $alert_html = "<div class=\"alert $alert_class\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><strong>" . $alert_heading . "</strong>" . $msg . "</div>";
        return $alert_html;
    }	
    
}
?>
