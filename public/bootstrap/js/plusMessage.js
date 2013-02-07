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
})

var parseJSON = function(data){
        $(data).each(function(i){
            creeHTML(this);
        });
    }
    
    var creeHTML = function(element){
        $message = '';
        for (var i = 0; i<element.messages.length; i++){
                  
            $message += '<div class="monaccordeon">';
                $message += '<div class="accordion-group">';
                    $message += '<div class="accordion-heading" id="' + element.messages[i].idMessage + '"> <a class="accordion-toggle" href="#menu' + element.messages[i].idMessage + '" data-parent=".monaccordeon" data-toggle="collapse">';
                        $message += '<div class="rep'+element.messages[i].idMessage+'">';
                            $message += '<div class="row-fluid">';
                                $message += '<div class="span12">';  
                                    $message += '<div class="avatar">'+ element.messages[i].emailUser+'</div>';
                                    $message += '<div class="nomUser">'+element.messages[i].loginUser +'</div>';
                                    $message += '<div class="dateMessage">'+element.messages[i].dateActiviteMsg +'</div><br/>';
                                    $message += '<div class="lblMessage">'+ element.messages[i].lblMessage +'</div>';
                                $message += '</div>';  
                            $message += '</div>';
                        $message += '</div>';
                    $message += '</a></div>';
                $message += '</div>';
                $message += '<div id="menu'+element.messages[i].idMessage+'" class="collapse menuMessage">';
                    $message += '<div id="monaccordeonMenu">';
                        $message += '<nav class="navbar">';
                            $message += '<div class="navbar-inner">';
                                $message += '<div class="container">';
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
