<?php

/***********************************
 * kissyface.php
 *
 * @param header
 * @param url
 * 
 * @author megan
 ***********************************
*/			
function kissyface($header, $url)  
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Music, jukebox" />
    <meta name="description" content="A Free Jukebox for Everyone"/>
    <title>ThePeoplesJukebox.com</title>
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet" >
	<link href="/css/animate.css" rel="stylesheet" />
	<link href="/css/prettyPhoto.css" rel="stylesheet"> 
	<link href="/css/style.css" rel="stylesheet">
    <?php echo("<meta http-equiv=\"Refresh\" content=\"3; url=$url\">"); ?>
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top"  style="background-color: black">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-1">
            <div class="site-logo">
              <a href="/" class="brand" style="color: white">The Peoples Jukebox</a>
            </div>
          </div>					  
          <div class="col-md-8">	 
            <div class="navbar-header">
              <button type="button" class="navbar-toggle"  data-toggle="collapse" data-target="#menu">
                <i class="fa fa-bars"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </nav>
  <br><br>
    <br><br><br><br>
    <section id="header">
      <br><br>
      <div class="container">
        <div class="center">
          <hr>
          <br><br>
          <h2>
            <?php echo($header); ?>
          </h2>
          <div class="col-md-10 col-md-offset-4">
            <img src="/images/jukebox.jpeg" alt="Jukebox" width="350" height="400">
          </div>
        </div>
      </div>
    </section>
  </body>
</html>

<?php
}
?>
