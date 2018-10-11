<?php
require_once "../include/view/page/user/indexIncludeFiles.php";
require_once "../include/etc/session.php";
siteSession();

if(!isAdminLoginOK())
{
    redirect("/login/");
}

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
          <a href="javascript:onclick=playSound(this, 'http://thepeoplesjukebox.com/mp3player/mp3player.php?jukeboxId=3&select=yes');">
          <img style="cursor: pointer;" src="/images/jukebox.jpeg" border="0" id="jukebox"/></a><br>
          <a href="javascript:ontouchstart=playSound(this, 'http://thepeoplesjukebox.com/mp3player/mp3player.php?jukeboxId=3&select=yes');">
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



