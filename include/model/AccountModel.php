<?php
require_once "EntityObjectsDB.php";
require      "Account.php";

/********************************************************************
 * AccountModel inherits EntityObjectsDB and provides functions to
 * map Account class to entityobjectsDB.
 *
 * @author  mgill
 * @version 180722
 *********************************************************************
 */
class AccountModel extends EntityObjectsDB
{
    /*********************************************************
     * Returns a Account by accountId
     *
     * @return account
     *********************************************************
     */
    public function find($id)
    {
        $query="SELECT accountId,".
                      "accountCompany,".
                      "accountAddress,".
                      "accountCity,".
                      "accountState,".
                      "accountCountry,".
                      "accountPhone,".
                      "accountFax,".
                      "accountEmail,".
                      "accountContactName ".                      		               
	       "FROM account ".
	       "WHERE accountId=".$id;

        return($this->selectDB($query, "Account"));
    }

    /*********************************************************
     * Insert a new Account into entityobjectsDB database
     *
     * @param $account
     * @return n/a
     *********************************************************
     */
    public function insert($account)
    {
        $query="INSERT INTO account ( ".
	              "accountId,".
                      "accountCompany,".
                      "accountAddress,".
                      "accountCity,".
                      "accountState,".
                      "accountCountry,".
                      "accountPhone,".
                      "accountFax,".
                      "accountEmail,".
                      "accountContactName ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($account->accountCompany)."',".
                      "'".$this->sqlSafe($account->accountAddress)."',".
                      "'".$this->sqlSafe($account->accountCity)."',".
                      "'".$this->sqlSafe($account->accountState)."',".
                      "'".$this->sqlSafe($account->accountCountry)."',".
                      "'".$this->sqlSafe($account->accountPhone)."',".
                      "'".$this->sqlSafe($account->accountFax)."',".
                      "'".$this->sqlSafe($account->accountEmail)."',".
                      "'".$this->sqlSafe($account->accountContactName)."' ".                      
                      ")"; 

        $this->executeQuery($query);
    }


    /*********************************************************
     * Insert a new Account into entityobjectsDB database
     * and return a Account with new autoincrement
     * primary key
     *
     * @param  $account
     * @return $account
     *********************************************************
     */
    public function insert2($account)
    {
        $query="INSERT INTO account ( ".
	              "accountId,".
                      "accountCompany,".
                      "accountAddress,".
                      "accountCity,".
                      "accountState,".
                      "accountCountry,".
                      "accountPhone,".
                      "accountFax,".
                      "accountEmail,".
                      "accountContactName ".                      
                           ")".
               "VALUES (".
                      "null,".
                      "'".$this->sqlSafe($account->accountCompany)."',".
                      "'".$this->sqlSafe($account->accountAddress)."',".
                      "'".$this->sqlSafe($account->accountCity)."',".
                      "'".$this->sqlSafe($account->accountState)."',".
                      "'".$this->sqlSafe($account->accountCountry)."',".
                      "'".$this->sqlSafe($account->accountPhone)."',".
                      "'".$this->sqlSafe($account->accountFax)."',".
                      "'".$this->sqlSafe($account->accountEmail)."',".
                      "'".$this->sqlSafe($account->accountContactName)."' ".                      
                      ")"; 

        $id = $this->executeInsert($query);
	    $account->accountId = $id;
	    return($account);	
    }


    /*********************************************************
     * Update a Account in entityobjectsDB database
     *
     * @param $account
     * @return n/a
     *********************************************************
     */
    public function update($account)
    {
        $query="UPDATE  account ".
	          "SET ".
                      "accountId= ".$account->accountId." ,".
                      "accountCompany='".$this->sqlSafe($account->accountCompany)."',".
                      "accountAddress='".$this->sqlSafe($account->accountAddress)."',".
                      "accountCity='".$this->sqlSafe($account->accountCity)."',".
                      "accountState='".$this->sqlSafe($account->accountState)."',".
                      "accountCountry='".$this->sqlSafe($account->accountCountry)."',".
                      "accountPhone='".$this->sqlSafe($account->accountPhone)."',".
                      "accountFax='".$this->sqlSafe($account->accountFax)."',".
                      "accountEmail='".$this->sqlSafe($account->accountEmail)."',".
                      "accountContactName='".$this->sqlSafe($account->accountContactName)."' ".                      
	          "WHERE accountId=".$account->accountId;

        $this->executeQuery($query);
    }

    /*********************************************************
     * Delete a Account by accountId
     *
     * @param  $id
     * @return n/a
     *********************************************************
     */
    public function delete($id)
    {
        $query="DELETE FROM account WHERE accountId=".$id;

        $this->executeQuery($query);
    }
}

?>