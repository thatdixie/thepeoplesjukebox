<?php

/***********************************
 * faq.php 
 * @author  dixie
 ***********************************
*/			
function faq($faqs)  
{
?>
  <section id="faq">
    <br><br><br>
    <div class="container ">
      <div class="center">
        <br><br><br>
        <div class="col-md-10 col-md-offset-1">
          <h2>Frequently Asked Questions</h2>
          <hr>					
          <div class="panel-group" id="faqAccordion">
        <?php foreach($faqs as $faq) { echo "\n" ?>
	    <div class="panel panel-default ">
	      <div class="panel-heading accordion-toggle question-toggle collapsed"
          data-toggle="collapse" data-parent="#faqAccordion" data-target=<?php echo "\"#question{$faq->faqOrder}\"\n"; ?>
          href=<?php echo "\"#question{$faq->faqOrder}\" style=\"cursor:pointer;\">\n"; ?>
            <h4 class="panel-title"><?php echo $faq->faqQuestion; ?></h4>
	      </div>
          <div id=<?php echo "\"question{$faq->faqOrder}\""; ?> class="panel-collapse collapse" style="height: 0px;">
	        <div class="panel-body">
              <p><?php echo $faq->faqAnswer; ?> </p>
	        </div>
	      </div>
	    </div>
        <?php } echo "\n" ?>
        </div>
	  </div>
      </div>
    </div>
  </section>
<?php
}
?>
