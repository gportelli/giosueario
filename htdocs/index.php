<?php
include 'giosueario.lib.php';

$g = new Giosueario();
?>
<!doctype html>
<html>
<head>
	<title>Il Giosueario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
		body { font-size: 14; font-family: Arial; margin: 5px; }
		h1 {margin-bottom: 0px; margin-top: 0px;}
		h3 {margin-bottom: 3px; margin-top: 5px;}
		a, a:visited { text-decoration: none; color: red; }
		a:hover { text-decoration: none; color: blue; }
		.currMonth {}
		.otherMonth { color: #888; }
		td { background-color: #d8d8d8; }
		th { background-color: #d6f680; }
		.currDay { font-weight: bold; color: blue; background-color: #86e652;}
	</style>
	<script>
		function update() {
			var y = document.getElementById('year').value;
			var m = document.getElementById('month').value;
			var o = document.getElementById('offset').value;

			document.location.href = "?offset=" + o + "&year=" + y + "&month=" + m;
		}
	</script>
</head>
<body>
	<div style="text-align: center">
	
		<h1><?php 
			if($g->getOffset() === "")
				echo "Il Giosueario";
			else
				echo "Turni in quinta (ciclo " . chr(ord("A") + $g->getOffset()) . ")";
		?></h1>
	
		<p>
			[ <a href="?">giosueario</a> | 
			<a href="?offset=0">turni a</a> | 
			<a href="?offset=1">turni b</a> | 
			<a href="?offset=2">turni c</a> | 
			<a href="?offset=3">turni d</a> | 
			<a href="?offset=4">turni e</a> ]
		</p>
		
		<a href="?offset=<?php echo $g->getOffset()?>&month=&year=">reset</a><br/>
		<?php $g->getYearSelect(); ?> 
		<br/>
		<?php $g->getMonthSelect(); ?>
		
		
		<div style="margin: auto; width:80%; margin-top: 4px; margin-bottom: 8px;">
		<?php $g->drawCalendar(); ?>
		</div>
		
	</div>
</body>
</html>