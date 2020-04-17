<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/sql.php";
require_once "JukeboxDB.php";
require_once "FaqModel.php";
require_once "Faq.php";

/********************************************************************
 * AdminFaqModel inherits FaqModel 
 *
 *
 * @author  mgill
 *********************************************************************
 */
class AdminFaqModel extends FaqModel
{
    /*********************************************************
     * Returns All Faq results
     *
     * @return array faqs
     *********************************************************
     */
    public function findAll()
    {
        $query="SELECT faqId,".
                      "faqQuestion,".
                      "faqAnswer,".
                      "faqOrder,".
                      "faqCreated,".
                      "faqModified,".
                      "faqStatus ".                      		               
	       "FROM faq ".
	       "WHERE faqStatus='ACTIVE' ORDER by faqOrder" ;

        return($this->selectDB($query, "Faq"));
    }

    /*********************************************************
     * update All Faq 
     *
     * @param array faqs
     *********************************************************
     */
    public function updateAll($faqs)
    {
        $query= " UPDATE faq SET ";

        $col = "faqQuestion = CASE ";
        foreach($faqs as $faq)
            $col.="WHEN faqId=".$faq->faqId." THEN '".$this->sqlSafe($faq->faqQuestion)."' ";
        $col.="ELSE faqQuestion END, ";
        $query.=$col; 
        
        $col = "faqAnswer = CASE ";
        foreach($faqs as $faq)
            $col.="WHEN faqId=".$faq->faqId." THEN '".$this->sqlSafe($faq->faqAnswer)."' ";
        $col.="ELSE faqAnswer END, ";
        $query.=$col;

        $col = "faqStatus = CASE ";
        foreach($faqs as $faq)
            $col.="WHEN faqId=".$faq->faqId." THEN '".$this->sqlSafe($faq->faqStatus)."' ";
        $col.="ELSE faqStatus END, ";
        $query.=$col;
        
        $col = "faqOrder = CASE ";
        foreach($faqs as $faq)
            $col.="WHEN faqId=".$faq->faqId." THEN ".$faq->faqOrder." ";
        $col.="ELSE faqOrder END, ";
        $query.=$col;

        $col = "faqModified = CASE ";
        foreach($faqs as $faq)
            $col.="WHEN faqId=".$faq->faqId." THEN '".$this->sqlSafe($faq->faqModified)."' ";
        $col.="ELSE faqModified END ";
        $query.=$col;
                
	    $where= "WHERE ";
        foreach($faqs as $faq)
            $where.="faqId=".$faq->faqId." OR ";
        $where.="faqId=0";
        $query.=$where;

        //error_log($query,0);
        $this->executeQuery($query);
    }
}

?>