<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Enquete</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <script>

            const enqueteId = new URLSearchParams(window.location.search).get('enqueteId');

            window.atualizarEnquete = function(){

                const enqueteTitulo = $('#tituloEnquete').val();
                const dataInicio = $('#dataInicio').val();
                const dataTermino = $('#dataTermino').val();

                //console.log(enqueteId, tituloEnquete, dataInicio, dataTermino);

                $.ajax({

                    url: 'routerAdmin.php',
                    type: 'POST',
                    data: {
                        action: 'atualizarEnquete',
                        enqueteId: enqueteId,
                        enqueteTitulo: enqueteTitulo,
                        dataInicio: dataInicio,
                        dataTermino: dataTermino
                    },
                    success: function(response){

                        console.log('Sucesso: ', response);
                        alert('Enquete atualizada com sucesso!!');
                        window.location.href = 'admin.php';
                    },
                    error: function(xhr, status, error){

                        console.error('Erro: ', status, error);
                    }
                });
            }

            $(document).ready(function(){

                window.carregarEnquete = function(){

                    $.ajax({

                        url: 'router.php',
                        type: 'GET',
                        data: {
                            action: 'buscarEnquete',
                            enqueteId: enqueteId
                        },
                        success: function(response){

                            console.log('Sucesso: ', response);
                            response = JSON.parse(response);

                            // usar[0] porque vem um objeto em um array
                            $('#tituloEnquete').val(response[0].titulo);
                            $('#dataInicio').val(response[0].data_inicio.replace(' ', 'T'));
                            $('#dataTermino').val(response[0].data_termino.replace(' ', 'T'));
                        },
                        error: function(xhr, status, error){

                            console.error('Erro: ', status, error);
                        }
                    });
                };

                carregarEnquete();
            });

        </script>

        <h1>Editar Enquete</h1>

        <form>

            <label for="tituloEnquete">Título:</label>
            <input type="text" id="tituloEnquete" placeholder="Título da enquete" required>
            <br>

            <label for="dataInicio">Data de Início:</label>
            <input type="datetime-local" id="dataInicio" required>
            <br>

            <label for="dataTermino">Data de Término:</label>
            <input type="datetime-local" id="dataTermino" required>
            <br>

            <button type="button" onclick="atualizarEnquete();">Atualizar</button>

        </form>
        
    </body>
</html>