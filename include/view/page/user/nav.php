<?php

/***********************************
 * nav.php 
 * @author  dixie
 ***********************************
*/			
function nav()
{
?>
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: black; color: white">
      <div class="container">
        <div class="row">
          <?php if(isAdminLoginOK()) { echo "\n"; ?>
          <div class="col-md-4">
            <div class="site-logo">
              <a href="/" class="brand" style="color: white">The Peoples Jukebox</a>
            </div>
          </div>				  
          <div class="col-md-8">	 
          <?php } else { echo "\n"; ?>
         <div class="col-md-4">
            <div class="site-logo">
              <a href="/" class="brand" style="color: white">The Peoples Jukebox</a>
            </div>
          </div>		  
          <div class="col-md-8">	 
          <?php }  echo "\n"; ?>
            <div class="navbar-header" style="background-color: black; color: white">
              <button type="button" class="navbar-toggle"  data-toggle="collapse" data-target="#menu">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <div class="collapse navbar-collapse" id="menu">
              <ul class="nav navbar-nav navbar-right" style="background-color: black; color: white">
               <?php if(isAdminLoginOK()) { echo "\n"; ?>
                <!-- <li><a href="#why">What Why How?</a></li> -->
                <?php if(hasPermission('canJukeboxAdmin')) { echo "\n"; ?>
                <li><a href="/user/index.php?func=player&jukeboxId=<?php echo getUserSession("userId"); ?>" >My-Catalog</a></li>
                <?php } echo "\n"; ?>
                <li><a href="/user/index.php?func=find_jukebox">Find-a-Jukebox</a></li>
                <li><a href="/user/index.php?func=edit_profile">My-Profile</a></li>
                <li><a href="/login/index.php?func=logout">Logout</a></li>
               <?php } else { echo "\n"; ?>
                <li><a href="#why">What Why How?</a></li>
                <li><a href="/login/">Be-a-Jukebox</a></li>
                <li><a href="/login/">Find-a-Jukebox</a></li>
                <li><a href="/signup/">Signup</a></li>
                <li><a href="/login/">Login</a></li>
               <?php }  echo "\n"; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>		
    </nav>
  <div id="home">
    <br><br>
  </div>

<?php
}
?>
