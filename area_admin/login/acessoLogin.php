<?php
session_start();

include '../conexao.php';

if (empty($_POST['email']) && empty($_POST['senha'])) {
    header('Location: ../index.php');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];
// CRIA A SQL PARA EXECUTAR NO BANCO DE DADOS
$sql = "SELECT * FROM usuarios WHERE email = ? and senha = ?";

$preparacao = $conexaoBanco->prepare($sql);

// FALANDO PRO BANCO QUAL SQL VAMOS EXECUTAR
$preparacao->execute([$email, $senha]);

// BUSCA OS DADOS E SALVA NA VARIAVEL DADOS
$usuario = $preparacao->fetch();

$_SESSION['usuarios'] = $usuario['id'];

header("Location: ../../crud/area_admin/adm.php");
