<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
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
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js"></script>
        
        
        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
        
        <!--  Integration de l'autocompletion -->
	    <script type="text/javascript">
	        jQuery(document).ready(function() {
	            var stationsList = ['Chatelet', 'Charles de Gaulle', 'Gare de Lyon'].sort();
	            $('#station').typeahead({source: stationsList, items:5});
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
        <div class="container">

            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <img src="img/SNC_Illu_Batiment_3-02.png">
                
            </div>
            <center>
            
            
            <form class="form-search">
                    <div class="input-append">
                        <input type="search" id="station" name="station" placeholder="Indiquez votre gare" data-provide="typeahead" class="search-query" />
                        <button type="submit" class="btn">Go!</button>
                    </div>
                </form>
                </center>
            <?php
            //include 'inc/footer.php';
            include 'inc/scripts.php';
            ?>
        </div> <!-- /container -->


    </body>
</html>
