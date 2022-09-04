<?php
session_start();
    if (empty($_SESSION['usuarios'])) {
        header('Location: ' . '../../crud/area_admin/adm.php');
        exit;
    }
   