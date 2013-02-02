$(document).ready(function() {
//au click sur le lien evenement
$("#nomEvent").click(function(){
$.ajax({
type: "GET",
url: BASE_URL + "/evenement/accueil",
dataType : "html",
//affichage de l'erreur en cas de problème
error:function(string){
alert( "Error !: " + string );
},

success:function(data){
//on met à jour le div zone_de_rechargement avec les données reçus
//on vide la div et on le cache
$("#detailsEvent").empty().hide();
//on affecte les resultats au div
$("#detailsEvent").append(data);
//on affiche les resultats avec la transition
$('#detailsEvent').fadeIn(1000);
}
});
});
})


