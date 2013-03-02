<<<<<<< HEAD
var paginationMessage = 1;
$(document).ready(function() {
    
    //au click sur le message
    $(".chargerPlusMessage").click(function(){
        paginationMessage ++;
        console.log(paginationMessage);
        $.ajax({
            type: "GET",
            url: BASE_URL + "/message/lister-tous/numpage/"+ paginationMessage + "?format=json" ,
            dataType : "json",
            //affichage de l'erreur en cas de problème
            error:function(string){
                alert( "Erreur !: " + string );
            },

            success:function(data){
                //traitement du json pour créer l'HTML
                //console.log(data);
                parseJSON(data);                
            }
            
        });return false;
    });
    
    var parseJSON = function(data){
        $(data).each(function(i){
            creeHTML(this);
        });
    }
    
var creeHTML = function(element){
=======
//@auteurs Fred H & AlexSolex

//Variable globale permettant de conserver la date des prochain messages à afficher 
var dateProchaine = null;
var dateProchaineReponse = null;

//Fonction de cryptage en MD5 - crypter les addresses email des utilisateurs pour gravatar
var MD5=function(s){function L(k,d){return(k<<d)|(k>>>(32-d))}function K(G,k){var I,d,F,H,x;F=(G&2147483648);H=(k&2147483648);I=(G&1073741824);d=(k&1073741824);x=(G&1073741823)+(k&1073741823);if(I&d){return(x^2147483648^F^H)}if(I|d){if(x&1073741824){return(x^3221225472^F^H)}else{return(x^1073741824^F^H)}}else{return(x^F^H)}}function r(d,F,k){return(d&F)|((~d)&k)}function q(d,F,k){return(d&k)|(F&(~k))}function p(d,F,k){return(d^F^k)}function n(d,F,k){return(F^(d|(~k)))}function u(G,F,aa,Z,k,H,I){G=K(G,K(K(r(F,aa,Z),k),I));return K(L(G,H),F)}function f(G,F,aa,Z,k,H,I){G=K(G,K(K(q(F,aa,Z),k),I));return K(L(G,H),F)}function D(G,F,aa,Z,k,H,I){G=K(G,K(K(p(F,aa,Z),k),I));return K(L(G,H),F)}function t(G,F,aa,Z,k,H,I){G=K(G,K(K(n(F,aa,Z),k),I));return K(L(G,H),F)}function e(G){var Z;var F=G.length;var x=F+8;var k=(x-(x%64))/64;var I=(k+1)*16;var aa=Array(I-1);var d=0;var H=0;while(H<F){Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=(aa[Z]|(G.charCodeAt(H)<<d));H++}Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=aa[Z]|(128<<d);aa[I-2]=F<<3;aa[I-1]=F>>>29;return aa}function B(x){var k="",F="",G,d;for(d=0;d<=3;d++){G=(x>>>(d*8))&255;F="0"+G.toString(16);k=k+F.substr(F.length-2,2)}return k}function J(k){k=k.replace(/rn/g,"n");var d="";for(var F=0;F<k.length;F++){var x=k.charCodeAt(F);if(x<128){d+=String.fromCharCode(x)}else{if((x>127)&&(x<2048)){d+=String.fromCharCode((x>>6)|192);d+=String.fromCharCode((x&63)|128)}else{d+=String.fromCharCode((x>>12)|224);d+=String.fromCharCode(((x>>6)&63)|128);d+=String.fromCharCode((x&63)|128)}}}return d}var C=Array();var P,h,E,v,g,Y,X,W,V;var S=7,Q=12,N=17,M=22;var A=5,z=9,y=14,w=20;var o=4,m=11,l=16,j=23;var U=6,T=10,R=15,O=21;s=J(s);C=e(s);Y=1732584193;X=4023233417;W=2562383102;V=271733878;for(P=0;P<C.length;P+=16){h=Y;E=X;v=W;g=V;Y=u(Y,X,W,V,C[P+0],S,3614090360);V=u(V,Y,X,W,C[P+1],Q,3905402710);W=u(W,V,Y,X,C[P+2],N,606105819);X=u(X,W,V,Y,C[P+3],M,3250441966);Y=u(Y,X,W,V,C[P+4],S,4118548399);V=u(V,Y,X,W,C[P+5],Q,1200080426);W=u(W,V,Y,X,C[P+6],N,2821735955);X=u(X,W,V,Y,C[P+7],M,4249261313);Y=u(Y,X,W,V,C[P+8],S,1770035416);V=u(V,Y,X,W,C[P+9],Q,2336552879);W=u(W,V,Y,X,C[P+10],N,4294925233);X=u(X,W,V,Y,C[P+11],M,2304563134);Y=u(Y,X,W,V,C[P+12],S,1804603682);V=u(V,Y,X,W,C[P+13],Q,4254626195);W=u(W,V,Y,X,C[P+14],N,2792965006);X=u(X,W,V,Y,C[P+15],M,1236535329);Y=f(Y,X,W,V,C[P+1],A,4129170786);V=f(V,Y,X,W,C[P+6],z,3225465664);W=f(W,V,Y,X,C[P+11],y,643717713);X=f(X,W,V,Y,C[P+0],w,3921069994);Y=f(Y,X,W,V,C[P+5],A,3593408605);V=f(V,Y,X,W,C[P+10],z,38016083);W=f(W,V,Y,X,C[P+15],y,3634488961);X=f(X,W,V,Y,C[P+4],w,3889429448);Y=f(Y,X,W,V,C[P+9],A,568446438);V=f(V,Y,X,W,C[P+14],z,3275163606);W=f(W,V,Y,X,C[P+3],y,4107603335);X=f(X,W,V,Y,C[P+8],w,1163531501);Y=f(Y,X,W,V,C[P+13],A,2850285829);V=f(V,Y,X,W,C[P+2],z,4243563512);W=f(W,V,Y,X,C[P+7],y,1735328473);X=f(X,W,V,Y,C[P+12],w,2368359562);Y=D(Y,X,W,V,C[P+5],o,4294588738);V=D(V,Y,X,W,C[P+8],m,2272392833);W=D(W,V,Y,X,C[P+11],l,1839030562);X=D(X,W,V,Y,C[P+14],j,4259657740);Y=D(Y,X,W,V,C[P+1],o,2763975236);V=D(V,Y,X,W,C[P+4],m,1272893353);W=D(W,V,Y,X,C[P+7],l,4139469664);X=D(X,W,V,Y,C[P+10],j,3200236656);Y=D(Y,X,W,V,C[P+13],o,681279174);V=D(V,Y,X,W,C[P+0],m,3936430074);W=D(W,V,Y,X,C[P+3],l,3572445317);X=D(X,W,V,Y,C[P+6],j,76029189);Y=D(Y,X,W,V,C[P+9],o,3654602809);V=D(V,Y,X,W,C[P+12],m,3873151461);W=D(W,V,Y,X,C[P+15],l,530742520);X=D(X,W,V,Y,C[P+2],j,3299628645);Y=t(Y,X,W,V,C[P+0],U,4096336452);V=t(V,Y,X,W,C[P+7],T,1126891415);W=t(W,V,Y,X,C[P+14],R,2878612391);X=t(X,W,V,Y,C[P+5],O,4237533241);Y=t(Y,X,W,V,C[P+12],U,1700485571);V=t(V,Y,X,W,C[P+3],T,2399980690);W=t(W,V,Y,X,C[P+10],R,4293915773);X=t(X,W,V,Y,C[P+1],O,2240044497);Y=t(Y,X,W,V,C[P+8],U,1873313359);V=t(V,Y,X,W,C[P+15],T,4264355552);W=t(W,V,Y,X,C[P+6],R,2734768916);X=t(X,W,V,Y,C[P+13],O,1309151649);Y=t(Y,X,W,V,C[P+4],U,4149444226);V=t(V,Y,X,W,C[P+11],T,3174756917);W=t(W,V,Y,X,C[P+2],R,718787259);X=t(X,W,V,Y,C[P+9],O,3951481745);Y=K(Y,h);X=K(X,E);W=K(W,v);V=K(V,g)}var i=B(Y)+B(X)+B(W)+B(V);return i.toLowerCase()};

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
    return '<img src="http://www.gravatar.com/avatar/' + MD5(email) + '.jpg?&d=mm&r=g&s=40"/>';
}

//Ajout des balise HTML - Mise en forme du message
function creeHtmlMessage(element){
dateProchaine = element.dateProchaine;
>>>>>>> fd7af3b9fcba7285303991ddca145725af0fe988
$message = '';
for (var i = 0; i<element.messages.length; i++){

    $message += '<div class="monaccordeon">';
        $message += '<div class="accordion-group">';
            $message += '<div class="accordion-heading" id="' + element.messages[i].idMessage + '"> <a class="accordion-toggle" href="#menu' + element.messages[i].idMessage + '" data-parent=".monaccordeon" data-toggle="collapse">';
<<<<<<< HEAD
                $message += '<div class="rep'+element.messages[i].idMessage+'">';
                    $message += '<div class="row-fluid">';
                        $message += '<div class="span12">';  
                            $message += '<div class="avatar">'+ element.messages[i].emailUser+'</div>';
                            $message += '<div class="nomUser">'+element.messages[i].loginUser +'</div>';
                            $message += '<div class="dateMessage">'+element.messages[i].dateActiviteMsg +'</div><br/>';
                            $message += '<div class="lblMessage">'+ element.messages[i].lblMessage +'</div>';
                        $message += '</div>';  
                    $message += '</div>';
=======
                $message += '<div class="row-fluid">';
                    $message += '<div class="span12">'; 
                        if( element.messages[i].idProfil != null) {$message += '<img class="vip"  src="../images/vip.gif"/>';}
                        $message += '<div class="avatar">' + gravatar(element.messages[i].emailUser) + '</div>';
                        $message += '<div class="nomUser">'+element.messages[i].loginUser +'</div>';
                        $message += '<div class="dateMessage" id="'+element.messages[i].dateActiviteMsg+'">'+ calculDate(element.messages[i].dateActiviteMsg) +'</div><br/>';
                        
                        $message += '<div class="lblMessage">'+ element.messages[i].lblMessage +'</div>';
                    $message += '</div>';  
>>>>>>> fd7af3b9fcba7285303991ddca145725af0fe988
                $message += '</div>';
            $message += '</a></div>';
        $message += '</div>';
        $message += '<div id="menu'+element.messages[i].idMessage+'" class="collapse menuMessage">';
            $message += '<div id="monaccordeonMenu">';
                $message += '<nav class="navbar">';
                    $message += '<div class="navbar-inner">';
                        $message += '<div class="container">';
<<<<<<< HEAD
                            $message += '<ul class="nav">';
                                $message += '<li class="divider-vertical"></li>';
                                $message +='<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-thumbs-up"></i>'+element.messages[i].like+'</a> </li>';
                                $message +='<li class="divider-vertical"></li>';
                                $message +='<li> <a href="'+element.messages[i].idMessage+'"><i class="icon-thumbs-down"></i>'+element.messages[i].dislike+'</a> </li>';
                            $message +='</ul>';
                        $message +='</div>';
                    $message +='</div>';
                $message +='</nav>'; 
            $message +='</div><!--monaccordeonMenu-->';
    $message +='</div>';
$message +='</div>';
}
$(".container-fluid").append($message);
$(".container-fluid").show();
}
    
    
=======
                                $message += '<div class="container-header">';
                                    $message += '<div class="saisieMessage">';
                                        $message += '<form class="form-vertical" enctype="application/x-www-form-urlencoded" method="post" action="envoyer">';
                                        $message += '<input type="hidden" name="IdMessageParent" value="'+element.messages[i].idMessage+'" id="IdMessageParent" />';
                                        $message += '<input type="text" name="message" id="message" placeholder="Votre message"/>'; 
                                        $message += '<input type="submit" name="envoyer" id="envoyer" value="Envoyer" style="display:none" class="btn btn-primary" />';
                                        $message += '</form>';
                                    $message += '</div>';
                                $message += '</div>';
                        $message +='</div>';
                    $message +='</div>';
                $message +='</nav>';
                $message +='<div class="container-reponse" id="reponses'+element.messages[i].idMessage+'">';
                $message +='</div>';
            $message +='</div><!--monaccordeonMenu-->';
    $message +='</div>';
    $message +='<div class="waitGif" id="waitGif'+element.messages[i].idMessage+'" style="display:none"><img id="attente" src="'+BASE_URL+'/images/attente.gif"/></div>';
$message +='</div>';

$(".container-fluid").append($message);

$(document).on("click", "#"+ element.messages[i].idMessage, function(){
    //$("#waitGif" + this.id).show();
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
                    $reponse += '<div class="rep">';
                        $reponse += '<div class="row-fluid">';
                            $reponse += '<div class="span12">';
                                if( element.reponses[i].idProfil != null) {$reponse += '<img class="vip"  src="../images/vip.gif"/>';}
                                $reponse += '<div class="avatar">' + gravatar(element.reponses[i].emailUser) + '</div>';
                                $reponse += '<div class="nomUser">'+element.reponses[i].loginUser +'</div>';
                                $reponse += '<div class="dateMessage" id="'+element.reponses[i].dateActiviteMsg+'">'+ calculDate(element.reponses[i].dateActiviteMsg) +'</div><br/>';
                                $reponse += '<div class="lblMessage">'+ element.reponses[i].lblMessage +'</div>';
                            $reponse += '</div>';  
                        $reponse += '</div>';
                    $reponse += '</div>';
                $reponse += '</div>';
            $reponse += '</div>';
        $reponse +='</div>';
    $("#reponses"+ numMessage).append($reponse);
    $reponse ='';    
    }

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
    dateProchaineReponse = Math.floor(dateProchaineReponse/1000);;
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
>>>>>>> fd7af3b9fcba7285303991ddca145725af0fe988
    
    
})


