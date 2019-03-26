<?php

/***********************************
 * nav.php 
 * @author  mgill
 ***********************************
*/			
function nav()
{
    //---------------------------------------------
    // collapse menu for small screens on click...
    //---------------------------------------------
    $datatoggle=" data-toggle=\"collapse\" data-target=\".navbar-collapse.in\"";
    //---------------------------------------------
    // navbar links...
    //---------------------------------------------
    $why      ="\"#why\"".$datatoggle;
    $login    ="\"/login/\"".$datatoggle;
    $signup   ="\"/signup/\"".$datatoggle;
    $myprofile="\"/user/index.php?func=edit_profile\"".$datatoggle;
    $mycatalog="\"/user/index.php?func=player&jukeboxId=".getUserSession("userId")."\"".$datatoggle;
    $jukeboxs ="\"/user/index.php?func=find_jukebox\"".$datatoggle;
    $logout   ="\"/login/index.php?func=logout\"".$datatoggle;
    //---------------------------------------------------------
    // This trys to set class and style for site logo section
    // clearly, there must be a cleaner css/js solution but
    // this is the best I can come up with using bootstrap 3.3
    //---------------------------------------------------------
    $logoid   ="";
    $logoclass="";
    if(isIphone())
    {
        $logoid   ="id=\"logospot\"";
        $logoclass="class=\"navbar-brand\"";
    }
    $logostyle= $logoclass."style=\"color:white; text-decoration:none; font-size:25px; font-family:'Roboto',sans-serif; font-weight:900\"";    
?>
    <style type="text/css">
      #logospot {
                  position:absolute;
                  top:50%;
                  height:30px;
                  margin-top:-23px
      }
    </style>    
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: black; color: white">
      <div class="container-fluid">
        <div class="row">
          <?php if(isAdminLoginOK()) { echo "\n"; ?>
          <div class="col-md-4">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                <!-- <span class="fa fa-bars"></span>  -->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>                         
              <div <?php echo $logoid ?> class="site-logo">
                <a href="/" <?php echo $logostyle; ?>>The Peoples Jukebox</a>
              </div>
            </div>
          </div>				  
          <div class="col-md-8">	 
          <?php } else { echo "\n"; ?>
          <div class="col-md-4">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                <!-- <span class="fa fa-bars"></span>  -->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>                         
              <div <?php echo $logoid ?> class="site-logo">
                <a href="/" <?php echo $logostyle; ?>>The Peoples Jukebox</a>
              </div>
            </div>
          </div>
          <div class="col-md-8">
          <?php }  echo "\n"; ?>
            <div class="collapse navbar-collapse" id="menu">
              <ul class="nav navbar-nav navbar-right" style="background-color: black; color: white">
                <?php if(isAdminLoginOK()) { echo "\n"; ?>
                <li><a href=<?php echo $why; ?>>What-Why-How?</a></li>
                <?php if(hasPermission('canJukeboxAdmin')) { echo "\n"; ?>
                <li><a href=<?php echo $mycatalog; ?>>My-Catalog</a></li>
                <?php } echo "\n"; ?>
                <li><a href=<?php echo $jukeboxs; ?>>Jukebox&apos;s</a></li>
                <li><a href=<?php echo $myprofile; ?>>My-Profile</a></li>
                <li><a href=<?php echo $logout; ?>>Logout</a></li>
                <?php } else { echo "\n"; ?>
                <li><a href=<?php echo $why; ?>>What Why How?</a></li>
                <li><a href=<?php echo $login; ?>>Be-a-Jukebox</a></li>
                <li><a href=<?php echo $login; ?>>Find-a-Jukebox</a></li>
                <li><a href=<?php echo $signup; ?>>Signup</a></li>
                <li><a href=<?php echo $login; ?>>Login</a></li>
                <?php }  echo "\n"; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  <div id="home">
  </div>
<?php
}
?>
