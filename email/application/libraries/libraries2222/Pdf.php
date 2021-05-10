<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
//require_once dirname(__FILE__) . '/tcpdf/examples/tcpdf_include.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}
?>