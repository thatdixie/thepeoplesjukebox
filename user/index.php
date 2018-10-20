<?php
require_once "../include/view/page/user/indexIncludeFiles.php";
require_once "../include/etc/session.php";
require_once "../include/model/UserProfileModel.php";
require_once "../include/model/UserMediaModel.php";
siteSession();

if(!isAdminLoginOK())
{
    redirect("/login/");
}
$func     = getRequest("func");
if($func=="find_jukebox"
|| $func=="edit_profile"
|| $func == "edit_catalog"
|| $func=="")
    redirect("/"); // stub these for now...

viewtest2();




function viewtest2()
{
    head();
    nav();
        
    $jukeboxId= getRequest("jukeboxId");
    $userId   = getUserSession("userId");
    $username = getUserSession("userName");
    $passcode = getUserSession("userPasscode");
    $db       = new UserProfileModel();
    $db2      = new UserMediaModel();
    $profile  = $db->find($jukeboxId);
    $media    = $db2->findCurrentlyPlaying($jukeboxId);
    if($userId == $jukeboxId)
        $select ="yes";
    else
        $select ="no";
    
?>
  <section id="about">
    <div class="center">
    <br><br>
    <h2 id="currently_playing" style="color: red"><?php echo $media[0]->mediaTitle." -- ".$media[0]->mediaArtist; ?></h2>
    </div>
    <div class="container">
      <div class="center">
        <h2><?php echo $profile[0]->userNickName."'s Jukebox";?> </h2>
        <p class="lead" style="cursor: pointer;">
        <?php echo "<a href=\"javascript:onclick=platNextSong(this,'".$username."','".$passcode."',".$jukeboxId.");\">" ?>
        <img style="cursor: pointer;" src="/user/photoviewer.php?userId=<?php echo $jukeboxId ?>" border="0" id="jukebox"/></a><br>
        <?php echo "<a href=\"javascript:onclick=playNextSong(this,'".$username."','".$passcode."',".$jukeboxId.");\">" ?>
        <button id="but" type="submit" class="btn btn-primary btn-lg" style="cursor:pointer" ><?php if($select=="yes") echo  "Stop/Play Next"; else echo  "Stop/Play"; ?> </button>
        </a>
        </p>
      </div>
    </div>
  </section>

<?php

    foot();
}

function viewtest()
{
    head();
    nav();
    
    $jukeboxId= getRequest("jukeboxId");
    $userId   = getUserSession("userId");
    $db       = new UserProfileModel();
    $db2      = new UserMediaModel();
    $profile  = $db->find($jukeboxId);
    $media    = $db2->findCurrentlyPlaying($jukeboxId);
    if($userId == $jukeboxId)
        $select ="yes";
    else
        $select ="no";
    
?>
  <section id="about">
    <div class="center">
    <br><br>
    <h2 id="currently_playing"><?php echo $media[0]->mediaTitle." -- ".$media[0]->mediaArtist; ?></h2>
    </div>
    <div class="container">
      <div class="center">
        <h2><?php echo $profile[0]->userNickName."'s Jukebox";?> </h2>
        <p class="lead" style="cursor: pointer;">
        <a href="javascript:onclick=playSound(this, 'http://thepeoplesjukebox.com/mp3player/mp3player.php?jukeboxId=<?php echo $jukeboxId."&select=".$select ?>');">
        <img style="cursor: pointer;" src="/user/photoviewer.php?userId=<?php echo $jukeboxId ?>" border="0" id="jukebox"/></a><br>
        <a href="javascript:onclick=playSound(this, 'http://thepeoplesjukebox.com/mp3player/mp3player.php?jukeboxId=<?php echo $jukeboxId."&select=".$select ?>');">
          <button id="but" type="submit" class="btn btn-primary btn-lg" style="cursor:pointer" ><?php if($select=="yes") echo  "Stop/Play Next"; else echo  "Stop/Play"; ?> </button>
        </a>
        </p>
      </div>
    </div>
  </section>

<?php

    foot();
}

?>



