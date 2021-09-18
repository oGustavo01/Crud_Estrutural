<?php
# criar um banco de dados usando SQlite

# criar a tabela e adicionar os dados na tabela

$db = new SQLite3('dados.db');
$db->query('create table if not exists cadastro(id integer  primary  key autoincrement, nome text, cidade text, endereco text)');

# função para inserir os dados no cadastro(nome, cidade, endereço).

function inserir($dados){
    $GLOBALS['db']->query("insert into cadastro (nome, cidade, endereco) values ('".
        $dados['nome']."','".$dados['cidade']."','".$dados['endereco']."')");
}
# função para mostrar a lista dos IDs cadastrados.

function listar(){
    $query = $GLOBALS['db']->query("SELECT * FROM cadastro");
    while($dados = $query->fetchArray(SQLITE3_ASSOC)){
        print_r($dados);
    }
}
# função para alterar os dados do ID.

function alterar($dados){
    $GLOBALS['db']->query("update cadastro set nome = '".$dados['nome']."', cidade = '".
        $dados['cidade']."',endereco = '".$dados['endereco']."' where id = '".$dados['id']."' ");
}
# função para apagar o ID(dados).

function apagar($id){
    $GLOBALS['db']->query("delete from cadastro where id = ".$id);
}
# função para pegar os dados no banco de dados.

function pegar($id){
    $query = $GLOBALS['db']->query("select * from cadastro where id = ".$id);
    $r = array();
    while ($dados = $query->fetchArray(SQLITE3_ASSOC)){
        $r[] = $dados;
    }
    if (count($r) !=0 ){
        return $r[0];
    } else {
        return false;
    }
}
# função para visualizar os comandos.

function main(){
    echo "Cadastro \n\n";
    echo "1 Novo Cadastro;\n";
    echo "2 Listar pessoas Cadastradas;\n";
    echo "3 Editar Cadastro;\n";
    echo "4 Apagar Cadastro;\n";
    echo "5 Sair \n\n";
    $opt  = readline('Escolha uma opção: ');
    if ($opt !=1 && $opt !=2  && $opt != 3 && $opt !=4 && $opt !=5 ){
        echo "Opção invalida\n";
    }else {
        switch ($opt){
            case 1 :
                $dados = array();
                $dados['nome'] = readline("Digite o nome: ");
                $dados['cidade'] = readline("Digite a cidade: ");
                $dados['endereco'] = readline("Digite o endereco: ");
                $r = readline("Deseja salvar esses dados? [SIM/NAO] ");
                if ($r != 'SIM' && $r !='NAO'){
                    echo "Opção Invalida \n";
                }else {
                    if ($r == 'SIM'){
                        inserir($dados);
                    }
                }

                break;
            case 2 :
                print_r(listar());
                break;
            case 3 :
                $id = readline("Digite o id do Cadastro que deseja editar: ");
                $cadastro = pegar($id);
                if ($cadastro){
                    $dados = array();
                    $dados['nome'] = readline("Digite o nome: ");
                    $dados['cidade'] = readline("Digite a cidade: ");
                    $dados['endereco'] = readline("Digite o endereco: ");
                    echo "antes: \n";
                    print_r($cadastro);
                    echo "depois: \n";
                    print_r($dados);
                    $dados['id'] = $id;
                    $r = readline("Deseja editar esses dados? [SIM/NAO] ");
                    if ($r != 'SIM' && $r !='NAO'){
                        echo "Opção Invalida \n";
                    } else {
                        if ($r == 'SIM'){
                            alterar($dados);
                        }
                    }

                }else {
                    echo "Cadastro não localizado \n";
                }

                break;
            case 4 :
                $id = readline("Digite o id do cadastro que apagar: ");
                $cadastro = pegar($id);
                if ($cadastro){
                    echo "Apagando registro: \n";
                    print_r($cadastro);
                    $r = readline("Deseja apagar esses dados? [SIM/NAO] ");
                    if ($r !='SIM' && $r !='NAO'){
                        echo "Opção invalida \n";
                    }else{
                        if ($r == 'SIM'){
                            apagar($id);
                        }
                    }
                }
                break;
            case 5 :
                exit();
            default:
                echo "\n\n Opção invalida... \n";
                break;



        }
    }
}
while(true){
    main();
}
?>