<?php

/**
 * @package  userManagement.                        *
 * @version  Create_User_2.                         *
 * @category manages users related operations       * 
 * This is code for updating user account status    *
 * If there is any error then user will be notified with that  *
 * else user account status will be updated *        
 * 
*/





include '../Validate.php';
    $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
   unset($validate);
// checking for session variable is set or not
if ($_SESSION['admin_id'] == "") {
    header("Location:../Login/Main_Login.php");
}

//creating object of validate class to call function
$user_id = $_POST['user_id'];
$status = $_POST['status'];
//creating object of validate class
disableUser($user_id, $status);
/**
 * This function is used to validate user,
 * If there is no validtaion error then update 
 * account status. If any error occured then display respective message
 * @param type $user_id
 * @param type $status
 * @return void
 */

function  disableUser($user_id,$status)
{
    $validate = new Validate();
   $login_id = $validate->validateLoginID($user_id);
   if($validate->errormsgLogin == 'Login id is already in use')
   {
    $validate->errormsgLogin='';   
   }
   if(empty($validate->errormsgLogin))
   {
        $dbconnect = new DBConnect();
        //creating database conenction
        $link = $dbconnect->connect_DataBase();
        //unset created object
        unset($dbconnect);    
         //firing query to delete user from table where login id mateched
        $sql = "update user set account_status ='$status' where login_id = '$login_id' ";
        $result = mysqli_query($link, $sql);
        
        $errormsg = "";
        if (!$result) {
            $errormsg = mysqli_error($link);
            return;
        }
        $sql1= "commit";
        $result = mysqli_query($link, $sql1);
        if($result)
        {
            echo  "<center><font color='red'> Selected User account is '$status'</font></center> ";
        }
        else
        {
            echo "<center><font color='red'>".mysqli_error($link)."</font></center>";
        }
        
        //closing database connection
        mysqli_close($link);
   }else
   {
       echo "<center><font color='red'>".$validate->errormsgLogin."</font></center>";
   }
    
}

?>