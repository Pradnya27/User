<?php /**
 * @package forget_password                          *
 * @version Create_User_2                            *
 * @category form for password reset                 *
 * This code provied a form where user can           *
 * enter his new password and submit the form        *
 * for futher processing after valdiating            *
 *  form if there is no errors then user is directly *
 * redirected to login page                          *
 */ ?>
<html>
    <style>
        .error { color: red; }
    </style>
    <body>
        <?php
        // including validate class for valdiation of form field
        include '../Validate.php';
        //Calling Validate class 
        $validate = new Validate();
        //secure session starting
        $validate->sec_start_session();
        unset($validate);
        $passkey = $_GET['passkey'];

        // checking for page is submited or not
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
            $new_pass = $_POST['new_pass'];
            $con_pass = $_POST['con_pass'];
            //function call to validate as well as process data
            UpdatePassword($passkey, $new_pass, $con_pass);
        }
        ?>
        <form method="POST" name="change" action="" >


            <p>New Password:
                <input type="password" name="new_pass"  id="new_pass" />
            </p>
            <p>Confirm Password :
                <input type="password" name="con_pass" id="con_pass"  />
            </p>
            <p align="left">
                <input name="submit" type="submit" value="Save Password" class="submit" />
            </p>
        </form>
    </body>
</html>
<?php
/**
 * This function is used to update user password with new password.
 * When user clicks on link for password reset then a form for reset password is 
 * loaded. By retrieving passkey attached with url and matched with temparory 
 * database of forget_password and respective user's password is updated if both new password and confirm password is same.
 * Else user will be notify with error occured.If password of user is upated successfully
 * then user will be redirected to login page.Properties are used to notify user with error.
 * @param type $key
 * @param type $new
 * @param type $con
 * @return void.
 * If successful then redirect user to login page else
 * display error occured.
 */

function updatePassword($key, $new, $con) {
    $errornew = '';
    $errorcon = '';
    $validate = new Validate();
    $new = $validate->validatePassword($new);
    if ($validate->errormsgpassword != '') {
        $errornew = 'Enter new password.';
        $validate->errormsgpassword = '';
    }
    $con = $validate->validatePassword($con);
    if ($validate->errormsgpassword != '') {
        $errorcon = 'Enter confirm password';
        $validate->errormsgpassword = '';
    }
 
    if (empty($errorcon) && empty($errornew)) {
      
        if ($new == $con) {
            $key = $validate->securityCheck($key);
            // hashing password
            $new = $validate->hashPassword($new);
            //creating object of databse for databse connection
            $dbconnect = new DBConnect();
            $link = $dbconnect->connect_DataBase();
            //unset object of $dbconnect
            unset($dbconnect);
            //query to be fired..
            $sql = "select * from forget_password where confirmation_code='$key' LIMIT 1";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
          $email = $row['email_id'];
          $login_id = $row['login_id'];
         if($result){
             
                $sql2 = "update user set password='$new' where email_id='$email' and login_id='$login_id'";
                $result2 = mysqli_query($link, $sql2);
                //if password is  updated successfully then..
                if ($result2) {
                    //delete data from temparory forget password database.
                    $sql3 = "delete from forget_password where confirmation_code='$key'";
                    $result = mysqli_query($link, $sql3);
                          
                    if (!$result) {
                        echo 'error occured' . mysqli_error($link);
                        return;                        
                    } 
                    //closing database
                    mysqli_close($link);
                    //redirect user to login page
                    header("Location:../Login/Main_Login.php");
                    }
            
                }
            }
         else {
            echo "<span class='error'>Password and confirm password donot match!!</span>";
        }
    } else {
        echo "<span class='error'>" . $errornew . $errorcon . "</span>";
    }
}
?>