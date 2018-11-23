<?php
/*
 ***********************************************
 * viewJukebox is the Jukebox profile view
 *
 * @author Megan
 * @version 181114
 ***********************************************
 */

function viewJukebox($profile, $media)
{
    $jukeboxId = $profile[0]->userId;
    $userId    = getUserSession("userId");
    $username  = getUserSession("userName");
    $passcode  = getUserSession("userPasscode");
    if(isIphone())
        $container_id ="iphone_container";
    else
        $container_id ="not_iphone_container";
    
    head();
    nav();            
?>
  <section id="about">
    <div class="container" id=<?php echo "\"$container_id\"" ?> >
    <br><br>
    <?php 
    if(isIphone()) 
        echo "<b>(Audio Playback for iPhone is currently for demostration purposes ONLY!)</b><br><br>\n";
    ?>
      <div class="row">
        <div class="col-md-3 col-md-offset-1">
          <?php echo "<img src=\"/user/photoviewer.php?userId=".$jukeboxId."\">"; ?>
        </div>
        <div class="col-md-8">
          <h3>
          <table>
            <tr>
              <td><b>Playing:</b></td><td id="currently_playing" style="color: red">
                <?php echo $media[0]->mediaTitle." -- ".$media[0]->mediaArtist; ?>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <tr>
              <td><b>DJ:</b></td>
              <td>
                <?php echo $profile[0]->userNickName." (".$profile[0]->userFirstName." ".$profile[0]->userLastName.")";  ?>
              </td>
            </tr>
            <tr>
              <td><b>Likes:</b></td><td><?php echo $profile[0]->userLikes; ?></td>
            </tr>
            <tr>
              <td><b>Where:</b></td><td><?php echo $profile[0]->userWorkplace; ?></td>
            </tr>
            <tr>
              <td><b>When:</b></td><td><?php echo $profile[0]->userWorkHours; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <tr>
            <?php if($media[0]->mediaSource=='UPLOAD'){ echo "\n"; ?>
              <td>
                <?php echo "<a href=\"javascript:onclick=playNextSong(this,'".$username."','".$passcode."',".$jukeboxId.");\">\n" ?>
                <button type="submit" name="submit" class="btn btn-primary btn-lg" >
                <?php if($userId == $jukeboxId)
                          echo "Play Next Song";
                      else
                          echo "Play This Song";
                ?>
                </button>
                </a>
              </td>
              <td>
                <a href="#" onclick="window.location.reload(true);">
                &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="submit" class="btn btn-primary btn-lg" >Stop</button>
                </a>
              </td>
              <?php } else { echo "\n"; ?>
              <td colspan="2">
                <b>This song only plays on the jukebox device </b>
              </td>
              <?php } echo "\n"; ?>
            </tr>
          </table>
          </h3>  
        </div>
      </div> <!-- end row -->
      <hr>
      <div class="row">
        <div class="col-md-5 col-md-offset-1">
          <form id="searchForm" action="#">
          <input type="hidden" id="userId"    value=<?php echo "\"$userId\"";  ?> >
          <input type="hidden" id="username"  value=<?php echo "\"$username\"";  ?> >
          <input type="hidden" id="passcode"  value=<?php echo "\"$passcode\"";  ?> >
          <input type="hidden" id="jukeboxId" value=<?php echo "\"$jukeboxId\""; ?> >
          <input type="text"   id="formSearchKey" >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button"  id="searchButton" class="btn btn-primary btn-lg" name="submit" value="Find Song" onclick="searchCatalog();">
          </form>     
        </div> 
      </div> <!-- end row -->
      <div id="find_song_row" class="row" style="visibility:hidden">
        <div class="col-md-11 col-md-offset-1">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="col-md-5">Song Title</th>
                <th scope="col-md-4">Artist</th>
                <th scope="col-md-1">Media Source</th>
                <th scope="col-md-1"></th>
              </tr>
            </thead>
            <tbody id="jukebox_catalog_list">
            <tr><td>Back to Black</td><td>Amy Winehouse</td><td>UPLOAD</td><td>Select This Song</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div> <!-- end container -->
  </section>
<?php

    foot();
}

?>



