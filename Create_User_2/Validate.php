<?php

/**
 * @package under project                                            *
 * @version  Create_User_2                                           *
 * @category Validate class                                          *
 * This class contains methods for validation                        *
 * and processing code accordingly.                                  *
 * This class also include DBConnect class for databse connection.   *
 * This class having following method:                               *
 * 1. validateLoginID():- validate entered login id.                 *   
 * 2. validateLoginIdWithDB():-validate login idaccross database.    *
 * 3. validateUserName():-validate entered first name.               *
 * 4. validatelastName():-validate entered last name.                *
 * 5. validateEmail():- validate entered email id.                   *
 * 6. validateEmailWithDB():-validate email id accross database.     *
 * 7. validatePassword():-valdiate entered password.                 *
 * 8. validatePhone():-validate phone number.                        *
 * 9. validateCreateUser():-validate creat user form.                *
 * 10.securityCheck():-check data for security purpose               * 
 * 11.hashPassword():- encrypt password                              *
 * 12.passwordSecurityCheck():-check password for security purpose   *
 * 13.resetPassword():- validate data in case of forget password     *
 * 14.sec_start_session():-start session in secure way               *
 * 15.getAccessLevel():- return acess level of ogged in user         *
 * 16.getInvalidCount():- return invalid attempt count of user        *
 */
/* This file contain a class validate which have all function to 
 * validate values and update database wherever necessary.
 * Function may return values in the form of String as error
 * In this code error message from email id and login id are overrided 
 * as no to display that error/check for that 
 */
/*
 * Including DBConnect.php file for creating database connection
 */
include 'DBConnect.php';

//to validate captacha require onces
require_once('../recaptchalib.php');

class Validate {

    public $errormsgLogin;
    public $errormsgpassword;
    public $errormsgemail;
    public $errormsgfirstname;
    public $errormsglastname;
    public $errormsgphone;
    public $errormsgaddress;
    public $errorconpass;

    /** This function is to validate login Id.
     *  In there are some error then set property  errormsgLogin
     * @param string $login_id
     * @return validate login_id
     *
     */
    function validateLoginID($login_id) {
        $this->errormsgLogin = '';
        $errorname = NULL;
        // calling function for security check of data
        $login_id = $this->securityCheck($login_id);
        if ($login_id == NULL) {
            $errorname = " Enter valid Login ID. ";
        } else {
                $errorname = $this->validateLoginIdWithDB($login_id);
          }

        $this->errormsgLogin = $errorname;

        return $login_id;
    }

    /** function to validate login id
     * @param $login_id  is string
     * @return  error messages as string
     */
    function validateLoginIdWithDB($login_id) {

        $errormsg = "";
        $login_id = $this->securityCheck($login_id);
        //creating object of  DBConnect clss
        $dbconnect = new DBConnect();
        //creating database function
        $link = $dbconnect->connect_DataBase();
         $sql = " select login_id from user where login_id='$login_id' LIMIT 1";
        $result = mysqli_query($link, $sql);
        $row= mysqli_fetch_assoc($result);
     
        if($login_id == $row['login_id'])
        {
            $errormsg= "Login id is already in use";
        }
        else
        {
            $errormsg="Login id is not present";
        }                      
        //closing databse connection
        mysqli_close($link);
        //destroying object of dbconnect class
        unset($dbconnect);
        return $errormsg;
    }

    /** function to validate User_name(first).
     * This function set property errormessagefirstname ,if any 
     * error occured.
     * @param $user_name as string
     * @return validated $user_name
     */
    function validateUserName($user_name) {
        $this->errormsgfirstname=NULL;
        $errorname = NULL;
        // function calling for checking irrelevant data attached with string
        $user_name = $this->securityCheck($user_name);
        if ($user_name == NULL) {
            $errorname = " Enter valid First Name. ";
        } else {
            if (strlen($user_name) < 3) {
                $errorname = " Entered first name is invalid format ";
            }
        }

       $this->errormsgfirstname= $errorname;
       return $user_name;
    }

    /** This function is to validate last_name.
     * This function set property errormsglastname, if any error occured.
     * @param $last_name as string
     * @return  validated last_name 
     * 
     */
    function validatelastName($last_name) {
        $this->errormsglastname=NULL;
        $errorname = NULL;
        $last_name = $this->securityCheck($last_name);
        if ($last_name == NULL) {
            $errorname = " Enter valid Last Name. ";
        } else {
            if (strlen($last_name) < 3) {
                $errorname = " Entered  Last name is too short. ";
            }
        }
        $this->errormsglastname=$errorname;
        return $last_name;
    }

