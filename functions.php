<?php
require_once 'helpers/Log.php';

$pdo = new PDO('mysql:host=localhost;dbname=project-211', 'root', '');

session_start();

function dump($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function redirect($page)
{
    header("Location: index.php?page=$page");
    exit;
}