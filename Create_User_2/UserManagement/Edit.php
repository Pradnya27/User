<?php
/**
 * @package  userManagement.                                              *
 * @version  Create_User_2.                                               *
 * @category edit and store user information                              * 
 * This is code for edit serarched user information and store/update      *
 * database accordingly .User information will be updated permantanly     * 
 * */?>
<html>
    <head>
          <style>
            .message { color: red; }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color:   red;
                opacity:  1;
            }
        </style>
    </head> 
    <body>
    <?php
     
   //including validtae class to validate all fields.
            include '../Validate.php';
            $validate  = new Validate();
            $validate->sec_start_session();
            unset($validate);
   //Checking for Form is post or not
    if ($_SESSION['admin_id'] == "") {
                header("Location:../Login/Main_Login.php");
    }
   //reteriving all data send by ajax query
    $user_id = $_POST['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    //function to validate all entered data
    $errormsg = validateInfo($user_id,$fname, $lname, $email, $phone, $address);
        
        echo "<font color='red'>". $errormsg."</font>";
        
    /**
     * This code validates all the data send by ajax/form to update user 
     * information permantantly. This function edit  perticular user information where login_id matches
     * @param type $fname
     * @param type $lname
     * @param type $email
     * @param type $phone
     * @param type $address
     * @return type string of errormsg
     * 
     */
    function validateInfo($login_id,$fname, $lname, $email, $phone, $address) {
    $validate = new Validate();
   
    //function call to valdiate first name
    $fname = $validate->validateUserName($fname);
    //function call to valdiate last name
    $lname = $validate->validatelastName($lname);
    //function call to valdiate email address
    $email = $validate->validateEmail($email);
    //function call to valdiate phone
    $phone = $validate->validatePhone($phone);
    //destroying created object of validate class
    
    if($validate->errormsgemail=='Email id already present in database')
    {
        $validate->errormsgemail='';
    }
if(empty($validate->errormsgfirstname) && empty($validate->errormsglastname) && empty($validate->errormsgemail)&& empty($validate->errormsgphone))
{
    $dbconnect = new DBConnect();
    //function call to create database connection
    $link = $dbconnect->connect_DataBase();
    //firing qyery to update database with new values
    $sql = "update user set user_name='$fname',last_name='$lname',email_id = '$email',phone_num = '$phone',address='$address' where login_id='$login_id'";
    $result = mysqli_query($link, $sql);
    //closing database connection 
   
    //destroying created object of dbconnect class
    unset($dbconnect);
    if ($result) {
        $errormsg = "Updated successfully!!";
    } else {
        $errormsg = mysqli_error($link);
    }
     mysqli_close($link);
}else
{
    $errormsg = $validate->errormsgfirstname.$validate->errormsglastname.$validate->errormsgemail.$validate->errormsgphone;
}
    return $errormsg;
}

/**
 * This function edit  perticular user information where login_id matches
 * @param string $fname,$lname,$email,$phone,$address,$login_id
 * @return string errormes if any
 */

    ?>    
        
        
        
    </body>
  </html>






