<?php
/**
 * Search for a jukebox profile
 *
 * POST to:
 * http://ThePeoplesJukebox/api/search_profile/
 *
 * REST PARAMS:
 *   username
 *   passcode
 *   searchKey
 *
 * @author  dixie
 **
*/
require_once "../login/UserSession.php";

$u     = new UserSession();

if(($user = $u->getUserSession(getRequest('username'), getRequest('passcode'))))
{
    $searchKey = getRequest('searchKey');
    $db        = new UserProfileModel();
    $users     = $db->findJukeboxBySearch($searchKey);

    if($users)
    {
        $profiles = array();
        $c        = count($users);
        
        for($i=0; $i<$c; $i++)
        {
            $profiles[$i] = new Profile();
            $profiles[$i]->userId    = $users[$i]->userId;
            $profiles[$i]->firstName = $users[$i]->userFirstName;
            $profiles[$i]->lastName  = $users[$i]->userLastName;
            $profiles[$i]->nickName  = $users[$i]->userNickName;
            $profiles[$i]->likes     = $users[$i]->userLikes;
            $profiles[$i]->workplace = $users[$i]->userWorkplace;
            $profiles[$i]->workhours = $users[$i]->userWorkHours;
            $profiles[$i]->longitude = $users[$i]->userLongitude;
            $profiles[$i]->latitude  = $users[$i]->userLatitude;
        }
        
        jsonResponse(json_encode($profiles));
    }
    else
    {
        jsonErrorResponse("200", "No Profiles Found");
    }
}
else
{
    jsonErrorResponse("404", "User Not Found");
}

class Profile
{
    public $userId    =0;
    public $firstName ="";
    public $lastName  ="";
    public $nickName  ="";
    public $likes     ="";
    public $workplace ="";
    public $workhours ="";
    public $longitude ="";
    public $latitude  ="";
}

?>
