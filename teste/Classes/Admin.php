<?php

    namespace Classes;

    class Admin{

        protected static function limpa_entrada($entrada){

            //var_dump($entrada);

            return filter_var($entrada, FILTER_SANITIZE_STRING);
        }

        public static function adicionarEnquete($dados){


            //var_dump($dados);

            $titulo = self::limpa_entrada($dados['titulo']);
            $data_inicio = date('Y-m-d H:i:s', strtotime($dados['data_inicio']));
            $data_termino = date('Y-m-d H:i:s', strtotime($dados['data_termino']));

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $query = "
                INSERT INTO enquetes(titulo, data_inicio, data_termino) VALUES ('$titulo', '$data_inicio', '$data_termino');
            ";
            //var_dump($query);

            $pdo->exec($query);


            return $pdo->lastInsertId();
        }

        public static function adicionarOpcao($dados){

            $opcao = self::limpa_entrada($dados['titulo_opcao']);
            $enqueteId = $dados['enquete_id'];

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $query = "
                INSERT INTO opcoes(enquete_id, titulo_opcao) VALUES ('$enqueteId', '$opcao')
            ";
            //var_dump($query);
            $pdo->exec($query);
        }

        public static function apagarOpcao($opcao_id){

            //var_dump($opcao_id);
            //return;
            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "SELECT enquete_id FROM opcoes WHERE id = $opcao_id";
            $stmt = $pdo->query($query);
            $stmt->execute();

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            
            if (!$result) {

                return false;
            }
        
            $enquete_id = $result[0]["enquete_id"];

            ///echo "enquete id:";
            //var_dump($enquete_id);

            //contando a quantidade de opcoes
            $query = "SELECT COUNT(*) as enquete_opcoes FROM opcoes WHERE enquete_id = '$enquete_id'";
            $stmt = $pdo->query($query);

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (!$result) {

                return false;
            }
        
            $enquete_opcoes = $result[0]['enquete_opcoes'];

            //echo "enquete opcoes:";
            //var_dump($enquete_opcoes);


            if($enquete_opcoes < 4){

                return "O número mínimo de opções é 3!";
            }else{

                $query = "DELETE FROM opcoes WHERE id=$opcao_id";
                $pdo->exec($query);
                return "opcao apagada com sucesso";
            }
        }

        public static function apagarEnquete($enquete_id){

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $query = "DELETE FROM enquetes WHERE id=$enquete_id";

            var_dump($query);
            $pdo->exec($query);
        }

        public static function atualizarOpcao($dados){

            //return var_dump($dados);

            $opcaoId = $dados['opcaoId'];
            $opcaoTitulo = self::limpa_entrada($dados['opcaoTitulo']);

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "UPDATE opcoes SET titulo_opcao='$opcaoTitulo' where id=$opcaoId";
            $pdo->exec($query);

        }


        public static function atualizarEnquete($dados){

            //return var_dump($dados);

            $enqueteId = $dados['enqueteId'];
            $enqueteTitulo = self::limpa_entrada($dados['enqueteTitulo']);
            $dataInicio = $dados['dataInicio'];
            $dataTermino = $dados['dataTermino'];

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "UPDATE enquetes SET titulo='$enqueteTitulo', data_inicio = '$dataInicio', data_termino = '$dataTermino' where id=$enqueteId";
            $pdo->exec($query);

        }

    }