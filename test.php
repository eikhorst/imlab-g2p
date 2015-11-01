<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Im Lab - test</title>
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
				<li role="presentation" class="active"><a href="#home-panel" aria-controls="home" role="tab" data-toggle="tab">Search</a></li>
				<li role="presentation"><a href="#search-panel" aria-controls="search" role="tab" data-toggle="tab">Tab2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home-panel">
					<section>
					<header>Search by Gname, Phenotype or Tissue</header>
<?php 
/**
 *
 * @create a dropdown select
 *
 * @param string $name
 *
 * @param array $options
 *
 * @param string $selected (optional)
 *
 * @return string
 *
 */
function dropdown( $name, array $options, $selected=null )
{
    /*** begin the select ***/
    $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";

    $selected = $selected;
    /*** loop over the options ***/
    foreach( $options as $key=>$option )
    {
        /*** assign a selected value ***/
        $select = $selected==$key ? ' selected' : null;

        /*** add each option to the dropdown ***/
        $dropdown .= '<option value="'.$key.'"'.$select.'>'.$option.'</option>'."\n";
    }

    /*** close the select ***/
    $dropdown .= '</select>'."\n";

    /*** and return the completed dropdown ***/
    return $dropdown;
}





?>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
						<p>
							Gname:     <input type="text" name="gname"><br><br>
							
<?php //setup the pageload reqs
$servername = "localhost";
$username = "root";
$password = "Iml@b1";
$dbname = "imlab";
$gnameselect = $phenotypeselect = $tissueselect = "";

try
{

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	//$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	/*** query the database ***/
	$stmtgname = $conn->prepare("select distinct gname from a1 order by gname");
	$stmtgname->execute();
	$gnameselects = $stmtgname->setFetchMode(PDO::FETCH_ASSOC);

	$stmphen = $conn->prepare("select distinct phenotype from a1 order by phenotype");
	$stmphen->execute();
	$phenotypeselect = $stmphen->setFetchMode(PDO::FETCH_ASSOC);

$name = 'gnameselects';
$options = $gnameselects
$selected = 1;
echo dropdown( $name, $options, $selected );

} catch (PDOException $e) {
	echo 'No Results';
}
?>
							
							Phenotype: <input type="text" name="phenotype"><br><br>
<?php
$name = 'phenotypeselect';
$options = $phenotypeselect
$selected = 1;
echo dropdown( $name, $options, $selected );

?>

							Tissue:    <input type="text" name="tissue"><br><br>
							<!--PVal: <input type="text" name="pval"><br>
							TVal: <input type="text" name="tval"><br>
							Source: <input type="text" name="source"><br>
							Cohort: <input type="text" name="cohort"><br>-->
						</p>
						<input type="submit">
					</form>
				</section>
				</div><!--end tab-panel-->
			</div><!--end tab-content -->
		</div> <!--end container-->
	</body>
</html>