<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Enquetes</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <script>
            
            $(document).ready(function(){

                $.ajax({

                    url: 'router.php',
                    type: 'GET',
                    data: { action: 'listarEnquetes' },
                    success: function(data){

                        var enquetes = JSON.parse(data); 
                        var now = new Date(); //armazenando data atual em now
                        enquetes.forEach(function(enquete){

                            var dataInicio = new Date(enquete.data_inicio);
                            var dataTermino = new Date(enquete.data_termino);
                            
                            var row = '<tr>' +
                                '<td>' + enquete.titulo + '</td>' +
                                '<td>' + enquete.data_inicio + '</td>' +
                                '<td>' + enquete.data_termino + '</td>' +
                                '<td><div id="opcoes-' + enquete.id + '"></div></td>' +
                                '</tr>';

                            if(now < dataInicio){

                                $('#lista-enquetes-proximas').append(row);
                            }else if(now > dataTermino){

                                $('#lista-enquetes-encerradas').append(row);
                            }else{

                                $('#lista-enquetes').append(row);
                            }

                            //enquetes, não iniciadas/em andamento/finalizadas

                            if (now >= dataInicio && now <= dataTermino){

                                carregarOpcoes(enquete.id, true); 
                            } else {

                                carregarOpcoes(enquete.id, false);
                                $('#opcoes-' + enquete.id).append('<p>Fora do horário de votação</p>');
                            }
                        });
                    },
                    error: function(error) {

                        console.log("Erro ao carregar os dados", error);
                    }
                });

                window.carregarOpcoes = function(enqueteId, votarboolean){
                    
                    $.ajax({

                        url: 'router.php',
                        type: 'GET',
                        data: { action: 'listarOpcoes', enqueteId: enqueteId },
                        success: function(data){

                            var opcoes = JSON.parse(data);

                            opcoes.forEach(function(opcao){

                                var opcaoHtml = '<div>' +
                                    '<span>' + opcao.titulo_opcao + ' - ' + opcao.votos + ' votos</span>';
                                    
                                if (votarboolean) {
                                    opcaoHtml += ' <button id="votar_' + opcao.id + '" onclick="votar('+ opcao.id +', '+ enqueteId +')">Votar</button>';
                                }
                                
                                opcaoHtml += '</div>';
                                $('#opcoes-' + enqueteId).append(opcaoHtml);
                            });
                        },
                        error: function(error){

                            console.log("Erro ao carregar opções", error);
                        }
                    });
                }

                window.votar = function(opcaoId, enqueteId){

                    $.ajax({

                        url: 'router.php',
                        type: 'POST',
                        data: { 
                            action: 'votar',
                            opcaoId: opcaoId
                        },
                        success: function(response) {

                            $('#opcoes-' + enqueteId).empty();
                            carregarOpcoes(enqueteId, false);
                        },
                        error: function(error){

                            console.log("Erro ao registrar o voto", error);
                        }
                    });
                }
            });

        </script>

        <h2>Enquetes em andamento</h2>
        <table id="lista-enquetes">

            <tr>
                <th>Título</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Opções</th>
            </tr>

        </table>

        <h2>Enquetes ainda não iniciadas</h2>
        <table id="lista-enquetes-proximas">

            <tr>
                <th>Título</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Opções</th>
            </tr>

        </table>

        <h2>Enquetes já encerradas</h2>

        <table id="lista-enquetes-encerradas">
            <tr>
                <th>Título</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Opções</th>
            </tr>

        </table>

    </body>
</html>