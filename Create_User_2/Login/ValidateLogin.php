<?php
    /**
     * This code belong to validate user login.If user entered valid login id but invalid 
     * password then increase invalid count. If invalid count is n then disbale user account.
     * Login page will show recpatcha image toavoid spammers.If login id and password are 
     * correct then redirect user accordig to his/her access level.If user alredy lgged in and 
     * want to come back on login page without logged out then he/she will be redirected to his/her respective 
     * home page.If user selects radio button then reserPassword() is called which validate 
     * entered email id and login id .If both are valid then procced further.In  validation login credential,
     * login id property is overloaded as no need to check for where login id is already in user or not.
     */

error_reporting(E_ERROR | E_PARSE);

include '../Validate.php';
include '../GenerateLink.php';

//Calling Validate class 
$validate = new Validate();
//secure session starting
$validate->sec_start_session();
$value = array();
$value = $validate->getAccessLevel();
if($value['login_check']==1)
{
    if($value['access_level']==1)
    {
        header("Location:../Admin_Panel/Admin_Home.php");
    }
 else {
        header("Location:../View_Reports/View_Reports.php") ;                       
    }
}


else{ 
 // Checking wheather form is posted or not 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) 
    {
       
        // $validate as object of Validate class 
        //verifying radio button is checked or not
        $radio = $_POST['fpass'];
        if (empty($radio))
        {           
            $login_id = $_POST['user_id'];
            $password = $_POST['password'];
            // calling function from validate class to validate login form 
            $login_id = $validate->validateLoginID($login_id);
            //validating password
            $password = $validate->validatePassword($password);
            //hashing password
            $password = $validate->hashPassword($password);
                                
            if($validate->errormsgLogin =='Login id is already in use')
            {
             $validate->errormsgLogin='';
            }
            // If there is no validation error
            if(empty($validate->errormsgLogin) && empty($validate->errormsgpassword))
            {

                $_SESSION['login_id'] = $login_id;
                //creating obejct of dbconnect class
                $dbconnect = new DBConnect();
                //creating databse connection
                $link = $dbconnect->connect_DataBase();
                //destroying object of dbconnect class
                unset($dbconnect);
                //firing query to database
                $sql = "select email_id,password ,account_status,access_level,invalid_count from user where login_id='$login_id' LIMIT 1";
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                
                // checking account status is active or not
                 
                if ($row['account_status'] == 'active') 
                {
                    // checking wherthere entered password is equal to database password or not
                    if ($row['password'] == $password && $row['invalid_count']<=3) 
                    {                      
                        //checking user browser
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        //creating login string
                        $login_string =  $validate->hashPassword($row['password'] . $user_browser);
                        $_SESSION['login_string'] = $login_string;
                        //session session variable email id
                        $_SESSION['email_id'] = $row['email_id'];
                        $count = 0;
                        $sql1 = "update user set invalid_count='$count',last_time= now() where login_id ='$login_id'";
                        $result1 = mysqli_query($link, $sql1);
                        //if result fails
                        if (!$result1) {
                            echo mysqli_error($link);
                        } else 
                        {  
                                                    
                            // if every thing fine then return access level
                            $access_level = $row['access_level'];
                            echo '$access_level'.$access_level;
                            switch($access_level)
                            {
                                case '1':
                                    
                                $_SESSION['admin_id'] = $login_id;

                                header("Location:../Admin_Panel/Admin_Home.php");
                                break;
                                case '3':
                              
                                //setting login_id in session
                                $_SESSION['login_id'] = $login_id;
                                //redirecting to home page
                                header("Location:../View_Reports/View_Reports.php");
                                break;

                            }
                        }
                    } 
                    else 
                    {
                 
                        // if entered password is not correct
                       //calling function to  update invalid  login attemps count after entering wrong password
                        $query = "update user set invalid_count = invalid_count+1 where login_id = '$login_id'";
                        $resultq = mysqli_query($link, $query);
                       $access_count = $validate->getInvalidCount($login_id);
                       //if access_count == 3 then disable account status
                       if ($access_count >= 3) 
                        {                          
                                
                            $sql = "update user set account_status='disable' where login_id='$login_id' ";
                            $result = mysqli_query($link, $sql);
                            if ($result) {
                            ?><center> <span class="message"><?php echo "Your account is disable"; ?></span></center>
                            <?php
                            } else {
                             echo mysqli_error($link);
                            }
                        }
                        else
                        {
                            echo "<center><font color='red'>Invalid Login_id and Password Combination</font></center>";
                        }
                    }
                } 
                else
               {
                    // if account is disable
                    ?><center> <span class="message"><?php echo "Your account is disable"; ?></span></center>
                    <?php
                }
                //closing databse connection
                mysqli_close($link);
                
            } 
            else 
            {
                //if some validation error is there
                echo "<center><font color='red'>";
                echo  $validate->errormsgLogin;
                echo  $validate->errormsgpassword;
                echo '</font></center>';
                unset($validate);
            }
        }else {
            //if radio button is selected 
            $email = $_POST['email'];
            $login_id = $_POST['login_id'];
            // validating entered laogin id email id
            $validate->resetPassword($email, $login_id);
            unset($validate);
        }
}

}


?>
