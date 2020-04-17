<?php
/***********************************
 * viewfaq.php 
 * @author  dixie
 ***********************************
*/			
function adminFaq($faqs)  
{
    head();
    nav();
?>
  <section id="admin-home">
    <div class="container">
      <br><br><br>
      <div class="col-md-6 col-md-offset-0">
        <h4>
          FAQ-CMS&nbsp;&nbsp;&nbsp;
          <a href="/admin/faq.php?func=add_faq">Add FAQ </a>
          &nbsp;&nbsp;&nbsp;
          <a href="/admin/faq.php?func=save_faq">Save FAQs </a>          
        </h4>
      </div>
      <div class="col-md-6 text-right">
        <h4>last updated <?php echo toHumanDate($faqs[0]->faqModified); ?></h4>
      </div>
      <br>
      <hr>
    </div>
    <div class="container ">
      <div class="center">
        <div class="col-md-6 col-md-offset-0">
          <div class="panel-group" id="faqAccordion">
            <?php for($i=0; $i < count($faqs); $i++)
                  {    $faqs[$i]->faqOrder=$i;
                       if($faqs[$i]->faqStatus == 'ACTIVE')
                       {
                       echo "\n"; ?>
            <a href=<?php echo "\"/admin/faq.php?func=move_up&id=".$faqs[$i]->faqOrder."\""; ?>><b>&#8593;</b></a>&nbsp;&nbsp;
            <a href=<?php echo "\"/admin/faq.php?func=move_down&id=".$faqs[$i]->faqOrder."\""; ?>><b>&#8595;</b></a>&nbsp;&nbsp;
            <a href=<?php echo "\"/admin/faq.php?func=edit&id=".$faqs[$i]->faqOrder."\""; ?> >edit</a>&nbsp;&nbsp;
            <a href=<?php echo "\"/admin/faq.php?func=delete&id=".$faqs[$i]->faqOrder."\""; ?>>delete</a>
            <br>
            <div class="panel panel-default ">
	          <div class="panel-heading accordion-toggle question-toggle collapsed"
                data-toggle="collapse" data-parent="#faqAccordion" data-target=<?php echo "\"#question{$faqs[$i]->faqOrder}\"\n"; ?>
                href=<?php echo "\"#question{$faqs[$i]->faqOrder}\" style=\"cursor:pointer;\">\n"; ?>
                <h4 class="panel-title"><?php echo $faqs[$i]->faqQuestion; ?></h4>
	          </div>
              <div id=<?php echo "\"question{$faqs[$i]->faqOrder}\""; ?> class="panel-collapse collapse" style="height: 0px;">
	            <div class="panel-body">
                  <p><?php echo $faqs[$i]->faqAnswer; ?> </p>
	            </div>
	          </div>
	        </div>
            <br><br>
            <?php }  } setUserSession('FAQ_ARRAY', serialize($faqs)); echo "\n"; ?>
          </div>
	    </div>
      </div>
    </div>
  </section>
<?php

    foot();
}
?>
