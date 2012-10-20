<?php
class Login extends AController{
    function GET($matches){
        echo '..............................................';
        if(file_exists("view/" .strtolower(get_class($this)) ."php")){
            //header('Location: '. "view/" .strtolower(get_class($this)) .".php");
            //include_once("view/" .strtolower(get_class($this)) .".php");
        }elseif(file_exists("view/" .strtolower($matches[1]) .".php")){
            //header('Location: '. "view/" .strtolower($matches[1]) .".php");
            //include_once("view/" .strtolower($matches[1]) .".php");
        }else{
            //when inside the browser, redirect to our 404
            //echo "<script>location = '" . Config::$HOSTNAME . Config::$SUBDIR . "404';</script>";
            //throw new Exception("Page not found.", 404);
        }
    }

    function PUT($matches){
        throw new Exception("Don't PUT this resource. You're probably trying something nasty.");
    }

    function DELETE($matches){
        throw new Exception("Don't DELETE this resource. You're probably trying something nasty.");
    }

    function POST($matches){
        throw new Exception("Don't POST this resource. You're probably trying something nasty.");
    }
}
