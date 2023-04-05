<?php
  include 'Classes/conexao.class.php';

  class Menu{
    
    public function listaMenu(){

      $conexao = new conexao_class();
      $banco = $conexao->conexaoBanco();
      $sql = 'SELECT acao, texto FROM Menu';
      $query = $banco->prepare($sql);
      $query->execute(); 
      
      echo '<ol>';
      foreach($query->fetchAll() as $item){
        echo '<li><a href='.$item[0].'>'.$item[1].'</li>';
      }
      echo '</ol>';
    }

    public function listaComando(){

      $conexao = new conexao_class();
      $banco = $conexao->conexaoBanco();

      $query_string = $_SERVER['QUERY_STRING'];

      if ($query_string == 'pagina=lista_pessoa'){
        $sqlpessoa = 'SELECT id, nome, email FROM pessoa';
        $querypessoa = $banco->prepare($sqlpessoa);
        $querypessoa->execute();

        echo '<ol>';
        foreach($querypessoa->fetchAll() as $itempessoa){
          echo '<li>'.$itempessoa[1].' '.$itempessoa[2].'</li>';
        }
        echo '</ol>';
      } else if ($query_string == 'pagina=lista_produto'){
          $sqlproduto= 'SELECT id, nome, valor, total_estoque FROM produto';
          $queryproduto = $banco->prepare($sqlproduto);
          $queryproduto->execute();

          echo '<ol>';
          foreach($queryproduto->fetchAll() as $itemproduto){
            echo '<li>'.$itemproduto[1].' '.$itemproduto[2].' '.$itemproduto[3].'</li>';
          }
          echo '</ol>';
      } else if ($query_string == 'pagina=lista_usuario'){
          $sqlusuario= 'SELECT id, nome, email, senha FROM usuario';
          $queryusuario = $banco->prepare($sqlusuario);
          $queryusuario->execute();

          echo '<ol>';
          foreach($queryusuario->fetchAll() as $itemusuario){
            echo '<li>'.$itemusuario[1].' '.$itemusuario[2].' '.$itemusuario[3].'</li>';
          }
          echo '</ol>';
      }
    }
  }

?>