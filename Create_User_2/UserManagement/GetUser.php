<?php /**
 * @package  userManagement.                           *
 * @version of this file is Create_User_2.             *
 * @category Edit User info                            * 
 * This code display all information about             *
 * selected user  in text field so admin can change it *
 * */ ?>
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
        <script type="text/javascript"src="save.js"></script>
    </head>
    <body>
        <br/><br/><br/>
        <br/><br/><br/>
    <center>
        <form name="" action="" method="POST" >       

            <?php
            include '../Validate.php';
    $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
   unset($validate);

            if ($_SESSION['admin_id'] == "") {
                header("Location:../Login/Main_Login.php");
            }
            $id = $_POST['user_id'];
            $dbconnect = new DBConnect();
            $link = $dbconnect->connect_DataBase();
            $sql = "select * from user where login_id = '$id' LIMIT 1";
            $result = mysqli_query($link, $sql);

            $count = mysqli_num_rows($result);
            echo "<table>";
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td class="b1">Login_ID of User:</td>
                    <td><input type="text" name="user_id" id="uid" value="<?php echo $row['login_id'] ?>" disabled/></td>
                </tr>
                <tr>
                    <td class="b1">User first name:</td>
                    <td><input type="text" id="fname" name="fname"  /></td>
                </tr>
                <tr>
                    <td class="b1">User last name:</td>
                    <td><input type="text" id="lname" name="lname"  /> </td>
                </tr>
                <tr>
                    <td class="b1">User email id:</td>
                    <td><input type="text" id="email" name="email"  />    </td>
                </tr>
                <tr>
                    <td class="b1">User phone no: </td>
                    <td><input type="text" id="phno"name="phno" /></td>
                <tr>
                    <td class="b1">User Address</td>
                    <td><input type="text" id="city"name="city"  /></td>
                </tr>
                <tr>
                    <td class="b1"> User Account_status</td>
                    <td><input type="text" name="account_status" value="<?php echo $row['account_status'] ?>" disabled /></td>
                </tr>
                <tr>
                    <td class="b1">User access_level</td>
                    <td><input type="text" name="access_level" value="<?php echo $row['access_level'] ?>" disabled/></td>
                </tr>
                <tr>
                    <td class="b1">account Created date</td>
                    <td><input type="text" name="date" value="<?php echo $row['date'] ?>" disabled/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Save" onclick="saveuser();
                            return false" /> </td>  </tr>
                <?php
            }

            mysqli_close($link);
            ?> 
            </table>
        </form>
    </center>
</body>
</html>

