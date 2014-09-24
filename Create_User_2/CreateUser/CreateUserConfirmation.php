
<?php
/**
 * @package  CreateUser.                                            *
 * @version of this file is Create_User_2.                          *
 * @category CreateUser                                             *
 * This code belongs to confirmation of account activation          *               *
 * When user clicks on activation link then this piece              *
 * get executed and transfer data stored in temparay table to       *  
 * original table and delete entry from temparay table.             *
 * if successful then User is able to login to system else          *
 * error will be dispiayed on screen to user                        *
 **/
/**
 * Including DBConnect class
 * for database connection  
 * 
 */
include '../Validate.php';

// Creating object of DBConnect class 
$dbconnect = new DBConnect();

// Calling function ofDBConnect class for creating database conenction 
$link = $dbconnect->connect_DataBase();
//unset dbconnect
unset($dbconnect);
$validate = new Validate();

// Reteriving  Passkey  which is attached with url 
$passkey = $_GET['passkey'];
//security checking pass key
$passkey = $validate->securityCheck($passkey);
unset($validate);


// Seleting username,account_status from user table where passkey are equal 
$sql = "select * from temp_members_db where confirm_code='$passkey'";

// calling function to execute query 
$result = mysqli_query($link, $sql);

// Counting number of returned row by fired query 
$count = mysqli_num_rows($result);

// Process if any row count is not zero 
if ($count == 1) {
   
    // fetecing whole row from table 
    $row = mysqli_fetch_array($result);
    // feteching  data 
    $login_id = $row['login_id'];
    $user_name = $row['user_name'];
    $lname = $row['last_name'];
    $email_id = $row['email_id'];
    $password = $row['password'];
    $phone = $row['phone_num'];
    $address = $row['address'];
    $account_status = "active";
    $access_level = 3;
    // query to insert information in original table from temparary table
    $sql2 = "insert into user(login_id,user_name,last_name, password,email_id,phone_num,address,account_status,access_level,date)" .
            "values ('$login_id','$user_name','$lname','$password','$email_id',$phone,'$address','$account_status','$access_level',now())";
    $result2 = mysqli_query($link, $sql2);
    if(!$result2)
    {
        echo  mysqli_error($link);
    }
    
    // If result of insertion of data is successful then delete whole row from temparay data table 
    if ($result2) {
       
        // Firing query  to delete data from tempary database 
        $sql = "delete from temp_members_db where confirm_code='$passkey'";
        $result = mysqli_query($link, $sql);
        echo 'Account activated successfully. ';
        ?>
        <a  href="../Login/Main_Login.php"  >Click Here for Login </a>       
        <?php
    }
} else{
    echo "Wrong confirmation code.Unable to Activate your account.Please try to create new user";
}
//closing databse
mysqli_close($link);
?>