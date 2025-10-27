<?php
session_start();

$users_file = 'users.json';

if (!file_exists($users_file)) {
    $default = [
        ['id' => 1, 'user' => 'admin', 'pass' => 'admin', 'nome' => 'Admin', 'tipo' => 'adm'],
        ['id' => 2, 'user' => 'aluno', 'pass' => 'aluno', 'nome' => 'Aluno', 'tipo' => 'aluno']
    ];
    file_put_contents($users_file, json_encode($default));
}

function carregarUsers() {
    global $users_file;
    return json_decode(file_get_contents($users_file), true);
}

function login($u, $p) {
    $users = carregarUsers();
    foreach ($users as $user) {
        if ($user['user'] === $u && $user['pass'] === $p) {
            $_SESSION['user'] = $user;
            return true;
        }
    }
    return false;
}

function logado() {
    return isset($_SESSION['user']);
}

function adm() {
    return isset($_SESSION['user']) && $_SESSION['user']['tipo'] === 'adm';
}

if (isset($_GET['sair'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>