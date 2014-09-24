<?php 
/**
 * @package  ChangePassword.                         *
 * @version of this file is Create_User_2.           *
 * @category change password                         *
 * This code is used to chnage password of user.     *
 * This file called function checkPassword() to      *
 * validate and update user password.If there is     *
 * any error occured then user will be notify.       *
 *                
 */

?>
<html>
    <style>
        .error { color: red; }
    </style>
    <?php
    // error parsing
    error_reporting(E_ERROR | E_PARSE); 
    //including validtae class
    include '../Validate.php';
  //creating object of validate class
        $obj = new Validate();
  $obj->sec_start_session();
  
    // checking for session variable is set or not
    if ($_SESSION['admin_id'] == "" && $_SESSION['login_id']=="") {
        header("Location:../Login/Main_Login.php");
    }
    //checking for page is submitted or not
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //reteriving vales from form
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $con_pass = $_POST['con_pass'];
       
        //calling function for passwodr validtaion
        $errormsg = checkPassword($old_pass, $new_pass, $con_pass);
        ?><span class="error"><?php echo $errormsg; ?></span>
        <?php
        
    }
    ?>
    <body>
        <form method="POST" name="change" action="Change_password.php" >

            <p>Old Password:
                <input type="password" name="old_pass"  id="old_Pass"   /><b class="error">*</b>

            </p>

            <p>New Password:
                <input type="password" name="new_pass"  id="new_pass" /><b class="error">*</b>

            </p>
            <p>Confirm Password :
                <input type="password" name="con_pass" id="con_pass"  /><b class="error">*</b>


            </p>
            <p align="left">
                <input name="submit" type="submit" value="Save Password" class="submit" />
            </p>
        </form>



    </body>
</html>
<?php 
/**
 * This function is used to validate entered password.
 * validate old password,check wheather it is correct or not.
 * If old password is correct then check for new password 
 * and confirm password. If both are correct then update password.
 * and display respective message.
 * @param type $old_pass
 * @param type $new_pass
 * @param type $con_pass
 */
function checkPassword($old_pass, $new_pass, $con_pass) {
   
    $error_old='';
    $error_new='';
    $error_con='';
    //retrieve login id;
    if ($_SESSION['admin_id'] == "") {
            $login_id = $_SESSION['login_id'];
        } else {
            $login_id = $_SESSION['admin_id'];
        }
        //creating object of validate class
     $validate = new Validate();
     //validating old password
     $old_pass = $validate->validatePassword($old_pass);
     if($validate->errormsgpassword!='')
     {
         $error_old = 'Enter current password.';
         $validate->errormsgpassword ='';
         
     }
     //validating new password
     $new_pass = $validate->validatePassword($new_pass);
     if($validate->errormsgpassword!='')
     {
         $error_new ='Enter new password.'; 
          $validate->errormsgpassword ='';
     }
     //validating confirm password
     $con_pass = $validate->validatePassword($con_pass);
     if($validate->errormsgpassword!='')
     {
         $error_con ='Enter Confirm password.'; 
          $validate->errormsgpassword ='';
     }
     //if theer is no validation error
     if(empty($error_old)&&empty($error_new) &&empty($error_con))
     {  // If confirm password and new password are equal
        if($new_pass == $con_pass)
        {
            //hashing password for security purpose
            $old_pass = $validate->hashPassword($old_pass);
            $dbconnect = new DBConnect();
            $link = $dbconnect->connect_DataBase();
            //destroying dbconnect object
            unset($dbconnect);
            $sql = "select password from user where login_id ='$login_id' LIMIT 1";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            if (!$result) {
                echo 'error accoured'. mysqli_errno($link);
            }
            if($old_pass == $row['password'])
            {
                //hashing new password
               $new_pass = $validate->hashPassword($new_pass);
                $sql = "update user set password='$new_pass' where password='$old_pass' and login_id = '$login_id'";
                $result = mysqli_query($link, $sql);
                $sql = "commit";
                mysqli_query($link, $sql);
                if (!$result) {
                $errormsg = mysqli_error($link);
                } else {
                   echo  "<span class='error'>Password updated successfully</span>";
                } 
            }
            else {
                echo"<span class='error'>Wrong current Password</span>";
            }
         }else
         {
              echo "<span class='error'>New Password and confirm password do not match</span>";
           
         }
         
         
     }  
     else
    {
         echo  "<span class='error'>".$error_old.$error_new.$error_con."</span>";    
     }
     unset($validate);
}
        
?>