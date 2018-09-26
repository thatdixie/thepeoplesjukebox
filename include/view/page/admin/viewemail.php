<?php
/***********************************
 * viewemail.php 
 * @author  dixie
 ***********************************
*/			

/**
 * viewPasswordResetEmail()
 *
 * @param class  -- $user
 * @param string -- $resetCode
 *
 * @return string -- $emailString
 */			
function viewPasswordResetEmail($user, $resetCode)
{
    $pubserver   = pubServerAddress();
    $emailString = <<<EOF

   <section id="home">
    <div class="container">
      <div class="col-md-6 col-md-offset-3">
      <hr>
      <p class="lead">
        {$user->userFirstName} {$user->userLastName}, your password has been reset
      </p> 
      <p class="lead">
       Your username is <b>{$user->userName}</b>
      </p>
      <p class="lead">
        This is what you have to do next to re-activate yourself as a user:<br>
        Click the following link to re-create your password using this login code<br><br>
        <b>$resetCode</b>
      </p>
      <p class="lead">
        <a href="{$pubserver}/login/activate.php?resetuser={$resetCode}&user={$user->userName}">
          CLICK HERE TO CHANGE PASSWORD
        </a>
      </p>
    </div>
  </div>
  </section>
   

EOF;

    return(emailHead().$emailString.emailFoot($user));
}

/**
 * viewUserActivateEmail()
 *
 * @param class  -- $user
 * @param string -- $resetCode
 *
 * @return string -- $emailString
 */			
function viewUserActivateEmail($user, $resetCode)
{
    $pubserver   = pubServerAddress();
    $emailString = <<<EOF
  <section id="home">
    <div class="container">
      <div class="col-md-6 col-md-offset-3">
      <hr>
      <p class="lead">
        {$user->userFirstName} {$user->userLastName}, Congratulations!
      </p> 
      <p class="lead">
       Your username is <b>{$user->userName}</b>
      </p>
      <p class="lead">
        This is what you have to do next to activate yourself as a user:<br>
        Click the following link to create your password using this login code<br><br>
        <b>$resetCode</b>
      </p>
      <p class="lead">
        <a href="{$pubserver}/login/activate.php?resetuser={$resetCode}&user={$user->userName}">
         CLICK HERE TO COMPLETE REGISTRATION
        </a>
      </p>
    </div>
  </div>
  </section>
    
EOF;

    return(emailHead().$emailString.emailFoot($user));
}

/**
 * viewSystemEventEmail()
 *
 * @param string  -- $text
 * @return string -- html email
 */			
function viewSystemEventEmail($text)
{
    $pubserver   = pubServerAddress();
    $emailString = <<<EOF
  <section id="home">
    <div class="container">
      <div class="col-md-6 col-md-offset-3">
      <hr>
      <p class="lead">
        {$text}
      </p> 
      <p class="lead">
        <a href="{$pubserver}/admin/">
         Login for details
        </a>
      </p>
    </div>
  </div>
  </section>
    
EOF;

    return(emailHead().$emailString.emailFoot2());
}


/**
 * emailFoot()
 *
 * @return string -- $emailString
 */			
function emailFoot($user)
{
    $pubserver   = pubServerAddress();
    $emailString = <<<EOF

<!--  <footer id="footer" class="midnight-blue">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          &nbsp;&nbsp;&nbsp;
          <a href="{$pubserver}/login/activate.php?unsubscribe=yes&userid={$user->userId}&first={$user->userFirstName}&last={$user->userLastName}&username={$user->userName}">unsubscribe</a>
        </div>
        <div class="top-bar">			
          <div class="col-lg-12">
            <div class="social">
	    </div>
          </div>
        </div>
      </div>
    </div>
-->
</body>
</html>
 
EOF;

    return($emailString);
}

/**
 * emailFoot2() -- no unsubscribe link
 *
 * @return string -- $emailString
 */			
