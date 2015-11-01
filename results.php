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
<?php include_once("analyticstracking.php") ?>
        <div class="container">
            <h1> G2P: Gene to Phenotype Query </h1>
            <ul class="nav nav-tabs" style="margin-top: 2em;" role="tablist">
                <li role="presentation" class="active"><a href="#home-panel" aria-controls="home" role="tab" data-toggle="tab">Search</a></li>
                <li role="presentation"><a href="#search-panel" aria-controls="search" role="tab" data-toggle="tab">Tab2</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home-panel">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<div class="span1"/><div class="span10">Example: Try searching for AKTIP in gname. Currently available diseases are BD, T2D, T1D, RA, CAD, CD, HT</div><div class="span1" /> 
                  <div class="span12"> <div class="span2">  Gene name:</div><div class="span10"><input type="text" name="gname"></div></div>
                        <div class="span2">Phenotype:</div><div class="span10"> <input type="text" name="phenotype"></div>
                       <div class="span2">Tissue:</div><div class="span10"><input type="text" name="tissue"></div>
                        <!--PVal: <input type="text" name="pval"><br>
                        TVal: <input type="text" name="tval"><br>
                        Source: <input type="text" name="source"><br>
                        Cohort: <input type="text" name="cohort"><br>-->
                        </br><input type="submit">
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
    echo "<h4>Your Input:</h4>";
    if (!empty($gname)) {
        echo "Gname: <i>$gname</i>  ";
    }
    if (!empty($phenotype)) {
        echo "Phenotype: <i>$phenotype</i>  ";
    }
    if (!empty($tissue)) {
        echo "Tissue: $tissue  ";
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
    $servername = "localhost";
    $username = "root";
    $password = "Iml@b1";
    $dbname = "imlab";
    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!empty($gname)) {
            if(!empty($phenotype))
            {
                $stmtall = $conn->prepare("SELECT gname,pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a1 where gname like CONCAT(:gname, '%') and phenotype like CONCAT(:phenotype,'%') order by pval limit 1000");
                $stmtall->execute(array(':gname' => $gname, ':phenotype' => $phenotype));
            }
            else
            {
                $stmtall = $conn->prepare("SELECT gname, pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a1 where gname like CONCAT(:gname, '%') order by pval limit 1000");
                $stmtall->execute(array('gname' => $gname));
            }
        }
        else
        {
            if (!empty($phenotype)) {
                $s1 = $stmtall = $conn->prepare("SELECT gname, pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a1 where phenotype like CONCAT(:phenotype, '%') order by pval limit 1000");
                $stmtall->execute(array('phenotype' => $phenotype));
            }
            if (!empty($tissue)) {
                $s1 = $stmtall = $conn->prepare("SELECT gname, pval,tval,phenotype,source,tissue,cohort,model,R2,nsnps from a1 where tissue like CONCAT(:tissue,'%') order by pval limit 1000");
                $stmtall->execute(array('tissue' => $tissue));
            }
        }
        // set the resulting array to associative
        $result = $stmtall->setFetchMode(PDO::FETCH_ASSOC);
        $results = $stmtall->fetchAll();
        $count = count($results);

        ##  now do the sorting asc/desc
        #
        #
        ## here are the helper functions
        #
        #
        foreach (new TableRows(new RecursiveArrayIterator($results)) as $k => $v) {
            echo $v;
        }
        echo $count. ' results returned';
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

   # echo $s1;
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
