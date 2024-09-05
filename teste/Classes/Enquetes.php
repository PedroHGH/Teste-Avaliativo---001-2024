<?php

    namespace Classes;

    class Enquetes{

        public static function listarEnquetes(){

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "SELECT * FROM enquetes";
            $stmt = $pdo->query($query);
            echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
        }

        public static function buscarEnquete($enquete_id){

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "SELECT * FROM enquetes WHERE id=$enquete_id";
            $stmt = $pdo->query($query);
            echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
        }

        public static function listarOpcoes($enquete_id){

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "SELECT * FROM opcoes WHERE enquete_id = $enquete_id";
            $stmt = $pdo->query($query);
            echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
        }

        public static function buscarOpcao($opcao_id){

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "SELECT * FROM opcoes WHERE id=$opcao_id";
            $stmt = $pdo->query($query);
            echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
        }

        public static function votar($opcaoId){

            $pdo = new \PDO("mysql:host=localhost;dbname=enquetes", 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
 
            $query = "UPDATE opcoes SET votos=votos+1 where id=$opcaoId";
            $pdo->exec($query);
        }

    }