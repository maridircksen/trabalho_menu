<?php

    include "autoload.php";

    class Home {

        public function montarPagina(){

            $html = new Html('pt-br');

            $head = new Head();
            $html->addElemento($head);
            
            $meta1 = new Meta('UTF-8', null, null, null);
            $meta2 = new Meta(null, 'X-UA-Compatible', 'IE=edge', null);
            $meta3 = new Meta(null, null, 'width=device-width, initial-scale=1.0', 'viewport');
            $head->addElemento($meta1);
            $head->addElemento($meta2);
            $head->addElemento($meta3);

            $title = new Title('Trabalho Mariana - Menu');
            $head->addElemento($title);

            $head->addElemento(new Link ('https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css', 'stylesheet'));

            $link2 = new Link ('./css/estilo.css', 'stylesheet');
            $head->addElemento($link2);

            $body = new Body();
            $html->addElemento($body);

            $menu = new Menu();
            $menu->listaMenu();
            //$menu -> listaComando();

           
            echo $html;
   
        }
    }

?>