<?php
/***********************************
 * contact.php 
 * @author  dixie
 ***********************************
*/			
function viewAdminContact($contact)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-1">
        <h3><?php echo $contact->contactSubject; ?></h3>
        <b> <?php echo $contact->contactName." ".
            "<a target=\"mail\" href=mailto:".$contact->contactEmail.">".$contact->contactEmail."</a> <br>";
              if($contact->contactCompany) { echo $contact->contactCompany." "; } 
              if($contact->contactPhone)   { echo $contact->contactPhone." "; }
            ?>
        </b>
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

        echo "&nbsp;&nbsp;&nbsp;<a href=\"/admin/index.php?func=delete&id=".$contact->contactId."\">DELETE</a>";
      ?> 
      </div>
      <hr>
    </div>
    <div class="container">
      <div class="col-md-6 col-md-offset-1">
        <pre>
        <?php echo "\n".$contact->contactMessage; ?>
        </pre>
      </div>
    </div>
  </section>

<?php

    foot();
}
?>
