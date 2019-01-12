<?php
/**************************************
 * upload functions: 
 *
 * - saveUploadedPhoto()
 * - saveUploadedMedia()
 * - saveUploaded()
 * - isFileUploaded()
 *
 * @author  mgill
 **************************************
 */			

/*
 * isFileUploaded() -- returns true if uploaded 
 *                     file is ready to be saved.
 * @return boolean  
 * 
 */			
function isFileUploaded()
{
    if(isset($_FILES['file']))
    {
        if($_FILES['file']['name'])
            return(true);
        else
            return(false);
    }
    else
    {
        return(false);
    }
}

/*
 * saveUploadedPhoto() 
 *
 * Saves uploaded file to server and returns filename
 * 
 * @param  $path -- string
 * @return filename of file 
 * 
 */			
function saveUploadedPhoto($path)
{
    return(saveUploaded($path, configValidPhotoExtensions()));
}

/*
 * saveUploadedMedia() 
 *
 * Saves uploaded file to server and returns filename
 * 
 * @param  $path -- string
 * @return filename of file 
 * 
 */			
function saveUploadedMedia($path)
{
    return(saveUploaded($path, configValidMediaExtensions()));
}

/*
 * saveUploaded() 
 *
 * Saves uploaded file to server and returns filename
 * 
 * @param  $path    -- string
 * @param  $allowed -- array of valid extensions 
 * @return filename of file 
 * 
 */			
function saveUploaded($path, $allowed)
{
    if (isset($_FILES['file']))
    {
        $errors = [];
	    $extensions = $allowed;

        //---------------------------------------------
        // first get all the upload information
        // the webserver left for us...
        //---------------------------------------------
		$file_name = $_FILES['file']['name'];
		$file_tmp  = $_FILES['file']['tmp_name'];
		$file_type = $_FILES['file']['type'];
		$file_size = $_FILES['file']['size'];
		$file_ext  = strtolower(end(explode('.', $_FILES['file']['name'])));
		$file = $path . $file_name;

        if(!$file_name)
        {
            error_log("saveUploaded() called with no upload...",0);
		    $errors[] .= 'No file to save:\n';            
        }
        //------------------------------------
        // Check valid extension -- we're not
        // uploading just any old file...
        //------------------------------------
		if (!in_array($file_ext, $extensions))
		    $errors[] .= 'Extension not allowed: ' . $file_name . ' ' . $file_type;

        //---------------------------------------------------
        // Can't do files larger than this...
        //----------------------------------------------------
		if ($file_size > configMaxUploadSize()) 
		    $errors[] .= 'File size exceeds limit: ' . $file_name . ' ' . $file_type;

        //-------------------------------
        // if we're good to go then save
        // file on server...
        //-------------------------------
		if (empty($errors))
		    move_uploaded_file($file_tmp, $file);
	}
    else
        $errors = "No file was uploaded";

    //---------------------------------------------------
    // Log any errors we had, otherwise return filename
    //---------------------------------------------------
	if($errors)
    {
        error_log($errors,0);
        return("");
    }
    else
    {
        return($file_name);   
    }
}

?>
