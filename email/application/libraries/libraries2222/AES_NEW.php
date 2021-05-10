<?php

/**
 *  Aes encryption
 * 
 * @author      Pankaj Garg
 */

class AES_NEW {
  
  const M_CBC = 'cbc';
  const M_CFB = 'cfb';
  const M_ECB = 'ecb';
  const M_NOFB = 'nofb';
  const M_OFB = 'ofb';
  const M_STREAM = 'stream';
  
  protected $key;
  protected $cipher;
  protected $data;
  protected $mode;
  protected $IV;

/**
* 
* @param type $data
* @param type $key
* @param type $blockSize
* @param type $mode
*/
  function __construct($param) {
    $blockSize = isset($param['blockSize']) ? $param['blockSize'] : null;
    $mode = isset($param['mode']) ? $param['mode'] : null;
    $this->setBlockSize($blockSize);
    $this->setMode($mode);
    $this->setIV("");
  }
  
/**
* 
* @param type $blockSize
*/
  public function setBlockSize($blockSize) {
    switch ($blockSize) {
      case 128:
      $this->cipher = MCRYPT_RIJNDAEL_128;
      break;
      
      case 192:
      $this->cipher = MCRYPT_RIJNDAEL_192;
      break;
      
      case 256:
      $this->cipher = MCRYPT_RIJNDAEL_256;
      break;
  
      default:
      $this->cipher = MCRYPT_RIJNDAEL_256;
      break;
    }
  }
  
/**
* 
* @param type $mode
*/
  public function setMode($mode) {
    switch ($mode) {
      case AES_NEW::M_CBC:
      $this->mode = MCRYPT_MODE_CBC;
      break;
      case AES_NEW::M_CFB:
      $this->mode = MCRYPT_MODE_CFB;
      break;
      case AES_NEW::M_ECB:
      $this->mode = MCRYPT_MODE_ECB;
      break;
      case AES_NEW::M_NOFB:
      $this->mode = MCRYPT_MODE_NOFB;
      break;
      case AES_NEW::M_OFB:
      $this->mode = MCRYPT_MODE_OFB;
      break;
      case AES_NEW::M_STREAM:
      $this->mode = MCRYPT_MODE_STREAM;
      break;
      default:
      $this->mode = MCRYPT_MODE_ECB;
      break;
    }
  }
  
/**
* 
* @return boolean
*/
  public function validateParams() {
    if ($this->data != null &&
        $this->key != null &&
        $this->cipher != null) {
      return true;
    } else {
      return false;
    }
  }
  
  public function setIV($IV) {
        $this->IV = $IV;
  }
  
  protected function getIV() {
      if ($this->IV == "") {
        $this->IV = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
      }
      return $this->IV;
  }
  
  public function safe_b64encode($string) {
      $string = base64_encode($string);
      $string = str_replace(array('+','/','='),array('-','_',''), $string);
      return $string;
  }

  public function safe_b64decode($string) {
      $string = str_replace(array('-','_'),array('+','/'), $string);
      $mod4 = strlen($string) % 4;
      if ($mod4) {
          $string .= substr('====', $mod4);
      }
      return base64_decode($string);
  }
  
/**
* @return type
* @throws Exception
*/
  public function encrypt($data, $key) {
    $this->data = $data;
    $this->key = $key;
    if ($this->validateParams()) {
      return trim($this->safe_b64encode(
        mcrypt_encrypt(
          $this->cipher, $this->key, $this->data, $this->mode, $this->getIV())));
    } else {
      throw new Exception('Invlid params!');
    }
  }

/**
* 
* @return type
* @throws Exception
*/
  public function decrypt($data, $key) {
    $this->data = $data;
    $this->key = $key;
    if ($this->validateParams()) {
      return trim(mcrypt_decrypt(
        $this->cipher, $this->key, $this->safe_b64decode($this->data), $this->mode, $this->getIV()));
    } else {
      throw new Exception('Invlid params!');
    }
  }
  
}