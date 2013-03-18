//@auteurs Fred H & AlexSolex

//Variable globale permettant de conserver la date des prochain messages à afficher 
var dateProchaine = null;
var dateProchaineReponse = null;
var dateDernierMessage = null;
//Fonction qui calcul le total des likes
function totalLike(like, unlike){
    return parseInt(like) - parseInt(unlike);
}
//Fonction qui retourne la date(timestamp) au format dd/mm/YYYY
function miseFormeDate(dateMessage){
    var d = new Date(dateMessage*1000);
    return d.toLocaleDateString();
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

//fonction de calcul des delais des messages
function calculDelais(){
    setInterval(function(){
         $(".dateMessage").each(function(){
            delai = calculDate(this.id);
            this.innerHTML= ' ' + delai;
        })
        nbrMessagesRecent();
    }, 60000);
}

//function de recherche du nombre de nouveau messages
//Depuis la dernière recherche
function nbrMessagesRecent(){
    if(dateDernierMessage==null){dateDernierMessage = new Date().getTime();
        dateDernierMessage = Math.floor(dateDernierMessage/1000);
        }
     $.ajax({
            type: "GET",
            url: BASE_URL + "/message/compter/fromdate/" + dateDernierMessage + "?format=json" ,
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
               
            },

            success:function(data){
                //traitement du json pour créer l'HTML
                //console.log(data.nbMessages);
                console.log(data.nbMessages);
                //parseJSON(data)
                console.log(dateDernierMessage);
                
                var nbr = data.nbMessages>0 ? data.nbMessages : '';
                $("#nbrMessageRecent").html(nbr);
            }
     })
}

//Fonction de création du lien gravatar
function gravatar(email){
    return '<img alt="Avatar" src="http://www.gravatar.com/avatar/' + email + '.jpg?&d=mm&r=g&s=40"/>';
}

//Requête Ajax pour liker un message
function likeMessage(event){
    $.ajax({
            type: "GET",
            url: BASE_URL + '/message/approuver/message/'+event.data.id+'/appreciation/'+event.data.val+'?format=json' ,
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
               alert( "Erreur !: " + string );
            },
            success:function(data){
                console.log(data);
                $('#totalLike' + event.data.id).html(data.noteGlobale);
                $('#like' + event.data.id).html(data.like);
                $('#dislike' + event.data.id).html(data.dislike);
            }
     })
}

