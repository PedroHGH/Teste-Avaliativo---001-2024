<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Opção</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <script>

            const opcaoId = new URLSearchParams(window.location.search).get('opcaoId');

            window.atualizarOpcao = function(){

                opcaoTitulo = $('#tituloOpcao').val();

                $.ajax({

                    url: 'routerAdmin.php',
                    type: 'POST',
                    data: {
                        action: 'atualizarOpcao',
                        opcaoId: opcaoId,
                        opcaoTitulo :opcaoTitulo
                    },
                    success: function(response){

                        console.log('ssucesso: ', response);
                        alert('atualizado com sucesso');
                        window.location.href='admin.php';
                    },
                    error: function(xhr, status, error){

                        console.error('erro: ', status, error);
                    }
                });
            }
        
            $(document).ready(function(){

                window.carregarOpcao = function(){

                    $.ajax({

                        url: 'router.php',
                        type: 'GET',
                        data: {
                            action: 'buscarOpcao',
                            opcaoId: opcaoId
                        },
                        success: function(response){

                            console.log('ssucesso: ', response);
                            response= JSON.parse(response);
                            document.getElementById('tituloOpcao').value = response[0].titulo_opcao;
                        },
                        error: function(xhr, status, error){

                            console.error('erro: ', status, error);
                        }
                    });
                };

                carregarOpcao();
            });




        </script>

        <h1>Editar Opção</h1>

        <form>

            <label for="tituloOpcao">Opcao:</label>
            <input type="text" id="tituloOpcao" placeholder="título" required>
            <button type="button" onclick="atualizarOpcao();">Atualizar</button>

        </form>
        
    </body>
</html>