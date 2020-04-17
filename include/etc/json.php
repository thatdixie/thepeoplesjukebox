<?php

/***********************************
 * JSON functions 
 *
 * @author  dixie
 ***********************************
*/			


/*************************************
 * jsonResponse()
 *
 * send JSON respose to a REST client 
 *
 * @param  string 
 * @return N/A  
 *************************************
*/			
function jsonResponse($s)
{
    $size = strlen($s);
    header("Content-Type: application/json");
    header("Content-Length: ".$size+1);
    echo $s;
}

/*************************************
 * jsonErrorResponse()
 *
 * send JSON ERROR respose to 
 * a REST client 
 *
 * @param  string 
 * @param  string
 * @return N/A  
 *************************************
*/			
function jsonErrorResponse($code, $s)
{
    $r = "{\"errorCode\":\"".$code."\", \"errorMessage\":\"".$s."\"}";
    $size = strlen($r);
    
    header("Content-Type: application/json");
    header("Content-Length: ".$size+1);
    echo $r;
}


?>
