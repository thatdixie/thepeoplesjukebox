<?php
/***********************************
 * deletecontact.php 
 * @author  dixie
 ***********************************
*/			
function viewDeleteConfirm($contact)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-1">
        <h2>
          Delete This Message? <?php echo "<a href=\"/admin/index.php?func=delete&confirm=yes&id=".$contact->contactId."\">YES</a>\n";
          echo "&nbsp;or&nbsp;<a href=\"/admin/\">NO</a>";
          ?>
        </h2>
      </div>
      <div class="col-md-6 col-md-offset-1">
        <h3><?php echo $contact->contactSubject; ?></h3>
        <b> <?php echo $contact->contactName." ".
                       $contact->contactEmail ?></b>
      </div>
      <div class="col-md-5 text-right">
        <?php echo toHumanDate($contact->contactCreated); ?>
      </div>
      <div class="col-md-5 text-right">
      <?php
        if($contact->contactStatus =="UNREAD")
          echo "<a href=\"/admin/index.php?func=mark_as_read&id=".$contact->contactId."\">FLAG-READ</a>";
        else
          echo "<a href=\"/admin/index.php?func=mark_as_unread&id=".$contact->contactId."\">FLAG-UNREAD</a>";
      ?> 
      </div>
      <hr>
    </div>
    <div class="container">
      <div class="col-md-6 col-md-offset-1">
        <pre>
        <?php echo $contact->contactMessage; ?>
        </pre>
      </div>
    </div>
  </section>
  
<?php

    foot();
}
?>
