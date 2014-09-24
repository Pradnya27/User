<?php

/**
 * @package Under project                                 *
 * @category Generation of activaltion link               *
 * @version Create_Use_2                                  *
 * This class include DBConnect class for databse access. *
 * This class contain code for generation of              *
 * activation link for Creating user and Password reset   *
 * After clicking on activation link only user account    *
 * get activated. After clicking on activation link       *
 * of password reset only user can access his             *
 *  account in case of forget password
 *
 */
/**
 * This file contain GenerateLink class for generation of activation link 
 * after perticular event fired.This code generate activation link for creating user 
 * and in case of forget password and send that link to enterd(registered)email id
 */


  
class GenerateLink {

    /** This code belong to generation of activation link for create user.
     *  Send that Link to user entered mail id.
     *  Store all data entered by user in database.
     *  @param  login_id,fname,lname,email_id,password,phone,address
     *  @return  void  
     */
    function LinkGenerationforCreateUser($login_id,$fname,$lname,$email_id,$password,$phone,$address) {
    // Random confirmation code
        $confirm_code = md5(uniqid(rand()));
        $validate = new Validate();
        $password = $validate->hashPassword($password);
        $dbconnect = new DBConnect();
        $link = $dbconnect->connect_DataBase();
     // Insert data into database
        $sql = "INSERT INTO temp_members_db(confirm_code,login_id,user_name,last_name, password,email_id,phone_num,address)VALUES('$confirm_code','$login_id','$fname','$lname','$password','$email_id','$phone','$address')";
        $result = mysqli_query($link, $sql);

// if suceesfully inserted data into database, send confirmation link to email
        if ($result) {
// send e-mail to ...
            $to = $email_id;
// Your subject
            $subject = "Your confirmation link here";
            $name = $_SERVER['SERVER_NAME'];
// Your message
            $message = "Your Comfirmation link \r\n";
            $message.="Click on this link to activate your account \r\n";
            $message.="http://$name/Create_user_2/CreateUser/CreateUserConfirmation.php?passkey=$confirm_code";
// send email
            $sentmail = mail($to, $subject, $message);

            if ($sentmail) {
                echo "<center><font color='red'>Your Confirmation link Has Been Sent To Your Email Address.</font></center>";
            } else {
                echo "<center><font color='red'>Please Try again!!</font></center>";
            }
        } else {
            echo mysqli_error($link);
        }
        //closing database connection
        mysqli_close($link);
        //unset object of dbconnect
        unset($dbconnect);
        //unset object of validate class
        unset($validate);
      
    }

    function LinkForPasswordReset($email, $login_id) {
       
     $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
   unset($validate);
   $email = $validate->securityCheck($email);
   $login_id = $validate->securityCheck($login_id);
      
 
//creating object of dbconnect class
        $dbconnect = new DBConnect();
//creating database connection
        $link = $dbconnect->connect_DataBase();
//destroying object
        unset($dbconnect);

// Random confirmation code
        $confirm_code = md5(uniqid(rand()));

        // Insert data into database
        $sql = "INSERT INTO forget_password(confirmation_code,email_id,login_id)VALUES('$confirm_code', '$email','$login_id')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            mysqli_error($link);
        }
//closing database connection
        mysqli_close($link);
// if suceesfully inserted data into database, send confirmation link to email
        if ($result) {
// send e-mail to ...
            $to = $email;

// Your subject
            $subject = "Reset your password for kotech software login";
            $name = $_SERVER['SERVER_NAME'];
    // Your message
            $message = "Your Comfirmation link \r\n";
            $message.="Click on this link to activate your account \r\n";
            $message.="http://$name/Create_User_2/forget_Password/New_Password.php?passkey=$confirm_code";
    // send email
            $sentmail = mail($to, $subject, $message);
    // if your email succesfully sent
            if ($sentmail) {
                echo "<center><font color='red'>Link for Password reset is forword to your email address.</font></center>";
            } else {
                echo "<center><font color='red'>Unable to send reset password link to your email address</font></center>";
            }
        }
    }

    
}

?>