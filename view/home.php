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
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js"></script>
	<script type="text/javascript" src="view/js/jquery.jcookie.min.js"></script>
	<script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>

<!--  Integration de l'autocompletion -->
<script type="text/javascript">

			var listeUIC = null;
			
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
									$( "#choix_trains" ).css('display', 'inline');
									$.ajax({
						        		async: false,
						        		url: "/webdev/hackaton/comulien/controllers/RecuperationTrainsPourGare.php",
						        		type : "POST",
						        		data: { uicGare : listeUIC[i].id_gare},
						        		success: function(data){ 
						        			$( "#loading" ).css('display', 'inline');
						        			$( "#trains" ).html('');      		
						        			var listeTrains = $.parseJSON(data);
											for(var k = 0, l = listeTrains.length; k < l; k++){
												$( "#trains" ).append('<option value="' + listeTrains[k].num + '">' + listeTrains[k].date + ' ' +listeTrains[k].mission + ' ' + listeTrains[k].terminusUIC + '</option>');
												
											}
											$( "#trains" ).change(function(){
												var num = $( "#trains option:selected" ).val();
												document.location.href="/webdev/hackaton/comulien/controller/RecuperationTrainPourChat.php?numtrain=" + num; 
												});
											$( "#loading" ).css('display', 'none');
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
			<div id="choix_trains" style="display:none">
				<div id="loading">
					<p id="loading_text">Chargement...</p>
				</div>
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

