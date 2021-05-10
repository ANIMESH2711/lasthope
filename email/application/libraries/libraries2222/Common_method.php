<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Common_method
 * Common library for all purpose 
 * @package		Common_method
 * @author		Nishant Kumar
 * @version		1.0.0
 */
class Common_method {

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->database();        
        $this->ci->load->model('bidding/sellerparticipant_model');
    }
    
    function helper_SC_calculatePrice ($bidDetails, $sellerData){
        $html = '';
        $dataCon = '';
        if (!empty($bidDetails)) {
            $ba_contract = json_decode($bidDetails[0]->ba_contract);
            $contract_period = ($ba_contract->days_dt)+( ($ba_contract->month_dt)*30 );
            if(isset($ba_contract->year_dt)){
                $contract_period += (($ba_contract->year_dt)*12*30);
            }
            foreach ($bidDetails AS $item) {
                $html .= '<p class="phead">'.$item->bd_category_name .'</p>';
                $addonsHead = [];
                $consignees = json_decode($item->bd_consignee_details);
                $bidDetail = json_decode($item->bd_details);
                $up = base64_decode($sellerData [$bidDetail->iId]);
                $rate_sheet_params = current( (Array)$bidDetail->rate_sheet_params );
                $rate_sheet_variable = current(array_keys( (Array)$bidDetail->rate_sheet_params ));
                $unitPriceLabel = $rate_sheet_params->display_name;
                
                extract([$rate_sheet_variable => $up]);
                $dataCon = '';
                $subtotal = 0;
                foreach ($consignees AS $c=>$con) {
                    $addoneName = $addOneQty = $addOneUP = '';
                    $addOns = $con->addons;
                    $estParams = $con->est_params;
                    $quantity = $con->qty;
                    $dataCon .= '<tbody><tr><td>Con '.($c+1).'</td>';
                    $dataCon .= '<td>'.$quantity.'</td>';
                    $dataCon .= '<td>'.$up.'</td>';
                    $totalAddonsPrice = 0;
                    if ( !empty($addOns) ) {
                        foreach ($addOns AS $addone) {
                            if ( $c == 0) {
                                $addonsHead [] = $addone->dName;
                                $addonsHead [] = 'Unit Price';
                            }
                            // Formula for addons START
                            extract([$addone->code=>$addone->qty]);
                            $value = base64_decode($sellerData ['addone_'.$bidDetail->vId.'_'.$addone->code]);
                            $getFormula = __getFormula($item->bd_formulas, $addone->aCode);
                            $calculatedPrice = eval('return '.$getFormula.';');
                            $addoneName = $addone->dName;
                            $addOneUP = $value;
                            $addOneQty = $addone->qty;
                            // Formula for addons FINISH
                            $dataCon .= '<td>'.$addOneQty.'</td>';
                            $dataCon .= '<td>'.$addOneUP.'</td>';
                            $totalAddonsPrice += $calculatedPrice;
                            
                        }
                    }
                    if ( !empty($estParams) ) {
                        foreach ($estParams AS $est) {
                            if ( $c == 0) {
                                $addonsHead [] = $est->dName;
                            }
                            extract([$est->code=>$est->qty]);
                            $dataCon .= '<td>'.$est->qty.'</td>';
                        }
                    }
                    // Formula for total Price START
                    $totalFormula = json_decode($item->bd_formulas)->output->total;
                    $calculatedtotalFormula = eval('return '.$totalFormula.';');
                    $final_Price = $totalAddonsPrice+$calculatedtotalFormula;
                    $subtotal += $final_Price;
                    // Formula for total Price FINISH
//                    $final_Price .= 'perCan'.$per_can.'quantity'.$quantity.'contract_period'.$contract_period.'area'.$area;
                    $dataCon .= '<td title="'.$totalFormula.'" au="Z3VwdGEubmlsZXNoNzZAZ21haWwuY29t" ta="'.$totalAddonsPrice.'" f="'.$calculatedtotalFormula.'">'.$final_Price.'</td><tr>';
                    $dataCon .='</tbody>';
                }
                
                $html .= '<table class="table table-bordered col-md-12">';
                $html .= '<thead><tr><th>Consignee(s)</th>';
                $html .= '<th>Quantity</th>';
                $html .= '<th>'.$unitPriceLabel.'</th>';
                foreach ($addonsHead AS $head) {
                    $html .= '<th>'.$head.'</th>';
                }
                $html .= '<th>Total Price (INR)</th></tr></thead>';
                $html .= $dataCon;
                $headCnt = count($addonsHead) + 3;
                $html .= '<tfoot><tr><td colspan="'.$headCnt.'" style="text-align:right"><b>Sub Total</b></td><td><b>'.$subtotal.'</b></td><tr></tfoot>';
                $html .= '</table>';
                
            }
        }
//        $html .= '</table>';
//        echo $html;
        return $html;
    }
    /**
     * @author Abhishek Verma akverma@digitalindia.gov.in
     * @param type $uid
     * @return type
     */
    function __getFormula ($formulaStr, $aCode) {
        $formulaArr = json_decode($formulaStr);
        foreach ($formulaArr->addon AS $k=>$item) {
            if ($k == $aCode) {
                return $item;
            }
        }
    }
    
    function helper_SC_finalPrice ($bidDetails, $sellerData) {
        $html = '';
        $dataCon = '';
        $finalReturnData = new stdClass;
        if (!empty($bidDetails)) {
            $ba_contract = json_decode($bidDetails[0]->ba_contract);
            $contract_period = ($ba_contract->days_dt)+( ($ba_contract->month_dt)*30 );
            if(isset($ba_contract->year_dt)){
                $contract_period += (($ba_contract->year_dt)*12*30);
            }
            foreach ($bidDetails AS $item) {
                $html .= '<p class="phead">'.$item->bd_category_name .'</p>';
                $addonsHead = [];
                $consignees = json_decode($item->bd_consignee_details);
                
                $bidDetail = json_decode($item->bd_details);
                $up = base64_decode($sellerData [$bidDetail->iId]);
                $rate_sheet_params = current( (Array)$bidDetail->rate_sheet_params );
                $rate_sheet_variable = current(array_keys( (Array)$bidDetail->rate_sheet_params ));
                $unitPriceLabel = $rate_sheet_params->display_name;
                
                extract([$rate_sheet_variable => $up]);
                $dataCon = '';
                $subtotal = 0;
                foreach ($consignees AS $c=>$con) {
                    $addoneName = $addOneQty = $addOneUP = '';
                    $addOns = $con->addons;
                    $estParams = $con->est_params;
                    $quantity = $con->qty;
                    $dataCon .= '<tbody><tr><td>Con '.($con->con).'</td>';
                    $dataCon .= '<td>'.$quantity.'</td>';
                    $dataCon .= '<td>'.$up.'</td>';
                    $totalAddonsPrice = 0;
                    if ( !empty($addOns) ) {
                        foreach ($addOns AS $addone) {
                            if ( $c == 0) {
                                $addonsHead [] = $addone->dName;
                                $addonsHead [] = 'Unit Price';
                            }
                            // Formula for addons START
                            extract([$addone->code=>$addone->qty]);
                            $value = base64_decode($sellerData ['addone_'.$bidDetail->vId.'_'.$addone->code]);
                            $getFormula = $this->__getFormula($item->bd_formulas, $addone->aCode);
                            $calculatedPrice = eval('return '.$getFormula.';');
                            $addoneName = $addone->dName;
                            $addOneUP = $value;
                            $addOneQty = $addone->qty;
                            // Formula for addons FINISH
                            $dataCon .= '<td>'.$addOneQty.'</td>';
                            $dataCon .= '<td>'.$addOneUP.'</td>';
                            $totalAddonsPrice += $calculatedPrice;
                            
                        }
                    }
                    if ( !empty($estParams) ) {
                        foreach ($estParams AS $est) {
                            if ( $c == 0) {
                                $addonsHead [] = $est->dName;
                            }
                            extract([$est->code=>$est->qty]);
                            $dataCon .= '<td>'.$est->qty.'</td>';
                        }
                    }
                    // Formula for total Price START
                    $totalFormula = json_decode($item->bd_formulas)->output->total;
                    $calculatedtotalFormula = eval('return '.$totalFormula.';');
                    $final_Price = $totalAddonsPrice+$calculatedtotalFormula;
                    $subtotal += $final_Price;
                    // Formula for total Price FINISH
//                    $final_Price .= 'perCan'.$per_can.'quantity'.$quantity.'contract_period'.$contract_period.'area'.$area;
                    $dataCon .= '<td title="'.$totalFormula.'" au="Z3VwdGEubmlsZXNoNzZAZ21haWwuY29t" ta="'.$totalAddonsPrice.'" f="'.$calculatedtotalFormula.'">'.$final_Price.'</td><tr>';
                    $dataCon .='</tbody>';
                    
                    $conIdKey = 'con_'.$con->con;
                    $finalReturnData->{$conIdKey}->{$bidDetail->vId} = ['price'=>$final_Price];
                }
                $html .= '<table class="table table-bordered col-md-12">';
                $html .= '<thead><tr><th>Consignee(s)</th>';
                $html .= '<th>Quantity</th>';
                $html .= '<th>'.$unitPriceLabel.'</th>';
                foreach ($addonsHead AS $head) {
                    $html .= '<th>'.$head.'</th>';
                }
                $html .= '<th>Total Price (INR)</th></tr></thead>';
                $html .= $dataCon;
                $headCnt = count($addonsHead) + 3;
                $html .= '<tfoot><tr><td colspan="'.$headCnt.'" style="text-align:right"><b>Sub Total</b></td><td><b>'.$subtotal.'</b></td><tr></tfoot>';
                $html .= '</table>';
                
            }
        }
        return $finalReturnData;
    }
    
    public function getFinalPrice ($bidId, $compId) {
        if ($bidId > 0 && $compId!='') {
            $bidDetails = $this->ci->sellerparticipant_model->getBidDetails($bidId, 0, ['bd_id, bd_category_name, bd_details, bd_consignee_details, bd_formulas, ba_contract']); 
            $sellerData = $this->ci->sellerparticipant_model->getSellerPriceData($bidId, $compId);
           
            $data = [];
            if (!empty($sellerData)) {
                foreach ($sellerData AS $sData) {
                    $dtl = json_decode($sData->bd_details);
                    $addOns = json_decode($sData->bpd_addone_prices);
                    $data [$dtl->vId] = base64_encode($sData->bpd_unit_price_dec); 
                    if (!empty($addOns)) {
                        foreach ($addOns AS $addon) { 
                            $data ['addone_'.$dtl->vId.'_'.$addon->code] = base64_encode($addon->price);
                        }
                    }
                }
            }
//            echo "<pre>"; print_r($sellerData); print_r($data);
            if (!empty($bidDetails)) {
                $conArr = $this->helper_SC_finalPrice($bidDetails, $data);
                return $conArr; exit;
            }            
        }
    }

}
