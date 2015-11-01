<!DOCTYPE html>
<html lang="en">
    <head>
        <title> G2P: Gene to Phenotype Query </title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="/css/dataTables.tableTools.css">
        <link rel="stylesheet" href="/css/styles-v2.css">
    </head>
    <body>
<?php 
include_once("analyticstracking.php") 
include dbconn.php

function print_dropdown($query, $link, $name){
    $queried = mysql_query($query, $link);
    $menu = '<select name="'. $name .'">';
    while ($result = mysql_fetch_array($queried)) {
        $menu .= '
      <option value="' . $result['id'] . '">' . $result['name'] . '</option>';
    }
    $menu .= '</select>';
    return $menu;
}

?>
        <div class="container">
            <h1> G2P: Gene to Phenotype Query </h1>
            <ul class="nav nav-tabs" style="margin-top: 2em;" role="tablist">
                <li role="presentation" class="active"><a href="#home-panel" aria-controls="home" role="tab" data-toggle="tab">Search</a></li>
                <li role="presentation"><a href="#search-panel" aria-controls="search" role="tab" data-toggle="tab">Tab2</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home-panel">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<span>Example: Try searching for AKTIP in gname. Currently available diseases are BD, T2D, T1D, RA, CAD, CD, HT</span><br><br> 
                    Gene name: 
<?php echo print_dropdown("SELECT DISTINCT gname FROM a2 order by gname", $conn, "gname"); ?>                    
                    <br>
                    Phenotype: 
<?php echo print_dropdown("SELECT DISTINCT phenotype FROM a2 order by phenotype", $conn, "phenotype"); ?>
                    <br>
                    Tissue: 
<?php echo print_dropdown("SELECT DISTINCT tissue FROM a2 order by tissue", $conn, "tissue"); ?>
                    <br><br>
                    <input type="submit">
                    </form>
                </div>
                <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$gname = $_POST["gname"];
	$pval = $_POST["pval"];
	$tval = $_POST["tval"];
	$phenotype = $_POST["phenotype"];
	$source = $_POST["source"];
	$tissue = $_POST["tissue"];
	$cohort = $_POST["cohort"];

	echo "<div role=tabpanel class='tab-pane active' id=results-panel>";
	echo "<h2>Your Input:</h2>";
	if (!empty($gname)) {
		echo "Gname: ";
		echo $gname;
	}
	if (!empty($phenotype)) {
		echo "Phenotype: ";
		echo $phenotype;
	}
	if (!empty($tissue)) {
		echo "Tissue: ";
		echo $tissue;
	}
	echo "<br>";

	### query the db
	### $sql = "select * from results where ";
	echo "<table style='border: solid 1px black;'>";
	echo "<tr><th>gname</th><th>pval</th><th>tval</th><th>phenotype</th><th>source</th><th>tissue</th><th>cohort</th><th>model</th><th>R2</th><th>n.snps</th></tr>";
	class TableRows extends RecursiveIteratorIterator {
		function __construct($it) {
			parent::__construct($it, self::LEAVES_ONLY);
		}
		function current() {
			return "<td style='width:150px;border:1px solid black;padding:1px;center;'>" . parent::current() . "</td>";
			//return "<td>" . parent::current(). "</td>";
		}
		function beginChildren() {
			echo "<tr>";
		}

		function endChildren() {
			echo "</tr>" . "\n";
		}
	}
	

	try
	{
		if (empty($gname)) {
		} else {
			$stmtall = $conn->prepare("SELECT gname,pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a2 where gname like :gname order by pval limit 1000");
			$stmtall->execute(array('gname' => $gname));
		}
		if (empty($phenotype)) {
		} else {
			$stmtall = $conn->prepare("SELECT gname,pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a2 where phenotype like :phenotype order by pval limit 1000");
			$stmtall->execute(array('phenotype' => $phenotype));
		}
		if (empty($tissue)) {
		} else {
			$stmtall = $conn->prepare("SELECT gname,pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a2 where tissue like :tissue order by pval limit 1000");
			$stmtall->execute(array('tissue' => $tissue));
		}
		//$stmtcount = $conn->prepare("SELECT count(*) from results");
		// $stmtall = $conn->prepare("SELECT * from results");
		// $stmtall = $conn->prepare("SELECT * from results");

		//$stmtcount->execute();
		// set the resulting array to associative
		$result = $stmtall->setFetchMode(PDO::FETCH_ASSOC);
		foreach (new TableRows(new RecursiveArrayIterator($stmtall->fetchAll())) as $k => $v) {
			echo $v;
		}
		//$count = $stmtcount->setFetchMode(PDO::FETCH_ASSOC);
		//echo $count + " is the total number of results.";
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;

} else {
	echo "<div role=tabpanel class=tab-pane id=results-panel>";
}
?>
<?php
// define variables and set to empty values
$gname = $pval = $tval = $phenotype = "";
$source = $tissue = $cohort = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	echo "</table>";

}
?>

                </div><!-- /tab-panel -->
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
