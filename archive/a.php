<html>
<body>

 <?php 
$gname = $_POST["gname"]; 
$pval =  $_POST["pval"]; 
$tval =  $_POST["tval"];
$phenotype =  $_POST["phenotype"];
$source =  $_POST["source"];
$tissue =  $_POST["tissue"];
$cohort =  $_POST["cohort"];

### query the db
### $sql = "select * from results where ";

?>
<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>gname</th><th>pval</th><th>tval</th><th>phenotype</th><th>source</th><th>tissue</th><th>cohort</th><th>model</th><th>R2</th><th>n.snps</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "localhost";
$username = "root";
$password = "Iml@b1";
$dbname = "imlab";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmtall = $conn->prepare("SELECT * from results limit 1000"); 
    //$stmtcount = $conn->prepare("SELECT count(*) from results");  
   // $stmtall = $conn->prepare("SELECT * from results");  
   // $stmtall = $conn->prepare("SELECT * from results"); 
    $stmtall->execute();
    //$stmtcount->execute();

    // set the resulting array to associative
    $result = $stmtall->setFetchMode(PDO::FETCH_ASSOC); 
    foreach(new TableRows(new RecursiveArrayIterator($stmtall->fetchAll())) as $k=>$v) { 
        echo $v;
    }
    //$count = $stmtcount->setFetchMode(PDO::FETCH_ASSOC);
	//echo $count + " is the total number of results.";
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
</body>
</html>
