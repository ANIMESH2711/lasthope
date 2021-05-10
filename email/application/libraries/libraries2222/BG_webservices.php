<?php

/*
 * This code is developed by Sandeep Kuamwat@25-03-2018
 * This will be used for ePBG and EMD service information.
 * BG_webservices Class

 * Task: Update New MCA 21 Web services with SOAP 1.2 request
 * Last Update: Sandeep Kumawat@25-03-2018
 * 
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class BG_webservices {

    function __construct() {
        $this->_ci = & get_instance();
        $this->db = $this->_ci->load->database('default', TRUE);
        $this->_ci->load->helper('url');
        date_default_timezone_set("Asia/Calcutta");
    }

   

    /**
     * Fetch the Company information
     *
     * @access	public
     * @input   Company CIN Number
     * @return	Company information like name, email and financialDetails etc
     */
    public function is_pbg_applied_check($bid_id) {
        $this->db->select('bg_buyer_info.buyer_id as bu_id, bg_buyer_info.bid_name as b_name, bg_buyer_info.status as app_status, br.f7023 ,br.f7025 ,br.f7029 ,br.f7033 ,br.f7034 ,br.f7039 ,br.cov_p1 ,br.cov_p2 ,br.error_code ,br.error_desc ,br.status');
        $this->db->from('bg_buyer_info');
        $this->db->join('bg_bank_responce as br', 'br.f7023=bg_buyer_info.bid_name', 'LEFT');
        $this->db->where('bid_id', $bid_id);
        $this->db->order_by("br.created_on", "DESC");
        $this->db->limit(1);
        $dataparms = $this->db->get();
        if ($dataparms->num_rows() > 0) {
            return $dataparms->result_array();
        } else {
            return NULL;
        }
    }

    public function get_epbg_draftpdf($bid) {

        $this->db->select('bgb.bank_bic as token,bgb.bank_branch_name as token_bank, bi.bid_name as bid_name, bi.buyer_id, bi.bid_id as bid_id, format(((bi.total_amount*bi.percentage_bg_required)/100),2) as total_bg_required,((bi.total_amount*bi.percentage_bg_required)/100) as total_bg_required_number,bi.percentage_bg_required as bg_percentage_required,bi.advicory_bank_id as buyer_advicory_bank_id,bi.buyer_bank_id as buyer_bank_id,bi.remarks as bid_remakrs, bi.validity_bg_required as bg_validity_reqired,u.u_id as user_id,  u.u_firstname as buyer_firstname, u.u_lastname as buyer_lastname, u.u_mobile_no as buyer_mobile, u.u_email as buyer_email, u.u_registration_no as buyer_regno, u.u_registration_no as user_reg_no, su.u_firstname as seller_firstname, su.u_lastname as seller_lastname, su.u_mobile_no as seller_mobile, su.u_email as seller_email, su.u_registration_no as seller_regno,bb.bank_ifsc as beneficiaryIFSC, CONCAT(bb.bank_name, " ", bb.bank_branch) as beneficiaryBank,sup.s_comp_name', false);
        $this->db->from('bg_buyer_info as bi');
        $this->db->join('users as u', 'u.u_id=bi.buyer_id', 'INNER');
        $this->db->join('bg_banks as bgb', 'bgb.id=bi.advicory_bank_id', 'INNER');
        $this->db->join('users as su', 'su.u_id=bi.seller_id', 'INNER');
        $this->db->join('bg_buyer_bank as bb', 'bb.id=bi.buyer_bank_id', 'INNER');
        $this->db->join('suppliers as sup', 'su.u_id=sup.s_user_id', 'INNER');

        $this->db->limit(1);
        $this->db->where('bi.bid_id', $bid);
        $dataparms = $this->db->get();
        if ($dataparms->num_rows() > 0) {
            foreach ($dataparms->result_array() as $row) {
                $row['buyer_department'] = "";
                $row['buyer_designation'] = "";
                $department = $this->FetchUserDepartment($row['buyer_id']);
                $row['buyer_department'] = htmlspecialchars_decode(html_entity_decode($department->ministry)) . ' ' . htmlspecialchars_decode(html_entity_decode($department->org)) . ' ' . htmlspecialchars_decode(html_entity_decode($department->dept));
                $row['buyer_designation'] = $department->buyer_designation;


                $result[] = $row;
            }
            return $result;
        } else {
            return NULL;
        }
    }

    function int_to_word($number) {
        $number = str_replace(',', '', $number);
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
        return ucwords($result) . "Rupees ";
    }

    function GetEMDDetails($b_id) {

/*        $this->db->select('bnk.id as advicory_bnk_id,bnk.bank_name as advicory_bnk,bnk.bank_ifsc as advicory_bnk_ifsc,bnk.bank_branch_name as advicory_bank_branch_name,bb.bank_name,bb.bank_ifsc,bb.bank_acctn_no,bi.validity_bg_required,bi.validity_emd_required,bi.remarks,bb.bank_acctn_name,bi.total_emd_amount,bi.percentage_bg_required,bi.emd_validity_date,bi.buyer_id,bids.b_id,bids.b_bid_number,bids.b_bid_start_date,bids.b_bid_end_date,ba.ba_bid_validity,ba.ba_official_details');
        $this->db->from('bg_buyer_info as bi');
        $this->db->join('bids', 'bids.b_id = bi.bid_id', 'left');
        $this->db->join('bid_attributes as ba', 'bids.b_id = ba.ba_bid_id', 'left');
        $this->db->join('bg_buyer_bank as bb', 'bb.id = bi.buyer_bank_id', 'left');
        $this->db->join('bg_banks as bnk', 'bnk.id = bi.advicory_bank_id', 'left');
        $updateData = array('bi.bid_id' => $b_id,
            'bb.`status`' => 1, 'bnk.`status`' => 1, 'bi.`type`' => 2);
        $this->db->where($updateData);
        $query = $this->db->get();
        $emd = $query->row();
        $emd->emd_amount_words=$this->int_to_word($emd->total_emd_amount);
*/
        $this->db->select('bnk.id as advicory_bnk_id,bnk.bank_name as advicory_bnk,bnk.bank_ifsc as advicory_bnk_ifsc,bnk.bank_branch_name as advicory_bank_branch_name,bi.validity_bg_required,bi.validity_emd_required,bi.remarks,bi.total_emd_amount,bi.percentage_bg_required,bi.emd_validity_date,bi.buyer_id,bids.b_id,bids.b_bid_number,bids.b_category_name,bids.b_bid_start_date,bids.b_bid_end_date,ba.ba_bid_validity,ba.ba_official_details,bids.b_all_config,ba.ba_bid_validity_offer,ba.ba_other_data');
        $this->db->from('bg_buyer_info as bi');
        $this->db->join('bids', 'bids.b_id = bi.bid_id', 'left');
        $this->db->join('bid_attributes as ba', 'bids.b_id = ba.ba_bid_id', 'left');
        $this->db->join('bg_banks as bnk', 'bnk.id = bi.advicory_bank_id', 'left');
        $updateData = array('bi.bid_id' => $b_id, 'bnk.`status`' => 1, 'bi.`type`' => 2, 'bi.status' => 1);
        $this->db->where($updateData);
        $query = $this->db->get();//echo $this->db->last_query();exit;
        $emd = $query->row();
        if($query->num_rows())
        {
            $emd->emd_amount_words=$this->int_to_word($emd->total_emd_amount);
            return $emd;
        }else{
            return false;
        }
        
    }
    
     function GetSellerEMDDetails($sd_seq_id) {

        $this->db->select('*');
        $this->db->from('seller_data as sd');
        $whereData = array('sd.sd_seq_id' => $sd_seq_id);
        $this->db->where($whereData);
        $query = $this->db->get();
        $seller_data = $query->row();
        return $seller_data;
    }
    
    function GetSellerDetailsbycomp($sd_comp_id) {

        $this->db->select('*');
        $this->db->from('seller_data as sd');
        $whereData = array('sd.sd_user_id' => $sd_comp_id);
        $this->db->where($whereData);
        $query = $this->db->get();
        $seller_data = $query->row();
        return $seller_data;
    }

    function call_seller_emdintimation($seller_seqid, $bid_id) {

        $GetEMDDetails = $this->GetEMDDetails($bid_id);

        if (!empty($GetEMDDetails)) {
            $data = array(
                'buyer_id' => $GetEMDDetails->buyer_id,
                'bid_id' => $bid_id,
                'bid_name' => $GetEMDDetails->b_bid_number,
                'total_amount' => $GetEMDDetails->total_emd_amount,
                'total_emd_amount' => $GetEMDDetails->total_emd_amount,
                'percentage_bg_required' => $GetEMDDetails->percentage_bg_required,
                'validity_emd_required' => $GetEMDDetails->validity_emd_required, //$validity_date,
                'advicory_bank_id' => $GetEMDDetails->advicory_bnk_id,
                'seller_id' => $seller_seqid,
                'created_by' => $this->_ci->session->userdata('user_detail')->comp_id,
                'buyer_bank_id' => 1,
                'status' => 2);
            
         
            $this->db->insert('bg_seller_info', $data);
            return true;
        }
    }

    function seller_emd_document($seller_seqid, $bid_id) {

        $GetEMDDetails = $this->GetEMDDetails($bid_id);
        
        /* INTEMATION TO THE ADVISORY BANKS */
        $inr = '';
        $bank_id = $GetEMDDetails->advicory_bnk_id;
        if ($bank_id == 2) { //sbi bank
            $inr = 'INR';
        }
        $result = json_encode(array(
            "7039" => '/EMD',
            "7025" => $inr . $GetEMDDetails->total_emd_amount,
            "7029" => $GetEMDDetails->emd_validity_date,
            "7033" => "sellerid",
            "7034" => "buyerid",
            "7035" => $GetEMDDetails->advicory_bnk_ifsc,
            "7036" => $GetEMDDetails->advicory_bank_branch_name,
            "param1" => "", "param2" => ""
        ));
        $seller_emdintimation = $this->call_seller_emdintimation($seller_seqid, $bid_id);
    }
    
    /***********************************************/
    /**
     * Fetch the ePBG details information for Bid
     *
     * @access	public
     * @input   Bid ID
     * @return	ePBG infromation details
     */
    function GetePBGDetails($bid,$comp_id=NULL) {

            $this->db->select('bi.*,bgb.bank_name as advisory_bnkname,bgb.bank_bic as token,bgb.bank_branch_name as token_bank, bi.bid_name as bid_name, bi.buyer_id, bi.bid_id as bid_id, format(((bi.total_amount*bi.percentage_bg_required)/100),2) as total_bg_required,((bi.total_amount*bi.percentage_bg_required)/100) as total_bg_required_number,bi.percentage_bg_required as bg_percentage_required,bi.advicory_bank_id as buyer_advicory_bank_id,bi.status as online_status,,bi.buyer_id,bids.b_id,bids.b_category_name,bids.b_bid_number,bids.b_status as bid_status,bids.b_bid_start_date,bids.b_bid_end_date,ba.ba_bid_validity,ba.ba_official_details,ba.ba_other_data', false);
            $this->db->from('bg_buyer_info as bi');
            $this->db->join('bids', 'bids.b_id = bi.bid_id', 'left');
            $this->db->join('bid_attributes as ba', 'bids.b_id = ba.ba_bid_id', 'left');
            $this->db->join('bg_banks as bgb', 'bgb.id=bi.advicory_bank_id', 'left');
            $this->db->limit(1);
            $this->db->where('bi.bid_id', $bid);
            if($comp_id!=NULL)
            {
                 $this->db->where('bi.seller_id', $comp_id);
            }
            $this->db->where('bi.type', 1);
            $this->db->order_by("bi.id", "DESC");
            $this->db->limit(1);
            $dataparms = $this->db->get();
            
            return $dataparms->result();
    }
    
    public function intemate_seller_banks($bid = null, $srlID = null, $price = null) {
        
        if($bid!="" && $srlID!="" && $price!="" )
        {
            $data = array('total_amount' => $price, 'epbg_validity_date' => date('Y-m-d'), 'modified_on' => date('Y-m-d H:i:s'), 'seller_id' => $srlID, 'status' => 2);
            $this->db->where('bid_id', $bid);
            $this->db->where('type', 1);
            $this->db->update('bg_buyer_info', $data);
            
            $GetEMDDetails = $this->GetEMDDetails($bid);
            
            $this->db->select('bgb.bank_bic as token,bgb.bank_branch_name as token_bank, bi.bid_name as bid_name, bi.buyer_id, bi.bid_id as bid_id, format(((bi.total_amount*bi.percentage_bg_required)/100),2) as total_bg_required,((bi.total_amount*bi.percentage_bg_required)/100) as total_bg_required_number,bi.percentage_bg_required as bg_percentage_required,bi.advicory_bank_id as buyer_advicory_bank_id', false);
            $this->db->from('bg_buyer_info as bi');
            $this->db->join('bg_banks as bgb', 'bgb.id=bi.advicory_bank_id', 'INNER');
            $this->db->limit(1);
            $this->db->where('bi.bid_id', $bid);
            $this->db->where('bi.type', 1);
            $dataparms = $this->db->get();
            
            if ($dataparms->num_rows() > 0) {
                $result = $dataparms->result_array();
                $result[0]['bid_name']=$GetEMDDetails->b_bid_number;
                return $result;
            } else {
                return NULL;
            }
            
        }else {
                return NULL;
            }
      
    }
    
     
    /***********************************************/
    /**
     * Fetch the ePBG details information for Bid
     *
     * @access	public
     * @input   Bid ID
     * @return	ePBG infromation details
     */
    function GeteRAsPBGDetails($bid,$srlID,$price) {

            $this->db->select('bi.*,bgb.bank_name as advisory_bnkname,bgb.bank_bic as token,bgb.bank_branch_name as token_bank, bi.bid_name as bid_name, bi.buyer_id, bi.bid_id as bid_id, format(((bi.total_amount*bi.percentage_bg_required)/100),2) as total_bg_required,((bi.total_amount*bi.percentage_bg_required)/100) as total_bg_required_number,bi.percentage_bg_required as bg_percentage_required,bi.advicory_bank_id as buyer_advicory_bank_id,bi.status as online_status,,bi.buyer_id,bids.b_id,bids.b_category_name,bids.b_bid_number,bids.b_status as bid_status,bids.b_bid_start_date,bids.b_bid_end_date,ba.ba_bid_validity,ba.ba_official_details', false);
            $this->db->from('bg_buyer_info as bi');
            $this->db->join('bids', 'bids.b_id = bi.bid_id', 'left');
            $this->db->join('bid_attributes as ba', 'bids.b_id = ba.ba_bid_id', 'left');
            $this->db->join('bg_banks as bgb', 'bgb.id=bi.advicory_bank_id', 'left');
            $this->db->limit(1);
            $this->db->where('bi.bid_id', $bid);
            $this->db->where('bi.seller_id', $srlID);
            $this->db->where('bi.total_amount', $price);
            $this->db->where('bi.type', 1);
            $dataparms = $this->db->get();
            return $dataparms->result();
    }
   
   

    
    
}
