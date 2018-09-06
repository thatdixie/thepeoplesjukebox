<?php

/***********************************
 * vieweditfaq.php 
 * @author  dixie
 ***********************************
*/			
function viewEditForm($faq)
{
    head();
    nav();
?>
  <section id="admin-home">
      <br><br><br>
      <div class="container">
        <div class="row contact-wrap">						
          <div class="status alert alert-success" style="display: none"></div>
            <form class="contact-form" method="post" action="/admin/faq.php">
                <div class="col-sm-5 col-sm-offset-3">
                  <div class="form-group">
                    <label>Question</label>
                    <textarea rows="7" cols="100" name="question" class="form-control" required="required"><?php echo $faq->faqQuestion; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Answer</label>
                    <textarea rows="7" cols="100" name="answer" class="form-control" required="required"><?php echo $faq->faqAnswer; ?></textarea>
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="func" value="edit">
                    <input type="hidden" name="update" value="yes">
                    <input type="hidden" name="id"     value=<?php echo "\"".$faq->faqOrder."\""; ?> >
                    <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Update</button>
                   </div>
                </div>
          </form> 
        </div>
      </div>
  </section>

<?php

    foot();
}
?>
