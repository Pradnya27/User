<?php
/**
 * @package  CreateUser.                                            *
 * @version of this file is Create_User_2.                          *
 * @category CreateUser                                             *
 * This code belongs to CreateUser package                          *
 * This code belongs to creation of users.                          *
 * In this file Validate class is included for validation purpose.  *
 * This code conatin form for creating user with login_id(unique),  *
 * first name,last name,emailid(unique),phone number,address of     *
 * the user. All this fields are validated in validateCreateUser()  *
 * of Validate class.On successful creation of user it will send a  *
 * account activation link to entered email id of user else it will *
 * notify user with error occured.                                  *
 */
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
         * If no error in validation of fields  call linkgenerationforcreateuser()
         *  function from  GenerateLink class. Send a activation link to entered 
         * mail id. 
         * If validation fields have some error then user will be notify with that
         * before processing
         */
        // calling validate.php file 
        include '../Validate.php';
        include '../GenerateLink.php';

        //Calling Validate class 
         $validate = new Validate();
            //secure session starting
            $validate->sec_start_session();
            $value = array();
            $value = $validate->getAccessLevel();
        if ($value['login_check'] == 1) {
            if ($value['access_level'] == 1) {
                header("Location:../admin_Panel/admin_home.php");
            } else {
                header("Location:../View_Reports/View_Reports.php");
            }
        }
else{
        // checking wheather form is posted or not 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
            //receiving parameter value entered by user 
            $login_id = $_POST['login_id'];
            $first_name = $_POST['user_name'];
            $last_Name = $_POST['user_last'];
            $password = $_POST['password'];
            $confirm_Password = $_POST['con_pass'];
            $email_Id = $_POST['email_id'];
            $phone = $_POST['user_phone'];
            $address = $_POST['user_address'];
            //$validate is object of class Validate
            $validate = new Validate();
            $fields = array();
            //calling function of Validate class to validate fields of  Create user form 
            $fields = $validate->validateCreateUser($login_id, $first_name, $last_Name, $email_Id, $password, $confirm_Password, $phone, $address);
            // destorying $validate object 
            if (count($fields) != 0) {
                $generatelink = new GenerateLink();
                $generatelink->LinkGenerationforCreateUser($fields['login_id'], $fields['fname'], $fields['lname'], $fields['email'], $fields['password'], $fields['phone'], $fields['address']);
                unset($generatelink);
            }
            unset($validate);
        }
        ?>
        <form name="createUser" method="POST"  action="">
            * field are required
            <table>
                <tr>
                    <td>Enter Login ID</td>
                    <td><input type="text" name="login_id"placeholder="Enter Login ID*" size="50" value ="<?php
        if (isset($_POST['login_id'])) {
            echo $_POST['login_id'];
        }
        ?>"/></td>

                </tr>

                <tr>
                    <td>Enter User Name</td>
                    <td><input type="text" name="user_name"placeholder="Enter first name*" size="50" value="<?php
        if (isset($_POST['user_name'])) {
            echo $_POST['user_name'];
        }
        ?>"/></td>

                </tr>
                <tr>
                    <td>Enter Last Name</td>
                    <td><input type="text" name="user_last" placeholder="Enter last name*" size="50" value="<?php
        if (isset($_POST['user_last'])) {
            echo $_POST['user_last'];
        }
        ?>"/></td>

                </tr>
                <tr>
                    <td>Enter  Email ID</td>
                    <td><input type="text" name="email_id" placeholder="Enter email address*" size="50" value="<?php
        if (isset($_POST['email_id'])) {
            echo $_POST['email_id'];
        }
        ?>" /></td>

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
                    <td><input type="text" name="user_phone" placeholder="Enter Phone number" size="50" value="<?php
        if (isset($_POST['user_phone'])) {
            echo $_POST['user_phone'];
        }
        ?>"/></td>

                </tr>
                <tr>
                    <td>Enter Address</td>
                    <td><input type="textfield" name="user_address"placeholder="Enter address" size="50" value="<?php
        if (isset($_POST['user_address'])) {
            echo $_POST['user_address'];
        }
        ?>"/></td>

                </tr>

                <tr>
                    <td></td>
                    <td><input type="submit" value="Create User"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>
<?php }?>