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

    pageTitle("Edit Profile");
    head();
    nav();            
?>
  <section id="about">
    <div class="container">
    <br><br>
      <div class="row">
        <div class="col-md-3 col-md-offset-1">
          <?php echo "<img src=\"/user/photoviewer.php?userId=".$jukeboxId."\">"; ?>
        </div>
        <div class="col-md-8">
          <h3>
          <table>
            <tr>
              <td><b>Edit Profile:</b></td>
              <td style="color: red">
              Profile editing is not yet complete on this aphla version. <br>If you need to change your password
              please <a href="/contact/">contact us</a>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><b>User:</b></td>
              <td>
                <?php echo $profile[0]->userNickName." (".$profile[0]->userFirstName." ".$profile[0]->userLastName.")";  ?>
              </td>
            </tr>
            <tr>
              <td><b>Jukebox?:</b></td><td><?php echo $profile[0]->userIsJukebox; ?></td>
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
          </table>
          </h3>  
        </div>
      </div> <!-- end row -->
      <hr>
    </div> <!-- end container -->
  </section>
<?php

    foot();
}

?>



