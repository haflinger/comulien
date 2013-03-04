//@auteurs Fred H & AlexSolex

//Variable globale permettant de conserver la date des prochain messages à afficher 
var dateProchaine = null;
var dateProchaineReponse = null;

//Fonction automatique de calcul des dates et heurs
function autoDate(){
  $("#dateMessage").each(
    function(){
        modifDate(this);
        //console.log(this);
    })
    
    setTimeout(autoDate(), 10000);
}

function modifDate(noeud){
    $(noeud).textContent = calculDate(noeud.id);
}
//Fonction qui retourne la date d'activité du message au format simplifié
//hier, min, heure, jour
function calculDate(dateMessage){
    var maintenant = new Date().getTime();
    var diff = Math.floor(maintenant/1000)- dateMessage;
    
    var diff_j = Math.floor(diff / (24*3600));
    diff = diff % (24*3600);
    var diff_h = Math.floor(diff / (3600));
    diff = diff % 3600;
    var diff_m = Math.floor(diff / (60));
    diff = diff % 60;

    
    if(diff_j == 1){
        return "hier";
    }
    else if(diff_j >1){
        return diff_j + " j";
    }
    else if(diff_h >0 && diff_h<24){
        return diff_h + " h";
    }
    else if(diff_m >0 && diff_m<60){
        return diff_m + " min";
    }
    else{
        return "à l'instant";
    }
    
}

//Fonction de création du lien gravatar
function gravatar(email){
    return '<img alt="Avatar" src="http://www.gravatar.com/avatar/' + email + '.jpg?&d=mm&r=g&s=40"/>';
}

//Ajout des balise HTML - Mise en forme du message
function creeHtmlMessage(element){
dateProchaine = element.dateProchaine;
$message = '';
$formulaire = '';
for (var i = 0; i<element.messages.length; i++){
    $message += '<div class="accordion-group accordion" id="selector">';
            $message += '<div class="user">';
                if( element.messages[i].idProfil != null) {$message += '<img alt="VIP" class="vip"  src="../images/vip.gif"/>';}
                $message += '<div class="avatar">' + gravatar(element.messages[i].emailMD5) + '</div>';
            $message += '</div>';  
            
            $message += '<div class="texteMessage accordion-heading" id="' + element.messages[i].idMessage + '"><a class="accordion-toggle" href="#tools'  + element.messages[i].idMessage + '" data-parent="#selector" data-toggle="collapse">';
                $message += '<div class="dateMessage" id="'+element.messages[i].dateActiviteMsg+'">'+ calculDate(element.messages[i].dateActiviteMsg) +'</div>';
                $message += '<div class="nomUser">'+ element.messages[i].loginUser +'</div>';
                $message += '<div class="lblMessage">'+ element.messages[i].lblMessage +'</div>';
            $message += '</a></div>';
            
             $message += '<div class="collapse navbar-inner tools" id="tools' + element.messages[i].idMessage + '"><ul>';
                $message += '<li> <a id="lienModal'+element.messages[i].idMessage+'" href="'+element.messages[i].idMessage+'" data-toggle="modal" href="#details"><i class="icon-edit icon-white" ></i></a> </li>';
                $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-thumbs-up icon-white"></i>'+element.messages[i].like+'</a> </li>';
                $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-thumbs-down icon-white"></i>'+element.messages[i].dislike+'</a> </li>';
                $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-share icon-white"></i></a> </li>';           
                $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-remove icon-white"></i></a> </li>';    
            $message += '</ul></div>';
     $message += '</div>';   


            
        
//        $message += '<div class="accordion-group accordion-heading" id="' + element.messages[i].idMessage + '">';
//            $message += '<a class="accordion-toggle" data-toggle="modal" href="#details" data-parent=".monaccordeon" data-toggle="collapse">';
//                $message += '<div class="row-fluid">';
//                    $message += '<div class="span12">'; 
//                        if( element.messages[i].idProfil != null) {$message += '<img class="vip"  src="../images/vip.gif"/>';}
//                        $message += '<div class="avatar">' + gravatar(element.messages[i].emailMD5) + '</div>';
//                        $message += '<div class="nomUser">'+element.messages[i].loginUser +'</div>';
//                        $message += '<div class="dateMessage" id="'+element.messages[i].dateActiviteMsg+'">'+ calculDate(element.messages[i].dateActiviteMsg) +'</div><br/>';
//                        $message += '<div class="lblMessage">'+ element.messages[i].lblMessage +'</div>';
//                    $message += '</div>';  
//                $message += '</div>';
//            $message += '</a>';
//            $message += '<div class="menu"><ul>'
//            $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-thumbs-up"></i>'+element.messages[i].like+'</a> </li>';
//            $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-thumbs-down"></i>'+element.messages[i].dislike+'</a> </li>';
//            $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class=""></i>Publier</a> </li>';           
//            $message += '<li> <a href="'+element.messages[i].idMessage+'"><i class=""></i>Modérer</a> </li>';    
//            $message += '</ul></div>'            
//        $message += '</div>';
$(".container-fluid").append($message);

$("#lienModal"+element.messages[i].idMessage).on("click", function(){
    //$("#waitGif" + this.id).show();
    //chargerReponses(this.id);
    $("#messParent").empty();
    $("#messReponse").empty();
    $("#messMenu").empty();
    $("#waitGifDetails").show();
    //Duplication du noeud du message
    var nouveau = this.cloneNode(true);
    //Ajout du nouveau noeud
    $("#messParent").append(nouveau);
    //chargment des réponses du noeud
    chargerReponses(this.id);
})
$message = '';

}
 $("#waitGif").hide();
}    

