<?php
/***********************************
 * captcha.inc
 * @author  dixie
 ***********************************
*/			
function captcha()  
{
    require_once $_SERVER['DOCUMENT_ROOT']."/include/etc/session.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/include/etc/captcha/simple-php-captcha.php";
    siteSession();
    $_SESSION['captcha'] = simple_php_captcha();
    $page = <<< EOF
    
  <section id="contact">
    <div class="contact-page" style="background-color: grey">
      <div class="container">
        <div class="center">
          <br><br><br>
          <h2>Hope you're not a robot?</h2>
        </div>
      <div class="row contact-wrap">						
        <div class="status alert alert-success" style="display: none"></div>
          <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="/captcha/captcha.php">
            <div class="wow fadeInDown">
              <div class="col-sm-5 col-sm-offset-4">
                <div class="form-group">
		  <div class="col-xs-5">
                  <img src="{$_SESSION['captcha']['image_src']}" >
                  <input type="text" name="captchaCode" class="form-control" id="cap1" required="required">
                  <input type="hidden" name="captchaPage" value="{$_SESSION['captchaPage']}" >
	          <button type="submit" name="submit" class="btn btn-primary btn-lg" >I'm not a robot!</button>
		  </div>
                </div>
              </div>
            </div>
	  </form>
        </div>
      </div>
    </div>
  </section>

EOF;

echo $page;
}
?>
