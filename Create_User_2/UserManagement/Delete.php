
<?php

/**
 * @package  userManagement.                                     *
 * @version of this file is Create_User_2.                       *
 * @category update User account status                          * 
 * This is code for Delete user account .In this code            *
 * errormessage returned  by loginId are override as no need     *
 *  to check for that.Seleted user account will be deleted permantanly    *
 * */
// including validtae classto validtae user id/login_id

include '../Validate.php';

 
    $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
   unset($validate);
if ($_SESSION['admin_id'] == "") {
    header("Location:../Login/Main_Login.php");
}
// retriving data send by ajax jquery
$user_id = $_POST['user_id'];

$errormsg = deleteUser($user_id);
  


/**
 * This function delete perticular user from orignal database  by email id
 * @param string $login_id
 * @return string
 */
function deleteUser($login_id)
{
    $validate = new Validate();
    $login_id =  $validate->validateLoginID($login_id);
    if($validate->errormsgLogin=='Login id is already in use')
    {
        $validate->errormsgLogin='';
    }
    if($validate->errormsgLogin =='')
    {
        $dbconnect = new DBConnect();
        $link = $dbconnect->connect_DataBase();
        $sql = "delete from user where login_id='$login_id'";
        $result = mysqli_query($link, $sql);
        if(!$result)
        {
            echo mysqli_error($link);
        }
        else 
        {
           $sql1 = "select email_id from user where login_id = '$login_id'";
           $result1 = mysqli_query($link, $sql1);
           $row = mysqli_fetch_assoc($result1);
           
           if($row['email_id']=='')
           {
               echo "<center><font color='red'>".$login_id." is deleted successfully</font></center>";
           }  
           else 
           {
             echo mysqli_error($link);
           }
        }
        //closing database connection
        mysqli_close($link);
        //destroying dbconnect object
        unset($dbconnect);
    }
    else
    {
        echo "<center><font color='red'>".$validate->errormsgLogin."</font></center>";    
    }
}
?>


