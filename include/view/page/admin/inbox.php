<?php
/***********************************
 * inbox.php 
 * @author  dixie
 ***********************************
*/			
function inbox($contacts)  
{

?>
    <div class="container">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="col-md-2">Received</th>
            <th scope="col-md-2">From</th>
            <th scope="col-md-3">Subject</th>
            <th scope="col-md-5">Message</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($contacts as $contact){
        $out = strlen($contact->contactMessage) > 60 ? substr($contact->contactMessage,0,60)."..." : $contact->contactMessage; ?>
          <tr>
            <td><?php echo toHumanDate($contact->contactCreated); ?></td>
            <td><?php echo "<a href=\"/admin/index.php?func=view_contact&id=".$contact->contactId."\">".$contact->contactName."</a>"; ?></td>
            <td><?php echo "<a href=\"/admin/index.php?func=view_contact&id=".$contact->contactId."\">".$contact->contactSubject."</a>"; ?></td>
            <td><?php echo "<a href=\"/admin/index.php?func=view_contact&id=".$contact->contactId."\">".$out."</a>"; ?></td>
          </tr>
        <?php }?>
        </tbody>
      </table>
    </div>
  </section>

<?php
}
?>
