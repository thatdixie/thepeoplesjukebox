<?php
/**********************************************
 * Upload a Jukebox Catalog for TPJ
 *
 * POST to:
 * http://ThePeoplesJukebox/api/upload_catalog/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *   metadata
 *   isUpload (optional)
 *
 * @author  dixie
 **********************************************
*/
require_once "../login/UserSession.php";

$u     = new UserSession();
    
if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    if($user[0]->userIsJukebox == 'YES')
    {
        //-------------------------------------------------------
        // This will save upload metadata to upload table
        // where a seperate process will insert new media records
        // ------------------------------------------------------
        $db     = new UserUploadModel();
        $upload = $db->findByUserId($user[0]->userId);
        
        $upload[0]->uploadMetaData= getRequest('metadata');
        $upload[0]->uploadStatus  = 'UPLOAD';
        $upload[0]->uploadModified= sqlNow();
        if(getRequest('isUpload') =='YES')
            $upload[0]->uploadSource= 'UPLOAD';
        else
            $upload[0]->uploadSource= 'LOCAL';
        $db->update($upload[0]);

        //-----------------------------------------------------
        // this will execute processUpload.php in background
        // we call it with argv[1]=jukeboxId argv[2]=doc root
        // ----------------------------------------------------
        $root   = realpath($_SERVER["DOCUMENT_ROOT"]);
        $script = $root."/scripts/processUpload.php";
        exec("php ".$script."  ".$user[0]->userId." ".$root." > /dev/null &");

        //-----------------------------------
        // return positive JSON response
        //-----------------------------------
        jsonResponse($upload[0]->makeJSON());
    }
    else
    {
        jsonErrorResponse("404", "User Not a Jukebox");
    }
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

?>
