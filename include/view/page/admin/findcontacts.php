<?php
/***********************************
 * findcontacts.php 
 * @author  dixie
 ***********************************
*/			
function findContacts($contacts)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
       <h3>
           <form method="post" action="/admin/index.php">
            <div class="form-group">
                <input type="hidden" name="func" value="findcontacts">
                Search Messages
                <input type="text" name="search_key">
                <button type="submit" name="submit" class="btn btn-lg btn-link" required="required">Go!</button>
            </div>
          </form>
       </h3>
      </div>
       <hr>
    </div>
<?php
      
    inbox($contacts);
    foot();
}
?>
