<?php
/**
 * @package  View_Reports.                                          *
 * @version of this file is Create_User_2.                          *
 * @category View  Registered candidate for QTP-Advance_framework   *
 * This code belongs to generation of reprots for QTP_adv           *
 * Include DBconnect class for Database connection                  *
 * This code gives details information about registered candidates  *
 * for courses QTP_Advance                                          *
 */
/*
 * This code belongs to generation of reprots for QTP_adv
 * Include Validate class for Database connection
 */
?>
<html>
    <body>
        <table border="1">
            <tr>
                <th>Name OF Student</th>
                <th>Email ID</th>
                <th>Contact Info</th>
                <th>Course </th>
                <th>Location</th>
            </tr>
            <?php
            //including validate class
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
            //checking for session variable is set or not


            if ($_SESSION['login_id'] == "") {
                header("Location:../Login/Main_Login.php");
            }
            error_reporting(E_ERROR | E_PARSE);

            //Creating oject of class DBConnect to call function

            $dbconnect = new DBConnect();
            //Function calling through object to create database connection 

            $link = $dbconnect->connect_DataBase();
            $query = "Select * from register where course='QTP-Advanced'";
            $sql = mysqli_query($link, $query);

            //show  selected row of record in table format

            while ($row = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td><?php echo $row[0]; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>
                </tr>
                <?php
            }
            //closing datbase connection

            mysqli_close();
            // Destorying created object

            unset($dbconnect);
            ?>
        </table>
    </body>
</html>