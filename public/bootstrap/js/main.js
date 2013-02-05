$(document).ready(function() {
//au click sur le lien evenement
    $(".accordion-heading").click(function(){
        console.log("toto");
        var valeur = this.id;
        $.ajax({
            type: "GET",
            url: BASE_URL + "/message/reponses/message/"+ valeur +"?format=json",
            dataType : "html",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Error !: " + string );
            },

            success:function(data){
                //traitement du json pour créer l'HTML
                
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