function creeHtmlReponses(element, numMessage){
    $reponse = '';
    for (var i = 0; i<element.reponses.length; i++){

        $reponse += '<div class="monaccordeonRep">';
            $reponse += '<div class="accordion-group">';
                $reponse += '<div class="accordion-heading" id="' + element.reponses[i].idMessage + '">';
                        $reponse += '<div class="row-fluid">';
                            $reponse += '<div class="span12">';
                                if( element.reponses[i].idProfil != null) {$reponse += '<img class="vip"  src="../images/vip.gif"/>';}
                                $reponse += '<div class="avatar">' + gravatar(element.reponses[i].emailMD5) + '</div>';
                                $reponse += '<div class="nomUser">'+element.reponses[i].loginUser +'</div>';
                                $reponse += '<div class="dateMessage" id="'+element.reponses[i].dateActiviteMsg+'">'+ calculDate(element.reponses[i].dateActiviteMsg) +'</div><br/>';
                                $reponse += '<div class="lblMessage">'+ element.reponses[i].lblMessage +'</div>';
                            $reponse += '</div>';  
                        $reponse += '</div>';
                $reponse += '</div>';
            $reponse += '</div>';
        $reponse +='</div>';
    //$("#reponses"+ numMessage).append($reponse);
    //$reponse ='';    
    }
    //$("#messReponse").empty();
    $("#messReponse").append($reponse);
    
$formulaire =  '<form class="form-vertical" enctype="application/x-www-form-urlencoded" method="post" action="envoyer"><fieldset>';
    $formulaire += '<input type="hidden" name="IdMessageParent" value="' + numMessage + '" id="IdMessageParent" />';
    $formulaire += '<div class="control-group"><div class="controls">';
    $formulaire += '<input type="text" name="message" id="message" value="" placeholder="Votre message" /></div></div>';
    $formulaire += '<div class="form-actions">';
    $formulaire += '<input type="submit" name="envoyer" id="envoyer" value="envoyer" style="display:none" class="btn btn-primary" /></div></fieldset>';
$formulaire += '</form>';

$("#messMenu").append($formulaire);
$formulaire = '';
    $("#waitGifDetails").hide();
}

//Fonction de parcours des éléments data retournés
function parseJSON(data){
    $(data).each(function(i){
        creeHtmlMessage(this);
    });
}

//Fonction de parcours des éléments data retournés
function parseJSONReponse(data, numMessage){
    $(data).each(function(i){
        creeHtmlReponses(this, numMessage);
    });
}

//Requête Ajax 
//Retourne les x messages suivant par rapport à une date
//IMPORTANT : Cette fonction est utilisée pour afficher les messages
//lors du premier chargement de la page
function chargerMessagesSuivant(){
    if(dateProchaine==null){dateProchaine = new Date().getTime();
        dateProchaine = Math.floor(dateProchaine/1000);
        }
     $.ajax({
            type: "GET",
            url: BASE_URL + "/message/lister-tous/fromdate/" + dateProchaine + "?format=json" ,
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Erreur !: " + string );
            },

            success:function(data){
                //traitement du json pour créer l'HTML
                console.log(data);
                parseJSON(data);                
            }
     })
}

function chargerReponses(numMessage){
    $("#reponses" + numMessage).empty();
    dateProchaineReponse = new Date().getTime();
    dateProchaineReponse = Math.floor(dateProchaineReponse/1000);
    $.ajax({
            type: "GET",
            url: BASE_URL + "/message/reponses/message/" + numMessage + "/fromdate/"+ dateProchaineReponse +"?format=json" ,
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Erreur !: " + string );
            },

            success:function(data){
                console.log(data);
                //traitement du json pour créer l'HTML
                parseJSONReponse(data,numMessage);
                
            }
        });
}



//Appel de la fonction lors du premier chargement des messages
chargerMessagesSuivant();

//Au chargement du document
$(document).ready(function() {
    //Lors du click sur le lien "Plus..."
    //Appel de la fonction pour charger les x messages suivant
    $("#chargerPlusMessage").click(function(){
        $("#waitGif").show();
        chargerMessagesSuivant();
    })
    //Lors du click sur le lien "Plus..."
    //Appel de la fonction pour charger les x messages suivant
    $("#btn_maj").click(function(){
        dateProchaine = null;
        /*$(".container-fluid").empty();
        $("#waitGif").show();
        chargerMessagesSuivant();*/
        location.reload() ;
    })
    
    $("#message").keydown(function(){
        if (event.keyCode == 13) {}
    })   
    autoDate();
})


