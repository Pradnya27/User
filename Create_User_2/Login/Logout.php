<?php
/**
 *  @package  Login.                         *
 * @version of this file is Create_User_2.   *
 * @category Logout                          *
 * This code is used to destory session and  *
 * set session variable to null  and logout  *
 * logged in user                            *
 */
?>
<html>
    <?php

include_once '../Validate.php';
$validate = new Validate();
$validate->sec_start_session();

// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// Delete the actual cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Destroy session 
session_destroy();

?>
    
    <body>
        <h2>You are Successfully Logout</h2>
        <h3>Click here to go <a href="Main_Login.php"> Login</a> Page</h3>
    </body>
</html>
