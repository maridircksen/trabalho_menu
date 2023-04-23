<?php

include 'classes/conexao.class.php';

class Table {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function ListarPessoa() {
        $sqlpessoa = 'SELECT id, nome, email, datacadastro FROM pessoa';
        $querypessoa = $this->conexao->conexaoBanco()->prepare($sqlpessoa);
        $querypessoa->execute();

        $menu = '<table class="table">';
        $menu .= '<thead class="thead-light"><tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Data Cadastro</th><th>Ações</th><th><a class="btn btn-outline-dark" href="index.php" data-toggle="tooltip" title="Voltar ao menu inicial"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146ZM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5Z"/>
      </svg></a></th></tr></thead>';
        foreach($querypessoa->fetchAll() as $item) {
            $menu .= '<tr><td>' . $item[0] . '</td><td>' . $item[1] . '</td><td>' . $item[2] . '</td><td>' . $item[3] . '</td><td><a class="btn btn-outline-danger" href="?excluir=' . $item[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
          </svg>Excluir</a> <a class="btn btn-outline-primary" href="?alterar=' . $item[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg>Alterar</a></td></tr>';
        }
        $menu .= '</table><hr>';

        return $menu;
    }

    public function excluirPessoa() {
        if(isset($_GET['excluir'])) {
            $id = $_GET['excluir'];
            $sql = "DELETE FROM pessoa WHERE id = ?";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $excluido = $query->execute([$id]);

            header("Location: lista_pessoa.php");
            exit;
        }
    }

    public function alterarPessoa() {
        if(isset($_GET['alterar'])) {
            $id = $_GET['alterar'];
            $sql = "SELECT nome, email FROM pessoa WHERE id = ?";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $query->execute([$id]);
            $pessoa = $query->fetch();


            echo '<form method="post">';
            echo '<input class="caixa" style="color: black;" type="text" name="nome" value="' . $pessoa[0] . '">'. '&nbsp';
            echo '<br>';
            echo '<input class="caixa" style="color: black;" type="text" name="email" value="' . $pessoa[1] . '">' . '<br>';
            //echo '<input class="btn btn-warning" type="submit" name="alterar" value="Alterar">';
            echo '<button class="btn btn-warning" type="submit" name="alterar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          </svg> &nbsp Alterar Pessoa</button>';
           
            echo '</form>';
            echo '<hr>';

            if(isset($_POST['alterar'])) {
                $nome = $_POST['nome'];
                $email =  $_POST['email'];
                $sql = "UPDATE pessoa SET nome = ?, email = ? WHERE id = ?";
                $query = $this->conexao->conexaoBanco()->prepare($sql);
                $atualizado = $query->execute([$nome, $email, $id]);

                header("Location: lista_pessoa.php");
                exit;
                
            }
        }
    }

