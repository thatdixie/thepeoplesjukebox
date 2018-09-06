<?php
/***********************************
 * viewdownloadreport.php 
 * @author  dixie
 ***********************************
*/			
function viewDownloadReport($downloadRows)  
{
    head();
    nav();
    foreach($downloadRows as $row)
        $total += $row->count;
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
        <h4>
          Download Report -- <b><?php echo $total ?></b> total downloads 
        </h4>
      </div>
      <div class="col-md-6 text-right">
          <h4>last updated <?php echo toHumanDate(sqlNow()); ?></h4>
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
                <th class="col-md-3">Platform</th>
                <th scope="col-md-3">Browser</th>
                <th scope="col-md-2">Version</th>
                <th scope="col-md-2">Count</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($downloadRows as $row){ ?>
              <tr>
                <td><?php echo $row->downloadOs; ?></td>
                <td><?php echo $row->downloadBrowser; ?></td>
                <td><?php echo $row->softwareVersion; ?></td>
                <td><?php echo $row->count; ?></td>
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
