<?php
/*
 ***********************************************
 * viewEditProfile is the user profile edit view
 *
 * @author Dixie
 * @version 181212
 ***********************************************
 */

function viewFindJukebox($profile)
{
    $jukeboxId = $profile[0]->userId;
    $userId    = getUserSession("userId");
    $username  = getUserSession("userName");
    $passcode  = getUserSession("userPasscode");

    pageTitle("Find Jukebox");
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
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><b>Find Jukebox</b></td>
              <td>
              </td>
            </tr>
            <tr>
              <td><b>--------------------</b></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>
              <form id="searchForm" action="javascript:searchProfile();">
              <input type="hidden" id="userId"    value=<?php echo "\"$userId\"";  ?> >
              <input type="hidden" id="username"  value=<?php echo "\"$username\"";  ?> >
              <input type="hidden" id="passcode"  value=<?php echo "\"$passcode\"";  ?> >
              <input type="text"   id="formSearchKey" >
              </form>     
           </td>
              <td>
              </td>
            </tr>
            <tr>
              <td>
                <input type="button"  id="searchButton" class="btn btn-primary btn-lg" name="submit" value="Find Jukebox" onclick="searchProfile();"/>
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
          </table>
          </h3>  
        </div>
      </div> <!-- end row -->
      <hr>
      <div id="find_profile_row" class="row" style="visibility:hidden">
        <div class="col-md-11 col-md-offset-1">
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="col-md-3">Who</th>
                <th scope="col-md-3">What</th>
                <th scope="col-md-4">Where</th>
                <th scope="col-md-1"></th>
              </tr>
            </thead>
            <tbody id="jukebox_profile_list">
             <tr><td>Joey (Joe Blow)</td><td>Rock Music</td><td>Every Bar</td><td>Go to Profile</td></tr>
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



