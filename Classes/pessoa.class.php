<?php

    include "autoload.php";

    class Pessoa {

        public function montarPagina(){

            $html = new Html('pt-br');

            $head = new Head();
            $html->addElemento($head);
            
            $head->addElemento(new Meta('UTF-8', null, null, null));
            $head->addElemento(new Meta(null, 'X-UA-Compatible', 'IE=edge', null));
            $head->addElemento(new Meta(null, null, 'width=device-width, initial-scale=1.0', 'viewport'));

            $title = new Title('Trabalho - Menu|Pessoa');
            $head->addElemento($title);
            
            $body = new Body();
            $html->addElemento($body);

            $head->addElemento(new Link ('https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css', 'stylesheet'));
            $head->addElemento(new Link ('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css', 'stylesheet>'));
            $head->addElemento(new Link ('estilo.css', 'stylesheet'));
            
            $body = new Body();
            $html->addElemento($body);

            $table = new Table();
            echo $table->ListarPessoa();
            $table->excluirPessoa();
            $table->alterarPessoa();
            $table->cadastrarPessoa();

            echo $html;
   
        }
    }

?>