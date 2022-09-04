<?php
    include '../conexao.php';
    
    session_start();

    unset($_SESSION['usuarios']);

    header('Location: ' . '../index.php');