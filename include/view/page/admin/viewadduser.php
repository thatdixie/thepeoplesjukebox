<?php
/***********************************
 * viewadduser.php 
 * @author  dixie
 ***********************************
*/			
function viewAddUser($user, $userGroups, $groups, $loginCode)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
        <h4>
          Add User 
        </h4>
      </div>
      <div class="col-md-6 text-right">
          <h4>Created <?php echo toHumanDate($user->userCreated); ?></h4>
      </div>
      <br>
      <hr>
    </div>
    <div class="container ">
      <div class="center">
        <div class="col-md-6 col-md-offset-0">
          <form method="post" action="/admin/users.php">
          <table class="table">
            <tbody>
              <tr>
                <td>User Name:</td>
                <td><input type="text" name="username" value="<?php echo $user->userName; ?>" > </td>
              </tr>
              <tr>
                <td>First Name:</td>
                <td><input type="text" name="first" value="<?php echo $user->userFirstName; ?>" > </td>
              </tr>
              <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last" value="<?php echo $user->userLastName; ?> "> </td>
              </tr>
              <?php foreach($groups as $group)   
                 {   echo "\n              <tr>";
                 $match="no";
                 foreach($userGroups as $userGroup)
                     if($userGroup->ugroupId == $group->ugroupId)
                         $match="yes";

                 if($match == "yes")
                 {
                     echo "<td>In group:</td>";
                     echo "<td><b>".$group->ugroupName.
                          "</b></td><td><a href=\"/admin/users.php?func=remove_group&id=".$user->userId.
                          "&login_code=".$loginCode.
                          "&gid=".$group->ugroupId."\">REMOVE</a> </td>";

                 }   
                 else
                 {
                    echo "<td>Not in group:</td>";
                    echo "<td>".$group->ugroupName.
                         "</td><td><a href=\"/admin/users.php?func=add_group&id=".$user->userId.
                         "&login_code=".$loginCode.
                         "&gid=".$group->ugroupId."\">ADD</a> </td>";
                 }
                 echo "</tr>\n";
                 } ?>
              <tr>
                <td>User Created:</td>
                <td><?php echo $user->userCreated; ?></td>
              </tr>
              <tr>
                 <td>Last Login:</td>
                <td><?php echo $user->userLastLogin; ?></td>
              </tr>
              <tr>
                <td>User Status:</td>
                <td><?php echo $user->userStatus;
                          if($user->userStatus=="SUS" || $user->userStatus=="RESET" || $user->userStatus=="NEW" )
                              echo "</td><td><a  href=\"/admin/users.php?func=delete_user&id=".$user->userId.
                                   "\">DELETE USER</a>"; ?>
               </td>
              </tr>
              <tr>
                <td>
                  <input  type="hidden" name="func"       value="add_user">
                  <input  type="hidden" name="id"         value=<?php echo $user->userId; ?> >
                  <input  type="hidden" name="login_code" value=<?php echo $loginCode; ?> >
                  <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Add User</button>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </tbody>
          </table>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php

    foot();
}
?>
