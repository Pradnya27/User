<?php
/**
 * @package  Login.                                           *
 * @version of this file is Create_User_2.                    *
 * @category Main_Login                                       *
 *  This code is divided in two section.                      *
 * 1.Login to account. 2.Forget Password                      *
 * Work according to selection of radio button.               *
 * Validate class inclued for form validation.                *
 * If successful login redirects to home page                 *
 * If radio button is selected then  user have to entered     *
 * login_id and email_id registered at time of creating user  *
 * In this error message from email id is 
 */
include './ValidateLogin.php';
?>     

<html>
    <head>
        <title></title>
        <style>
            .message { color: red; }
        </style>
        <script type="text/javascript" src="login.js"></script>
    </head>
    <body>
        
    <br/>
    <br/>
    <form method="post" action="Main_Login.php" id="login_form">
        <div align="center">
            <table>

                <tr>
                    <td> Login Id :<br/></td>
                    <td> <input name="user_id" type="text" id="user_id" value="" maxlength="20" /><br/></td>

                </tr>
                <tr>
                    <td>Password :<br/></td>
                    <td><input name="password" type="password" id="password" value="" maxlength="20" /><br/></td>

                </tr>
                <tr><td></td>
                    <td><?php 
                     if (isset($_SESSION['login_id'])) {
                                
                          $login_id = $_SESSION['login_id'];
                          
                         
                          $validate = new Validate();
                          $count = $validate->getInvalidCount($login_id);
                         
                          
                          if($count>=2)
                          {
                             require_once('../recaptchalib.php');
                              $publickey = "6Ldjd_kSAAAAAIAUwMZMUFTAyxB3lOA7hQWnx1jZ"; // you got this from the signup page
                              echo recaptcha_get_html($publickey);
                          }
                          unset($validate);
                                      
                     }
                              
                    ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input name="Submit" type="submit" id="submit" value="Login" style="margin-left:-10px; height:23px"  /></td>
                </tr>

                <tr>
                    <td><input type="radio" id ="fpass" name="fpass"  value="forgetPass" style="margin-right:-10px; height:23px" onChange="call();"/></td>
                    <td>Forget Password</td>

                </tr>
                <tr>
                    <td >Enter  Login ID</td>
                    <td><input  type="text" id="login_id" name="login_id"  /></td>
                </tr>
                <tr>
                    <td>Enter  Email ID</td>
                    <td><input  type="text" id="email" name="email"  "  /></td>
                </tr>

                <tr>
                    <td></td>
                    <td><input  type="submit" id="forget_password" value="Generate Password"   disabled="true"  /></td>
                </tr>
            </table>
            <div id="log"></div>
        </div>
    </form>
</body>
</html>



