<?php

/**
 * Created by PhpStorm.
 * User: sam
 * Date: 1/11/2017
 * Time: 12:40 PM
 */
class Lib_model extends CI_Model
{
    /*
     * Construct
     */
	public function __construct()
    {
        parent::__construct();
    }

    /*
     *  Select Records From Table
     */
    public function Select($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);

        /*
         * Fetch Records
         */

        return $query->result();
    }

    /*
     *  Select One Col  From Table
     */
    public function Select_Single($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);
        /*
         * Fetch Records
         */
        $rs = $query->result();
        foreach ($rs as $r) {
            $Name = $r->$Fields;
        }

        return $Name;
    }

    /*
     * Count No Rows in Table
     */
    public function Counter($Table, $Where = 1)
    {
        $rows = $this->Select($Table, '*', $Where);

        return count($rows);
    }

    /*
     * Insert
     */
    public function Insert($table, $f)
    {
        $query = $this->db->insert($table, $f);
        if ($query) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        } else {
            return false;
        }
    }

    /*
     *  UPDATE
     */
    public function Update($table, $f, $w = 0)
    {
        if ($w != 0) {
            $this->db->where($w);
        }
        $query = $this->db->update($table, $f);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * DELETE
     */
    public function Delete($table, $w = 0)
    {
        if ($w != 0) {
            $this->db->where($w);
        }
        $query = $this->db->delete($table);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Direct Query Execution
     */
    public function Execute($q, $w = array())
    {
        $query = $this->db->query($q, $w);
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    /*
     * Insert Multiple Records
     */
    public function Insert_Batch($table, $f)
    {
        $query = $this->db->insert_batch($table, $f);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Fetch DaysBetweenTwoDates
     */
    public function DBTD($startDate, $endDate)
    {
        $sql = "SELECT DATEDIFF(day,'" . $startDate . "','" . $endDate . "')+1 AS Day";
        $rs = $this->Execute($sql)->result();
        foreach ($rs as $r) {
            return $r->Day;
        }
    }

    /*
     *  Taken Leave
     */
    public function LeaveTaken($EmpId = 0)
    {
        /*
         * By Default Self Leave
         */
        if ($EmpId == 0) {
            $EmpId = $this->session->EmpId;
        }
        /*
         * Session Management
         */
        if (SessionId % 2 == 0) {
            $sessions = SessionId . "," . (SessionId - 1);
        } else {
            $sessions = SessionId;
        }
        /*
         * CL
         */
        $sql1 = "SELECT sum(Nod) AS Nod FROM M_HRM_Leave_Request WHERE EmpId=? AND isSELF=1 AND isDIR IN (1,-1) AND LeaveType=1 AND  Session IN ($sessions) ";
        $rs1 = $this->Execute($sql1, array($EmpId))->result();
        foreach ($rs1 as $r) {
            $CL = $r->Nod;
        }

        /*
        * VL
        */

        $sql1 = "SELECT sum(Nod) AS Nod FROM M_HRM_Leave_Request WHERE EmpId=? AND isSELF=1 AND isDIR IN (1,-1) AND LeaveType=10 AND  Session IN ($sessions) ";
        $rs1 = $this->Execute($sql1, array($EmpId))->result();
        foreach ($rs1 as $r) {
            $VL = $r->Nod;
        }

        /*
         * Category Id
         */
        $rs2 = $this->lib_model->Select('M_Employee', 'Category', array('EmpID' => $EmpId));
        foreach ($rs2 as $r2) {
            $Category = $r2->Category;
        }

        if (in_array($Category, array(2, 11))) {
            return (float)$Total = $CL + $VL / 2;

        } else {
            return (int)$Total = $CL + $VL / 1.5;
        }


    }

    /*
    *  Taken Leave
    */
    public function LeaveTakenVL($EmpId = 0)
    {
        /*
         * By Default Self Leave
         */
        if ($EmpId == 0) {
            $EmpId = $this->session->EmpId;
        }
        /*
         * Session Management
         */
        if (SessionId % 2 == 0) {
            $sessions = SessionId . "," . (SessionId - 1);
        } else {
            $sessions = SessionId;
        }

        /*
         * VL
         */
        $VL = 0;
        $sql1 = "SELECT sum(Nod) AS Nod FROM M_HRM_Leave_Request WHERE EmpId=? AND isSELF=1 AND isDIR IN (1,-1) AND LeaveType=10 AND  Session IN ($sessions) ";
        $rs1 = $this->Execute($sql1, array($EmpId))->result();
        foreach ($rs1 as $r) {
            $VL = $r->Nod;
        }

        return (float)$Total = $VL;
    }

    /*
     * Max Leave Date of Join
     */
    public function MaxLeaveDOJ($EmpId = 0)
    {
        /*
         * By Default Self Leave
         */
        if ($EmpId == 0) {
            $EmpId = $this->session->EmpId;
        }
        /*
         * Date of Joining
         */
        $sql = "SELECT DateOfJoin FROM M_Employee WHERE EmpID=?";
        $rs = $this->Execute($sql, array($EmpId))->result();
        foreach ($rs as $r) {
            $DOJ = $r->DateOfJoin;
        }
        /*
         * Check 1 year Complete Session Start
         */
        if (strtotime($DOJ) > strtotime('7/1/2016')) {
            if (strtotime($DOJ) < strtotime('7/1/2017')) {
                $MaxLeave = 12;
            } else {
                $DOM = date('m', strtotime($DOJ));
                $DOD = date('d', strtotime($DOJ));
                /*
                 * Leave Manage Joiningwise
                 */
                switch ($DOM) {
                    case 1:
                        $MaxLeave = 6;
                        break;
                    case 2:
                        $MaxLeave = 5;
                        break;
                    case 3:
                        $MaxLeave = 4;
                        break;
                    case 4:
                        $MaxLeave = 3;
                        break;
                    case 5:
                        $MaxLeave = 2;
                        break;
                    case 6:
                        $MaxLeave = 1;
                        break;
                    case 7:
                        $MaxLeave = 12;
                        break;
                    case 8:
                        $MaxLeave = 11;
                        break;
                    case 9:
                        $MaxLeave = 10;
                        break;
                    case 8:
                        $MaxLeave = 9;
                        break;
                    case 7:
                        $MaxLeave = 8;
                        break;
                    case 6:
                        $MaxLeave = 7;
                        break;
                }
                /*
                 * After 10 Joining did not receive Cl for Current Month
                 */
                if ($DOD > 10) {
                    $MaxLeave--;
                }
            }
        } else {
            $MaxLeave = 14;
        }

        return $MaxLeave;
    }

    /*
     * Max Leave Date of Join
     */
    public function MaxLeave($EmpId = 0)
    {
        $Doj = '7/1/2017';
        $LeaveYear = '17-18';
        $rs = $this->lib_model->Select('M_HRM_Leave_Request_Mgmt', 'TotalMax as Max', array('EmpId' => $EmpId, 'Session' => SessionId, 'LeaveType' => 1));
        if ($rs) {
            foreach ($rs as $r) {
                $MaxLeave = $r->Max;
            }
        } else {
            if (SessionId % 2 == 0) {
                $sql = "Sp_Employee_Leave_Mgmt_Even_CL_Emp ?,?,?,?";
                $this->lib_model->Execute($sql, array($Doj, SessionId, $LeaveYear, $EmpId));
            } else {
                $sql = "Sp_Employee_Leave_Mgmt_Odd_CL_Emp ?,?,?,?";
                $this->lib_model->Execute($sql, array($Doj, SessionId, $LeaveYear, $EmpId));
            }
            $rs = $this->lib_model->Select('M_HRM_Leave_Request_Mgmt', 'TotalMax as Max', array('EmpId' => $EmpId, 'Session' => SessionId, 'LeaveType' => 1));
            foreach ($rs as $r) {
                $MaxLeave = $r->Max;
            }
        }

        return $MaxLeave;
    }

    /*
    * Max Leave
    */
    public function MaxLeaveABC($EmpId = 0)
    {
        /*
         * By Default Self Leave
         */
        if ($EmpId == 0) {
            $EmpId = $this->session->EmpId;
        }
        /*
         * Date of Joining
         */
        $sql = "SELECT DateOfJoin FROM M_Employee WHERE EmpID=?";
        $rs = $this->Execute($sql, array($EmpId))->result();
        foreach ($rs as $r) {
            $DOJ = $r->DateOfJoin;
        }
        /*
         * Check 1 year Complete Session Start
         */
        if (strtotime($DOJ) > strtotime('7/1/2016')) {
            if (strtotime($DOJ) < strtotime('7/1/2017')) {
                $MaxLeave = 12;
            } else {
                $DOM = date('m', strtotime($DOJ));
                $DOD = date('d', strtotime($DOJ));
                /*
                 * Leave Manage Joiningwise
                 */
                switch ($DOM) {
                    case 1:
                        $MaxLeave = 6;
                        break;
                    case 2:
                        $MaxLeave = 5;
                        break;
                    case 3:
                        $MaxLeave = 4;
                        break;
                    case 4:
                        $MaxLeave = 3;
                        break;
                    case 5:
                        $MaxLeave = 2;
                        break;
                    case 6:
                        $MaxLeave = 1;
                        break;
                    case 7:
                        $MaxLeave = 12;
                        break;
                    case 8:
                        $MaxLeave = 11;
                        break;
                    case 9:
                        $MaxLeave = 10;
                        break;
                    case 8:
                        $MaxLeave = 9;
                        break;
                    case 7:
                        $MaxLeave = 8;
                        break;
                    case 6:
                        $MaxLeave = 7;
                        break;
                }
                /*
                 * After 10 Joining did not receive Cl for Current Month
                 */
                if ($DOD > 10) {
                    $MaxLeave--;
                }
            }
        } else {
            $MaxLeave = 14;
        }

        return $MaxLeave;
    }

    /*
     * Balance Leave
     */
    public function BalanceLeave($EmpId = 0)
    {
        /*
         * By Default Self Leave
         */
        if ($EmpId == 0) {
            $EmpId = $this->session->EmpId;
        }
        $MaxLeave = $this->MaxLeave($EmpId);
        $LeaveTaken = $this->LeaveTaken($EmpId);
        $BL = $MaxLeave - $LeaveTaken;

        return $BL;
    }

    /*
     * Attendance Mark
     */
    public function MarkAttendance($Sec, $Pr, $Date)
    {
        $DayNo = $this->lib->DayNoFinder($Date);
        $sql = "SELECT Id, EmpName, Subject_Code, TT_Day, TT_Period, Batch_Id FROM V_TimeTable_History WHERE Section_Id=? AND TT_Period=? AND TT_Day=? AND CAST(TIMESTAMP AS DATE)=CAST(? AS DATE)";
        $rs = $this->Execute($sql, array($Sec, $Pr, $DayNo, $Date))->result();
        /*
         * Check Every Period
         */
        $Name = array();
        foreach ($rs as $r) {
            $Cn2 = array();
            $Id = $r->Id;
            $EmpName = $r->EmpName;
            $Subject_Code = $r->Subject_Code;
            $Batch_Id = $r->Batch_Id;
            /*
             * Period Details
             */
            $q1 = "Select TopicName, Created  FROM M_Class_Topic_All WHERE  TT_Id=? AND Session_Id=? ";
            $Cn = $this->Execute($q1, array($Id, SessionId))->result();
            if ($Cn) {
                foreach ($Cn as $c) {
                    $Icon = 'check';
                    $Status = 'success';
                    $TopicName = $c->TopicName;
                    $TimeStamps = $c->Created;
                }
                /*
                 * Percentage
                 */
                if ($Batch_Id == 0) {
                    $NoS = $this->Counter('V_Student_Section_Current_Session', array('SectionId' => $Sec));
                    /*
                     * Absent Student List
                     */
                    $q2 = "SELECT University_RollNo, Student_Name,  CASE WHEN Hostel=1 THEN 'H' ELSE '' END AS Hostel FROM V_Student_Section_Current_Session WHERE Student_Id IN (Select Student_Id  FROM M_Class_Topic_All WHERE TT_Id=? AND session_id=? AND Is_Absent=1)";
                    $Cn2 = $this->Execute($q2, array($Id, SessionId))->result();
                    $NoA = count($Cn2);
                    $Percentage = round((($NoA / $NoS) * 100), 2);
                } else if ($Batch_Id == 3) {
                    $Cn2 = array();
                    $Percentage = 'Monitoring';
                } else {
                    $NoS = $this->Counter('V_Student_Section_Current_Session', array('SectionId' => $Sec, 'Batch' => $Batch_Id));
                    /*
                     * Absent Student List
                     */
                    $q2 = "SELECT University_RollNo, Student_Name,  CASE WHEN Hostel=1 THEN 'H' ELSE '' END AS Hostel FROM V_Student_Section_Current_Session WHERE Student_Id IN (Select Student_Id  FROM M_Class_Topic_All WHERE TT_Id=? AND session_id=? AND Is_Absent=1)";
                    $Cn2 = $this->Execute($q2, array($Id, SessionId))->result();
                    $NoA = count($Cn2);
                    $Percentage = round((($NoA / $NoS) * 100), 2);
                }
            } else {
                $Icon = 'ban';
                $Status = 'danger';
                $TopicName = '-';
                $TimeStamps = '';
                $Percentage = ' - ';
            }
            $arr = array('EmpName' => $EmpName, 'Subject_Code' => $Subject_Code, 'Icon' => $Icon, 'Status' => $Status, 'TopicName' => $TopicName, 'TimeStamps' => $TimeStamps, 'AbsentList' => $Cn2, 'Percentage' => $Percentage . '%');
            array_push($Name, $arr);
        }

        return $Name;
    }

    /*
     *  Notification
     */
    public function Notification()
    {
        /*
         * Notification Management
         */
        $Co = $Co1 = $Co2 = $Co3 = $Co4 = $Co5 = $Co6 = $Co7 = $Co8 = 0;
        /*
         * Department Notice
         */
        $str = "SELECT Count(*) as No FROM M_Notice_Viewer WHERE EmpId=? AND N_Id IN (SELECT Id FROM M_Notice WHERE SessionId IN (SELECT * FROM V_Session) AND Dept=?)";
        $rs = $this->Execute($str, array($this->session->EmpId, $this->session->Dept))->result();
        foreach ($rs as $r) {
            $Co1 = $r->No;
        }
        $Co2 = $this->Counter('M_Notice', array('SessionId' => SessionId, 'Dept' => $this->session->Dept));
        $Co = $Co2 - $Co1;
        $f = array(array('title' => 'Department Notices', 'count' => $Co2 - $Co1, 'icon' => 'fa fa-bell media-object bg-red', 'Tcount' => $Co, 'Link' => 'Erp/Dashboard'));
        /*
         *  Check is Hod
         */
        $CountHod = $this->Counter('M_Role_Assignment', array('EmpId' => $this->session->EmpId, 'RoleId' => 5));
        if ($CountHod > 0) {
            /*
             * Pending Leave Request
             */
            $Co4 = $this->Counter('V_HRM_Leave_Request', array('Dept' => $this->session->Dept, 'isHOD' => -1, 'isSELF' => 1, 'Session' => SessionId));
            $Co = $Co + $Co4;
            array_push($f, array('title' => ' Leave Request ', 'count' => $Co4, 'icon' => 'fa fa-bell media-object bg-red', 'Tcount' => $Co, 'Link' => 'Hod/LeaveForward'));
            /*
             * Attendance Reactifectaion
             */
            $Co5 = $this->Counter('V_AttendanceCorrectionRequest', array('Dept' => $this->session->Dept, 'isHOD' => -1, 'Session' => SessionId));
            $Co = $Co + $Co5;
            array_push($f, array('title' => 'Attendance Rectification Request', 'count' => $Co5, 'icon' => 'fa fa-bell media-object bg-red', 'Tcount' => $Co, 'Link' => 'Hod/AttendanceRectification'));
        }
        /*
         *  Check is Dir
         */
        $CountHod = $this->Counter('M_Role_Assignment', array('EmpId' => $this->session->EmpId, 'RoleId' => 4));
        if ($CountHod > 0) {
            /*
             * Pending Leave Request
             */
            $sql6 = "SELECT count(*) as No FROM V_HRM_Leave_Request WHERE Current_Office=? AND isSELF=1 AND isHOD IN (0,1) AND isDIR=-1 AND Session=?";
            $rs6 = $this->Execute($sql6, array($this->session->CollegeId, SessionId))->result();
            foreach ($rs6 as $r6) {
                $Co6 = $r6->No;
            }
            $Co = $Co + $Co6;
            array_push($f, array('title' => ' Leave Request', 'count' => $Co6, 'icon' => 'fa fa-bell media-object bg-red', 'Tcount' => $Co, 'Link' => 'Director/LeaveForward'));
            /*
             * Attendance Reactifectaion
             */
            $sql7 = "SELECT count(*) as No FROM V_AttendanceCorrectionRequest WHERE Current_Office=? AND isHOD IN (0,1) AND isDir=-1 AND Session=?";
            $rs7 = $this->Execute($sql7, array($this->session->CollegeId, SessionId))->result();
            foreach ($rs7 as $r7) {
                $Co7 = $r7->No;
            }
            $Co = $Co + $Co7;
            array_push($f, array('title' => 'Attendance Rectification Request', 'count' => $Co7, 'icon' => 'fa fa-bell media-object bg-red', 'Tcount' => $Co, 'Link' => 'Director/AttendanceRectification'));
        }
        /*
         * Call Meeting
         */
        $CountMeeting = $this->Counter('M_MeetingScheduleAttendance', array('EmpId' => $this->session->EmpId, 'IsView' => 0));
        if ($CountMeeting > 0) {
            $Co = $Co + $CountMeeting;
            array_push($f, array('title' => 'Call Meeting Reminder', 'count' => $CountMeeting, 'icon' => 'fa fa-bell media-object bg-red', 'Tcount' => $Co, 'Link' => 'Erp/MeetingManagement'));
        }

        return $f;
    }

    /*
     * Password Encryption
     */
    public function PwdEncode($var)
    {
        $rs = $this->Execute("DECLARE @Pwd varbinary(max);
SET @Pwd = (SELECT  DBO.FNC_ENCRIPTION_PW('" . $var . "') AS Pwd);
Select @Pwd AS Pwd ")->result();
        foreach ($rs as $r) {
            $Pwd = $r->Pwd;
        }

        return (binary)$Pwd;
    }

    /*
     * Password Decryption
     */
    public function PwdDecode($var)
    {
        $rs = $this->Execute("DECLARE @Pwd varbinary(max);
SET @Pwd = (SELECT  DBO.FNC_DECRIPTION_PW('" . $var . "') AS Pwd);
Select @Pwd AS Pwd ")->result();
        foreach ($rs as $r) {
            $Pwd = $r->Pwd;
        }

        return $Pwd;
    }

    public function m_u_map_list()
    {
$this->db->select('m.*, u.*,mum.*');   
     
      $this->db->from('m_u_map as mum');	
      $this->db->join('machine_master m', 'm.mid = mum.m_id', 'left');
      $this->db->join('users u', 'u.uid = mum.u_id', 'left');
     
     // $this->db->where('users.status', 'Active');  
      $query= $this->db->get()->result();      
      return $query;		 
    }

    public function product_list($p_id = 0)
    {
$this->db->select('product_master.*');   
     
      $this->db->from('product_master');	
    //   $this->db->join('cat_master', 'cat_master.c_id = product_master.cat_id ', 'left');
    //   $this->db->join('sub_cat_master', 'sub_cat_master.s_id = product_master.sub_cat_id', 'left');
     
      $this->db->where('product_master.name', $p_id); 
      $this->db->where('product_master.status', '0');  
      $query= $this->db->get()->result();      
      return $query;		 
    }

    public function Product_detail($p_id)
    {
$this->db->select('product_master.*,cat_master.*,sub_cat_master.*');   
     
      $this->db->from('product_master');	
      $this->db->join('cat_master', 'cat_master.c_id = product_master.cat_id ', 'left');
      $this->db->join('sub_cat_master', 'sub_cat_master.s_id = product_master.sub_cat_id', 'left');
     
      $this->db->where('product_master.p_id', $p_id);  
      $query= $this->db->get()->result();      
      return $query;		 
    }
    public function city_requirement_list($state)
    {
$this->db->select('product_master.*, student.name , student.s_id , student.phone');   
     
      $this->db->from('student');	
      $this->db->join('product_master', 'student.city = product_master.cat_id ', 'left');
    //   $this->db->join('sub_cat_master', 'sub_cat_master.s_id = product_master.sub_cat_id', 'left');
     
      $this->db->where('product_master.cat_id', $state);  $this->db->order_by('product_master.created_at', 'desc'); 
      $this->db->group_by('product_master.p_id');  
      $query= $this->db->get()->result();      
        return $query;  		 
    }

}
