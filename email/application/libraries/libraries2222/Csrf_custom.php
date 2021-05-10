<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csrf_custom
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();
	}
	
	public function get_token_name() {
		
        if($this->ci->session->userdata('token_name')) { 
                return $this->ci->session->userdata('token_name');
        } else {
                $token_name = $this->random(10);
                $this->ci->session->set_userdata('token_name', $token_name);
                return $token_name;
        }
	}
	public function get_token_hash() {
        if($this->ci->session->userdata('token_value')) {
                return $this->ci->session->userdata('token_value'); 
        } else {
                $token = hash('sha256', $this->random(500));
                $this->ci->session->set_userdata('token_value',$token);
                return $token;
        }
 
	}
	public function check_valid($method) {
		
        if($method == 'post' || $method == 'get') {
                $post = $_POST;
                $get = $_GET;
				
			if(isset(${$method}[$this->get_token_name()]) && (${$method}[$this->get_token_name()] == $this->get_token_hash())) {
							$this->reset_token();
							return true;
					} else {
							$this->reset_token();
							return false;   
					}
			} else {
					$this->reset_token();
					return false;   
			}
	}
	public function reset_token() {
		if($this->ci->session->userdata('token_name')) {
				$this->ci->session->unset_userdata('token_name');
		}
		if($this->ci->session->userdata('token_value')) {
				$this->ci->session->unset_userdata('token_value');
		}
				return true;
		}
	public function form_names($names, $regenerate) {
 
        $values = array();
        foreach ($names as $n) {
                if($regenerate == true) {
					$this->ci->session->unset_userdata($n);
                }
			   $s= $this->ci->session->userdata('token_name') ? $this->ci->session->userdata('token_name') : $this->random(10);
			   $this->ci->session->set_userdata($n,$s);
                $values[$n] = $s;       
        }
        return $values;
	}
	private function random($len) {
        if (function_exists('openssl_random_pseudo_bytes')) {
                $byteLen = intval(($len / 2) + 1);
                $return = substr(bin2hex(openssl_random_pseudo_bytes($byteLen)), 0, $len);
        } elseif (@is_readable('/dev/urandom')) {
                $f=fopen('/dev/urandom', 'r');
                $urandom=fread($f, $len);
                fclose($f);
                $return = '';
        }
 
        if (empty($return)) {
                for ($i=0;$i<$len;++$i) {
                        if (!isset($urandom)) {
                                if ($i%2==0) {
                                             mt_srand(time()%2147 * 1000000 + (double)microtime() * 1000000);
                                }
                                $rand=48+mt_rand()%64;
                        } else {
                                $rand=48+ord($urandom[$i])%64;
                        }
 
                        if ($rand>57)
                                $rand+=7;
                        if ($rand>90)
                                $rand+=6;
 
                        if ($rand==123) $rand=52;
                        if ($rand==124) $rand=53;
                        $return.=chr($rand);
                }
        }
 
        return $return;
}
	public function no_cache()
	{
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		
	}
	
}
