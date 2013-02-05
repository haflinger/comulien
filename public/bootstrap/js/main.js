$(document).ready(function() {
//au click sur le lien evenement
    $("#monaccordeon").click(function(){
        console.log( $("#IdMessageParent"));
        var valeur = $("#IdMessageParent").val();
        $.ajax({
            type: "GET",
            url: BASE_URL + "/message/reponses/message/"+ valeur +"?format=json",
            dataType : "html",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Error !: " + string );
            },

            success:function(data){
                //on met à jour le div zone_de_rechargement avec les données reçus
                //on vide la div et on le cache
                $("#reponses"+ valeur).empty().hide();
                //on affecte les resultats au div
                $("#reponses"+ valeur).append(data);
                //on affiche les resultats avec la transition
                $("#reponses"+ valeur).fadeIn(1000);
            }
        });
    });
})


