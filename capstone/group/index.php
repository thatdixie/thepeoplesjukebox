<?php
require_once "../include/view/page/capstone/indexIncludeFiles.php";
require_once "../include/etc/session.php";
siteSession();

if(isset($_SESSION['CAPSTONE_LOGIN_OK']))
{
    switch(getRequest("func"))
    {
        case "player": 
        playJukebox(getRequest("jukeboxId"));
        break;

        case "find_jukebox":
        findJukebox(getUserSession("userId"));
        break;
   
        case "edit_profile":
        editProfile(getUserSession("userId"));
        break;
    
        case "edit_catalog":
        editCatalog(getUserSession("userId"));
        break;

        default:
        userHome();
    }
}
else if(getRequest("func") == "login")
{
    //------------------------------------
    // we got a username and password...
    //------------------------------------
    userLogin(getRequest("username"), getRequest("password"));
}
else if(getRequest("func") == "login_ok")
{
    //------------------------------------
    // we got a valid login...
    //------------------------------------
    userHome();
}
else if(getRequest("func") == "signup")
{
    //------------------------------------
    // we need to register...
    //------------------------------------
    doSignup();
}
else
{
    //------------------------------------
    // if we're not logged in, do that...
    //------------------------------------
    doLogin();
}

/**
 * doSignup -- show Signup screen
 *
 */
function doSignup()
{
    signup();
}


/**
 * doLogin -- show Login screen
 *
 */
function doLogin()
{
    login();
}

/**
 * ussrLogin -- handle login form data and 
 *              login via capstone API
 *
 * @param $u -- username
 * @param $p -- password
 *
 */
function userLogin($u, $p)
{
    $args['email']   = $u;
    $args['password']= $p;
    
    $req        = "/v1/users/login";
    $param      = makeParameterString($args);
    $rs         = capstoneApiRequest("POST", $req, $param, "");
    $json       = json_decode(utf8_encode($rs), TRUE);
    error_log($rs, true);
    if($json['statusCode'] == 200)
    {
        $_SESSION['CAPSTONE_LOGIN_OK'] ='YES';
        $_SESSION['userId'] =88;        
        redirect("/capstone?func=login_ok");
    }
    else
    {
        unset ($_SESSION['CAPSTONE_LOGIN_OK']);
        redirect("/capstone/");
    }
}

/**
 * userHome -- show user home page after login 
 *
 */
function userHome()
{
    viewJukebox(88);    
}

/**
 * capstoneApiRequest      Simple REST API wrapper 
 *
 * @param $reqMethod       -- GET POST PUT DELETE
 * @param $requestString   -- REST request
 * @param $parameterString -- parameters
 * @param $authString      -- possiably a x-token
 *
 */
function capstoneApiRequest($reqMethod, $requestString, $parameterString, $authString)
{
    $url           ="http://huntercapstonejukebox.com";
    $response      ="";
    $requestString =$url.$requestString;

    $ch = curl_init();

    
    if($authString)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-access-token: '.$authString) );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded') );

    if(($reqMethod =="GET") || ($reqMethod =="DELETE"))
    {
        $requestString = $requestString."?version=1".$parameterString;
        error_log($requestString,0);
    }
    
    curl_setopt($ch, CURLOPT_URL, $requestString);
    error_log($requestString,0);    
    
    if(($reqMethod =="POST") || ($reqMethod =="PUT"))
    {
        $parameterString = "version=1".$parameterString;
        error_log($parameterString,0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameterString);
    }
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $reqMethod);
    $response = curl_exec($ch);
    error_log($response,0);    

    //curl_close($ch);
    return($response);    
}

function makeParameterString($args)
{
    $name    ="";
    $value   ="";
    $b       ="";

    foreach ($args as $key => $val)
    {
        $name  = $key;
        $value = $val;
        $b.="&";
        $b.=$name;
        $b.="=";
        $b.=utf8_encode($value);
    }
    return($b);
}


/**
 * playJukebox -- set up user profile for jukebox
 *
 * @param $id -- this is the jukeboxId
 */
function playJukebox($id)
{
    /*
    $db       = new UserProfileModel();
    $db2      = new UserMediaModel();
    $profile  = $db->find($id);
    $media    = $db2->findCurrentlyPlaying($id);
    
    viewJukebox($profile, $media);
    */
    
    redirect("/capstone/");
}

/*
 * editProfile -- edit user profile and allow 
 *                for changing profile photo
 *                password and becoming a jukebox
 *
 * @param $id -- this is the userId
 */
function editProfile($id)
{
/*    $db       = new UserProfileModel();
    $profile  = $db->find($id);

    viewEditProfile($profile);
*/
    redirect("/capstone/");
    
}

function findJukebox()
{
    redirect("/capstone/");
}


function editCatalog()
{
    redirect("/capstone/");    
}


?>
