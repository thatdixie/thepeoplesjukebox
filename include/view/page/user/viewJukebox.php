<?php
/*
 ***********************************************
 * viewJukebox is the Jukebox profile view
 *
 * @author Megan
 * @version 181114
 ***********************************************
 */

function viewJukebox($profile, $media, $id)
{
    $jukeboxId = $id;
    $userId    = getUserSession("userId");
    $username  = getUserSession("userName");
    $passcode  = getUserSession("userPasscode");
    if($userId == $jukeboxId)
        $select="yes";
    else
        $select="no";
    
    head();
    nav();
            
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
        <?php echo "<a href=\"javascript:onclick=playNextSong(this,'".$username."','".$passcode."',".$jukeboxId.");\">" ?>
        <img style="cursor: pointer;" src="/user/photoviewer.php?userId=<?php echo $jukeboxId ?>" border="0" id="jukebox"/></a><br>
        <?php echo "<a href=\"javascript:onclick=playNextSong(this,'".$username."','".$passcode."',".$jukeboxId.");\">" ?>
<?php if($media[0]->mediaSource=='UPLOAD'){ ?>
<button id="but" type="submit" class="btn btn-primary btn-lg" style="cursor:pointer" ><?php if($select=="yes") echo  "Stop/Play Next"; else echo  "Stop/Play"; ?> </button>
<?php } ?>          
        </a>
        </p>
      </div>
    </div>
  </section>

<?php

    foot();
}

?>



