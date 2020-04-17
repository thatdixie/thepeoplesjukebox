<?php
/**************************************
 * environment related functions: 
 *
 *
 * @author  megan
 **************************************
*/
/*
 * get functions for environment
 *
*/
function getServerSoftware()
{
    return(safeGetenv('SERVER_SOFTWARE'));    
}

function getServerName()
{
    return(safeGetenv('SERVER_NAME'));    
}

function getGatewayInterface()
{
    return(safeGetenv('GATEWAY_INTERFACE'));    
}

function getServerProtocol()
{
    return(safeGetenv('SERVER_PROTOCOL'));    
}

function getServerPort()
{
    return(safeGetenv('SERVER_PORT'));
}

function getRequestMethod()
{
    return(safeGetenv('REQUEST_METHOD'));    
}

function getDocumentRoot()
{
    return(safeGetenv('DOCUMENT_ROOT'));    
}

function getPathInfo()
{
    return(safeGetenv('PATH_INFO'));  
}

function getPathTranslated()
{
    return(safeGetenv('PATH_TRANSLATED'));
}

function getScriptName()
{
    return(safeGetenv('SCRIPT_NAME'));
}

function getQueryString()
{
    return(safeGetenv('QUERY_STRING'));
}

function getRemoteHost()
{
    return(safeGetenv('REMOTE_HOST'));
}

function getRemoteAddr()
{
    return(safeGetenv('REMOTE_ADDR'));    
}

function getAuthType()
{
    return(safeGetenv('AUTH_TYPE'));    
}

function getRemoteUser()
{
    return(safeGetenv('REMOTE_USER'));    
}

function getRemoteIdent()
{
    return(safeGetenv('REMOTE_IDENT'));    
}

function getContentType()
{
    return(safeGetenv('CONTENT_TYPE'));    
}

function getContentLength()
{
    return(safeGetenv('CONTENT_LENGTH'));    
}

function getAccept()
{
    return(safeGetenv('HTTP_ACCEPT'));    
}

function getUserAgent()
{
    return(safeGetenv('HTTP_USER_AGENT'));    
}

function getRedirectRequest()
{
    return(safeGetenv('REDIRECT_REQUEST'));    
}

function getRedirectURL()
{
    return(safeGetenv('REDIRECT_URL'));    
}

function getRedirectStatus()
{
    return(safeGetenv('REDIRECT_STATUS'));    
}

function getReferrer()
{
    return(safeGetenv('HTTP_REFERER'));    
}

function getCookie()
{
    return(safeGetenv('COOKIE'));    
}

function getUsingHTTPS()
{
    return(safeGetenv('HTTP_COOKIE'));
}

/*
 * safeGetenv()
 * 
 * - using getenv() to safely return variables 
 *   whether set by putenv() or SAPI
 *
 * @param  string $varName
 * @return string $var
 */
function safeGetenv($varName)
{
    $var = getenv($varName, true) ?: getenv($varName);
    return($var);
}
?>