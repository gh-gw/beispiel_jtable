<?php
// prüft die Verbindung zur DB
try {
    $user = 'root';
    $pass = 'whotan51';
    $rows = array();
    $dbh = new PDO('mysql:host=localhost;dbname=jtabletestdb', $user, $pass);
    
    foreach($dbh->query('SELECT Name from people') as $row) {
        $rows[] = $row;
    }
    $jTableResult = array();
    $jTableResult['Result']  = "OK";
    $jTableResult['Records'] = $rows;
    print json_encode($jTableResult);
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

<?php

try{

    //Open database connection
    $user = 'root';
    $pass = 'whotan51';
$rows = array();    
    $dbh = new PDO('mysql:host=localhost;dbname=jtabletestdb', $user, $pass);
        //Getting records (listAction)
        if($_GET["action"] == "list")
        {
                //Get records from database
                foreach($dbh->query('SELECT Name from people') as $row) {
                    $rows[] = $row;
                }
                $jTableResult = array();
                $jTableResult['Result']  = "OK";
                $jTableResult['Records'] = $rows;
                print json_encode($jTableResult);
        }
        //Creating a new record (createAction)
        else if($_GET["action"] == "create")
        {
                //Insert record into database
                $result = mysql_query("INSERT INTO people(Name, Age, RecordDate) VALUES('" . $_POST["Name"] . "', " . $_POST["Age"] . ",now());");
                
                //Get last inserted record (to return to jTable)
                $result = mysql_query("SELECT * FROM people WHERE PersonId = LAST_INSERT_ID();");
                $row = mysql_fetch_array($result);

                //Return result to jTable
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                $jTableResult['Record'] = $row;
                print json_encode($jTableResult);
        }
        //Updating a record (updateAction)
        else if($_GET["action"] == "update")
        {
                //Update record in database
                $result = mysql_query("UPDATE people SET Name = '" . $_POST["Name"] . "', Age = " . $_POST["Age"] . " WHERE PersonId = " . $_POST["PersonId"] . ";");

                //Return result to jTable
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                print json_encode($jTableResult);
        }
        //Deleting a record (deleteAction)
        else if($_GET["action"] == "delete")
        {
                //Delete from database
                $result = mysql_query("DELETE FROM people WHERE PersonId = " . $_POST["PersonId"] . ";");

                //Return result to jTable
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                print json_encode($jTableResult);
        }

        //Close database connection
        mysql_close($con);

}
catch(Exception $ex)
{
    //Return error message
        $jTableResult = array();
        $jTableResult['Result'] = "ERROR";
        $jTableResult['Message'] = $ex->getMessage();
        print json_encode($jTableResult);
}
        
?>
