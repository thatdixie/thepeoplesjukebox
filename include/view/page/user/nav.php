<?php

/***********************************
 * nav.php 
 * @author  dixie
 ***********************************
*/			
function nav()
{
?>
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: black" style="color: white">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="site-logo">
              <a href="/" class="brand" style="color: white">The Peoples Jukebox</a>
            </div>
          </div>					  

          <div class="col-md-8">	 
            <div class="navbar-header" style="background-color: black" style="color: white">
              <button type="button" class="navbar-toggle"  data-toggle="collapse" data-target="#menu">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <div class="collapse navbar-collapse" id="menu">
              <ul class="nav navbar-nav navbar-right" style="background-color: black" style="color: white">
                <?php if(hasPermission('canContentEdit')) { echo "\n"; ?>
                <li><a href="/admin/">Home</a></li>
                <?php } echo "\n"; ?>
                <?php if(!hasPermission('canContentEdit')) { echo "\n"; ?>
                <li><a href="/">Home</a></li>
                <?php } echo "\n"; ?>
                <?php if(hasPermission('canJukeboxAdmin')) { echo "\n"; ?>
                <li><a href="#">Edit-My-Catalog</a></li>
                <?php } echo "\n"; ?>
                <li><a href="/user/index.php?func=find_jukebox">Find a Jukebox</a></li>
                <li><a href="/user/index.php?func=edit_profile">My-Profile</a></li>
                <li><a href="/login/index.php?func=logout">Logout</a></li>
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
