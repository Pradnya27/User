<?php 
/**
 * @package Admin_Panel.                               *
 * @version of this file is Create_User_2.             *
 * @category default home page for admin               *
 * This is basic for dividing page in different        *
 * frameset.Every frameset have it's own functionality *
*/



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
<frameset rows="16%,84%">
<frame src="Top.php" name="top" >
<frameset cols="15%,85%">
<frame src="Left_Frame.php" name="left">
<frame src="Right_Frame.php" name="right">
</frameset>
</frameset> 
</html>