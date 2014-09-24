<?php
/**
 * @package  View_Reports.                                                *
 * @version of this file is Create_User_2.                                *
 * @category View  Registered candidate for  STA-Python-frameworks.       *
 * This code belongs to generation of reprots for  STA-Python-frameworks. *
 * Include DBConnect class for Database connection.                       *
 * This code gives details information about condidates registered  for   *
 * course STA_Python_Frameworks.
 * */
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
            //Checking for sesion veriablr set or not

            if ($_SESSION['login_id'] == "") {
                header("Location:../Login/Main_Login.php");
            }

            error_reporting(E_ERROR | E_PARSE);

            //Creating oject of class DBConnect to call function

            $dbconnect = new DBConnect();

            // calling function of validate class to create database connection

            $link = $dbconnect->connect_DataBase();
            $query = "Select * from register where course='STA-Python-Framework'";
            $sql = mysqli_query($link, $query);

            //  showing selected data in tabel format


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

            //Closing database connection

            mysqli_close($link);

            // destorying object of validate class

            unset($dbconnect);
            ?>
        </table>
    </body>
</html>