var valeur = null;
$(document).ready(function() {
    
    //au click sur le message
    $(".accordion-heading").click(function(){
        valeur = this.id;
        console.log(valeur);
        $.ajax({
            type: "GET",
            url: BASE_URL + "/message/reponses/message/"+ valeur +"?format=json",
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Erreur !: " + string );
            },

            success:function(data){
                //on vide la div et on le cache
                $("#reponses"+ valeur).empty().hide();
                //traitement du json pour créer l'HTML
                console.log(data);
                parseJSON(data, valeur)
                //on met à jour le div zone_de_rechargement avec les données reçus
                $("#reponses"+ valeur).append();
                //$("#reponses"+ valeur).fadeIn(500);
                $("#reponses"+ valeur).show();
            }
        });
    });
    
    var parseJSON = function(data){
        $(data).each(function(i){
            creeHTML(this);
        });
    }
    
    var creeHTML = function(element){
        $reponse = '';
        for (var i = 0; i<element.reponses.length; i++){
            $reponse += '<div class="reponse">';
            $reponse += '<div class="row-fluid">';
            $reponse += '<div class="span12">';
            $reponse += '<div class="avatar">avatar</div>';
            $reponse += '<div class="nomUser">'+element.reponses[i].idUser_emettre +'</div>';
            $reponse += '<div class="dateMessage">'+element.reponses[i].dateActiviteMsg +'</div><br/>';
            $reponse += '<div class="lblMessage">'+ element.reponses[i].lblMessage +'</div>';
            $reponse += '</div>';  
            $reponse += '</div>';
            $reponse += '</a>';
            $reponse += '</div>';
            
        }
        console.log($reponse);
        $("#reponses"+ valeur).append($reponse);
    }
})


                             
