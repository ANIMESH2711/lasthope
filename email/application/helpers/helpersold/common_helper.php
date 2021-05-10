<?php

/**
 * @author :: Vishal Tomer
 *
 * Create :: Feb-2016
 * comman helper for some comman function and these are call default without including page
 *
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// ------------------------------------------------------------------------

/**
 * @author :: Vishal Tomer
 *
 * Get random string on every time
 *
 * @access	public
 * @param	string
 * @return	string
 */

if (!function_exists('rand_string')) {
    function rand_string($length)
    {
        $numericAlphabet = '98765431ABCDEFGHIJKLMNPRSTUVWXYabcdefghjklmnpqrstuvwxyz13456789';
        $output          = "";
        for ($i = 0; $i < $length; $i++) {
            $string = "";
            $string = str_shuffle($numericAlphabet);
            $output .= $string[0];
        }
        return substr($output, 0, $length);
    }
}

if (!function_exists('captcha_string')) {
    function captcha_string($length)
    {
        $numericAlphabet = '9876543ABCDEFGHJKLMNPRSTUVWXYabcdefghjkmnpqrstuvwxyz3456789';
        $output          = "";
        for ($i = 0; $i < $length; $i++) {
            $string = "";
            $string = str_shuffle($numericAlphabet);
            $output .= $string[0];
        }
        return substr($output, 0, $length);
    }
}


/**
 * @author :: Vishal Tomer
 *
 * Get random string on every time
 *
 * @access   public
 * @param    string
 * @return   string
 */

if (!function_exists('langSess')) {
    function langSess($lang = '')
    {
        $ci = &get_instance();
        if ($ci->session->userdata('lang')) {
            $ci->session->set_userdata('lang', $lang);
        } else {
            $ci->session->set_userdata('lang', 'english');
        }
    }
}
// ------------------------------------------------------------------------

/**
 * @author :: Vishal Tomer
 *
 * Access function by alias
 */

if (!function_exists('alias')) {
    function alias($string)
    {
        $adjective = array('and', 'of', 'or', 'if', 'else', 'so');
        $string = strtolower($string);
        $string = str_replace($adjective, '', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '_', $string);
        $string = str_replace('__', '_', $string);
        return $string;
    }
}

// ------------------------------------------------------------------------


/**
 * @author :: Vishal Tomer
 *
 * preety_url function by session
 *
 * @access  public
 * @param   Boolean
 * @return  Boolean
 */

