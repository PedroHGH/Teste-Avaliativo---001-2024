<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <script>

            $(document).ready(function(){

                function carregarEnquetes(){

                    $.ajax({

                        url: 'router.php',
                        type: 'GET',
                        data: { action: 'listarEnquetes' },
                        success: function(data){

                            var enquetes = JSON.parse(data);
                        
                            $('#lista-enquetes').empty();

                            enquetes.forEach(function(enquete){

                                var row = '<tr>' +
                                    '<td>' + enquete.titulo + '</td>' +
                                    '<td>' +
                                    '<button id="editar_enquete_' + enquete.id + '" onclick="window.location.href=\'editarenquete.php?enqueteId=' + enquete.id + '\'">Editar</button>' +
                                    '<button id="apagar_enquete_' + enquete.id + '" onclick="apagarEnquete(' + enquete.id + ')">Apagar</button>' +
                                    '</td>' +
                                    '<td>' +
                                    '<button onclick="window.location.href=\'adicionaropcao.php?enqueteId=' + enquete.id + '\'">Adicionar Opção</button>' +
                                    '</td>' +
                                    '<td><div id="opcoes-' + enquete.id + '"></div></td>' +
                                    '</tr>';

                                $('#lista-enquetes').append(row);

                                carregarOpcoes(enquete.id);
                            });
                        },
                        error: function(error){

                            console.log("erro no carregamento das enquetes", error);
                        }
                    });
                }

                function carregarOpcoes(enqueteId){

                    $.ajax({

                        url: 'router.php',
                        type: 'GET',
                        data: { action: 'listarOpcoes', enqueteId: enqueteId },
                        success: function(data) {

                            var opcoes = JSON.parse(data);
                            opcoes.forEach(function(opcao){

                                var opcaostring = '<div id="divOpcao_' + opcao.id + '">' +
                                    '<span>' + opcao.titulo_opcao + ' - ' + opcao.votos + ' votos</span>' +
                                    '<button id="editar_opcao_' + opcao.id + '" onclick="window.location.href=\'editaropcao.php?opcaoId=' + opcao.id + '\'">Editar</button>' +
                                    '<button id="apagar_opcao_' + opcao.id + '" onclick="apagarOpcao(' + opcao.id + ', '+ enqueteId +')">Apagar</button>' +
                                    '</div>';

                                $('#opcoes-' + enqueteId).append(opcaostring);
                            });
                        },
                        error: function(error){

                            console.log("erro no carregamento das opcoes", error);
                        }
                    });
                }

                window.apagarEnquete = function(enqueteId){

                    //console.log('na funcao de apagar enquete', enqueteId);

                    $.ajax({

                        url: 'routerAdmin.php',
                        type: 'POST',
                        data: { action: 'apagarEnquete', enqueteId: enqueteId },
                        success: function(response){

                            alert("Enquete apagada!!");
                            carregarEnquetes();
                        },
                        error: function(error){

                            console.log("erro ao tentar apagar enquete", error);
                        }
                    });
                }
                
                window.apagarOpcao = function(opcaoId, enqueteId){
                    
                    //console.log('na funcao de apagar', opcaoId);

                    $.ajax({

                        url: 'routerAdmin.php',
                        type: 'POST',
                        data: {

                            action: 'apagarOpcao',
                            opcaoId: opcaoId
                        },
                        success: function(response){


                            alert(response);
                            carregarEnquetes();

                        },
                        error: function(error){

                            console.log("Erro ao apagar opcao", error);
                        }
                    });
                }

                window.adicionarOpcaoForm = function(){

                    $('#opcoes').append('<input type="text" class="opcao" placeholder="opção">');
                };
                
                window.adicionarEnquete = function(){

                    //console.log('aaa');

                    var titulo = $('#titulo').val();
                    var data_inicio = $('#data_inicio').val();
                    var data_termino = $('#data_termino').val();

                    //array de opcoes
                    var opcoes = [];

                    //faz push da opcao nova no ar
                    $('.opcao').each(function(){

                        //console.log('loop');
                        var opc= $(this).val();

                        if (opc.trim() !== ""){

                            opcoes.push(opc);
                        }
                    });

                    if(titulo == ""){

                        alert('titulo invalido');
                        return;
                    }

                    if(data_inicio === ""){

                        alert('data inicial invalida');
                        return;
                    }

                    if(data_termino === ""){

                        alert('data final invalida');
                        return;
                    }

                    if(opcoes.length < 3)
                    {
                        alert('o numero minimo de opcoes é 3');
                        return;
                    }

                    //console.log('aqui');

                    $.ajax({

                        url: 'routerAdmin.php',
                        type: 'POST',
                        data: {
                            action: 'adicionarEnquete',
                            titulo: titulo,
                            data_inicio: data_inicio,
                            data_termino: data_termino,
                        },
                        success: function(response){

                            var idNovaEnquete = response;
                            
                            opcoes.forEach(function(opcao){

                                console.log("opcao e enquete", opcao, idNovaEnquete);

                                //adicionando a opcao enviando o texto da opcao e o id da enquete criada
                                adicionarOpcao(opcao, idNovaEnquete);
                            });

                            document.getElementById("nova-enquete-form").reset();
                            carregarEnquetes();
                        },
                        error: function(error){

                            console.log("Erro na criacao da nova enquete", error);
                        }
                    });
                };

                //adicionando a nova opcao
                window.adicionarOpcao = function(opcao, enquete){

                    //console.log('na funcao', opcao, enquete);

                    $.ajax({

                        url: 'routerAdmin.php',
                        type: 'POST',
                        data: {
                            action: 'adicionarOpcao',
                            titulo_opcao: opcao,
                            enquete_id: enquete
                        },
                        success: function(response){

                            console.log('ssucesso: ', response);
                        },
                        error: function(xhr, status, error){

                            console.error('erro: ', status, error);
                        }
                    });
                }


                $('#adicionarOpcaoForm').on('click', adicionarOpcaoForm);
                $('#adicionarEnquete').on('click', adicionarEnquete);

                carregarEnquetes();

            });

        </script>


        <h1>Página de admin</h1>
        
        <h2>Nova enquete</h2>

        <form id="nova-enquete-form">

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            <br>
            
            <label for="data_inicio">Início:</label>
            <input type="datetime-local" id="data_inicio" name="data_inicio" required>
            <br>

            <label for="data_termino">Fim:</label>
            <input type="datetime-local" id="data_termino" name="data_termino" required>
            <br>

            <h3>Opções</h3>
            <div id="opcoes">

                <input type="text" class="opcao" placeholder="Opção" required>
                <br>

                <input type="text" class="opcao" placeholder="Opção" required>
                <br>

                <input type="text" class="opcao" placeholder="Opção" required>

                <br>
            </div>

            <button type="button" id="adicionarOpcaoForm">Adicionar mais uma opção</button>
            <br>

            <button type="button" id="adicionarEnquete">Adicionar nova enquete</button>
            <br>

        </form>

        <h2>Enquetes</h2>
        <table id="lista-enquetes">

            <tr>
                
                <th>Título</th>
                <th>Ações</th>
                <th>Opções</th>

            </tr>
        </table>

    </body>
</html>