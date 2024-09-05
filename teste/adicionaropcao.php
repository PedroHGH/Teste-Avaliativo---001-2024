<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Adicionar Opção</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>

        <script>

            const enqueteId = new URLSearchParams(window.location.search).get('enqueteId');

            window.adicionarOpcao = function(){

                var opcaoTitulo = $('#tituloOpcao').val();

                if (opcaoTitulo.trim() === ""){

                    alert("O título da opção não pode estar vazio!");
                    return;
                }

                $.ajax({

                    url: 'routerAdmin.php',
                    type: 'POST',
                    data: {

                        action: 'adicionarOpcao',
                        enquete_id: enqueteId,
                        titulo_opcao: opcaoTitulo
                    },
                    success: function(response){

                        alert('Opção adicionada com sucesso!');
                        window.location.href = 'admin.php'; // Redireciona de volta para a página principal
                    },
                    error: function(xhr, status, error){

                        console.error('Erro ao adicionar opção:', status, error);
                    }
                });
            }

        </script>

        <h1>Adicionar nova opção</h1>

        <form>

            <label for="tituloOpcao">Opção:</label>
            <input type="text" id="tituloOpcao" placeholder="Nova opção" required>
            <button type="button" onclick="adicionarOpcao()">Enviar</button>

        </form>

    </body>
</html>