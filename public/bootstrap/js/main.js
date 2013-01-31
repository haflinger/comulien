$(document).ready(function() {
//au click sur le lien chercher
$("#nomEvent").click(function(){
//on recupere la valeur de l'attribut name pour afficher tel ou tel resultat
//requête ajax, appel du fichier recherche.php
$.ajax({
type: "GET",
url: BASE_URL + "/evenement/accueil",
dataType : "html",
//affichage de l'erreur en cas de problème
error:function(msg, string){
alert( "Error !: " + string );
},
success:function(data){
//alert(data);
//on met à jour le div zone_de_rechargement avec les données reçus
//on vide la div et on le cache
$("#detailsEvent").empty().hide();
//on affecte les resultats au div
$("#detailsEvent").append(data);
//on affiche les resultats avec la transition
$('#detailsEvent').fadeIn(500);
}
});
});
})


