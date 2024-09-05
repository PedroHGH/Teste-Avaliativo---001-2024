<?php

    include('Classes/Enquetes.php');

    use Classes\Enquetes;

    $local_serve = "localhost";
    $usuario_serve = 'root';
    $senha_serve = '';
    $database = 'enquetes';


    if ($_GET['action'] == 'listarEnquetes') {

        Enquetes::listarEnquetes();
        exit;
    } elseif ($_GET['action'] == 'buscarEnquete') {
        
        Enquetes::buscarEnquete($_GET['enqueteId']);
        exit;
    } elseif ($_GET['action'] == 'listarOpcoes') {

        Enquetes::listarOpcoes($_GET['enqueteId']);
        exit;
    } elseif ($_GET['action'] == 'buscarOpcao') {

        Enquetes::buscarOpcao($_GET['opcaoId']);
        exit;
    } elseif ($_POST['action'] == 'votar') {
        Enquetes::votar($_POST['opcaoId']);
        exit;
    }



    