function emailFoot2()
{
    $pubserver   = pubServerAddress();
    $emailString = <<<EOF
<!--
  <footer id="footer" class="midnight-blue">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          &nbsp;&nbsp;&nbsp;
        </div>
        <div class="top-bar">			
          <div class="col-lg-12">
            <div class="social">
	        </div>
          </div>
        </div>
      </div>
    </div>
-->
</body>
</html>
    
EOF;

    return($emailString);
}


/**
 * emailHead()
 *
 * @return string -- $emailString
 */			
function emailHead()
{
    $emailString = <<<EOF

<!DOCTYPE html >
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" >
  <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">

  <title>Email</title>

  <style type="text/css">
body {
    width: 100%;
    height: 100%;
    font-family: 'Ek Mukta', sans-serif;
	font-weight: 300;
    color: #666;
    background-color: #fff;
	font-size: 16px;
    line-height: 1.6em;
	font-weight: 400;
}

p {
	font-size:16px;

}

.btn-primary {
  padding: 8px 20px;
  background: #fff;
  color: #000;
  border-radius: 0;
  border:none;
  margin-top: 10px;
  outline: solid;
}

.btn-primary:hover, 
.btn-primary:focus{
  background: #fff;
  color:#FFFFFF;
  outline: solid;
  box-shadow: none;
} 


/* --- logo --- */
.site-logo {	
	margin-top:40px;
	margin-bottom:40px;
}

.site-logo a.brand {
	color: #FFFFFF;	
	font-size: 30px;
	font-family: 'Roboto', sans-serif;
	font-weight: 900;
	
}
.site-logo a.brand:hover {
	text-decoration:none;
}

/* ------- Navigation ------------ */

.navbar {
    margin-bottom: 0;
}

.navbar-brand {
    font-weight: 700;
}

.navbar-brand:focus {
    outline: 0;
}

.nav.navbar-nav {
	padding:30px;
}

.navbar-fixed-top ul.nav li a {
	font-size: 14px;
	letter-spacing: 3px;
    color: #000;
	text-transform: uppercase;
	font-weight: 700;
}

.navbar-fixed-top.top-nav-collapse ul.nav li a {
	    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
	color: #fff;
}

.navbar-fixed-top ul.nav ul.dropdown-menu {
	  border-radius: 0;	
	margin-top: 21px;
	border-top: none;
}

.navbar-fixed-top ul.nav li a:hover ul.dropdown-menu {
	    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}

.navbar-fixed-top ul.nav ul.dropdown-menu li:last-child{
	border-bottom: none;
}

.navbar-fixed-top ul.nav ul.dropdown-menu li a {
	padding: 10px 20px;
}

.navbar-fixed-top.top-nav-collapse ul.nav ul.dropdown-menu li a {
	color: #666;
}

.navbar-fixed-top .nav li a {
    -webkit-transition: background .3s ease-in-out;
    -moz-transition: background .3s ease-in-out;
    transition: background .3s ease-in-out;
}

.navbar-fixed-top .nav li a:hover,
.navbar-fixed-top .nav li a:focus,
.navbar-fixed-top.nav li.active {
    outline: 0;
  
	color:#FFFFFF ;
}

.navbar-toggle {
    padding: 4px 6px;
    font-size: 18px;
    color: #000;
}

.navbar-toggle:focus,
.navbar-toggle:active {
    outline: 0;
}

.slider {
	padding-top:50px;
}

#carousel-slider {
  position: relative;
}

#carousel-slider .carousel-indicators {
  bottom: -25px;
}

#carousel-slider .carousel-indicators li {
  border: 1px solid #ffbd20;
}

#carousel-slider a i {
  border: 1px solid #FFFFFF;;
  border-radius:50%;
  font-size: 30px;
  height: 50px;
  padding: 8px;
  position: absolute;
  top: 50%;
  width: 50px;
  color:#fff;
   background:#FFFFFF;
}

#carousel-slider a i:hover {
  background:#FFFFFF;
  color:#fff;
  border: 1px solid #FFFFFF;
}

#carousel-slider 
.carousel-control {
  width:inherit;
}

