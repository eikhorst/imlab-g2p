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
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="search-panel">
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
</div> <!--searchpane-->
</div> <!--content -->
</div> <!--container -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.tableTools.min.js"></script>
<script src="/js/jquery.dateFormat.js"></script>
<script src="/js/jsviews.min.js"></script>
<script src="/js/bootbox.min.js"></script>

</body>
</html>
