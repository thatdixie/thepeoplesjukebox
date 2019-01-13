<?php
/***********************************
 * viewusers.php 
 * @author  dixie
 ***********************************
*/			
function viewUsers($userRows)  
{
    head();
    nav();   
    $total = count($userRows);
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
        <h4>
        Users -- <b><?php echo $total ?></b> total users &nbsp;&nbsp;
                <?php echo "<a href=\"/admin/users.php?func=add_user_form\">Add User</a>"; ?>  
        </h4>
      </div>
      <div class="col-md-6 text-right">
          <h4>last viewed <?php echo toHumanDate(sqlNow()); ?></h4>
      </div>
      <br>
      <hr>
    </div>
    <div class="container ">
      <div class="center">
        <div class="col-md-6 col-md-offset-0">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="col-md-4">Username</th>
                <th class="col-md-1">Status</th>
                <th scope="col-md-5">Last Login</th>
                <th scope="col-md-1">&nbsp;</th>
                <th scope="col-md-1">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($userRows as $row){ ?>
              <tr>
                <td><?php echo $row->userName; ?></td>
                <td><?php echo $row->userStatus; ?></td>
                <td><?php echo $row->userLastLogin; ?></td>
                <td><?php echo "<a href=\"/admin/users.php?func=edit&id=".$row->userId."\">view/edit</a>";  ?></td>
                <td><?php if ($row->userStatus == 'ACTIVE')
                              echo "<a href=\"/admin/users.php?func=disable&id=".$row->userId."\">disable</a> \n";
                         else echo "<a href=\"/admin/users.php?func=enable&id=".$row->userId."\">enable</a> \n"; ?>
                </td>
              </tr>
            <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
<?php

    foot();
}
?>