#carousel-slider .carousel-control.left i {
  left:70px
}

#carousel-slider .carousel-control.right i {
  right: 70px;
}

#carousel-slider
.carousel-control.left, 
#carousel-slider
.carousel-control.right {
  background: none;
}

.center h2{
  font-size: 40px;
  margin-top: 0;
  margin-bottom: 10px;
  text-align:center;
  color:#000;
  text-transform:uppercase;
}

#portfolio .lead {
	text-align:center;
	font-size:18px;
	margin-bottom:40px;
}

#portfolio {
	padding-top:40px;
	position:center;
}


.portfolio-items, 
.portfolio-filter {
  list-style: none outside none;
  margin: 0 0 40px 0;
  padding: 0;
}

.portfolio-filter > li {
  display: inline-block;
}

.portfolio-filter > li a {
  background: none repeat scroll 0 0 #FFFFFF;
  font-size: 14px;
  font-weight: 400;
  margin-right: 20px;
  text-transform: uppercase;
  transition: all 0.9s ease 0s;
  -moz-transition: all 0.9s ease 0s;
  -webkit-transition: all 0.9s ease 0s;
  -o-transition: all 0.9s ease 0s;
  border: 1px solid #F2F2F2;
  outline: none;
  border-radius: 0;
}

.portfolio-filter > li a:hover,
.portfolio-filter > li a.active{
  color:#fff;
  background: #FFFFFF ;
  border: 1px solid #FFFFFF ;
  box-shadow: none;
  -webkit-box-shadow: none;
}

.portfolio-items > li {
  float: left;
  padding: 0;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.portfolio-item {
  margin: 0;
  padding:0;
}

/* Start: Recommended Isotope styles */
/**** Isotope Filtering ****/
.isotope-item {
  z-index: 2;
}

.isotope-hidden.isotope-item {
  pointer-events: none;
  z-index: 1;
}

/**** Isotope CSS3 transitions ****/
.isotope,
.isotope .isotope-item {
  -webkit-transition-duration: 0.8s;
  -moz-transition-duration: 0.8s;
  -ms-transition-duration: 0.8s;
  -o-transition-duration: 0.8s;
  transition-duration: 0.8s;
}

.isotope {
  -webkit-transition-property: height, width;
  -moz-transition-property: height, width;
  -ms-transition-property: height, width;
  -o-transition-property: height, width;
  transition-property: height, width;
}

.isotope .isotope-item {
  -webkit-transition-property: -webkit-transform, opacity;
  -moz-transition-property: -moz-transform, opacity;
  -ms-transition-property: -ms-transform, opacity;
  -o-transition-property: -o-transform, opacity;
  transition-property: transform, opacity;
}

/**** disabling Isotope CSS3 transitions ****/
.isotope.no-transition,
.isotope.no-transition .isotope-item,
.isotope .isotope-item.no-transition {
  -webkit-transition-duration: 0s;
  -moz-transition-duration: 0s;
  -ms-transition-duration: 0s;
  -o-transition-duration: 0s;
  transition-duration: 0s;
}

/* End: Recommended Isotope styles */
/* disable CSS transitions for containers with infinite scrolling*/
.isotope.infinite-scrolling {
  -webkit-transition: none;
  -moz-transition: none;
  -ms-transition: none;
  -o-transition: none;
  transition: none;
}


.recent-work-wrap {
  position: relative;
}

.recent-work-wrap img{
  width: 100%;
}

.recent-work-wrap .recent-work-inner{
  top: 0;
  background: transparent;
  opacity: .8;
  width: 100%;
  border-radius: 0;
  margin-bottom: 0;
}

.recent-work-wrap .recent-work-inner h3{
  margin: 10px 0;
}

.recent-work-wrap .recent-work-inner h3 a{
  font-size: 24px;
  color: #fff;
}

.recent-work-wrap .overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  border-radius: 0;
  background: #333;
  color: #fff;
  vertical-align: middle;
  -webkit-transition: opacity 500ms;
  -moz-transition: opacity 500ms;
  -o-transition: opacity 500ms;
  transition: opacity 500ms;  
  padding: 30px;
}

