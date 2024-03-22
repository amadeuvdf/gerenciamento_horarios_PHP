<?php
require_once("./banco.php");
include("./includes/topo_bibliotecas.php");
//Incluindo as bibliotecas até o topo de abertura da TAG <body>


// SELECT para recolher todos os dados.
$Query_Consulta_gravacoes = "SELECT * FROM test_time_table;"; 
$sql_consulta_gravacoes = mysqli_query($con, $Query_Consulta_gravacoes) or die("Erro na query que gera tabela de gravações."); 
$dados_solicitacoes = array();
$dados_calendario = array();
while ($row = mysqli_fetch_array( $sql_consulta_gravacoes )) {
    $linha_calendario = array(); // Array para gerar json e alimentar calendario
    $linha_tabela = array(); // Array para alimentar tabela

    $linha_calendario['start'] = $row['tempo_gravacao_ini'];
    $linha_calendario['end'] = $row['tempo_gravacao_final'];
    $linha_calendario['title'] = $row['docente'];

    $dados_calendario[] = $linha_calendario;

    $linha_tabela['id'] = $row['id'];
    $ini = strtotime($row['tempo_gravacao_ini']);
    $fin = strtotime($row['tempo_gravacao_final']);
    $duracao = date("H\h i\m\i\\n", $fin-$ini);
    $linha_tabela['data-hora-gravacao'] = date("d-m-Y H\h i\m\i\\n", $ini);
    $linha_tabela['titulo_gravacao'] = $row['titulo_gravacao'];
    $linha_tabela['status_sol'] = $row['status_sol'];
    $linha_tabela['docente'] = $row['docente'];
    $linha_tabela['duracao'] = $duracao;
    $linha_tabela['tempo_ini'] = $ini;
    $linha_tabela['tempo_final'] = $fin;
    $linha_tabela['data_publicacao'] = $row['data_publicacao'];
    $linha_tabela['destino_material'] = $row['destino_material'];
    $linha_tabela['descricao'] = $row['descricao'];
    

    $dados_solicitacoes[] = $linha_tabela;


}     

$json_solicitacao = json_encode($dados_solicitacoes);

$json_calendario = json_encode($dados_calendario); // Aqui vem só as datas para o calendario e o nome do docente




?>
<link rel="stylesheet" type="text/css" href="./style/controle.css" />
  <div id="calendario"></div>
  <div id="lado_dir">
    <div id="superior">
      

        <div id="controle" name="controle">
            <button class="seletor_linha" name="seleciona_form" id="seleciona_form" value="Cadastro">Cadastrar horario</button>
        </div>

    </div>
    <div id="caixa_acao">Ponto de controle</div>
    <div id="inferior">
      <table>
        <thead>
            <tr>
                <th>Data/Hr gravação</th> 
                <th>Duração</th>
                <th>Docente</th>
                <th>Titulo</th>
                <th>Status</th>
                <th>Controle</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($dados_solicitacoes as $l) {
                ?>
                    <tr>
                        <td><?=$l['data-hora-gravacao'];?></td>
                        <td><?=$l['duracao'];?></td>
                        <td><?=$l['docente'];?></td>
                        <td><?=$l['titulo_gravacao'];?></td>
                        <td><?=$l['status_sol'];?></td>
                        <td><button class="seletor_linha" style="background: url('./img/settings.svg'); height: 28px; width: 28px; cursor: pointer;" value="<?=$l['id'];?>"></button></td> <!-- Aqui não vem um link mas uma função JS para prencher os INPUTS -->
                    </tr>
                <?php
            }   
        ?>
        </tbody>
    </table>
    
    </div>
  </div>




<script>
    $(document).ready(function(){
        $(".seletor_linha").click(function(e) { 
		var indicadorDeAcao = $(this).val(); // Atualizar ou Cadastrar
            $.ajax({
                url: 'formularios.php',
                type: 'POST',
                data: { 
                    select: indicadorDeAcao,
                    <?php echo "json: ".$json_solicitacao."";?>
                },
                success: function(msg) {
                    $('#caixa_acao').html(msg);

                }
            });
	    });
        
    });
</script>


<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarioEl = document.getElementById('calendario');

    var calendario = new FullCalendar.Calendar(calendarioEl, { // O Calendario consulta um $json com o PHP
        timeZone: 'America/Sao_Paulo',
        locale: 'pt-BR',
        initialView: 'timeGridFourDay',
        slotMinTime: "08:00:00",
        slotMaxTime: "17:40:00",
        allDaySlot: false,
        height: "100%",
        headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'timeGridDay,timeGridFourDay'
        },
        views: {
        timeGridFourDay: {
            type: 'timeGrid',
            duration: { days: 4 },
            buttonText: '4 day'
            
            }
        },
        <?php echo "events: ".$json_calendario.""?>
    });

    calendario.render();
});

</script>

</body>
</html>