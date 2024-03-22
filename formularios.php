<?php
require_once("./banco.php");

function pesquisarPorId($array, $id) {
    foreach ($array as $item) {
        if ($item['id'] == $id) {
            return $item;
        }
    }
    // Retorna falso se o id não for encontrado
    return false;
}

if(isset($_POST['select'])){
    $tipo_formulario = "";
    $dados_prencher_form = array();
    if($_POST['select'] == "Cadastro"){ // Cadastrar novo 
        $tipo_formulario = "Cadastra";
        $form = "IN";
        $dados_prencher_form['id'] = "";
        $dados_prencher_form['data-hora-gravacao'] = "";
        $dados_prencher_form['titulo_gravacao'] = "";
        $dados_prencher_form['status_sol'] = "";
        $dados_prencher_form['docente'] = "";
        $dados_prencher_form['duracao'] = "";
        $dados_prencher_form['tempo_ini'] = "";
        $dados_prencher_form['tempo_final'] = "";
        $dados_prencher_form['descricao'] = "";
        $dados_prencher_form['data_publicacao'] = "";
        $dados_prencher_form['destino_material'] =  "";
        
    } elseif( preg_match('/\d+/', $_POST['select'])>0 ) {
        $tipo_formulario = "Atualiza";
        $form = "UP";
        $id = $_POST['select'];

        if(isset($_POST['json'])){ // Ta vindo o JSON agora preciso pesquisar dentro dele pra trazer os dados do ID selecionado
            $json = $_POST['json'];
        } else {
            $json = "";
        }

        $resultado = pesquisarPorId($json, $id);
        if ($resultado !== false) {
            
            // Tem que ver porque não ta vindo o resto dos dados pra prencher o form
            $dados_prencher_form['id'] = $resultado['id'];
            $dados_prencher_form['data-hora-gravacao'] = $resultado['data-hora-gravacao'];
            $dados_prencher_form['titulo_gravacao'] = $resultado['titulo_gravacao'];
            $dados_prencher_form['status_sol'] = $resultado['status_sol'];
            $dados_prencher_form['docente'] = $resultado['docente'];
            $dados_prencher_form['duracao'] = $resultado['duracao'];
            $dados_prencher_form['tempo_ini'] = $resultado['tempo_ini'];
            $dados_prencher_form['tempo_final'] = $resultado['tempo_final'];
            $dados_prencher_form['descricao'] = $resultado['descricao'];
            $dados_prencher_form['data_publicacao'] = $resultado['data_publicacao'];
            $dados_prencher_form['destino_material'] =  $resultado['destino_material'];
        } else {
            echo "Nenhum resultado encontrado para o ID $id.\n";
        }
        

    } else {
        die("Erro para exibir formularios!");
    }
    echo $tipo_formulario."<br />";

    ?>
    
        <form  method="post" id="formulario_registro">
            <div class="field_wrapper">
                <div class="caixa_input">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <label for="tempo_inicial">tempo inicial</label><br />
                                    <input class="input_form" type="datetime-local" name="tempo_inicial" value="<?php echo date("Y-m-d\\TH:i", $dados_prencher_form['tempo_ini']);?>"/>
                                </td>
                                <td>
                                    <label for="tempo_final">tempo final</label><br />
                                    <input class="input_form" type="datetime-local" name="tempo_final" value="<?php echo date("Y-m-d\\TH:i", $dados_prencher_form['tempo_final']);?>"/>
                                </td>
                                <td>
                                    <label for="Docente">Docente</label><br />
                                    <input class="input_form" type="text" name="docente" value="<?=$dados_prencher_form['docente'];?>"/>
                                </td>
                                <td>
                                    <label for="descricao">Informações adicionais</label><br />
                                    <input class="input_form" type="text" name="descricao" value="<?=$dados_prencher_form['descricao'];?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="data_publicacao">Data p/ publicação</label><br />
                                    <input class="input_form" type="date" name="data_publicacao" value="<?=$dados_prencher_form['data_publicacao'];?>"/>
                                </td>
                                <td>
                                    <label for="destino_material">Material destinado</label><br />
                                    <input class="input_form" type="text" name="destino_material" value="<?=$dados_prencher_form['destino_material'];?>"/>
                                </td>
                                <td>
                                    <label for="titulo_gravacao">Titulo gravacao</label><br />
                                    <input class="input_form" type="text" name="titulo_gravacao" value="<?=$dados_prencher_form['titulo_gravacao'];?>"/>
                                </td>
                                <td>
                                    <label for="descricao">Status</label><br />
                                    <select class="input_form" name="status_sol" id="status_sol"> <!-- Aqui vou passar um PHP com o option selected -->
                                        <option value="Pendente">Pendente</option>
                                        <option value="Confirmado">Confirmado</option>
                                        <option value="Edição">Edição</option>
                                        <option value="Entregue">Entregue</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="index" value="<?=$id;?>"/>
            <input type="hidden" name="envia_form" value="<?=$form;?>"/>
            <input type="submit" value="Enviar">
        </form>
    <?php
    }

?>

<script>

$('#formulario_registro').submit(function(event){
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'executor.php',
            data: formData,
            success: function(response){
                $('#caixa_acao').html(response);
                setTimeout(900);
                window.location.reload();
            }
        });
    });
</script>