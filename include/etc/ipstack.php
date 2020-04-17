<?php

/*********************************
 * ipstack.inc
 * @author megan
 *********************************
*/
function ipstack()
{
    //-----------------------------------------------
    // REST API call to ipstack.com using
    // access key and users IP address
    // $userInfo has resulting object
    //-----------------------------------------------
    $restUrl   ="http://api.ipstack.com/";
    $accessKey ="8ea7d0e7cbd5c95cdb983b6df5f00664";
    $userIp    = getRemoteAddr();
    $userInfo  = json_decode(file_get_contents($restUrl."/".$userIp."?access_key=".$accessKey ), TRUE);    

    setUserSession('LOC_IP_ADDRESS',$userInfo['ip']);
    setUserSession('LOC_STATE'     ,$userInfo['region_name']);
    setUserSession('LOC_STATE_CODE',$userInfo['region_code']);
    setUserSession('LOC_CITY'      ,$userInfo['city']);
    setUserSession('LOC_ZIP'       ,$userInfo['zip']);
    setUserSession('LOC_COUNTRY'   ,$userInfo['country_name']);
    setUserSession('LOC_LONGITUDE' ,$userInfo['longitude']);
    setUserSession('LOC_LATITUDE'  ,$userInfo['latitude']);
}    
?>
