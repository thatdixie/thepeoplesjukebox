<?php
require_once "EntityObjectsDB.php";
require      "Faq.php";

/********************************************************************
 * FaqModel inherits EntityObjectsDB and provides functions to
 * map Faq class to entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class FaqModel extends EntityObjectsDB
{
    /*********************************************************
     * Returns a Faq by faqId
     *
     * @return faq
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT faqId,".
                      "faqQuestion,".
                      "faqAnswer,".
                      "faqOrder,".
                      "faqCreated,".
                      "faqModified,".
                      "faqStatus ".                      		               
	       "FROM faq ".
	       "WHERE faqId=".$id;

        return($this->selectDB($query, "Faq"));
    }

    /*********************************************************
     * Insert a new Faq into entityobjectsDB database
     *
     * @param $faq
     * @return n/a
     *********************************************************
     */
    public function insert($faq)
    {
        $query="INSERT INTO faq ( ".
	              "faqId,".
                      "faqQuestion,".
                      "faqAnswer,".
                      "faqOrder,".
                      "faqCreated,".
                      "faqModified,".
                      "faqStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($faq->faqQuestion)."',".
                      "'".$this->sqlSafe($faq->faqAnswer)."',".
                      " ".$faq->faqOrder." ,".
                      "'".$this->sqlSafe($faq->faqCreated)."',".
                      "'".$this->sqlSafe($faq->faqModified)."',".
                      "'".$this->sqlSafe($faq->faqStatus)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Faq into entityobjectsDB database
     * and return a Faq with new autoincrement
     * primary key
     *
     * @param  $faq
     * @return $faq
     *********************************************************
     */
    public function insert2($faq)
    {
        $query="INSERT INTO faq ( ".
	              "faqId,".
                      "faqQuestion,".
                      "faqAnswer,".
                      "faqOrder,".
                      "faqCreated,".
                      "faqModified,".
                      "faqStatus ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($faq->faqQuestion)."',".
                      "'".$this->sqlSafe($faq->faqAnswer)."',".
                      " ".$faq->faqOrder." ,".
                      "'".$this->sqlSafe($faq->faqCreated)."',".
                      "'".$this->sqlSafe($faq->faqModified)."',".
                      "'".$this->sqlSafe($faq->faqStatus)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $faq->faqId = $id;
	    return($faq);	
    }


    /*********************************************************
     * Update a Faq in entityobjectsDB database
     *
     * @param $faq
     * @return n/a
     *********************************************************
     */
    public function update($faq)
    {
        $query="UPDATE  faq ".
	          "SET ".
                      "faqId= ".$faq->faqId." ,".
                      "faqQuestion='".$this->sqlSafe($faq->faqQuestion)."',".
                      "faqAnswer='".$this->sqlSafe($faq->faqAnswer)."',".
                      "faqOrder= ".$faq->faqOrder." ,".
                      "faqCreated='".$this->sqlSafe($faq->faqCreated)."',".
                      "faqModified='".$this->sqlSafe($faq->faqModified)."',".
                      "faqStatus='".$this->sqlSafe($faq->faqStatus)."' ".                      
	          "WHERE faqId=".$faq->faqId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Faq by faqId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM faq WHERE faqId=".$id;

        $this->executeQuery($query);
    }
}

?>