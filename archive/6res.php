<!DOCTYPE html>

<html lang="en">
<head>
<title>Im Lab</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/css/dataTables.tableTools.css">
<link rel="stylesheet" href="/css/styles-v2.css">
</head>

<body>

<div class="container">
    <h1>Im-Lab</h1>

    <ul class="nav nav-tabs" style="margin-top: 2em;" role="tablist">
    <li role="presentation" class="active"><a href="#home-panel" aria-controls="home" role="tab" data-toggle="tab">Tab 1</a></li>
    <li role="presentation"><a href="#search-panel" aria-controls="search" role="tab" data-toggle="tab">Tab2</a></li>
    </ul>
    
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="form-pane">
                <form action="results.php" method="post">
                    Gname: <input type="text" name="gname"><br>
                    PVal: <input type="text" name="pval"><br>
                    TVal: <input type="text" name="tval"><br>
                    Phenotype: <input type="text" name="phenotype"><br>
                    Source: <input type="text" name="source"><br>
                    Tissue: <input type="text" name="tissue"><br>
                    Cohort: <input type="text" name="cohort"><br>
                    <input type="submit">
                </form>
        </div>

        <div role="tabpanel" class="tab-pane active" id="results-panel">
            

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
       return "<td style='width:150px;border:1px solid black;padding:1px;center;'>" . parent::current(). "</td>";
        //return "<td>" . parent::current(). "</td>";
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
    $stmtall = $conn->prepare("SELECT gname, pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a1 limit 1000"); 
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
        </div><!-- /tab-pane -->
    </div><!-- /tab-content -->
    
</div><!-- /container -->


<div id="modal-wait" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"><p>Please wait&hellip;<br><img src="/images/ajax-loader-md.gif"></p></div>
        </div>
    </div>
</div>



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.tableTools.min.js"></script>
<script src="/js/jquery.dateFormat.js"></script>
<script src="/js/jsviews.min.js"></script>
<script src="/js/bootbox.min.js"></script>


</body>
</html>