//Requête Ajax pour liker un message
function modererMessage(event){
    $.ajax({
            type: "POST",
            url: BASE_URL + '/message/moderer' ,
            data: {hiddenIdMessage: event.data.id,format:'json'},
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
               alert( "Erreur !: " + string );
            },

            success:function(){
                        console.log($('texte' +event.data.id));                     
                        if($('#texte' +event.data.id).hasClass('modere')){
                            $('#texte' +event.data.id + ' > .inactif').remove();
                        }else
                        {
                            $('<div>',{
                                'class': 'inactif'
                            }).prependTo($('#texte' + event.data.id));
                            
                        }
                        $('#texte' +event.data.id).toggleClass('modere');      
            }
     })
}
//Ajout des balise HTML - Mise en forme du message
function creeHtmlMessage(element){
dateProchaine = element.dateProchaine;
$message = '';
$formulaire = '';
for (var i = 0; i<element.messages.length; i++){

    var accordion = $("<div/>", {
    "class": "accordion-group accordion",  
    id: "selector"
    }).appendTo( "#selector" );

        var user = $('<div>', {
        'class': 'user'
        }).appendTo(accordion);

            var avatar = $('<div>', {
            'class': 'avatar'
            }).appendTo(user);
        
            $(gravatar(element.messages[i].emailMD5)).appendTo(avatar);
            
        var texteMessage = $('<div>', {
         id : 'texte' + element.messages[i].idMessage,
        'class': 'texteMessage accordion-heading'
        }).appendTo(accordion);
        //Test si le message à été modéré ou non
        if(element.messages[i].idUser_moderer != null){
            texteMessage.addClass('modere');
            $('<div>',{
                'class': 'inactif'
            }).appendTo(texteMessage);
        }else
        {
            texteMessage.removeClass('modere');
        }
            var contenu = $('<a>', {
            'class': 'accordion-toggle',
            href : '#tools'  + element.messages[i].idMessage,
            'data-parent' : '#selector',
            'data-toggle' : 'collapse'
            }).appendTo(texteMessage);
        
            $('<div>', {
            'class': 'dateEmission',
            text : miseFormeDate(element.messages[i].dateEmissionMsg)
            }).appendTo(contenu);
        
            $('<div>', {
            'class': 'nomUser',
            text : element.messages[i].loginUser
            }).appendTo(contenu);
        
            $('<hr>', {
            }).appendTo(contenu);
        
            $('<div>', {
            'class': 'lblMessage',
            text : element.messages[i].lblMessage
            }).appendTo(contenu);
            
            $('<div>', {
            id : element.messages[i].dateActiviteMsg,
            'class': 'dateMessage',
            text : ' ' + calculDate(element.messages[i].dateActiviteMsg)
            }).appendTo(contenu);
            
            $('<img>',{
                id: 'clock',
                src: BASE_URL + '/images/clock.PNG'
            }).appendTo(contenu);
            
           /* $('<i>', {
                id : 'totalLike',
                'class': 'icon-thumbs-up'    
                }).appendTo(contenu);
                
            var total = $('<div>', {
            id: 'totalLike' + element.messages[i].idMessage,
            'class': 'totalLike',
            text : totalLike(element.messages[i].like, element.messages[i].dislike)
            }).appendTo(contenu);*/
            
            $('<div>', {
            id : 'bulle' + element.messages[i].idMessage,
            'class': 'bulle',
            text : element.messages[i].NbReponse
            }).appendTo(contenu);    
                
                
        var nav = $('<div>', {
         id : 'tools' + element.messages[i].idMessage,
        'class': 'collapse navbar-inner tools'
        }).appendTo(accordion);
        
            var liste = $('<ul>', {
            }).appendTo(nav);
            
                var lienModal = $('<li>', {
                }).appendTo(liste);
                
                     var modal = $('<a>', {
                     id : element.messages[i].idMessage,
                     'class': 'lienModal'+element.messages[i].idMessage,
                     href : '#details',
                     "data-toggle":'modal'
                     }).appendTo(lienModal);
                        
                        modal.append($('<img>',{
                            id: 'repondre',
                            src: BASE_URL + '/images/repondre.png'
                        }));
                        
                        modal.click(function(){
                            $("#messParent").empty();
                            $("#messReponse").empty();
                            $("#messMenu").empty();
                            $("#waitGifDetails").show();
                            //Ajout du noeud parent
                            //console.log($(this));
                            $(this).parent().parent().parent().parent().clone().appendTo("#messParent");
                            chargerReponses(this.id);
                        })
                     
                var l2 = $('<li>', {
                }).appendTo(liste);
                
                     var modal2 = $('<a>', {
                     id : 'like' + element.messages[i].idMessage,
                     text : element.messages[i].like
                     }).appendTo(l2);
                     
                        modal2.before($('<img>',{
                            id: 'like',
                            src: BASE_URL + '/images/like.png'
                        })
                        ); 
                        
                        l2.click({id: element.messages[i].idMessage, val: '1'},likeMessage);
                
                var l3 = $('<li>', {
                }).appendTo(liste);
                
                     var modal3 = $('<a>', {
                     id : 'dislike' + element.messages[i].idMessage,
                     text : element.messages[i].dislike
                     }).appendTo(l3);
                     
                        modal3.before($('<img>',{
                            id: 'dislike',
                            src: BASE_URL + '/images/dislike.png'
                        })
                        );
                
                        l3.click({id: element.messages[i].idMessage, val: '-1'},likeMessage);
                        
                var l4 = $('<li>', {
                }).appendTo(liste);
                
                     var modal4 = $('<a>', {
                     }).appendTo(l4);
                     
                        modal4.before($('<img>',{
                            id: 'partager',
                            src: BASE_URL + '/images/partager.png'
                        })
                        );
                
                if(element.moderateur){
                    var l5 = $('<li>', {
                    }).appendTo(liste);
                
                     var modal5 = $('<a>', {
                     }).appendTo(l5);
                     
                        modal5.before($('<img>',{
                            id: 'moderer',
                            src: BASE_URL + '/images/moderer.png'
                        })
                        );
                        l5.click({id: element.messages[i].idMessage}, modererMessage);
                }   
                
}

 $("#waitGif").hide();
 
}    

