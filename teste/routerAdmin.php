<?php

    include('Classes/Admin.php');

    use Classes\Admin;

    $local_serve = "localhost";
    $usuario_serve = 'root';
    $senha_serve = '';
    $database = 'enquetes';

    //echo 'no router admain';

    if ($_POST['action'] == 'adicionarEnquete') {

        echo Admin::adicionarEnquete($_POST);
        exit;
    }else if ($_POST['action'] == 'adicionarOpcao') {

        //var_dump($_POST);
        Admin::adicionarOpcao($_POST);
        exit;
    }else if ($_POST['action'] == 'apagarOpcao') {
        //var_dump($_POST);
        echo Admin::apagarOpcao($_POST['opcaoId']);
        exit;
    }else if ($_POST['action'] == 'apagarEnquete') {
        Admin::apagarEnquete($_POST['enqueteId']);
        exit;
    }else if ($_POST['action'] == 'atualizarOpcao') {
        Admin::atualizarOpcao($_POST);

        exit;
    }else if ($_POST['action'] == 'atualizarEnquete') {
        Admin::atualizarEnquete($_POST);

        exit;
    }