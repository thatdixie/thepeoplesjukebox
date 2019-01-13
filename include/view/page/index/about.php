<?php

/***********************************
 * about.php 
 * @author  dixie
 ***********************************
*/			
function about($profiles)  
{
    pageTitle("The Peoples Jukebox");
?>
  <section id="about">
    <div class="container">
      <div class="col-md-10 col-md-offset-1">
        <br><h1><b>Jukebox&#39;s near you!</b></h1><br>
      </div>
<?php
    foreach($profiles as $profile)
    {
?>
      <div class="row">
        <div class="col-md-3 col-md-offset-1">
          <?php echo "<img src=\"/user/photoviewer.php?userId=".$profile->userId."\">"; ?>
        </div>
        <div class="col-md-8">
          <h3>
          <table>
            <tr>
              <td><b>Playing:</b></td><td style="color: red"><?php echo $profile->userStatus; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <tr>
              <td><b>DJ:</b></td><td><?php echo $profile->userNickName." (".$profile->userFirstName." ".$profile->userLastName.")";  ?></td>
            </tr>
            <tr>
              <td><b>Likes:</b></td><td><?php echo $profile->userLikes; ?></td>
            </tr>
            <tr>
              <td><b>Where:</b></td><td><?php echo $profile->userWorkplace; ?></td>
            </tr>
            <tr>
              <td><b>When:</b></td><td><?php echo $profile->userWorkHours; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <tr>
              <td>
                <a href="/user/index.php?func=player&jukeboxId=<?php echo $profile->userId ?>" >
                <button type="submit" name="submit" class="btn btn-primary btn-lg" >Play Jukebox</button>
                </a>
              </td>
              <td><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="submit" class="btn btn-primary btn-lg" >Get Directions</button></a></td>
            </tr>
          </table>
          </h3>
        </div>
      </div>
      <br>
<?php
    }
?>
      <br>
    </div>
  </section>
<?php
}
?>
