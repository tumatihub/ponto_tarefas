<?php
    require_once 'GerenciadorDeTarefas.php';
    require_once 'APITarefas.php';
    date_default_timezone_set('Brazil/East');
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
    }

    $acao = $_POST['acao'];

    if (isset($_SESSION['gerenciador'])) {
        $gerenciador = $_SESSION['gerenciador'];
    } else {
        header('Location: login.php');
    }

    $api = new APITarefas($gerenciador);

    switch ($acao) {
        case "adicionaTarefa":
            echo $api->adicionaTarefa($_POST['nome']);
            break;
        case 'pegaTodasAsTarefas':
            $api->recarregaGerenciador();
            $_SESSION['gerenciador'] = $api->getGerenciador();
            echo $api->pegaTodasAsTarefas();
            break;
        case 'removeTarefa':
            echo $api->removeTarefa($_POST['id']);
            break;
        case 'mudaNomeTarefa':
            echo $api->mudaNomeTarefa($_POST['id'], $_POST['nome']);
            break;
        case 'desativaTarefa':
            echo $api->desativaTarefa($_POST['id']);
            break;
        case 'ativaTarefa':
            echo $api->ativaTarefa($_POST['id']);
            break;
        case 'salvaGerenciador':
            echo $api->salvaGerenciador();
            break;
            case 'geraRelatorio':
            echo $api->geraRelatorio();
            break;
    }
