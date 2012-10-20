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
            <h1>Destination</h1>
            <!-- Main hero unit for a primary marketing message or call to action -->
            <div class="hero-unit">
                <img src="img/SNC_Illu_Transport_10-02.png">
                <h2>Nom du train</h2>

            </div>
            <div class="accordion" id="accordion2">
                <div class="accordion-group">
                    <div class="accordion-heading accordion-toggle" data-parent="#accordion2" data-toggle="collapse"  href="#collapseOne">
                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <td><span class="badge badge-important">20</span> Y'a pas un problème de clim ici??</td>
                            </tr>
                        </table>
                    </div>
                    <div id="collapseOne" class="accordion-body collapse">
                        <div class="accordion-inner">
                                <table class="table table-bordered table-hover table-striped">
                                <tr class="warning">
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <form class="form-inline">
                                        <p><input class="input-large" type="text" placeholder="votre commentaire"></p>
                                    <p><button type="submit" class="btn btn-primary pull-right">Envoyer</button></p>
                            </form>
                                    </td>
                            
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <td><span class="badge badge-important">20</span> Collapsible Group Item #2</td>
                            </tr>
                        </table>
                    </div>
                    <div id="collapseTwo" class="accordion-body collapse">
                        <div class="accordion-inner">


                            <table class="table table-bordered table-hover table-striped">
                                <tr class="warning">
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <form class="form-inline">
                                        <p><input class="input-large" type="text" placeholder="votre commentaire"></p>
                                    <p><button type="submit" class="btn btn-primary pull-right">Envoyer</button></p>
                            </form>
                                    </td>
                            
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">

                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <td><span class="badge badge-important">20</span> Collapsible Group Item #2</td>
                            </tr>
                        </table>
                    </div>
                    <div id="collapseThree" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <table class="table table-bordered table-hover table-striped">
                                <tr class="warning">
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> texte  texte  texte  texte </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                    <form class="form-inline">
                                        <p><input class="input-large" type="text" placeholder="votre commentaire"></p>
                                    <p><button type="submit" class="btn btn-primary pull-right">Envoyer</button></p>
                            </form>
                                    </td>
                            
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            //include 'inc/footer.php';
            include 'inc/scripts.php';
            ?>
        </div> <!-- /container -->


    </body>
</html>
