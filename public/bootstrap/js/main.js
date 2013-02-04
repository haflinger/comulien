$(document).ready(function() {
//au click sur le lien evenement
    $("#monaccordeon").click(function(){
        $.ajax({
            type: "GET",
            url: BASE_URL + "/message/reponses",
            dataType : "html",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Error !: " + string );
            },

            success:function(data){
                //on met à jour le div zone_de_rechargement avec les données reçus
                //on vide la div et on le cache
                $("#monaccordeonMenu").empty().hide();
                //on affecte les resultats au div
                $("#monaccordeonMenu").append(data);
                //on affiche les resultats avec la transition
                $('#monaccordeonMenu').fadeIn(1000);
            }
        });
    });
})


