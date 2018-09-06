<?php

/***********************************
 * SQL helper functions 
 *
 * @author  mgill
 ***********************************
*/			



/***********************************
 * Easy format current date-time 
 *
 * @param  n/a 
 * @return string  
 ***********************************
*/			
function sqlNow()
{
    return(date("Y-m-d H:i:s"));
}


/***********************************
 * convert SQL datetime string 
 * to more human friendly string
 *
 * @param  string $dateTime
 * @return string  
 ***********************************
*/			
function toHumanDate($dateTime)
{
    $date = date_create_from_format("Y-m-d H:i:s", $dateTime);
    return(date_format($date, "M d, Y \a\\t h:i A"));
}


/*************************************
 * blacklist chars and strings 
 * for nice usernames, passwords etc.
 *
 * @param  string 
 * @return string  
 *************************************
*/			
function blacklistSafe($s)
{
    $forbidden = array(
        "$", "%", "^", "*", "|", ",", "`", "~", "\"", "\'",
        "<", ">",
        "{", "}",
        "[", "]",
        "(", ")",
        "-", "+",
        "SELECT", "UPDATE", "DELETE", "INSERT", "DROP", "CONCAT"
    );

    foreach($forbidden as $forbid_word)
        $s = str_ireplace($forbid_word, '', $s);

    return($s);
}


?>
