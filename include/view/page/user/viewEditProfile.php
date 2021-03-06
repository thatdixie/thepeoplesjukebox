<?php
/*
 ***********************************************
 * viewEditProfile is the user profile edit view
 *
 * @author Megan
 * @version 181114
 ***********************************************
 */

function viewEditProfile($profile)
{
    $jukeboxId = $profile[0]->userId;
    $userId    = getUserSession("userId");
    $username  = getUserSession("userName");
    $passcode  = getUserSession("userPasscode");
    if($profile[0]->userIsJukebox == "YES")
    {
        $yescheck="checked";
        $nocheck="";
    }
    else
    {
        $yescheck="";
        $nocheck="checked";
    }
    pageTitle("Edit Profile");
    head();
    nav();            
?>
  <section id="about">
    <div class="container">
    <br><br>
      <div class="row">
      <form method="post" action="/user/index.php" enctype="multipart/form-data">
        <div class="col-md-3 col-md-offset-1">
          <!-- <label>Photo:</label> -->
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 256px; height: 256px;">
            <?php echo "<img src=\"/user/photoviewer.php?userId=".$jukeboxId."\">"; ?>
            </div>
            <div>
              <span class="btn btn-default btn-file">
                <span class="fileinput-new">Select image to change</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="file">
              </span>
              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <h3>
          <table>
            <tr>
              <td><b>Username:</b></td>
              <td style="color: black">
              <?php echo $profile[0]->userName;  ?>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><b>First Name:</b></td>
              <td>
              <input type="text" name="first" value="<?php echo $profile[0]->userFirstName;  ?>" >
              </td>
            </tr>
            <tr>
              <td><b>Last Name:</b></td>
              <td>
                <input type="text" name="last" value="<?php echo $profile[0]->userLastName;  ?>" >
              </td>
            </tr>
            <tr>
              <td><b>Nickname:</b></td>
              <td>
                <input type="text" name="nickname" value="<?php echo $profile[0]->userNickName; ?>" >
              </td>
            </tr>
            <tr>
              <td><hr></td>
              <td><hr></td>
            </tr>  
            <tr>
              <td><b>Be a Jukebox:</b></td>
              <td>
              &nbsp;
              <label class="radio-inline"><input type="radio" name="jukebox" value="NO"  <?php echo $nocheck;  ?> >NO</label>
              <label class="radio-inline"><input type="radio" name="jukebox" value="YES" <?php echo $yescheck; ?> >YES</label>
              </td>
            </tr>
            <tr>
              <td><b>Likes:</b></td>
              <td>
                <input type="text" name="likes" value="<?php echo $profile[0]->userLikes; ?>" >
              </td>
            </tr>
            <tr>
              <td><b>Where:</b></td>
              <td>
                <input type="text" name="where" value="<?php echo $profile[0]->userWorkplace; ?>" >
              </td>
            </tr>
            <tr>
              <td><b>When:</b></td>
              <td>
                <input type="text" name="when" value="<?php echo $profile[0]->userWorkHours; ?>" >
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>
                &nbsp;
                <input type="hidden" name="func" value="update_profile">
                <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Update Profile</button>              
              </td>
            </tr>
          </table>
          </h3>  
        </div>
      </form>
      </div> <!-- end row -->
      <hr>
    </div> <!-- end container -->
  </section>
<?php

    foot();
}

?>



