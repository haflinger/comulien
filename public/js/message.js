function afficher_cacher(id)
{
        if(document.getElementById(id).style.display=="none")
        {
                document.getElementById(id).style.display="";
        }
        else
        {
                document.getElementById(id).style.display="none";
        }
        return true;
}

