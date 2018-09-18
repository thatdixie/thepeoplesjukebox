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
    <div class="container" style="text-align:center;color:black;background:grey;">
      <br>
      <h1><b>Frequently Asked Questions</b></h1>
      <br>
    </div>
    <br>
    <div class="container" style="text-align:center;">
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
  </section>
<?php
}
?>
