<?php

/***********************************
 * foot.php 
 * @author  dixie
 ***********************************
*/			
function foot()  
{
?>

  <footer id="footer" class="midnight-blue" style="background-color: black">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="text-center">
            <a href="#home" class="scrollup"><i class="fa fa-angle-up fa-3x"></i></a>
          </div><a href="/">
          &copy; <?php echo date("Y"); ?>&nbsp;&nbsp;Capstone by Megan Williams</a>
        </div>
        <div class="top-bar">			
          <div class="col-lg-12">
            <div class="social">
            <ul class="social-share">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="/contact/"><i class="fa fa-comment"></i></a></li>
            </ul> 
	      </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="/js/jquery.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/jquery.prettyPhoto.js"></script>
  <script src="/js/jquery.isotope.min.js"></script> 
  <script src="/js/wow.min.js"></script>
  <script src="/js/jquery.easing.min.js"></script>	
  <script src="/js/main.js"></script>
  <script src="/js/dixie.js"></script>
  </body>
</html>

<?php
}
?>
