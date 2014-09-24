<?php
/**
 * @package  admin_panel.                                       *
 * @version of this file is Create_User_2.                       *   
 * @category View  all registered users                          *    
 * This is default frame display on home page                    *
 * Include DBConnect class for Database connection               *
 * This code gives all registered users for all courses available.*
 * */
?>
<html>
    <body>
        <table border="1">
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
            include '../Validate.php';
            $validate = new Validate();
            //secure session starting
            $validate->sec_start_session();
            $login_check = array();
            $login_check = $validate->getAccessLevel();
//checking whether user is logged in or not
            if ($login_check['login_check'] == 0) {

                header("Location:../Login/Main_Login.php");
            } else {
                // checking for session veriable set or not
                error_reporting(E_ERROR | E_PARSE);

                // Creating Object of validate class
                $dbconnect = new DBConnect();
                // creating database connetcion by calling function of validate class

                $link = $dbconnect->connect_DataBase();
                $query = "Select * from user where access_level = 3"; //fetching data from database
                $result = mysqli_query($link, $query);

                // show  selected row of record in table format
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td>
                        <td><?php echo $row[4]; ?></td>
                        <td><?php echo $row[5]; ?></td>
                        <td><?php echo $row[6]; ?></td>
                        <td><?php echo $row[7]; ?></td>
                        <td><?php echo $row[8]; ?></td>
                        <td><?php echo $row[9]; ?></td>

                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <h3><font color='red'>User want to register to Kotech software</font></h3>

        <table border="1">
            <tr>
                <th>Login ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Id </th>
                <th>Contact no.</th>
                <th>Address</th>
            </tr>
            <?php
            $sql1 = "select * from temp_members_db";
            $result1 = mysqli_query($link, $sql1);
            while ($row = mysqli_fetch_array($result1)) {
                ?>
                <tr>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                    <td><?php echo $row[7]; ?></td>                                      
                </tr>
                <?php
            }
            ?>
            <tr></tr>
        </table>
    </body>
</html>
<?php
// closing database connection
mysqli_close($link);
// Destroying obejct of validate class
unset($dbconnect);
?>