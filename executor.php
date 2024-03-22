<?php
// Conexão com o banco de dados
require_once("./banco.php");

// Verifica a conexão
if ($con->connect_error) {
    die("Erro na conexão: " . $con->connect_error);
}
$mensagem_final = "";
if(isset($_POST['envia_form'])) {
  $query  = '';
  $tempo_inicial = "";
  $tempo_final = "";
  $descricao = "";
  $docente = "";
  $data_publicacao = "";
  $destino_material = "";
  $titulo_gravacao = "";
  $index = "";
  if(isset($_POST['tempo_inicial'])){
    $tempo_inicial = $_POST['tempo_inicial'];
  }
  if(isset($_POST['tempo_final'])){
    $tempo_final = $_POST['tempo_final'];
  }
  if(isset($_POST['descricao'])){
    $descricao = $_POST['descricao'];
  }
  if(isset($_POST['docente'])){
    $docente = $_POST['docente'];
  }
  if(isset($_POST['data_publicacao'])){
    $data_publicacao = $_POST['data_publicacao'];
  }
  if(isset($_POST['destino_material'])){
    $destino_material = $_POST['destino_material'];
  }
  if(isset($_POST['titulo_gravacao'])){
    $titulo_gravacao = $_POST['titulo_gravacao'];
  }
  if(isset($_POST['status_sol'])){
    $status_sol = $_POST['status_sol'];
  }
  if(isset($_POST['index'])){
    $id = $_POST['index'];
  }

    if($_POST['envia_form'] == "IN"){
      $query = "INSERT INTO test_time_table (tempo_gravacao_ini, tempo_gravacao_final, descricao, docente, data_publicacao, destino_material, titulo_gravacao, status_sol) VALUES ('".$tempo_inicial."','".$tempo_final."','".$descricao."','".$docente."','".$data_publicacao."','".$destino_material."','".$titulo_gravacao."','".$status_sol."')";
      $mensagem_final = "Dados cadastrados com sucesso <br />";
    }
    if($_POST['envia_form'] == "UP"){
      $query = "UPDATE test_time_table SET tempo_gravacao_ini = '$tempo_inicial', tempo_gravacao_final = '$tempo_final', descricao = '$descricao', docente = '$docente', data_publicacao = '$data_publicacao', destino_material = '$destino_material', titulo_gravacao = '$titulo_gravacao', status_sol = '$status_sol' WHERE id = $id";
      $mensagem_final = "Dados atualizados com sucesso <br />";
    }
    //echo $query;
    $query_ex = $con->query($query) or die(mysqli_error());
    

} else {
    echo "Erro ao receber os dados";
}

// Será que aqui não consigo aplicar um auto-reload pra recarregar a página
echo $mensagem_final;
$con->close();
?>
