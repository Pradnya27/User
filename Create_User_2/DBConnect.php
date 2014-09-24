<?php

/**
 * @package Under project                                 *
 * @category Database connection                          *
 * @version Create_Use_2                                  *
 * This class include DBConnect class for databse access. *
 *         
 */


class DBConnect {

    /**
     * Function for creating connection to database with mysqli
     * @return connection 
     */
    function connect_DataBase() {
       
        $connect = new mysqli("localhost","root","","kotech");
        if (mysqli_connect_errno()) {
            printf("Connection failed" . mysqli_connect_errno());
            exit();
        }
        return $connect;
    }

}

?>
