<?php
  include 'classes/conexao.class.php';

  class Menu {
    public function listaMenu(){

      $conexao = new Conexao();
      $banco = $conexao->conexaoBanco();
      $sql = 'SELECT acao, texto FROM menu';
      $query = $banco->prepare($sql);
      $query->execute(); 
      
      echo '<nav class="navbar bg-danger">';
      foreach($query->fetchAll() as $item){
        echo '<a class="navbar-brand" style="color: white"  href="'.str_replace('?pagina=','',$item['acao']).'.php">'.$item['texto'].' </a>';
      }
      echo '</nav>';
    }

  

  }

?>
