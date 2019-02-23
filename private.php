<?php
require_once "include/etc/session.php";
require_once "include/view/page/index/indexIncludeFiles.php";
require_once "include/model/AdminFaqModel.php";
require_once "include/model/UserProfileModel.php";
siteSession();
//-----------------------------------
// partials for head and navigation
// and page content and footer...
//-----------------------------------
head();
nav();
?>
  <section id="privacy">
    <br><br>
    <div class="container">
      <div class="center">
    <h1>Privacy Statement</h1>
          <hr>
		<p class="lead">ThePeoplesJukebox.com, has created this privacy statement in order to demonstrate our firm commitment
		        to privacy. The following discloses our information gathering and dissemination
		        practices for this site, ThePeoplesJukebox.com.
        </p>
		<p class="lead">
                ThePeoplesJukebox.com's
		        registration form requires users to give us their email address.
		        The email address is used to contact the user, <i>only
		        when necessary</i>, concerning matters pertaining to the ThePeoplesJukebox.com jukebox application.
		        Email addresses are not used in mass mailings from ThePeoplesJukebox.com, nor are
		        they sold to or shared with third parties.
        </p>
		<p class ="lead">
                We track
		        IP addresses to help administer our Web site. 
        </p>
		<p class="lead">
              Our site uses cookies to count and track site visits anonymously. A cookie
		        is a small piece of data that many Web sites write to a file on your hard
		        disk. A cookie can contain data like an ID number used to track what pages
		        are visited. A cookie cannot by itself be used by a Web site to obtain
		        personal information about the user or to read information from your computer
		        other than that which has been voluntarily provided by you or is contained
		        in cookies given by the same Web site.
        </p>
		<p class="lead">
           We use
		   outside ad companies to display ads on our site. These ads may contain
		   cookies that may be used for purposes such as limiting the number of times
		   an ad is seen by the same person, monitoring how many people have viewed
		   certain ads, or other advertising-related purposes. While we use cookies
		   in other parts of our Web site, cookies received with banner ads are controlled
		   by our ad companies, and we do not have access to information regarding
		   these cookies. 
        </p>
		<p class="lead">
        If you have any questions about this privacy statement, the practices of this
		        site, or your dealings with this Web site, please contact us at <a href="mailto:privacy@ThePeoplesJukebox.com">privacy@ThePeoplesJukebox.com</a></font>

        </div>
      </div>
  </section>

<?php
foot();

?>
