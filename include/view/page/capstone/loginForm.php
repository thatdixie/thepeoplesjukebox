<?php

/***********************************
 * login.php 
 * @author  dixie
 ***********************************
*/			
function login()  
{
    head();
    nav();
?>
  <section id="contact">
    <div class="contact-page" style="background-color: grey">
      <div class="container">
        <div class="center">
          <br><br><br>
          <h2>Capstone Login</h2>						
        </div> 
        <div class="row contact-wrap">						
          <div class="status alert alert-success" style="display: none"></div>
            <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="/capstone/index.php?func=login">
              <div class="wow fadeInDown">
                <div class="col-sm-5 col-sm-offset-3">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="username" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="login" value="yes">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Login</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/capstone/index.php?func=signup" style="color: black">sign up here</a> 
                  </div>
                </div>
              </div>
             </div>
          </form> 
        </div>
      </div>
    </div>
  </section>

<?php

    foot();
}


function userResetForm($username, $resetCode)
{
?>
  <section id="contact">
    <div class="contact-page" style="background-color: grey">
      <div class="container">
        <div class="center">
          <br><br><br>
          <h2>Activate/Reset Login</h2>
        </div> 
        <div class="row contact-wrap">						
          <div class="status alert alert-success" style="display: none"></div>
            <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="/login/activate.php">
              <div class="wow fadeInDown">
                <div class="col-sm-5 col-sm-offset-3">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value=<?php echo $username ?> class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label>Activate code</label>
                    <input type="text" name="reset_code" value=<?php echo $resetCode ?> class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="text" name="password2" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="activate" value="yes">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Activate</button>
                   </div>
                </div>
              </div>
            </form> 
          </div>
        </div>
      </div>
  </section>

<?php
}
?>
