<?php
//categoria
$categoriaSolicitacao = "Agendamento Gravação";

$usuario = "Amadeu"; // Pessoa que fez a solicitação

$dataAtual = date('Y-m-d H:i:s');
require_once("./banco.php");

$sql_data_hr = "SELECT tempo_gravacao_ini FROM test_time_table;";
$dados_prencher_marcados = array();
$sql_gravacoes = mysqli_query($con, $sql_data_hr) or die("Erro na query que gera tabela de gravações."); // Consulta
while ($row = mysqli_fetch_array( $sql_gravacoes )) {
	$dados_prencher_marcados[] =  date("d-m-Y H:i", strtotime($row['tempo_gravacao_ini']));

}
$string = json_encode($dados_prencher_marcados); //JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE

if(isset($_POST['enviarSolicitacaoGravacao'])){ //enviarSolicitacaoGravacao
	//Monta um array para imprimir a string da solicitação
	//Deixando em branco '' as info que não serão utilizadas
	$solicitacao = array();

	//textarea dos docentes selecionados para gravação
	if(isset($_POST['docente'])) {
		//traz as quebras de linha
		$solicitacao['docente'] = nl2br($_POST['docente']);
	} else {
		$solicitacao['docente'] = '';
	}

	if(isset($_POST['data_gravacao'])) {
		// Recebe data e hora 
		$data_grava = $_POST['data_gravacao'];
		
		// Atribuir valor formatado
		$solicitacao['data_gravacao'] = $data_grava;
		if($solicitacao['data_gravacao'] == "31-12-1969 00:00") {
			$solicitacao['data_gravacao'] == "Erro ao selecionar data de gravação";
		}
	} else {
		$solicitacao['data_gravacao'] = '';
	}

	if(isset($_POST['data_publicacao'])) {
		// Recebe data e hora 
		$data_grava = $_POST['data_publicacao'];
		
		// Atribuir valor formatado
		$solicitacao['data_publicacao'] = $data_grava;
		if($solicitacao['data_gravacao'] == "31-12-1969 00:00") {
			$solicitacao['data_publicacao'] == "Erro ao selecionar data de gravação";
		}
	} else {
		$solicitacao['data_publicacao'] = '';
	}

	if(isset($_POST['destino'])) {
		//traz as quebras de linha
		$solicitacao['destino'] = nl2br($_POST['destino']);
	} else {
		$solicitacao['destino'] = '';
	}

	if(isset($_POST['titulo'])) {
		//traz as quebras de linha
		$solicitacao['titulo'] = nl2br($_POST['titulo']);
	} else {
		$solicitacao['titulo'] = '';
	}

	if(isset($_POST['infoExtras'])) {
		//traz as quebras de linha
		$solicitacao['infoExtras'] = $_POST['infoExtras'];
	} else {
		$solicitacao['infoExtras'] = '';
	}
	
	echo "<pre>";
	print_r($solicitacao);
	echo "</pre>";
	echo "<br /><br />";
	$solicitacaoFinal = "<strong>Agendamento de gravação.</strong><br /><strong>1) Quem solicitou a gravação?</strong><br />".$usuario."<br /><br /><strong>2) Para que dia a gravação?</strong><br />".$solicitacao['data_gravacao']."<br /><br /><strong>3) Quem é o docente que irá participar da gravação?</strong><br />".$solicitacao['docente']."<br /><br /><strong>4) Essa gravação tem como destino qual material ou conteúdo?</strong><br />".$solicitacao['destino']."<br /><br /><strong>5) Qual o titulo dessa gravação?</strong><br />".$solicitacao['titulo']."<br /><br /><strong>6) Qual o prazo para a publicação desse material?</strong><br />".$solicitacao['data_publicacao']."<br /><br /><strong>Informações adicionais:</strong><br />".$solicitacao['infoExtras'];

	echo $solicitacaoFinal;

	if($solicitacaoFinal != "") {

	die();
	}
	
}

include("./includes/topo_bibliotecas.php");
?>
<link rel="stylesheet" type="text/css" href="./style/formulario.css" />
	<div class="aviso">
		Favor não comparecer a gravação com camisa da cor Verde pois atrapalha o recorte.
	</div>

	<form action="./form_envio.php" method="post" enctype="multipart/form-data">
		<label for="datetimepicker">Para que dia a gravação? (Selecione um dos horarios disponiveis)</label>
		<input id="datetimepicker" value="1970-0-01T00:00" name="data_gravacao" type="text" style="border-radius: 5px; border: 1px solid;">

		<br>

		<label for="docente">Quem é o docente que irá participar da gravação?</label>
		<select id="docente" name="docente">
			<option value="Jhon Tales" >Jhon Tales</option>
			<option value="Emily White" >Emily White</option>
			<option value="Isabella Brown" >Isabella Brown</option>
			
		</select>
		<br>
		<br>

		<label for="data_publicacao">Data para publicação:</label>
		<input id="data_publicacao" name="data_publicacao" type="text" style="border-radius: 5px; border: 1px solid;">

		<br>

		<label for="destino">Essa gravação tem como destino qual material ou conteúdo?</label>
		<input id="destino" name="destino" type="text" style="border-radius: 5px; border: 1px solid;">

		<br>

		<label for="titulo">Escreva um título para essa gravação:</label>
		<input id="titulo" name="titulo" type="text" style="border-radius: 5px; border: 1px solid;">

		<label for="infoExtras">Informações adicionais</label>
		<textarea id ="infoExtras" name="infoExtras" style="height:100px; "></textarea>
		
		<br>
		<br>
		<input type="submit" value="Enviar">
		<input type="hidden" name="enviarSolicitacaoGravacao" id="enviarSolicitacaoGravacao" value="Enviar Solicitação" />
	</form>


