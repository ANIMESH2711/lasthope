<?php

/**
 * Created by PhpStorm.
 * User: sam
 * Date: 1/11/2017
 * Time: 12:06 PM
 */
class Lib
{
	/*
	 *  Validation
	 */
	public function validate($var)
	{
		$var = str_replace("/", "&#47;", $var);
		$var = str_replace("'", "&#39;", $var);
		$var = str_replace('"', "&#34;", $var);
		//$var = $this->security->xss_clean($var);
		return $var;
	}

	/*
	 * clean
	 */
	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		return $string;
	}

	/*
	 *  Year LIST
	 */
	public function SelectList($var, $name, $id = '', $ext = '')
	{
		$str = "<select " . $ext . "  class='form-control selectpicker' data-size='10' data-live-search='true' data-style='btn-white' name='" . $name . "' id='" . $name . "' data-parsley-required='true' ><option value='' >Select Here</option>";
		//ksort($var);
		foreach ($var as $v) {
			if ($v->Id == $id) {
				$a = 'selected';
			} else {
				$a = '';
			};
			$str = $str . " <option value='" . trim($v->Id) . "' " . $a . " >" . trim($v->Name) . "</option>";
		}
		$str = $str . " </select>";
		return $str;
	}

	/*
	 *  Year LIST
	 */
	public function SelectListED($var, $name, $id = '', $ext = '')
	{
		$str = "<select " . $ext . "  class='form-control selectpicker' data-size='10' data-live-search='true' data-style='btn-white' name='" . $name . "' id='" . $name . "' data-parsley-required='true' ><option value='' >Select Here</option>";
		asort($var);
		foreach ($var as $v) {
			if ($v->Id == $id) {
				$a = 'selected';
			} else {
				$a = '';
			};
			$str = $str . " <option value='" . $this->encryption->encrypt($v->Id) . "' " . $a . " >" . trim($v->Name) . "</option>";
		}
		$str = $str . " </select>";
		return $str;
	}

	/*
	 *  Month LIST
	 */
	public function MonthList($id = 0, $ext = '')
	{
		$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		if ($ext != 0) {
			$ext = 'onchange="this.form.submit();"';
		}
		$str = "<select  class='form-control '   name='month' id='month' " . $ext . " >
                <option value='' >Select Here</option>";
		$i = 0;
		foreach ($months as $m) {
			$i++;
			$str2 = "";
			if ($i == $id) {
				$str2 = 'selected="selected"';
			}
			$str = $str . '<option value="' . $i . '" ' . $str2 . '>' . $m . '</option>';
		}
		$str = $str . " </select>";
		return $str;
	}

	/*
	 *  Year LIST
	 */
	public function YearList($id = 0, $ext = '')
	{
		$months = array('2017', '2018');
		if ($ext != 0) {
			$ext = 'onchange="this.form.submit();"';
		}
		$str = "<select  class='form-control'   name='year' id='year' " . $ext . " >
                <option value='' >Select Here</option>";
		$i = 2018;
		foreach ($months as $m) {
			$i--;
			$str2 = "";
			if ($m == $id) {
				$str2 = 'selected="selected"';
			}
			$str = $str . '<option value="' . $m . '" ' . $str2 . '>' . $m . '</option>';
		}
		$str = $str . " </select>";
		return $str;
	}

	/*
	 *  Encode
	 */
	public function Encode($string)
	{
		$string = strtr($string, '+/=', '-_~');
		return $string;
	}

	/*
	 *  Decode
	 */
	public function Decode($string)
	{
		$string = strtr($string, '-_~', '+/=');
		return $string;
	}

	/*
	 *  Days Between Two Dates
	 */
	public function DateDifference($d1, $d2)
	{
		// Return the number of days between the two dates:
		return (string)round(abs(strtotime($d1) - strtotime($d2)) / 86400);
	}

	/*
	 *  Day No
	 */
	public function DayNoFinder($date)
	{
		$day = date('l', strtotime($date));
		switch ($day) {
			case  'Monday':
				$nod = 1;
				break;
			case  'Tuesday':
				$nod = 2;
				break;
			case  'Wednesday':
				$nod = 3;
				break;
			case  'Thursday':
				$nod = 4;
				break;
			case  'Friday':
				$nod = 5;
				break;
			case  'Saturday':
				$nod = 6;
				break;
			case  'Sunday':
				$nod = 7;
				break;
			default :
				$nod = 7;
		}
		return $nod;
	}

	/*
	 *  DATE BETWEEN TWO DATES
	 */
	public function DBTD($strDateFrom, $strDateTo)
	{
		if (strtotime($strDateFrom) > strtotime($strDateTo)) {
			$a = $strDateTo;
			$strDateTo = $strDateFrom;
			$strDateFrom = $a;
		}
		$aryRange = array();
		$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
		$iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
		if ($iDateTo >= $iDateFrom) {
			array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
			while ($iDateFrom < $iDateTo) {
				$iDateFrom += 86400; // add 24 hours
				array_push($aryRange, date('Y-m-d', $iDateFrom));
			}
		}
		return $aryRange;
	}

	/*
	 *  Leave Months
	 */
	public function LeaveMonths($month)
	{
		switch ($month) {
			case '7':
				$month_no = '7';
				break;
			case '8':
				$month_no = '7,8';
				break;
			case '9':
				$month_no = '7,8,9';
				break;
			case '10':
				$month_no = '7,8,9,10';
				break;
			case '11':
				$month_no = '7,8,9,10,11';
				break;
			case '12':
				$month_no = '7,8,9,10,11,12';
				break;
			case '1':
				$month_no = '1,7,8,9,10,11,12';
				break;
			case '2':
				$month_no = '1,2,7,8,9,10,11,12';
				break;
			case '3':
				$month_no = '1,2,3,7,8,9,10,11,12';
				break;
			case '4':
				$month_no = '1,2,3,4,7,8,9,10,11,12';
				break;
			case '5':
				$month_no = '1,2,3,4,5,7,8,9,10,11,12';
				break;
			case '6':
				$month_no = '1,2,3,4,5,6,7,8,9,10,11,12';
				break;
		}
		return $month_no;
	}

	/*
	 * Leave Years
	 */
	public function LeaveYears($month)
	{
		$year = date('Y');
		switch ($month) {
			case '7':
				$month_no = $year;
				break;
			case '8':
				$month_no = $year;
				break;
			case '9':
				$month_no = $year;
				break;
			case '10':
				$month_no = $year;
				break;
			case '11':
				$month_no = $year;
				break;
			case '12':
				$month_no = $year;
				break;
			case '1':
				$month_no = "$year,$year-1";
				break;
			case '2':
				$month_no = "$year,$year-1";
				break;
			case '3':
				$month_no = "$year,$year-1";
				break;
			case '4':
				$month_no = "$year,$year-1";
				break;
			case '5':
				$month_no = "$year,$year-1";
				break;
			case '6':
				$month_no = "$year,$year-1";
				break;
		}
		return $month_no;
	}

	/*
	 * Attendance Block Days
	 */
	public function AttendanceBlockDays($EmpCode, $SecId = 0)
	{
		/*
		 * Ist Year Allow Back Date

		if(in_array($SecId,array(245,247,251,252,253,254,255,256,257,274,277,284,294,295,296,297,306,317,333,334,342,348,372,374,375,482,483,484,485,522,523)))
		{
			return (int)45;

		}
		else
		{
		   cut & paste here Running Code
		}
		*/
		if (in_array($EmpCode, array('ts14006'))) {
			return (int)5;
		} else {
			###################### BLOCK DAYS DAYS WISE #########################
			switch (date("l")) {
				case  'Monday':
					$nod = 2;
					break;
				case  'Tuesday':
					$nod = 1;
					break;
				case  'Wednesday':
					$nod = 1;
					break;
				case  'Thursday':
					$nod = 1;
					break;
				case  'Friday':
					$nod = 1;
					break;
				case  'Saturday':
					$nod = 1;
					break;
				case  'Sunday':
					$nod = 1;
					break;
				default :
					$nod = 1;
			}
			return (int)$nod;
		}
	}

	/*
	 * Check Date Exist Between Two Dates
	 */
	public function DCB2D($start, $end, $crr)
	{
		$start = strtotime($start);
		$end = strtotime($end);
		$crr = strtotime($crr);
		if (($crr > $start) && ($crr < $end)) {
			return 1;
		} else {
			return 2;
		}
	}

	/*
	 * Send SMS
	 */
	public function SendSMS($Mob, $Msg)
	{
		$Mob = trim($this->validate($Mob));
		$Msg = urlencode(trim($this->validate($Msg)));
		$ch = curl_init();
		$str = "http://tsms.ezeesolution.com/API/WebSMS/Http/v1.0a/dashboard.php?username=psitkp&password=psitkp123!&sender=PSITKP&to=" . $Mob . "&message=" . $Msg . "&reqid=1&format={json|text}&route_id=route+id&callback=Any+Callback+URL&unique=0";
		curl_setopt($ch, CURLOPT_URL, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "user=USER&senderID=SENDER&receipientno=Mob&cid=CID&msgtxt=MSG");
		$buffer = curl_exec($ch);
		curl_close($ch);
	}

	/*
	 *  Status Chekcer
	 */
	public function CheckStatus($str)
	{
		switch ($str) {
			case 1:
				$var = '<span class="text-success"> Approved</span>';
				break;
			case -1:
				$var = '<span class="text-danger">Pending</span>';
				break;
			case 0:
				$var = '<span class="text-warning">Rejected</span>';
				break;
			default :
				$var = '';
		}
		return $var;
	}

	/*
	*  Status Chekcer 2
	*/
	public function CheckStatus2($str)
	{
		switch ($str) {
			case 1:
				$var = '<span class="text-success"> Recommended</span>';
				break;
			case -1:
				$var = '<span class="text-danger">Pending</span>';
				break;
			case 0:
				$var = '<span class="text-warning">Not Recommended</span>';
				break;
			default :
				$var = '';
		}
		return $var;
	}

	/*
	 * Menu Active Non Active Process
	 */
	public function MenuManagement($var)
	{
		$var = strtolower($var);
		switch ($var) {
			case ($var == strtolower('dashboard') || $var == strtolower('mytimetable') || $var == strtolower('myMonthlyattendance') || $var == strtolower('EmployeeBooksList')):
				$data['HO'] = 'active';
				$data['NO'] = $data['RE'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('sammvadlist') || $var == strtolower('sammvad') || $var == strtolower('DiscussionAll') || $var == strtolower('DiscussionListAll') || $var == strtolower('test')):
				$data['NO'] = 'active';
				$data['HO'] = $data['RE'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('TechnicalTraining') || $var == strtolower('MyEventsStaff') || $var == strtolower('timetable') || $var == strtolower('totallecture') || $var == strtolower('OnlineTraining') || $var == strtolower('LecturePlanReport')):
				$data['RE'] = 'active';
				$data['NO'] = $data['HO'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('AttendanceReportSectionwise') || $var == strtolower('lectureattendancereportsectionwise') || $var == strtolower('labattendancereportsectionwise') || $var == strtolower('trainingattendancereportsectionwise') || $var == strtolower('pendingattendancerequest') || $var == strtolower('pendingattendancerequestlist') || $var == strtolower('AttRegSectionSubWise')):
				$data['SA'] = 'active';
				$data['NO'] = $data['HO'] = $data['RE'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('MarksEditRequestList') || $var == strtolower('assignsubject') || $var == strtolower('assignmentmarks') || $var == strtolower('labmarks') || $var == strtolower('TestSubjectMarksReport')):
				$data['MM'] = 'active';
				$data['NO'] = $data['HO'] = $data['RE'] = $data['LA'] = $data['AS'] = $data['SA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('UploadNotes') || $var == strtolower('UploadNotesList') || $var == strtolower('LabAssignment') || $var == strtolower('LabAssignmentList') || $var == strtolower('LabAssignmentStudentList')):
				$data['AS'] = 'active';
				$data['NO'] = $data['HO'] = $data['RE'] = $data['LA'] = $data['MM'] = $data['SA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('CompLeaveForward') || $var == strtolower('CompLeaveRequest') || $var == strtolower('leaverequest') || $var == strtolower('pendingleaverequest') || $var == strtolower('attendancerectification') || $var == strtolower('EmployeeLeaveDetails')):
				$data['LA'] = 'active';
				$data['NO'] = $data['HO'] = $data['RE'] = $data['MM'] = $data['AS'] = $data['SA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('InfrastructureBooking') || $var == strtolower('InfrastructureBookingList') || $var == strtolower('MeetingManagement') || $var == strtolower('CallMeeting') || $var == strtolower('lectureplan') || $var == strtolower('searchstudent') || $var == strtolower('commentforstudent') || $var == strtolower('MyNomination') || $var == strtolower('MediaManagerList') || $var == strtolower('MediaManager') || $var == strtolower('Selfnomination')):
				$data['MI'] = 'active';
				$data['NO'] = $data['HO'] = $data['RE'] = $data['MM'] = $data['AS'] = $data['SA'] = $data['LA'] = '';
				break;
			default :
				$data['HO'] = 'active';
				$data['NO'] = $data['RE'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
		}
		return $data;
	}

	/*
	 * Menu Active Non Active Process
	 */
	public function StudentMenuManagement($var)
	{
		$var = strtolower($var);
		switch ($var) {
			case ($var == strtolower('Dashboard') || $var == strtolower('MyTimeTable') || $var == strtolower('MyAttendance')):
				$data['HO'] = 'active';
				$data['NO'] = $data['RE'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('NotesList') || $var == strtolower('sammvad') || $var == strtolower('LabAssignmentList')):
				$data['NO'] = 'active';
				$data['HO'] = $data['RE'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			case ($var == strtolower('timetable') || $var == strtolower('assignmentmarks') || $var == strtolower('labmarks') || $var == strtolower('totallecture') || $var == strtolower('OnlineTraining') || $var == strtolower('TechnicalTraining') || $var == strtolower('OnlineTrainingDetails') || $var == strtolower('TechnicalTrainingDetails')):
				$data['RE'] = 'active';
				$data['NO'] = $data['HO'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
			default :
				$data['HO'] = 'active';
				$data['NO'] = $data['RE'] = $data['SA'] = $data['MM'] = $data['AS'] = $data['LA'] = $data['MI'] = '';
				break;
		}
		return $data;
	}

	/*
	 * History Back
	 */
	public function HistoryBack()
	{
		echo "<script language='javascript'>history.go(-1);</script> ";
	}

	/*
	 * College
	 */
	public function College($Id = 1)
	{
		switch ($Id) {
			case 1 :
				$Name = 'PSIT';
				break;
			case 2 :
				$Name = 'PSITCOE';
				break;
			case 3 :
				$Name = 'PSITCHE';
				break;
			case 0 :
				$Name = 'All';
				break;
			default :
				$Name = '';
		}
		return $Name;
	}

	/*
	 * Notification Message
	 */
	public function Notification()
	{
		$CI =& get_instance();
		if ($CI->session->flashdata('Msg')) {
			echo '<div class="alert alert-' . $CI->session->flashdata('Type') . ' alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p class="mb-0">' . $CI->session->flashdata('Msg') . '</p></div>';
		}
	}

	/*
	 * Select In Selected
	 */
	public function Selected($a, $b)
	{
		if ($a == $b) {
			return 'selected';
		}

	}

	/*
	 *  CheckBox & Radio Selected
	 */
	public function RCSelected($a, $b)
	{
		if ($a == $b) {
			return 'checked';
		}
	}
}
