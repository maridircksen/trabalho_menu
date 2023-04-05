<?php

    spl_autoload_register(function($class) {
        $arquivo = $_SERVER["DOCUMENT_ROOT"]
        ."/TRABALHO_MENU/classes/". $class. ".class.php";
    
        if (file_exists($arquivo)) {
            require $arquivo;
        }
        
    });

?>