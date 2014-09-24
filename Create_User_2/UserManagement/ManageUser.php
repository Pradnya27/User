<?php
/**
 * @package  userManagement.                                             *
 * @version of this file is Create_User_2.                               *
 * @category manages users related operations                            * 
 * This is code for searching perticular user in database and update     *
 * or delete his/her information .This code include a javasecript file   *       
 *  file which handle all operation on selected user by ajax             *
 */
?>
<html>
    <head>
        <style>
            .errormessages { color: red; }
             .error1 { color: red; }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color:   red;
                opacity:  1;
                
            }
        </style>
        <script type="text/javascript" src="manage.js"></script>
    </head>
    <body>
        <form name="searchform" action="" method="">
            <?php
           //including validate class
   include '../Validate.php';
    $validate = new Validate();
    //secure session starting
   $validate->sec_start_session();
   unset($validate);
            //checking for logged in user
            if ($_SESSION['admin_id'] == "") {
                header("Location:../Login/Main_Login.php");
            }?>
            <center>
                <br/>
                <br/>

                <input type="text"id="search" name="search" size="30">
                <input type="button" value="Search User" onclick="searchUser()" >
                <br/>
                <br/>
                <div id="errormessages" class='errormessages'></div>
                <div id="error1"></div>
            </center>
        </form>
    </body>
</html>