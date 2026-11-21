<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "<h1>Erro 405 - Method Not Allowed</h1>";
    echo "<p>O acesso direto a este script via GET não é permitido.</p>";
    echo "<a href='index.html'>Voltar ao formulário</a>";
    exit;
}


$nome        = trim($_POST['nome'] ?? '');
$email       = trim($_POST['email'] ?? '');
$experiencia = trim($_POST['experiencia'] ?? '');
$turno       = trim($_POST['turno'] ?? '');
$oficinas    = $_POST['oficinas'] ?? [];
$mensagem    = trim($_POST['mensagem'] ?? '');

$erros = [];

if (mb_strlen($nome) < 3) {
    $erros[] = "O nome completo deve conter pelo menos 3 caracteres.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "O endereço de e-mail informado é inválido.";
}

$niveisPermitidos = ['iniciante', 'intermediario', 'avancado'];
if (!in_array($experiencia, $niveisPermitidos, true)) {
    $erros[] = "O nível de experiência selecionado é inválido.";
}

$turnosPermitidos = ['manha', 'noite'];
if (!in_array($turno, $turnosPermitidos, true)) {
    $erros[] = "O turno de preferência selecionado é inválido.";
}

$oficinasPermitidas = ['html_css', 'js_dom', 'php_backend'];
if (!is_array($oficinas) || empty($oficinas)) {
    $erros[] = "Você deve selecionar pelo menos uma oficina de interesse.";
} else {
    foreach ($oficinas as $oficina) {
        if (!in_array($oficina, $oficinasPermitidas, true)) {
            $erros[] = "Uma das oficinas selecionadas é inválida.";
            break;
        }
    }
}

if (mb_strlen($mensagem) > 200) {
    $erros[] = "A mensagem excede o limite máximo de 200 caracteres.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Experience 2026 - Resultado da Inscrição</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <?php if (!empty($erros)): ?>
            <h2 style="color: #e74c3c;">Ocorreram erros no preenchimento:</h2>
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
            <br>
            <a href="index.html">&larr; Voltar e corrigir</a>

        <?php else: ?>
            <h2 style="color: #27ae60;">Inscrição Realizada com Sucesso!</h2>
            <p>Confira abaixo os dados cadastrados no evento:</p>
            
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>E-mail:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Nível de Experiência:</strong> <?php echo htmlspecialchars($experiencia, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Turno:</strong> <?php echo htmlspecialchars($turno, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Oficinas Escolhidas:</strong></p>
            <ul>
                <?php foreach ($oficinas as $of): ?>
                    <li><?php echo htmlspecialchars($of, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
            <?php if (!empty($mensagem)): ?>
                <p><strong>Mensagem:</strong> <?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <br>
            <a href="index.html">Realizar nova inscrição</a>
        <?php endif; ?>
    </main>
</body>
</html>