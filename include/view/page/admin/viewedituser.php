<?php
/***********************************
 * viewedituser.php 
 * @author  dixie
 ***********************************
*/			
function viewEditUser($user, $userGroups, $groups)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
        <h4>
          View/Edit User <b><?php echo $user->userName ?></b> 
        </h4>
      </div>
      <div class="col-md-6 text-right">
          <h4>last updated <?php echo toHumanDate($user->userModified); ?></h4>
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
                          "&gid=".$group->ugroupId."\">REMOVE</a> </td>";
                }   
                else
                {
                    echo "<td>Not in group:</td>";
                    echo "<td>".$group->ugroupName.
                         "</td><td><a href=\"/admin/users.php?func=add_group&id=".$user->userId.
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
                  <input  type="hidden" name="func"   value="update">
                  <input  type="hidden" name="id"     value=<?php echo $user->userId; ?> >
                  <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Update</button>
                </td>
                <td>&nbsp;</td>
                <td> <?php echo "<a href=\"/admin/users.php?func=reset_user&id=".$user->userId.
                                "\" class=\"btn btn-primary btn-lg\" role=\"button\" >Reset Password</a>\n"; ?>
                </td>
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
