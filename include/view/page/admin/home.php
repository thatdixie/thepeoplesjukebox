<?php
/***********************************
 * home.php 
 * @author  dixie
 ***********************************
*/			
function adminHome($contacts)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
      <?php echo "<h3>"
                    .getUserSession('userFirstName')." "
                    .getUserSession('userLastName')."'s Inbox"
                    ." -- ".count($contacts)." unread messages
                  </h3>
                  <h4>(last Login: "
                    .getUserSession('userLastLogin').
                ")</h4>";
      ?>
      </div>
      <div class="col-md-6 text-right">
        <h4>
          <form method="post" action="/admin/index.php">
            <div class="form-group">
              <input type="hidden" name="func" value="findcontacts">
              <input type="text" name="search_key">
              <button type="submit" name="submit" class="btn btn-lg btn-link" required="required">Search</button>
            </div>
          </form>
        </h4>
      </div>
      <hr>
    </div>
<?php
      
    inbox($contacts);
    foot();
}
?>
