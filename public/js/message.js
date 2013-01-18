var menuOuvert = null;
function afficher_cacher(id)
{
        if(document.getElementById(id).style.display=="none")
        {
                if(menuOuvert != null){
                    document.getElementById(menuOuvert).style.display="none";
                }
                document.getElementById(id).style.display="";
                menuOuvert = id;
        }
        else
        {
                document.getElementById(id).style.display="none";
        }
        return true;
}

