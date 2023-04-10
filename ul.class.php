<?php
include_once "autoload.php";

    class Ul {
        private $listaElementos = [];
       
        function addElemento($elemento) {
            $this->listaElementos[] = $elemento;
        }
       
        function __toString() {
            $ul = "<ul>";
            foreach($this->listaElementos as $iListaElementos){
                $ul .= $iListaElementos;
            }
            $ul .= "</ul>";
            return $ul;
        }
    }