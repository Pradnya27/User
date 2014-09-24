<?php
/**
 * @package  admin_Panel.                                          *
 * @version of this file is Create_User_2.                         *
 * @category Assount status                                        *
 * This code contain form for editing user account status.         *
 * On selecting perticular status  user account status is updated  *
 * accordingly.                                                    *
 **/
include '../Validate.php';
 $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
    $login_check = array();
   $login_check = $validate->getAccessLevel();
//checking whether user is logged in or not
if ($login_check['login_check'] == 0) {

    header("Location:../Login/Main_Login.php");
}
   unset($validate);
?>
<html>
    <head>
        <style>       
        </style>
    </head>
    <body>
    <br/>
    <br/>
    <div  style="width:300px;height:150px;border:1px solid #000">
    <br/>
        <form name='f1'>
            <input type="radio"  id='status' name="status" value="0" />Active<br/><br/>
            <input type="radio"  id='status' name="status" value="1"/>Disable<br/><br/>
            <input type="button" id="submit" name="submit" value="Update Status" onclick="disable(this)"/>
        </form>
       </div>
    </body>
</html>

