<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<head>
	<meta HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<title>Wikidéchets - Ocean Plastic Tracker</title>
	<link rel="stylesheet" href="../style.css" />
	<script type="text/javascript" src="../Highcharts-6/code/jquery.min.js"></script>
	<script src="../Highcharts-6/code/highcharts.js"></script>
</head>

<div id="container" style="width: 100%; height: 600px; margin: 0 auto"></div>

<center>
<button id="Toutes les regions">Toutes les régions</button>
<button id="Mer du Nord">Mer du Nord</button>
<button id="Manche Est">Manche Est</button>
<button id="Nord de la Seine">Nord de la Seine</button>
<button id="Cotentin Ouest">Cotentin Ouest</button>
<button id="Bretagne Nord">Bretagne Nord</button>
<button id="Bretagne Ouest">Bretagne Ouest</button>
<button id="Bretagne Sud">Bretagne Sud</button>
<button id="Sud-Ouest">Sud Ouest</button> 
</center>

<script type="text/javascript">
$(document).ready(function() {
	var options = {
		chart: {renderTo: 'container', type: 'spline', zoomType: 'y', },
		tooltip: { crosshairs: true },
		title: { text:'' },
		subtitle: { text: 'Source des données : <a href="http://oceanplastictracker.com">http://oceanplactictracker.com</a>'},
		xAxis: { categories: [] },
		yAxis: { allowDecimals: false, title: { text: 'Nombre de traceurs signalés' }},
		series: []
		};
		
// Initialisation du premier graphique avec les données la table "toutes zones".
	$.get('tables/conteneurs/zones/Toutes les regions.csv', function(data) {
		options.title.text = 'Région : Toutes les régions.' ;
		var lines = data.split('\n');
		$.each(lines, function(lineNo, line){
			var items = line.split(',');
				if (lineNo == 0) {
				$.each(items, function(itemNo, item) {
					if (itemNo > 0) {
						options.xAxis.categories.push(item);
					};
				});
				} 
				else {
					var donnees = { data: [] };
					$.each(items, function(itemNo, item) {
						if (itemNo == 0) {
							donnees.name = String(item);
						} else { 
							donnees.data.push(parseFloat(item));					
						};		
					});
					options.series.push(donnees);
				};	
		});
		var chart = new Highcharts.Chart(options);

	$('button').click(function() {
		var region = $(this).attr('id');
		var titre = String(region);
		chart.setTitle({ text: 'Région : ' + titre +'.'});
		$.get('tables/conteneurs/zones/'+region+'.csv', function(data) {
			var lines = data.split('\n');
			var i = 0;
			$.each(lines, function(lineNo, line){
			var items = line.split(',');
			if (lineNo > 0) {
				var donnees = { data: [] };
				$.each(items, function(itemNo, item) {
				if (itemNo > 0) {
					donnees.data.push(parseFloat(item));
				};				
				});			
				chart.series[i].setData(donnees.data);
				i ++ ;
			};
			});
		});
	});
});
});
</script>
</BODY>
</html>