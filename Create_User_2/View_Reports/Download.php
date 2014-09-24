<?php

/**
 * @package  View_Reports.                                          *
 * @version of this file is Create_User_2.                          *
 * @category download report page                                   *
 * This code belong to download all registered cnadidate for course *
 * This report is in .csv format                                    *                  
 * This code include DBConnect class for database connection        *
 */
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

// verifying session variable


error_reporting(E_ERROR | E_PARSE);

// Including DBConnect class



//  Creating oject of class DBConnect to call function

$dbconnect = new DBConnect();

//calling function for creating database connection

$link = $dbconnect->connect_DataBase();

//output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
$newline = "\r\n";

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Name', 'EmailAddress', 'Contact_no', 'Course', 'Location'));
$rows = mysqli_query($link, 'select name ,email_id,contact_no,course,location,company from register');

// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($rows)) {  //fetching row from database
    fwrite($output, $newline);       // moving pointer to new line
    fputcsv($output, $row);   // putting data in file
}
//closing mysql connection
mysqli_close($link);
// closing file pointer

fclose($fp);





// destorying object of validate class

unset($dbconnect);
?>