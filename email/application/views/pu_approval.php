<!DOCTYPE html>
<html>
<head>
    <title>Notification - User Approval Request</title>
</head>
<body style="padding: 0; margin: 0">
    <table bgcolor="#e6e6e6" width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td>
                    <table width="600px" align="center" cellspacing="0" cellpadding="0" border="0" style="background: rgb(52, 82, 255);background-image: -moz-linear-gradient( 135deg, rgb(255, 16, 83) 0%, rgb(52, 82, 255) 100%);background-image: -webkit-linear-gradient( 135deg, rgb(255, 16, 83) 0%, rgb(52, 82, 255) 100%);background-image: -ms-linear-gradient( 135deg, rgb(255, 16, 83) 0%, rgb(52, 82, 255) 100%);">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="480" cellpadding="0" cellspacing="0" border="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="bottom" style="padding: 40px 0px 20px 0px; font-weight: 300; font-size: 30px; letter-spacing: 0.025em; line-height: 40px; color: #ffffff; font-family: 'Poppins', sans-serif;">
                                                    <span style="font-weight: 600; font-size: 22px; letter-spacing: 0.000em; line-height: 40px; color: #ffffff; font-family: 'Poppins', sans-serif;">WELCOME TO URISE</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="480" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" align="center">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 20px 0px 0px 0px;">
                                                    <table width="420" height="100" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" style="font-weight: 500; font-size: 18px; letter-spacing: 0.100em; line-height: 26px; color: #203442; font-family: 'Poppins', sans-serif;">
                                                                    <img style="vertical-align: middle;" src="http://thewebprofessional.in/urise/assets/images/logo-color.png">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="50"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size: 14px; line-height: 26px; color: #203442; font-family: 'Poppins', sans-serif; padding: 5px 0; vertical-align: top;">Respected Sir/Madam,</td>
                                                            </tr>
                                                            <tr>
                                                                <td height="20"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size: 14px; line-height: 26px; color: #203442; font-family: 'Poppins', sans-serif; padding: 5px 0; vertical-align: top;">Please find the details of primary user for approval:-</td>
                                                            </tr>
                                                            <tr>
                                                                <td height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="background: #004895; padding: 10px; text-align: center;">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-weight: 600; font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px; vertical-align: top;">User Name
                                                                                </td>
                                                                                <td style="font-weight: 600; font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px; vertical-align: top;">Email Id
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px 5px 10px 5px; vertical-align: top; border-bottom:1px solid #fff;"><?php echo ucfirst($data['firstName']).' '.ucfirst($data['lastName']);?>
                                                                                </td>
                                                                                <td style="font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px 5px 10px 5px; vertical-align: top; border-bottom:1px solid #fff;"><?php echo ucfirst($data['emailId']);?>
                                                                                </td>
                                                                            </tr>
																			<tr>
                                                                                <td style="font-weight: 600; font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 10px 5px 5px 5px; vertical-align: top;">Employee Id
                                                                                </td>
                                                                                <td style="font-weight: 600; font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 10px 5px 5px 5px; vertical-align: top;">Department
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px 5px 10px 5px; vertical-align: top; border-bottom:1px solid #fff;"><?php echo ucfirst($data['employee_id']);?>
                                                                                </td>
                                                                                <td style="font-size: 14px; width: 50%; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px 5px 10px 5px; vertical-align: top; border-bottom:1px solid #fff;"><?php echo ucfirst($data['department']);?>
                                                                                </td>
                                                                            </tr>
																			<tr>
                                                                                <td colspan="2" style="font-weight: 600; font-size: 14px; color: #fff; font-family: 'Poppins', sans-serif; padding: 10px 5px 5px 5px; vertical-align: top;">Register for
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="font-size: 14px; color: #fff; font-family: 'Poppins', sans-serif; padding: 5px; vertical-align: top; text-transform:uppercase;"><?php 
        if($data['link_with'] == '2') { echo 'ITI'; }
        if($data['link_with'] == '3') { echo 'POLYTECHNIC'; }
        if($data['link_with'] == '1') { echo 'SKILL DEVELOPMENT'; }
        ?>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="20"></td>
                                                            </tr>
                                                           <!-- <tr>
                                                                <td style="font-size: 14px; line-height: 26px;  color: #203442; font-family: 'Poppins', sans-serif; padding: 5px 0; vertical-align: top;">Click here for - <a href="<?php echo base_url().'user/Signup/verify/'.$data['isEmailToken'];?>" style="font-weight: 600; font-size: 14px; text-decoration: none; line-height: 26px; color: #00a7f1; font-family: 'Poppins', sans-serif;">Accept</a> | <a href="<?php echo base_url().'user/Signup/decline/'.$data['isEmailToken'];?>" style="font-weight: 600; font-size: 14px; text-decoration: none; line-height: 26px; color: #00a7f1; font-family: 'Poppins', sans-serif;">Decline</a>
                                                                </td>
                                                            </tr>-->
                                                            <tr>
                                                                <td height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size: 14px; color: #203442; font-family: 'Poppins', sans-serif; padding: 5px 0; vertical-align: top;">
                                                                    Thanks,
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-size: 14px; color: #203442; font-family: 'Poppins', sans-serif; padding: 5px 0; vertical-align: top;">
                                                                    Urise Team!
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="35"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="480" cellpadding="0" cellspacing="0" border="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="top" style="padding: 15px 0px 30px 0px; font-weight: 300; font-size: 12px; letter-spacing: 0.025em; line-height: 40px; color: #ffffff; font-family: 'Poppins', sans-serif;">&copy; 2020 Urise
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
