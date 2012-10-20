<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<link rel="stylesheet" href="css/bootstrap.css">
<style>
body {
	padding-top: 60px;
	padding-bottom: 40px;
}
</style>
<link rel="stylesheet" href="css/bootstrap-responsive.css">
<link rel="stylesheet" href="css/main.css">
<!--  AutoCompletion -->
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script type="text/javascript"
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js"></script>


<script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>

<!--  Integration de l'autocompletion -->
<script type="text/javascript">

			var listeUIC = null;
			var listeTrains = null;

			function callback() {
			    setTimeout(function() {
			        $( "#img_accueil" ).removeAttr( "style" ).hide().fadeIn();
			    }, 1000 );
			};

	        jQuery(document).ready(function() {
	        	$.ajax({
	        		async: false,
	        		url: "/webdev/hackaton/comulien/ListeGaresJson",
	        		type : "GET",
	        		data: { },
	        		success: function(data){        		
	        			listeUIC = $.parseJSON(data);
	        			var stationsList = [];
	        			for(var i = 0, j = listeUIC.length; i<j; ++i){
								stationsList.push(listeUIC[i].nom_gare);
		        		}
						stationsList.sort();
	    	            $('#station').typeahead(
	    	    	            	{source: stationsList, 
		    	    	            items:5
	    	    	    });
		        	}
	        	});	

	        	
	        	$( "#station" ).focus(function() {
					var options = {};
					$( "#img_accueil" ).collapse('hide');
		           
				});

	        	$( "#station" ).change(
	        			function(even)
	    	            {
							var txt = $('#station').val();
		        			for(var i = 0, j = listeUIC.length; i<j; ++i){
								if(listeUIC[i].nom_gare == txt){
									$( "#test" ).css('display', 'inline');

									$.ajax({
						        		async: false,
						        		url: "/webdev/hackaton/comulien/ListeGaresJson",
						        		type : "GET",
						        		data: { },
						        		success: function(data){        		
						        			listeTrains = $.parseJSON(data);
						        			var nomTrains = [];
						        			for(var i = 0, j = listeTrains.length; i<j; ++i){
						        					nomTrains.push(listeTrains[i].nom_gare);
							        		}
						        			listeTrains.sort();
											for(var k=0, l = listeTrains.length; k < l; k++){
												$( "#trains" ).append('<option value="' + listeTrains. + '">' + itemTexte + '</option>');
											}
							        	}
						        	});	
									
									break;
								}
		        			}
	    	            }

	    	     );
	        });
	    </script>

</head>
<body>
	<!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

	<!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->
	<?php
		include 'inc/navbar.php';
	?>
	<div class="container" >

		<!-- Main hero unit for a primary marketing message or call to action -->
		<div id="img_accueil" class="collapse in" data-toggle="collapse">
			<div class="hero-unit">
				<div class="accordion-inner">
        			<img src="img/SNC_Illu_Batiment_3-02.png">
      			</div>
			</div>
		</div>


		<form class="form-search">
			<div class="input-append">
				<input type="search" id="station" name="station"
					placeholder="Indiquez votre gare" data-provide="typeahead"
					class="search-query" />
				<button type="submit" class="btn">Go!</button>
			</div>
			<div id="trains" style="display:none">
				<select id="trains">
				
				</select>
			</div>
		</form>
		<?php
		//include 'inc/footer.php';
		include 'inc/scripts.php';
		?>
	</div>
	<!-- /container -->


</body>
</html>

