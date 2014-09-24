<?php
/**
 * @package  userManagement.                                        *
 * @version of this file is Create_User_2.                          *
 * @category CreateUser                                             *
 * This code belongs to CreateUser package                          *
 * This code belongs to creation of users.                          *
 * In this file Validate class is included for validation purpose.  *
 * This code conatin form for creating user with login_id(unique),  *
 * first name,last name,emailid(unique),phone number,address of     *
 * the user. All this fields are validated in validateCreateUser()  *
 * of Validate class.On successful creation of user it will add     *
 * new user to database and show his details on admin home page     *
 *  if any error then user will notify with error occured.          *                        *
*/

include '../Validate.php';
 $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
    $login_check = array();
   $login_check = $validate->getAccessLevel();
//checking whether user is logged in or not
if ($login_check['login_check'] == 0) {

    header("Location:../Login/Main_Login.php");
}
   unset($validate);
?>
<html>
    <head>
        <title>Create New User</title>
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
        /**
         * This file is used to create new user to login in the system
         * This code include Validate class for validation of fields
         * If no error in validation of fileds  call activatin_link function fron validate class
         *  and send to entered mail id
         */
      
       
        //calling GenerateLink.php to generate activation link on succesful creation of user
         include '../GenerateLink.php';
          $check=0;
        // checking wheather form is posted or not 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
           //receiving parameter value entered by user 
            $login_id = $_POST['login_id'];
            $first_name = $_POST['user_name'];
            $last_Name = $_POST['user_last'];
            $password = $_POST['password'];
            $con_pass = $_POST['con_pass'];
            $email_Id = $_POST['email_id'];
            $phone = $_POST['user_phone'];
            $address = $_POST['user_address'];
           
            
            //$validate is object of class Validate
          $check = createUser($login_id,$first_name,$last_Name,$email_Id,$password,$con_pass,$phone,$address);
     
            
        }
        ?>
        <form name="createUser" method="POST"  action="">
            * field are required
             <table>
                <tr>
                    <td>Enter Login ID</td>
                    <td><input type="text" name="login_id"placeholder="Enter Login ID*" size="50" value ="<?php if(isset($_POST['login_id'])){ echo $_POST['login_id'];}?>"/></td>

                </tr>

                <tr>
                    <td>Enter User Name</td>
                    <td><input type="text" name="user_name"placeholder="Enter first name*" size="50" value="<?php if(isset($_POST['user_name'])){ echo $_POST['user_name'];}?>"/></td>

                </tr>
                <tr>
                    <td>Enter Last Name</td>
                    <td><input type="text" name="user_last" placeholder="Enter last name*" size="50" value="<?php if(isset($_POST['user_last'])){ echo $_POST['user_last'];}?>"/></td>

                </tr>
                <tr>
                    <td>Enter  Email ID</td>
                    <td><input type="text" name="email_id" placeholder="Enter email address*" size="50" value="<?php if(isset($_POST['email_id'])){ echo $_POST['email_id'];}?>" /></td>

                </tr>

                <tr>
                    <td>Enter Password</td>
                    <td><input type="password"name="password" placeholder="Enter password*"size="50"/></td>

                </tr>
                <tr>
                    <td>Enter Confirm Password</td>
                    <td><input type="password"name="con_pass"placeholder="Enter confirm password*" size="50" /></td>

                </tr>

                <tr>
                    <td>Enter Phone</td>
                    <td><input type="text" name="user_phone" placeholder="Enter Phone number" size="50" value="<?php if(isset($_POST['user_phone'])){ echo $_POST['user_phone'];}?>"/></td>

                </tr>
                <tr>
                    <td>Enter Address</td>
                    <td><input type="textfield" name="user_address"placeholder="Enter address" size="50" value="<?php if(isset($_POST['user_address'])){ echo $_POST['user_address'];}?>"/></td>

                </tr>

                <tr>
                    <td></td>
                    <td><input type="submit" value="Create User"/></td>
                </tr>
                 </table><?php
            if($check === 1)
            {
            ?>
            <table border="1">
            <tr>
                <th>Login ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Id </th>
                <th>Contact no.</th>
                
            </tr>
            
             
                    <tr>
                        <td><?php echo $login_id; ?></td>
                        <td><?php echo $first_name; ?></td>
                        <td><?php echo $last_Name; ?></td>
                        <td><?php echo $email_Id; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $address; ?></td>
                        
            

                    </tr>
            </table>
            <?php 
            
                }?>
        
              
        </form>
    </body>
</html>

<?php 
                    
/**
 * This function is used to validate all the form field. If all the 
 * entered data is correct then, it create a new entry in database. 
 * If there is some validation error then user will be notify with that.
 * Error message will be display on screen. In this function error message
 * for email id and login id are overriden as no need to check for that.
 * @param type $login_id
 * @param type $first_name
 * @param type $last_name
 * @param type $email_id
 * @param type $password
 * @param type $con_pass
 * @param type $phone
 * @param type $address
 * @return void 
 *  */
function  createUser($login_id,$first_name,$last_name,$email_id,$password,$con_pass,$phone,$address)
{   //creating object of validate class
    $validate = new Validate();
    // validating all data fields
    $login_id = $validate->validateLoginID($login_id);
    $first_name = $validate->validateUserName($first_name);
    $last_name = $validate->validatelastName($last_name) ;
    $email_id = $validate->validateEmail($email_id);
    $password = $validate->validatePassword($password);
    $con_pass = $validate->validatePassword($con_pass);
    $phone = $validate->validatePhone($phone);
    $address = $validate->securityCheck($address);
   
    //overriding error message from email id and login id 
    // as no need to check for that
   if($validate->errormsgLogin=='Login id is not present')
   {
       $validate->errormsgLogin='';
   }
   if($validate->errormsgemail == 'Not register email id')
   {
       $validate->errormsgemail = '';
   }
   
   $array = array();
   // if no valdiation error
   
   if(empty($validate->errormsgLogin) && empty($validate->errormsgfirstname) && empty($validate->errormsglastname)&& empty($validate->errormsgpassword) && empty($validate->errormsgphone))
   {    if($password == $con_pass)
        {
             $password = $validate->hashPassword($password);
            //creating object of DBConnect class
           $dbconnect= new DBConnect();
           //creating database connection
           $link = $dbconnect->connect_DataBase();
           $access_level=3;
           $sql="insert into user(login_id,user_name,last_name, password,email_id,phone_num,address,account_status,access_level,date)" .
                "values ('$login_id','$first_name','$last_name','$password','$email_id',$phone,'$address','active','$access_level',now())";
           $result = mysqli_query($link, $sql);
           if(!$result)
           {
               echo mysqli_error($link);
           }
           else
           {
               echo "<center><font color='red'>New User created successfully</font></center>";    
                return 1;           


           }
        }
       else {
      echo "<center><font color='red'> Eneterd Password and confirm password do not match!!</font></centre> ";
              }
       
   }  
   else 
   {
       // if any error then display it
    echo "<center><font color='red'>".$validate->errormsgLogin.$validate->errormsgfirstname;
    echo $validate->errormsglastname.$validate->errormsgemail.$validate->errormsgpassword.$validate->errormsgphone;
    echo "</font></center>";
    return 0;
   }    
    return $array;
}

