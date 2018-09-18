<?php
require_once "../include/view/page/index/indexIncludeFiles.php";

head();
nav();
stub();
foot();

function stub()
{
?>
  <section id="about">
    <br><br>
    <div class="container">
      <div class="center">
          <hr>					
        <br><br>
        <div class="col-md-10 col-md-offset-1">
          <h2>Dixie's Jukebox</h2>
          <p class="lead" style="cursor: pointer;">
          <a href="javascript:onclick=playSound(this, 'http://thepeoplesjukebox.com/mp3player/mp3player.php?jukebox=1234');">
          <img style="cursor: pointer;" src="/images/jukebox.jpeg" border="0" id="jukebox"/></a><br>
          <a href="ontouchstart=playSound(this, 'http://thepeoplesjukebox.com/mp3player/mp3player.php?jukebox=1234'); return false;">
          <button id="but" type="submit" class="btn btn-primary btn-lg" style="cursor:pointer" >Play Me!</button>
          </a>
          </p>
        </div>
      </div>
    </div>
  </section>

<?php
    
}
?>