    /** This function is to validate email ID.
     * If any error occured then set property errormsgemail
     * @param $email is string
     * @return  validated email id
     */
    function validateEmail($email) {
        $this->errormsgemail=NULL;
        error_reporting(E_ERROR | E_PARSE);
        //checking email id for security purpose
        $email = $this->securityCheck($email);
        $errormsg = null;
        if ($email == NULL) {
            $errormsg = "Enter valid Email ID. ";
        } else {
            // validating email id
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errormsg = "Entered email id is not valid. ";
            } else {
                // function caling to validate email id with databse
                $errormsg = $this->validateEmailWithDB($email);
                if ($errormsg == 0) {
                    $errormsg = "Not register email id";
                } else {

                    $errormsg = "Email id already present in database";
                }
            }
        }
        $this->errormsgemail=$errormsg;
        return $email;
    }

    /** This function is to validate email id with database
     * and check entered email id is unique or not
     * @param $email id  is string
     * @return Interger error flag
     */
    function validateEmailWithDB($email) {

        $flag = 0;
        // creating database connection
        $dbconnect = new DBConnect();
        //calling function of DBConnect to connect with Database

        $link = $dbconnect->connect_DataBase();
        // firing query to selet email id
        $sql = "select email_id from user where email_id='$email' LIMIT 1";
        $result = mysqli_query($link, $sql);

        // fetching rows from data table

         $row= mysqli_fetch_assoc($result);
            if ($row['email_id'] == $email) {
                        $flag=1;
            }else {$flag=0;  }
           // Closing database connection
        mysqli_close($link);
        // destroying created object of DBConnect class
        unset($dbconnect);
        return $flag;
    }

    /** This function is to validate password.
     * If there is error thn errormsgpassword is set.
     * @param $password  is string
     * @return  validated password
     *  */
   function validatePassword($password) {

        $errorpassword = NULL;
        $this->errormsgpassword='';
        //security check for password
        $password = $this->passwordSecurityCheck($password);
        if ($password == NULL) {
            $errorpassword = "Enter valid Password. ";
        } else {
            if (strlen($password) < 3) {
                $errorpassword = "Entered password is too short. ";
            }
        }
        $this->errormsgpassword=$errorpassword;
        return $password;
    }

   

    /** This function is to validate phone number.
     * If any error occured then set errormsgphone.
     * @param integer $phone 
     * @return validated phone number.
     */
    function validatePhone($phone) {
        //security check for phone number
        $phone = $this->securityCheck($phone);
        if (empty($phone)) {
            // if no number has been supplied, add to array "error"
            $errormsg = 'Please Enter a Mobile Number ';
            // CF: Fixed the RegExp for you. Read post for comments.
        } else {

            if (preg_match('/^(NA|[0-9+-]+)$/', $phone) && strlen($phone) == 10) {
                
            } else {
                $errormsg = 'Your Mobile No. is invalid  ';
            }
        }
      $this->errormsgphone =$errormsg;
      return $phone;
    }

    /**
     * function to check values entered at create user form are proper or not,
     * if not then print property  which have error mesage. If there is no validation 
     * error then create object of GnerateLink class and call function LinkGenerationforCreateUser.
     * This function validates all form value entered in create user form. Validating email id and 
     * login id accross database may return that data is not present in database but for creating user
     * it's not valid test so set to null. Same thing is done in case of email id validtaion.
     * @param string user name, last name,email id,password,confirm password,phone(Integer) numbe,r adderss 
     * @return  errormessage.
     */
    function validateCreateUser($login_id, $user_name, $last_name, $email_id, $password, $confirm_password, $phone, $address) {
        // security checking for address 
        $address = $this->securityCheck($address);
        //validating login_id entered in form
        $login_id = $this->validateLoginID($login_id);
        //validating user first name
       $user_name =  $this->validateUsername($user_name);
        //validating user entered last name
       $last_name = $this->validatelastName($last_name);
        //validating entered email id
       $email_id = $this->validateEmail($email_id);
        // validating user entere password
       $password= $this->validatePassword($password);
        //verifying entered confirm password
       $confirm_password = $this->validatePassword($confirm_password);
       //verifying where password and confirm password are same or not
       //if not then set errorconpass property
       if(strcmp($password, $confirm_password)!=0)
       {
           $this->errorconpass='Password and Confirm password donot match';
       }
       $phone=$this->validatePhone($phone);
       
        if ($this->errormsgLogin == "Login id is not present") {
            $this->errormsgLogin = "";
        }
        if ($this->errormsgemail == "Not register email id") {
            $this->errormsgemail = "";
        }
        
       $errormsg= $this->errormsgLogin. $this->errormsgfirstname . $this->errormsglastname . $this->errormsgemail . $this->errormsgpassword . $this->errorconpass . $this->errormsgphone;
     
      if(empty($errormsg))
      {
           $fields = array(); 
           $fields['login_id'] = $login_id;
           $fields['fname'] = $user_name;
           $fields['lname'] = $last_name;
           $fields['email'] = $email_id;
           $fields['password'] = $password;
           $fields['phone'] = $phone;
           $fields['address'] = $address;        
            return $fields;
      }  else {
          echo "<font color='red'>". $errormsg."</font>";    
      }
    }

    /** This function is to validate entered data for security purpose
     * @param string data
     * @return data  as string    */
    public function securityCheck($data) {
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = stripcslashes($data);
        return $data;
    }

    
    
    /**
     * This is the function to encrypt password
     * @param $password is string
     * @return password in encrypted format
     */
    function hashPassword($password) {
        $this->passwordSecurityCheck($password);
        return md5($password);
    }

    
    
    /** function to validate entered data for security purpose
     * @param string data
     * @return data  as string    */
    public function passwordSecurityCheck($data) {
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }

    /**
     * This function reset your current password.
     * In this code msg1 is override because no need to check with
     * database as it is already checked.Also overried  prperties of   because
     * login id and email id as no need check with this error here.
     * @param type $email
     * @param type $login_id
     * @return void
     */
    function resetPassword($email, $login_id) {
               
         //validating and security check of login id and email id
         $email=$this->validateEmail($email);
         $login_id= $this->validateLoginID($login_id);
         
         
        //overriding error message from email id because no need to check
        if ($this->errormsgemail == "Email id already present in database") {
            $this->errormsgemail = "";
        }
        if ($this->errormsgLogin == "Login id is already in use") {
            $this->errormsgLogin = "";
        }
        //code to check wherether both email id and login id belong to same person/user
        $dbconnect = new DBConnect();
        $link = $dbconnect->connect_DataBase();
        $sql = "select email_id from user where login_id='$login_id'";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo 'error occured' . mysqli_error($link);
        } else {
          
            $row = mysqli_fetch_array($result);
            if ($row['email_id'] == $email) {
                
            } else {
                echo "<font color='red'>Incorrect combination of Login id and email id registered</font>";
                return;
            }
        }
        mysqli_close($link);
        if (empty($this->errormsgLogin) & empty($this->errormsgemail)) {
            //redirect to generation of link to reset password
         
            $generate = new GenerateLink();
            $errormsg = $generate->LinkForPasswordReset($email, $login_id);
        } else {
            echo "<font color='red'>" .$this->errormsgLogin.$this->errormsgemail ."</font>";
        }
    }
  
