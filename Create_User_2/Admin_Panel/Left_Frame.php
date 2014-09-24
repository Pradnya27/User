<?php
/**
 * @package  Admin_home                     *
 * @version of this file is Create_User_2.  *
 * @category Admin panel home               *   
 * This code belongs to Left frame .        *
 * Contins Link for all user management operation             *
 * */

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
    <body>
        <a href="Admin_Home.php" target="_top" ><input type="button" value="Home" name="Home" /></a><br/><br/>
        <a href="../UserManagement/CreateUser.php" target="right"><input type="button" value="Create User" name="create user"/></a><br/><br/>
        <a href="../UserManagement/ManageUser.php" target="right" ><input type="button" value="User Management" name="Delete user"/></a><br/><br/>
        
     
    </body>
</html>
<?php
?>