<script>
/* O SCRIPT abaixo permite a seleção de datas especificas e horarios especificos, limitando a escolha de acordo com um array */
// Esse Script ainda não consegue fazer a limitação de dias indisponiveis, por exemplo Fim de Semana.

	function formatarData(data) { // essa função rece a data no formato JS (Thu Feb 29 2024 09:19:14 GMT-0300 (Horário Padrão de Brasília)) e retorna como String 29-02-2024
		var dia = ("0" + data.getDate()).slice(-2);
		var mes = ("0" + (data.getMonth() + 1)).slice(-2);
		var ano = data.getFullYear();
		var horas = ("0" + data.getHours()).slice(-2);
		var minutos = ("0" + data.getMinutes()).slice(-2);
		
		return dia + '-' + mes + '-' + ano;
	}
	// Array com todos os horarios que é permitido o agendamento.
	var horarios_visualizacao = ['11:30', '14:00', '14:30','15:00', '15:30', '16:00', '16:30', '17:00'];
	// Esse array é que determina os horarios que já foram marcados, com as datas e horas.
	var Data_horarios_marcados = <?php echo $string;?>;

	var todas_horarios_marcadas = []; // array que separa os horarios com o mesmo indice do original
	var todas_datas_marcadas = []; // array que separa as data com o mesmo indice do original
	for(var i = 0; i < Data_horarios_marcados.length; i++){ // Popular o dois arrays
		var partes = Data_horarios_marcados[i].split(' ');
		todas_datas_marcadas.push(partes[0]);
		todas_horarios_marcadas.push(partes[1]);
		
	}

	function remover_horario_data_selecionada(data_string){ // Função que recebe a data selecionada no Input como uma String. Retira os horarios já marcados.
		var retorno = horarios_visualizacao;
        var index = [];
		for(var j = 0; j < todas_datas_marcadas.length; j++){ 
			if(todas_datas_marcadas[j] == data_string){
				index.push(j); // Salva o indice do horario que foi marcado.
			}
		}

        for(var k = 0; k < index.length; k++){ // Passa por todo o array que tem as horas marcadas e faz um filtro. O Filtro gera um array retorno que tira o elemento daquele indice.
            var retirar = todas_horarios_marcadas[index[k]];
            retorno = retorno.filter(function (el) {
                return el !== retirar;
            })
        }
		return retorno;
	}

	var novos_horarios = []; // Array onde mostra os horarios disponiveis.
	var logica_mostra_hora = function(currentDateTime) {
		var libera_funcao_remover_hr = false;
		if ( todas_datas_marcadas.find((element) => element == formatarData(currentDateTime)) ) {
			libera_funcao_remover_hr = true;
			novos_horarios = remover_horario_data_selecionada(formatarData(currentDateTime));
			
		}
		if (libera_funcao_remover_hr) {
			this.setOptions({
				allowTimes: novos_horarios,
			});
		} else {
			this.setOptions({
				allowTimes: horarios_visualizacao,
			});
		}
		libera_funcao_remover_hr = false;
	};

	jQuery('#datetimepicker').datetimepicker({ // Inicia o plugin do datetime picker para data de gravação
		format:'d-m-Y H:i',
  		lang:'pt-BR',
		minDate: 0,
		validateOnBlur: false,
		disabledWeekDays:[ 0, 6], //retira sábado e domingo
		onChangeDateTime:logica_mostra_hora,
  		onShow:logica_mostra_hora,
		defaultTime: '00:00',

	});

	jQuery('#data_publicacao').datetimepicker({ // Inicia o plugin do datetime picker para data de publicação
		format:'d-m-Y',
  		lang:'pt-BR',
		minDate: 0,
		timepicker:false,

	});

document.getElementById('datetimepicker').readOnly = true;
</script>

<script>
	$(document).ready(function () {
		$("#docente").select2({
			placeholder: "Escreva o nome do docente para buscá-lo",
			"language": "pt-BR",
			width: '100%'
		});
		
	});
</script>

</body>
</html>