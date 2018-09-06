<?php

/**************************************
 * session related functions such as: 
 *
 * - make sure there's a session
 * - CAPTCHA check/set status
 * - redirect
 *
 * @author  mgill
 **************************************
*/			

/*
 * starts a session if not started
 *
 * @param  null
 * @return null
 * 
*/			
function siteSession()
{
    if(!isset($_SESSION['SITESESSION']))
    {
        session_start();
	    $_SESSION['SITESESSION'] ="OK";
    }
}

/*
 * return $_REQUEST[] parameter 
 *
 * @param  string -- paramener
 * @return string -- parameter value or ""
 * 
*/			
function getRequest($param)
{
    if(isset($_REQUEST[$param]))
	    return($_REQUEST[$param]);
    else
        return("");
}

/*
 * redirect page
 *
 * @param  string $url destination URL
 * @return null
 * 
*/			
function redirect($url)
{
    header('Location: '.$url);
}

/*
 * returns CAPTCHA status
 *
 * @param  null
 * @return bool 
 * 
*/			
function isCaptchaOK()
{
    if(isset($_SESSION['CAPTCHA_OK']))
    {
        return(true);
    }
    else
    {
        return(false);
    }
}

/*
 * set CAPTCHA OK
 *
 * @param  null
 * @return null
 * 
*/			
function setCaptchaOK()
{
    $_SESSION['CAPTCHA_OK'] = "YES";
}


/*
 * Is ADMIN_LOGIN_OK set
 *
 * @param  null
 * @return bool
 * 
*/			
function isAdminLoginOK()
{
    if(isset($_SESSION['ADMIN_LOGIN_OK']))
    {
        return(true);
    }
    else
    {
        return(false);
    }
}

/*
 * set ADMIN_LOGIN_OK
 *
 * @param  null
 * @return null
 * 
*/			
function setAdminLoginOK()
{
    $_SESSION['ADMIN_LOGIN_OK'] = "YES";
}

/*
 * UNset ADMIN_LOGIN_OK
 *
 * @param  null
 * @return null
 * 
*/			
function unSetAdminLoginOK()
{
    unset($_SESSION['ADMIN_LOGIN_OK']);
}

/*
 * Set a user session parameter
 *
 * @param  string $p session param
 * @param  string $v param value
 * @return null
 * 
*/			
function setUserSession($p, $v)
{
    $_SESSION[$p] = $v;
}

/*
 * Get a user session parameter
 *
 * @param  string $p session param
 * @return string session parameter
 * 
*/			
function getUserSession($p)
{
    return($_SESSION[$p]);
}

/*
 * returns user permission
 *
 * @param  string $p user permission
 * @return bool
 * 
*/			
function hasPermission($p)
{
    if(isset($_SESSION[$p]))
    {
        return(true);
    }
    else
    {
        return(false);
    }
}

/*
 * Set a user permission
 *
 * @param  string $p user permission
 * @return null
 * 
*/			
function setPermission($p)
{
    $_SESSION[$p] = "YES";
}


?>