/**
 * This function is used to start session in secure way.
 * If session is start in secure way then we can save data from hackers.
 * In this function some cookies param are used to start ession in secure way.
 */
    function sec_start_session() {
        $session_name = 'sec_session_id';   // Set a custom session name
        $secure = FALSE;
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session 
        session_regenerate_id();    // regenerated the session, delete the old one. 
    }
 
/**
 * This function is used to retrieve user access level from database.
 * This access level is used to redirect user to his/her respective page.
 * @return int access level of current logged in user.
 */
    function getAccessLevel() {
        $value =array();
         if(isset($_SESSION['email_id']) && isset($_SESSION['login_string']))
        {
             
            $login_string = $_SESSION['login_string'];
            $email_id = $_SESSION['email_id'];
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            //creating login string
           $dbconnect = new DBConnect();
           $link = $dbconnect->connect_DataBase();
           $result = mysqli_query($link,"select access_level, password from user where email_id = '$email_id'LIMIT 1");
           $row = mysqli_fetch_assoc($result);
            $login_string1 = $this->hashPassword($row['password'] . $user_browser);
          
            if($login_string == $login_string1)
            {
                $value['login_check']= 1;
                $value['access_level'] = $row['access_level'];
                return $value;
                
            }
        }
        else {
        $value['login_check']=0;
        
        }

        
    }
    /**
     * This function is used to retrieve invalid count from database.
     * This function is used to display captch image on login page and 
     * to disable user acount status.
     * @param type $login_id
     * @return type
     */
  

    function getInvalidCount($login_id) {
        $dbconnect = new DBConnect();

        //creating databse connection with connect_Database() of DBConnect
        $link = $dbconnect->connect_DataBase();
        //reteriving invalid count form database
        $sql = "select invalid_count from user where login_id='$login_id' LIMIT 1";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo mysqli_error($link);
        }
        $row = mysqli_fetch_assoc($result);
        $count = $row['invalid_count'];
        //destroying dbconnect object
        unset($dbconnect);
        //closing databse connection
        mysqli_close($link);
        //return invalid count
        return $count;
    }

}
