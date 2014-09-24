
<?php
/**
 * @package  admin Panel.                           *
 * @version of this file is Create_User_2.          *
 * @category View  Top frmae on admin home page     * 
 * This is default frame display on home page       *
 * in top section      *
 * */
?>
<html>
    <head>
        <style>
            div.topRight 
            {
                position: absolute;
                top: 15%;
                right: 0%;
            }
            div.topLeft 
            {
                position: absolute;
                top: 5%;
                left: 0%;
            }
        </style>
    </head>
    <body>
        <div class="topLeft">
            <h3><i>Welcome to Reports Page ,<u><?php
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
if ($_SESSION['admin_id'] == "") {
    header("Location:../Login/Main_Login.php");
}
$user_Id = $_SESSION['admin_id'];
echo strtoupper($user_Id);
?></u></i></h3>
        </div>
        <div class="topRight">
            <a href="../ChangePassword/Change_password.php" target='_blank'>Change Password</a>
            <a href="../Login/Logout.php" target='_top'> 
                <input type="button" name="logout" value="Log Out"/></a>
        </div>
    </body>
</html>