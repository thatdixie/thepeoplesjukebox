<?php
/**********************************************
 * Script to process Jukebox Catalog for TPJ
 * called via exec() with $argv[1] => jukeboxId 
 * and $argv[2] =>  web DOCUMENT_ROOT
 *
 * Process:
 * --------
 * 1) load JSON metadata regarding new media
 * 2) check against catalog to make sure file 
 *    is not already inserted
 * 3) insert new media records
 * 4) set uploadStatus = 'COMPLETE'
 *
 * @author  dixie
 **********************************************
*/

//--------------------------
// This better be jukeboxId
// and docroot...
//--------------------------
$userId = $argv[1];
$docroot= $argv[2];
require_once $docroot."/include/model/UserUploadModel.php";
require_once $docroot."/include/model/UserMediaModel.php";
require_once $docroot."/include/etc/sql.php";

if($userId)
{
    //---------------------------------------
    // get entire user catalog and create a
    // hash of file names to check for dups
    //---------------------------------------
    $db      = new UserMediaModel();
    $medias  = $db->findAllByUserId($userId);
    foreach($medias as $media)
        $mediaFile[$media->mediaFile] = $media->mediaFile;

    //-----------------------------------------
    // get metadata for new uploads
    //-----------------------------------------
    $db2         = new UserUploadModel();
    $upload      = $db2->findByUserId($userId);   
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
        $db->insertArray($newMedia);
    $upload[0]->uploadStatus  = 'COMPLETE';
    $db2->update($upload[0]);
}
?>
