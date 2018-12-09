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
         <div class="col-md-4">
            <div class="site-logo">
              <a href="/capstone/" class="brand" style="color: white">Capstone Jukebox</a>
            </div>
          </div>		  
          <div class="col-md-8">	 
            <div class="navbar-header" style="background-color: black; color: white">
              <button type="button" class="navbar-toggle"  data-toggle="collapse" data-target="#menu">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <div class="collapse navbar-collapse" id="menu">
              <ul class="nav navbar-nav navbar-right" style="background-color: black; color: white">
                <li><a href="/capstone/HunterCapstoneWhitePaper.pdf">White Paper</a></li>
                <li><a href="/capstone/capstoneER.pdf">ER Diagram</a></li>
                <li><a href="/capstone/jukeboxDB_Model.png">Object Model</a></li>
                <li><a href="/capstone/javadocs/">Android Javadocs</a></li>
                <li><a href="https://github.com/thatdixie">Git</a></li>
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
