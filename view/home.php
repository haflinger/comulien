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

        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
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
                        <input type="text" class="search-query">
                        <button type="submit" class="btn">Go!</button>
                    </div>
                </form>
                <table class="table table-striped table-bordered table-hover">
                    <tr><td>Chatelet les halles</td></tr>
                    <tr><td>Versailles Chantier</td></tr>
                    <tr><td>Charles de Gaule - Etoiles</td></tr>
                </table>
                </center>
            <?php
            //include 'inc/footer.php';
            include 'inc/scripts.php';
            ?>
        </div> <!-- /container -->


    </body>
</html>
