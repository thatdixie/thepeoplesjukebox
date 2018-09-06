<?php

/***********************************
 * kissyface 
 *
 * @param $header
 * @param $url
 *
 * @author  dixie
 ***********************************
*/			
function kissyface($header, $url)  
{
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo("<meta http-equiv=\"Refresh\" content=\"3; url=$url\">"); ?>
  </head>
  <body>
  <br><br>
    <center>
      <table border="0">   
        <tr><td>
          <font size=+3>
            <?php echo($header); ?>
          </font>
          <br><br>
          <center>
            <img src="/images/kiss.jpg">
          </center>
        </td></tr>
      </table>
    </center>
  <br><br>
  </body>
</html>

<?php
}
?>
