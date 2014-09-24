<?php
/**
 * @package  View_Reports.                                        *
 * @version of this file is Create_User_2.                        *
 * @category View Left Frame                                      *
 * This code contain links depends upon course selected           *
 * Selected link is executed in right frame                       *
 * On selecting perticular course user is able to see             *
 * detail information of registered candidates for that course.   *
 * 
 **/

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
 //Checking for Session variable is set or not
 

    ?>
    <html>
        <body>
            <a href="STA-Java.php" target="right"><input type="button" name="STA-Java" value="STA-Java"/></a><br/><br/>
            <a href="STA-Python.php" target="right"><input type="button" name="STA-Python" value="STA-Python"/></a><br/><br/>
            <a href="STA-Framework.php" target="right"><input type="button" name="STA-Framework" value="STA-Framework"/></a><br/><br/>
            <a href="STA-Java-Framework.php" target="right"><input type="button" name="STA-Java-Framework" value="STA-Java-Framework"/></a><br/><br/>
            <a href="STA-Python-Framework.php" target="right"><input type="button" name="STA-Python-Framework" value="STA-Python-Framework"/>
            </a><br/><br/>
            <a href="QTP-Advanced.php" target="right"><input type="button" name="QTP-Advanced" value="QTP-Advanced"/></a><br/><br/>
            <a href="QTP-Framework.php" target="right"><input type="button" name="QTP-Framework" value="QTP-Framework"/></a><br/><br/>
            <a href="QTP-Advanced-Framework.php" target="right"><input type="button" name="QTP-Advanced-Framework" value="QTP-Advanced-Framework"/></a><br/><br/>
            <a href="Download.php" > Download  Reports</a>
        </body>
    </html>
