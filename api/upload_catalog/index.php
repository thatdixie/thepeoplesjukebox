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
        //$root   = realpath($_SERVER["DOCUMENT_ROOT"]);
        //$script = $root."/scripts/processUpload.php";
        //error_log("php ".$script."  ".$user[0]->userId." ".$root." > /opt/data/jukebox/upload.log",0);
        //exec("php ".$script."  ".$user[0]->userId." ".$root." > /opt/data/jukebox/upload.log");

        //---------------------------------------
        // get entire user catalog and create a
        // hash of file names to check for dups
        //---------------------------------------
        $dbx     = new UserMediaModel();
        $medias  = $dbx->findAllByUserId($user[0]->userId);
        foreach($medias as $media)
            $mediaFile[$media->mediaFile] = $media->mediaFile;

        //-----------------------------------------
        // get metadata for new uploads
        //-----------------------------------------
        $db2         = new UserUploadModel();
        $upload      = $db2->findByUserId($user[0]->userId);   
        $uploadMedia = json_decode($upload[0]->uploadMetaData, true);

        //--------------------------------------------
        // check each against hash for matching
        // filenames -- we don't want to insert files
        // that already exist.
        //--------------------------------------------
        $l = count($uploadMedia);
        for($i =0, $j=0; $i < $l; $i++)
        {
            $filename =$uploadMedia[$i]['mediaFile']; 
            if($filename != $mediaFile[$filename])
            {
                $newMedia[$j] = new Media();
                $newMedia[$j]->mediaId       = $uploadMedia[$i]['mediaId'];
                $newMedia[$j]->userId        = $uploadMedia[$i]['userId'];
                $newMedia[$j]->mediaFile     = $uploadMedia[$i]['mediaFile'];
                $newMedia[$j]->mediaSource   = $uploadMedia[$i]['mediaSource'];
                $newMedia[$j]->mediaArtist   = $uploadMedia[$i]['mediaArtist'];
                $newMedia[$j]->mediaTitle    = $uploadMedia[$i]['mediaTitle'];
                $newMedia[$j]->mediaYear     = $uploadMedia[$i]['mediaYear'];
                $newMedia[$j]->mediaDuration = $uploadMedia[$i]['mediaDuration'];
                $newMedia[$j]->mediaCreated  = sqlNow();
                $newMedia[$j]->mediaModified = sqlNow();
                $newMedia[$j]->mediaStatus   = 'ACTIVE';
                $j++;
            }
        }
        if(count($newMedia))
            $dbx->insertArray($newMedia);
        $upload[0]->uploadStatus  = 'COMPLETE';
        $db2->update($upload[0]);

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