.recent-work-wrap .overlay .preview {
  bottom: 0;
  display: inline-block;
  height: 35px;
  line-height: 35px;
  border-radius: 0;
  background: transparent;
  text-align: center;
  color: #fff;
}

.recent-work-wrap:hover .overlay {
  opacity: 1;
}

#about  {
	margin-top:80px;
	margin-bottom:40px;
}

#about .lead {
	text-align:center;
	font-size:18px;
	margin-bottom:50px;
}

#about  img {	
	margin-bottom:40px;
}

.panel-default{
  border-color: transparent;
}

.panel-default>.panel-heading,
.panel{
  background-color: #e6e6e6; 
  border:0 none;
  box-shadow:none;
}

.panel-default>.panel-heading+.panel-collapse .panel-body{
  background: #fff;
  color: #858586;
}

.panel-body{
  padding: 20px 20px 10px;
}

.panel-group .panel+.panel{
  margin-top: 20px;
  border-top: 1px solid #fff;
}

.panel-group .panel{
  border-radius: 0;
}

.panel-heading{
	border-radius: 0;
}

.panel-title>a{
  color: #4e4e4e;
}

.accordion-inner img{
  border-radius: 4px;
}


.panel-heading.active{
  background: #1f1f20;
}

.panel-heading.active .panel-title>a{
  color:#fff;
}

a.accordion-toggle  i{
  width: 40px;
  line-height: 38px;
  font-size: 20px;
  margin-top: -10px;
  text-align: center;
  margin-right: -15px;
  background: #FFFFFF;
  color:#fff;
}

.panel-heading.active a.accordion-toggle i{
  background: #FFFFFF;
  color: #fff;
}

.panel-heading.active a.accordion-toggle.collapsed i{
  background: #FFFFFF;
  color: #fff;
}

#features {
	margin-top:50px;
	padding:50px;
	text-align:center;
}

#features .lead {
	text-align:center;
	font-size:18px;
	margin-bottom:50px;
}

#features img {
	border-radius:30%;
	margin-top:30px;
	margin-bottom:40px;
}

/* --- Map --- */
.map{
	position:relative;
	padding-top:50px;
	margin-top:50px;
	
}

.map iframe{
	width:100%;
	height:600px;
	border:none;
}

.map-grid iframe{
	width:100%;
	height:350px;
	border:none;
	margin:0 0 -5px 0;
	padding:0;
}

.contact-page{
  padding-top: 80px;
  background:#FFFFFF;
  margin-top:-10px;
}

.contact-page .contact-form 
.form-group label {
  color: #4E4E4E;
  font-size: 16px;
  font-weight: 300;
}

.form-group .form-control {
  padding: 7px 12px;
  border-color:#f2f2f2;
  box-shadow: none;
  border-radius:0;
}

textarea#message{
  resize: none;
  padding: 10px;
}

.contact-page .contact-wrap {
  margin-top: 20px;
}


#footer {
  padding-top: 30px;
  padding-bottom: 30px;
  color: #fff;
  background: #FFFFFF;
}

#footer a {
  color: #fff;
}

#footer a:hover {
  color: #fff;
}

#footer ul {
  list-style: none;
  padding: 0;
  margin: 0;
  text-align:center;
}

#footer ul > li {
	margin-top:20px;
	margin-bottom:30px;
  display: inline-block;
  margin-left: 15px;
  text-align:center;
}
.midnight-blue {
	text-align:center;

}

.text-center {
	margin-bottom:20px;
	font-size:30px;

}
  </style>
</head>
<body>
<!--  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="row">
	<div class="col-md-2">
	  <div class="site-logo">
	    <a href="http://getsome.thatdixie.com" class="brand">:-)</a>
	  </div>
	</div>
  </nav>
-->    

EOF;

    return($emailString);
}

?>
