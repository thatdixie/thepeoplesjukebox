<?php
$root = realpath($_SERVER['DOCUMENT_ROOT']);
require_once $root."/include/etc/sql.php";
require_once "JukeboxDB.php";
require_once "ContactModel.php";
require_once "Contact.php";

/********************************************************************
 * AdminContactModel inherits ContactModel 
 *
 *
 * @author  mgill
 *********************************************************************
 */
class AdminContactModel extends ContactModel
{
    /*********************************************************
     * Returns Contact search results
     *
     * @return array contacts
     *********************************************************
     */
    public function findBySearch($key)
    {
        if(blacklistSafe($key) != "")
        {
            $where = " contactName COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR contactEmail   COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR contactSubject COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ".
                        "OR contactCompany COLLATE UTF8_GENERAL_CI LIKE '%".$key."%' ";
        }
        else
        {
            $where = "contactStatus='UNREAD' OR contactStatus='READ' ";
        }
          
        $query="SELECT contactId,".
                      "contactName,".
                      "contactEmail,".
                      "contactPhone,".
                      "contactCompany,".
                      "contactSubject,".
                      "contactMessage,".
                      "contactSource,".
                      "contactCreated,".
                      "contactModified,".
                      "contactStatus ".                      		               
	       "FROM contact ".
	       "WHERE ".$where.
           "ORDER BY contactCreated DESC";

        return($this->selectDB($query, "Contact"));
    }

    /*********************************************************
     * Returns UNREAD Contacts
     *
     * @return array contacts
     *********************************************************
     */
    public function findUnread()
    {
        $query="SELECT contactId,".
                      "contactName,".
                      "contactEmail,".
                      "contactPhone,".
                      "contactCompany,".
                      "contactSubject,".
                      "contactMessage,".
                      "contactSource,".
                      "contactCreated,".
                      "contactModified,".
                      "contactStatus ".                      		               
	       "FROM contact ".
	       "WHERE contactStatus='UNREAD' ".
           "ORDER BY contactCreated DESC";

        return($this->selectDB($query, "Contact"));
    }
}

?>