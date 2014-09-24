<?php
/**
 * @package  userManagement.                                              *
 * @version  Create_User_2.                                               *
 * @category manages users related operations                             * 
 * This is code for searching perticular user in database and update      *
 * or delete his/her information .This codeshow seleted user information  * 
 * with button to perform operation on that user information.              *       
 * 
*/
?>
<html>
    <head>
    <style>
            .message { color: red; }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color:   red;
                opacity:  1;
            }
            .b1{font-weight:bold;}
        </style>
    </head>

    <body>
        <?php
      include '../Validate.php';
    $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
   unset($validate);
        //checking wheather user is logged in or not
        if ($_SESSION['admin_id'] == "") {
            header("Location:../Login/Main_Login.php");
        }
        
// getting user_id from textbox
        $name = $_GET['name'];
        if (empty($name)) {
            echo "<font color='red'>Please! Enter Login Id to be search</font>";
        } else {
            //creating object of DBConnect class
            $dbconnect = new DBConnect();
            //creating databse connection
            $link = $dbconnect->connect_DataBase();
            //firing query to reterive whole information of selected user
            $query = "select * from user where login_id='$name' LIMIT 1"; //fetching data from database
            $sql = mysqli_query($link, $query);
            // show  selected row of record in table
            $count = mysqli_num_rows($sql);
            if ($count >= 1) {
                //display data in table format
                ?>  

                <table border="1" id="mytab">
                    <tr>
                        <th>Login ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Id </th>
                        <th>Contact no.</th>
                        <th>Address</th>
                        <th>Account_status</th>
                        <th>Access_Level</th>
                        <th>Date</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td><input type="text" value="<?php echo $row[0]; ?>" id='user_id' name='user_id' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[1]; ?>" id='first_name' name='first_name' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[2]; ?>" id='last_name' name='last_name' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[4]; ?>" id='email_id' name='email_id' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[5]; ?>" id='phone_no' name='phone_no' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[6]; ?>" id='address' name='address' disabled="true"/></td>
                            <td id="cell"><input type="text"  value="<?php echo $row[7]; ?>" id='account_status' name='account_status' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[8]; ?>" id='access_level' name='access_level' disabled="true"/></td>
                            <td><input type="text" value="<?php echo $row[9]; ?>" id='date' name='date' disabled="true"/></td>
                        </tr>
                        <tr><td></td>

                            <td><input type="button" name="save" id="save" value="Edit" onclick="editinfo(this)" size="30" /></td>
                            <td><input type="button" name="update" id="update" value="Disable/Enable" onclick="disable(this)" size="30" /></td>
                            <td><input type="button" name="delete" id="delete" value="Delete" onclick="editinfo(this)" size="30" /></td>
                        </tr>

                        <?php
                    }
                    //closing database connection

                    mysqli_close($link);

                    // Destroying obejct of validate class

                    unset($dbconnect);
                } else {
                    echo 'Enter User id is not present in database';
                }
            }
            ?>
        </table>
    </body>
</html>