
<?php
require_once "DBConstants.php";

/********************************************************************
 * JukeboxDB is the base class for jukeboxDB access.
 *
 * @author  megan
 * @version 180927
 ********************************************************************
 */
class JukeboxDB implements DBConstants
{
    public $conn = null;    //our DB connection

    /********************************************************
     * Returns a connection object for a jukeboxDB connection
     *
     * @return $conn
     *********************************************************
     */
    public function connectDB()
    {
        //--------------------------------------
	    // Construct Data Source Name (DSN)
	    // username and password for PDO object
	    //--------------------------------------
        $dsn =""        .JukeboxDB::DBDRIVER.  ":";
        $dsn.="host="   .JukeboxDB::DBSERVER.  ";";
        $dsn.="dbname=" .JukeboxDB::DBNAME.    ";";
        $dsn.="port="   .JukeboxDB::DBPORT.    ";";
        $dsn.="charset=".JukeboxDB::DBCHARSET;
	    $username       =JukeboxDB::DBUSER;
	    $password       =JukeboxDB::DBPASSWORD;

        return(new PDO($dsn,$username,$password));
    }

    /********************************************************
     * Returns an array of resulting rows for an objecct
     *
     * @param $query
     * @param $class
     *
     * @return $results
     *********************************************************
     */
    public function selectDB($query, $class )
    {
        $this->conn = $this->connectDB();

        $result = $this->conn->query($query);
	    $result->setFetchMode(PDO::FETCH_CLASS, $class);

        for($i=0; $f=$result->fetch(); $i++)
	    if($f !=0)
	        $r[$i] = $f;
		
        $this->conn = null;
        return($r);
    }


    /********************************************************
     * executeQuery
     *
     * @param $query
     * @return n/a
     *********************************************************
     */
    public function executeQuery($query)
    {
        $this->conn = $this->connectDB();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        $this->conn->exec($query);
        $this->conn = null;
    }


    /********************************************************
     * executeInsert
     *
     * @param  $query
     * @return $id
     *********************************************************
     */
    public function executeInsert($query)
    {
        $this->conn = $this->connectDB();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        $this->conn->exec($query);
        $id   = $this->conn->lastInsertId();
        $this->conn = null;
	    return($id);
    }

    /********************************************************
     * sqlSafe -- 100% sql injection proof sanitizer
     *            USE UTF8 CHARSET!
     *
     * @param  $attr
     * @return $attr
     *********************************************************
     */
    public function sqlSafe($attr)
    {
	    return(addslashes($attr));
    }
}

?>