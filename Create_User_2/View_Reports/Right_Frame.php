<?php
/**
 * @package  View_Reports.                                       *
 * @version of this file is Create_User_2.                       *   
 * @category View  all registered candidate                      *    
 * This is default frame display on home page                    *
 * This code belongs to generation of reprots for QTP_frameworks *
 * Include DBConnect class for Database connection               *
 * This code gives all registered candidates for all courses available.*
 **/

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
           
             // checking for session veriable set or not
          
            if ($_SESSION['login_id'] == "") {
                header("Location:../Login/Main_Login.php");
            } else {
                error_reporting(E_ERROR | E_PARSE);
             
               
                 // Creating Object of validate class
                
                $dbconnect = new DBConnect();
               
                 // creating database connetcion by calling function of validate class
                
                $link = $dbconnect->connect_DataBase();
                $query = "Select * from register"; //fetching data from database
                $sql = mysqli_query($link, $query);

                
                 // show  selected row of record in table format
                 
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
                
                // closing database connection
                 
                mysqli_close($link);
              
                 // Destroying obejct of validate class
                 
                unset($dbconnect);
            }
            ?>
        </table>
    </body>
</html>