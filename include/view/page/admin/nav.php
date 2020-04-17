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
    $jukebox  ="\"/user/index.php?func=player&jukeboxId=".getUserSession("userId")."\"".$datatoggle;
    $inbox    ="\"/admin/\"".$datatoggle;
    $faq      ="\"/admin/faq.php\"".$datatoggle;
    $useradmin="\"/admin/users.php/\"".$datatoggle;
    $chpasswd ="\"/admin/index.php?func=chpassword\"".$datatoggle;
    $jukeboxs ="\"/user/index.php?func=find_jukebox\"".$datatoggle;
    $logout   ="\"/admin/index.php?func=logout\"".$datatoggle;
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
              <ul class="nav navbar-nav navbar-right" style="background-color: black" style="color: white">
                <?php if(isAdminLoginOK()) { echo "\n"; ?>
                <li><a href=<?php echo $jukebox; ?>>Jukebox</a></li>
                <li><a href=<?php echo $inbox; ?>>Inbox</a></li>
                <li><a href=<?php echo $faq; ?>>FAQ-CMS</a></li>
                <?php if(hasPermission('canUserEdit')) { echo "\n"; ?>
                <li><a href=<?php echo $useradmin; ?>>User-Admin</a></li>
                <?php } echo "\n"; ?>
                <!-- <li><a class="dropdown-item" href=<?php echo $chpasswd; ?>>Change Password</a></li> -->
                <li><a class="dropdown-item" href=<?php echo $logout; ?>>Logout</a></li>
                <!-- <li class="dropdown">
                  <a class="dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Account-Options <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href=<?php echo $chpasswd; ?>>Change Password</a></li>
                    <li><a class="dropdown-item" href=<?php echo $logout; ?>>Logout</a></li>
                  </ul>
                </li> -->
                <?php } echo "\n"; ?>
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
