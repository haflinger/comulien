paginationMessage = 0;
$(document).ready(function() {
    
    //au click sur le message
    $(".chargerPlusMessage").click(function(){
        pagination += 1;
        console.log(paginationMessage);
        $.ajax({
            type: "GET",
            url: BASE_URL + "message/lister-tous/numpage/"+ paginationMessage+"?format=json",
            dataType : "html",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Erreur !: " + string );
            },

            success:function(data){
                //on vide la div et on le cache
                //$("#reponses"+ valeur).empty().hide();
                //traitement du json pour créer l'HTML
                console.log(data);
                //parseJSON(data, valeur)
                //on met à jour le div zone_de_rechargement avec les données reçus
                $(".monaccordeon"+ valeur).append(data);
                //$("#reponses"+ valeur).fadeIn(500);
                $(".monaccordeon"+ valeur).show();
            }
        });
    });
})