if (!function_exists('preety_url')) {
    function preety_url($string)
    {
        if (strlen($string) > 100) {
            $string = substr($string, 0, 99);
        }
        $urlStr = str_replace(' ', '-', strtolower(trim($string)));
        $urlStr = str_replace('.', '', $urlStr);
        $urlStr = preg_replace('/[^A-Za-z0-9\-]/', '', $urlStr);
        $urlStr = str_replace('--', '-', $urlStr);
        return $urlStr;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('prx')) {
    function prx($string)
    {
        echo '<pre>';
        print_r($string);
        echo '</pre>';
        die;
    }
}

if (!function_exists('pr')) {
    function pr($string)
    {
        echo '<pre>';
        print_r($string);
        echo '</pre>';
    }
}


/**
 * @author :: Vishal Tomer
 *
 * Bootstrap alert success function by session
 *
 * @access  public
 * @param   Boolean
 * @return  Boolean
 */

if (!function_exists('alert_success')) {
    function alert_success($string)
    {
        $str = '<div class="alert alert-success media fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <div class="media-left">

                    </div>
                    <div class="media-body">
                        <h4 class="alert-title">Success</h4>
                        <p class="alert-message">' . $string . '</p>
                    </div>
                </div>';
        return $str;
    }
}

/**
 * @author :: Vishal Tomer
 *
 * Bootstrap alert error function by session
 *
 * @access  public
 * @param   Boolean
 * @return  Boolean
 */

if (!function_exists('alert_error')) {
    function alert_error($string)
    {
        $str = '<div class="alert alert-danger media fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <div class="media-left">
                    	 
                    </div>
                    <div class="media-body">
                        
                        <p class="alert-message">' . $string . '</p>
                    </div>
                </div>';
        return $str;
    }
}

/**
 * @author :: Vishal Tomer
 *
 * Sweet alert success function by session
 *
 * @access  public
 * @param   Boolean
 * @return  Boolean
 */

if (!function_exists('sweet_success')) {
    function sweet_success($msg = '')
    {
        echo '<script>';
        echo 'swal("Success","' . $msg . '", "success")';
        echo '</script>';
    }
}

/**
 * @author :: Vishal Tomer
 *
 * Sweet alert error function by session
 *
 * @access  public
 * @param   Boolean
 * @return  Boolean
 */

if (!function_exists('sweet_error')) {
    function sweet_error($msg = '')
    {
        echo '<script>';
        echo 'swal("Error","' . $msg . '", "error")';
        echo '</script>';
    }
}

if (!function_exists('getData')) {
    function getData($tablenm, $col, $where, $f_org)
    {
        if ($where == 'in_program_type') {
            $where_in = $f_org;
        } else {
            $where_in = array('1', 'Y');
        }
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select($col);
        $ci->db->from($tablenm);
        $ci->db->where_in($where, $where_in);
        $query = $ci->db->get();
        // prx($ci->db->last_query());
        $num = $query->num_rows();
        if ($num > 0) {
            $results = $query->result();
            if ($results !== "" && $results != null) {
                return $results;
            }
        } else {
            return 0;
        }
    }
}
if (!function_exists('getInstitutes')) {
    function getInstitutes($filter, $limit, $start)
    {
        $filter['in_status'] = 1;
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('in_id,in_code,in_name,in_d_id,in_program_type,in_addr');
        $ci->db->from('ur_institute');
        $ci->db->where($filter);
        $ci->db->limit($limit, $start);
        $query = $ci->db->get(); //echo "<pre>".$ci->db->last_query(); exit;
        $num = $query->num_rows();
        if ($num > 0) {
            $results = $query->result();
            if ($results !== "" && $results != null) {
                return $results;
            }
        } else {
            return 0;
        }
    }
}
if (!function_exists('getInstitutesCount')) {
    function getInstitutesCount($filter)
    {
        $filter['in_status'] = 1;
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('in_id,in_code,in_name,in_d_id');
        $ci->db->from('ur_institute');
        $ci->db->where($filter);
        $query = $ci->db->get(); //echo "<pre>".$ci->db->last_query(); exit;
        return $query->num_rows();
    }
}

if (!function_exists('getsessdata')) {
    function getsessdata($user)
    {
        $ci = &get_instance();
        $sess_key = $ci->session->userdata($user)['session_var'];
        $sess_data = $ci->session->userdata($sess_key);
        return $sess_data;
    }
}
if (!function_exists('getsessadmindata')) {
    function getsessadmindata($user)
    {
        $ci = &get_instance();
        $sess_key = $ci->session->userdata($user)['session_var'];
        $sess_data = $ci->session->userdata($sess_key);
        return $sess_data;
    }
}
if (!function_exists('designation')) {
    function designation($where = [])
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('udg_id as id,udg_dsignation as name,udg_is_active');
        $ci->db->from('ur_designation');
        $ci->db->where($where);
        // $ci->db->where('ur_role_name !=', 'STU');
        $query = $ci->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            $results = $query->result();
            if ($results !== "" && $results != null) {
                return $results;
            }
        } else {
            return 0;
        }
    }
}

if (!function_exists('role')) {
    function role($where = [])
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('ur_id as id,ur_display_name as name,ur_status');
        $ci->db->from('ur_role');
        $ci->db->where($where);
        // $ci->db->where('ur_role_name !=', 'STU');
        $query = $ci->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            $results = $query->result();
            if ($results !== "" && $results != null) {
                return $results;
            }
        } else {
            return 0;
        }
    }
}


if (!function_exists('getInstid')) {
    function getInstid($userid, $tblname)
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('inst_id');
        $ci->db->from($tblname);
        $ci->db->where('meta_id', $userid);
        $results = $ci->db->get()->row();
        if ($results !== "" && $results != null) {
            return $results;
        } else {
            return 0;
        }
    }
}

if (!function_exists('getStudid')) {
    function getStudid($instId, $tblname)
    {
        $ci = &get_instance();
        $ci->load->database();
        $this->db->select('meta_id');
        $this->db->from($tblname);
        $this->db->where('inst_id', $instId);
        $results = $this->db->get()->row();
        if ($results !== "" && $results != null) {
            return $results;
        } else {
            return 0;
        }
    }
}

if (!function_exists('department')) {
    function department($where = [])
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('ud_id as id,ud_department as name,ud_status');
        $ci->db->from('ur_department');
        $ci->db->where($where);
        $ci->db->order_by('ud_department');
        $query = $ci->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            $results = $query->result();
            if ($results !== "" && $results != null) {
                return $results;
            }
        } else {
            return 0;
        }
    }
}
