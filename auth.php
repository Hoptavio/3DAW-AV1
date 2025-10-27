<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'sistema_questoes';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    tipo ENUM('adm','aluno') NOT NULL
)";

$sql_perguntas = "CREATE TABLE IF NOT EXISTS perguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(20) NOT NULL,
    pergunta TEXT NOT NULL,
    tipo ENUM('multipla','discursiva') NOT NULL,
    opcoes JSON,
    resp TEXT,
    gab VARCHAR(10),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($sql_users);
$conn->query($sql_perguntas);

$check_users = $conn->query("SELECT COUNT(*) as total FROM users");
$row = $check_users->fetch_assoc();
if ($row['total'] == 0) {
    $conn->query("INSERT INTO users (user, pass, nome, tipo) VALUES 
        ('admin', 'admin', 'Admin', 'adm'),
        ('aluno', 'aluno', 'Aluno', 'aluno')");
}

function carregarUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM users");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

function login($u, $p) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE user = ? AND pass = ?");
    $stmt->bind_param("ss", $u, $p);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $_SESSION['user'] = $user;
        return true;
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