function creeHtmlReponses(element, numMessage){
    for (var i = 0; i<element.reponses.length; i++){
            var accordion = $("<div/>", {
            "class": "accordion-group accordion"  
            }).appendTo( "#messReponse" );

                var user = $('<div>', {
                'class': 'user'
                }).appendTo(accordion);

                    var avatar = $('<div>', {
                    'class': 'avatar'
                    }).appendTo(user);

                    $(gravatar(element.reponses[i].emailMD5)).appendTo(avatar);

                var texteMessage = $('<div>', {
                 id : element.reponses[i].idMessage,
                'class': 'texteMessage accordion-heading'
                }).appendTo(accordion);

                    var contenu = $('<a>', {
                    'class': 'accordion-toggle',
                    href : '#tools'  + element.reponses[i].idMessage,
                    'data-parent' : '#messReponse',
                    'data-toggle' : 'collapse'
                    }).appendTo(texteMessage);

                    $('<div>', {
                    id : element.reponses[i].dateActiviteMsg,
                    'class': 'dateMessage',
                    text : calculDate(element.reponses[i].dateActiviteMsg)
                    }).appendTo(contenu);

                    $('<div>', {
                    'class': 'nomUser',
                    text : element.reponses[i].loginUser
                    }).appendTo(contenu);

                    $('<hr>', {
                    }).appendTo(contenu);

                    $('<div>', {
                    'class': 'lblMessage',
                    text : element.reponses[i].lblMessage
                    }).appendTo(contenu);                    

                    /*var total = $('<div>', {
                    'class': 'totalLike',
                    text : totalLike(element.reponses[i].like, element.reponses[i].dislike)
                    }).appendTo(contenu);
                        $('<i>', {
                        'class': 'icon-thumbs-up'    
                        }).appendTo(total);*/

                var nav = $('<div>', {
                 id : 'tools' + element.reponses[i].idMessage,
                'class': 'collapse navbar-inner tools'
                }).appendTo(accordion);

                    var liste = $('<ul>', {
                    }).appendTo(nav);

                        var l2 = $('<li>', {
                        }).appendTo(liste);

                             var modal2 = $('<a>', {
                             text : element.reponses[i].like
                             }).appendTo(l2);

                                modal2.before($('<i>', {
                                'class': 'icon-thumbs-up icon-white'    
                                })
                                ); 


                        var l3 = $('<li>', {
                        }).appendTo(liste);

                             var modal3 = $('<a>', {
                             text : element.reponses[i].dislike
                             }).appendTo(l3);

                                modal3.before($('<i>', {
                                'class': 'icon-thumbs-down icon-white'    
                                })
                                );

                        var l4 = $('<li>', {
                        }).appendTo(liste);

                             var modal4 = $('<a>', {
                             }).appendTo(l4);

                                modal4.before($('<i>', {
                                'class': 'icon-share icon-white'    
                                })
                                );
                        
                        if(element.moderateur){
                            var l5 = $('<li>', {
                            }).appendTo(liste);

                                 var modal5 = $('<a>', {
                                 }).appendTo(l5);

                                    modal5.before($('<i>', {
                                    'class': 'icon-remove icon-white'    
                                    })
                                    );
                        }
    }
    
    
$formulaire =  '<form enctype="application/x-www-form-urlencoded" method="post" action="envoyer">';
    $formulaire += '<input type="hidden" name="IdMessageParent" value="' + numMessage + '" id="IdMessageParent" />';
    $formulaire += '<input type="text" name="message" id="message" value="" placeholder="Votre message" />';
    $formulaire += '<input type="submit" name="envoyer" id="envoyer" value="envoyer" style="display:none"/>';
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
    $("#plus").click(function(){
        $("#waitGif").show();
        chargerMessagesSuivant();
    })
    //Lors du click sur le lien "Plus..."
    //Appel de la fonction pour charger les x messages suivant
    $("#btn_maj").click(function(){
        $("#waitGif").show();
        dateProchaine = null;
        $(".container-fluid").empty();
        chargerMessagesSuivant();
    })
    
    $("#message").keydown(function(){
        if (event.keyCode == 13) {}
    })   
    
    //Calcul automatique des délais des message
    calculDelais()
    
})