    public function cadastrarPessoa() {
        if(isset($_POST['cadastrar'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $datacadastro = $_POST['datacadastro'];
            $sql = "INSERT INTO pessoa (nome, email, datacadastro) VALUES (?, ?, ?)";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $cadastrado = $query->execute([$nome, $email, $datacadastro]);
    
            header("Location: lista_pessoa.php");
            exit;
        }
    
        echo '<h4>Cadastrar pessoa</h4>';
        echo '<form method="post">';
        echo '<input class="caixa" style="color: black;" type="text" name="nome" autocomplete="off" placeholder="Nome" required><br>';
        echo '<input class="caixa" style="color: black;" type="text" name="email" autocomplete="off" placeholder="Email" required><br>';
        echo '<input class="caixa" style="color: black;" type="datetime-local" name="datacadastro" required><br>';
        echo '<button class="btn btn-outline-success" type="submit" name="alterar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
      </svg> &nbsp Adicionar Pessoa</button>';
        echo '</form>';
        echo '<hr>';

    }

    public function ListarProduto() {
        $sqlproduto = 'SELECT id, nome, valor, total_estoque FROM produto';
        $queryproduto = $this->conexao->conexaoBanco()->prepare($sqlproduto);
        $queryproduto->execute();

        $menu = '<table class="table">';
        $menu .= '<thead class="thead-light"><tr><th>ID</th><th>Nome</th><th>Valor</th><th>Estoque</th><th>Ações</th><th><a class="btn btn-outline-dark" href="index.php" data-toggle="tooltip" title="Voltar ao menu inicial"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146ZM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5Z"/>
      </svg></a></th></tr></thead>';
        foreach($queryproduto->fetchAll() as $item) {
            $menu .= '<tr><td>' . $item[0] . '</td><td>' . $item[1] . '</td><td>' . $item[2] . '</td><td>' . $item[3] . '</td><td><a class="btn btn-outline-danger" href="?excluir=' . $item[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
          </svg>Excluir</a> <a class="btn btn-outline-primary" href="?alterar=' . $item[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg>Alterar</a></td></tr>';
        }
        $menu .= '</table><hr>';

        return $menu;
    }

    public function excluirProduto() {
        if(isset($_GET['excluir'])) {
            $id = $_GET['excluir'];
            $sql = "DELETE FROM produto WHERE id = ?";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $excluido = $query->execute([$id]);

            header("Location: lista_produto.php");
            exit;
        }
    }

    public function alterarProduto() {
        if(isset($_GET['alterar'])) {
            $id = $_GET['alterar'];
            $sql = "SELECT nome, valor, total_estoque FROM produto WHERE id = ?";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $query->execute([$id]);
            $produto = $query->fetch();

            echo '<form method="post">';
            echo '<input class="caixa" style="color: black;" type="text" name="nome" value="' . $produto[0] . '"><br>';
            echo '<input class="caixa" style="color: black;" type="number" name="valor" value="' . $produto[1] . '"><br>';
            echo '<input class="caixa" style="color: black;" type="number" name="total_estoque" value="' . $produto[2] . '"><br>';
            echo '<button class="btn btn-warning" type="submit" name="alterar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
            <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
            <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
          </svg> &nbsp Alterar Produto</button>';
            echo '</form>';
            echo '<hr>';

            if(isset($_POST['alterar'])) {
                $nome = $_POST['nome'];
                $valor = $_POST['valor'];
                $total_estoque =  $_POST['total_estoque'];
                $sql = "UPDATE produto SET nome = ?, valor = ?, total_estoque = ? WHERE id = ?";
                $query = $this->conexao->conexaoBanco()->prepare($sql);
                $atualizado = $query->execute([$nome, $valor, $total_estoque, $id]);

                header("Location: lista_produto.php");
                exit;
                
            }
        }
    }

    public function cadastrarProduto() {
        if(isset($_POST['cadastrar'])) {
            $id = $_POST['id'];
           	$nome = $_POST['nome'];
            $valor = $_POST['valor'];
            $total_estoque =  $_POST['total_estoque'];
            $sql = "INSERT INTO produto (id, nome, valor, total_estoque) VALUES (?, ?, ?, ?)";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $cadastrado = $query->execute([$id, $nome, $valor, $total_estoque]);
    
            header("Location: lista_produto.php");
            exit;
        }
    
        echo '<h4>Cadastrar produto</h4>';
        echo '<form method="post">';
        echo '<input class="caixa" style="color: black;" type="number" name="id" autocomplete="off" placeholder="Código" required><br>';
        echo '<input class="caixa" style="color: black;" type="text" name="nome" autocomplete="off" placeholder="Nome" required><br>';
        echo '<input class="caixa" style="color: black;" type="number" name="valor" autocomplete="off" placeholder="Valor" required><br>';
        echo '<input class="caixa" style="color: black;" type="number" name="total_estoque" autocomplete="off" placeholder="Estoque" required><br>';
        echo '<button class="btn btn-outline-success" type="submit" name="alterar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
      </svg> &nbsp Adicionar Produto</button>';
        echo '</form>';
        echo '<hr>';

        
    }

    public function ListarUsuario() {
        $sqlusuario = 'SELECT id, nome, email FROM usuario';
        $queryusuario = $this->conexao->conexaoBanco()->prepare($sqlusuario);
        $queryusuario->execute();

        $menu = '<table class="table">';
        $menu .= '<thead  class="thead-light"><tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th><th><a class="btn btn-outline-dark" href="index.php" data-toggle="tooltip" title="Voltar ao menu inicial"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146ZM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5Z"/>
      </svg></a></th></tr></thead>';
        foreach($queryusuario->fetchAll() as $item) {
            $menu .= '<tr><td>' . $item[0] . '</td><td>' . $item[1] . '</td><td>' . $item[2] . '</td><td><a class="btn btn-outline-danger" href="?excluir=' . $item[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
          </svg>Excluir</a> <a class="btn btn-outline-primary" href="?alterar=' . $item[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
        </svg>Alterar</a></td></tr>';
        }
        $menu .= '</table><hr>';

        return $menu;
    }

    public function excluirUsuario() {
        if(isset($_GET['excluir'])) {
            $id = $_GET['excluir'];
            $sql = "DELETE FROM usuario WHERE id = ?";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $excluido = $query->execute([$id]);

            header("Location: lista_usuario.php");
            exit;
        }
    }

    public function alterarUsuario() {
        if(isset($_GET['alterar'])) {
            $id = $_GET['alterar'];
            $sql = "SELECT nome, email FROM usuario WHERE id = ?";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $query->execute([$id]);
            $usuario = $query->fetch();

            echo '<form method="post">';
            echo '<input class="caixa" style="color: black;" type="text" name="nome" value="' . $usuario[0] . '">&nbsp ';
            echo '<input class="caixa" style="color: black;" type="text" name="email" value="' . $usuario[1] . '"><br>';
            echo '<button class="btn btn-warning" type="submit" name="alterar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
          </svg> &nbsp Alterar Usuário</button>';
            echo '</form>';
            echo '<hr>';

            if(isset($_POST['alterar'])) {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $sql = "UPDATE usuario SET nome = ?, email = ? WHERE id = ?";
                $query = $this->conexao->conexaoBanco()->prepare($sql);
                $atualizado = $query->execute([$nome, $email, $id]);

                header("Location: lista_usuario.php");
                exit;
                
            }
        }
    }

    public function cadastrarUsuario() {
        if(isset($_POST['cadastrar'])) {
            $id = $_POST['id'];
           	$nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha =  $_POST['senha'];
            $sql = "INSERT INTO usuario (id, nome, email, senha) VALUES (?, ?, ?, ?)";
            $query = $this->conexao->conexaoBanco()->prepare($sql);
            $cadastrado = $query->execute([$id, $nome, $email, $senha]);
    
            header("Location: lista_usuario.php");
            exit;
        }
		        
		echo '<h4>Cadastrar usuário</h4>';
        echo '<form method="post">';
        echo '<input class="caixa" style="color: black;" type="number" name="id" autocomplete="off" placeholder="Código" required><br>';
        echo '<input class="caixa" style="color: black;" type="text" name="nome" autocomplete="off" placeholder="Nome" required><br>';
        echo '<input class="caixa" style="color: black;" type="text" name="email" autocomplete="off" placeholder="Email" required><br>';
        echo '<input class="caixa" style="color: black;" type="text" name="senha" autocomplete="off"placeholder="Senha" required><br>';
        echo '<button class="btn btn-outline-success" type="submit" name="alterar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
      </svg> &nbsp Adicionar Usuário</button>';
        echo '</form>';
        echo '<hr>';

        
    }

    
}