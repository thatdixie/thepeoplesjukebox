<?php 

/*************************************************
 * interface defines common constants
 *
 * @author  megan
 * @version 180927
 *************************************************
 */
interface DBConstants 
{
    //---------------------------------------------
    // jukeboxDB parameters for PDO
    //---------------------------------------------
    const DBNAME    = "jukeboxDB";
    const DBSERVER  = "127.0.0.1";
    const DBPORT    = "3316";
    const DBUSER    = "www";
    const DBPASSWORD= "www123";
    const DBDRIVER  = "mysql";
    const DBCHARSET = "utf8";

    //---------------------------------------------
    // JSON Response Codes
    //---------------------------------------------
    const RESPONSE_OK             = 200;
    const RESPONSE_UNAUTHORIZED   = 401;
    const RESPONSE_NOTFOUND       = 404;
    const RESPONSE_NOACCESS       = 422;
    const RESPONSE_SERVER_ERROR   = 500;
}

?>
