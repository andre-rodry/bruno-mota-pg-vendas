<?php
/**
 * ajax-contato.php
 * Recebe o POST do formulário de contato (fetch/AJAX), valida,
 * sanitiza e envia o e-mail. Responde sempre em JSON.
 *
 * IMPORTANTE:
 * - Ajuste $destinatario para o e-mail que deve receber as mensagens.
 * - Em produção, prefira PHPMailer + SMTP autenticado a mail() nativo,
 *   pois muitos hosts bloqueiam/limitam mail() e ele cai em spam com facilidade.
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

// ---------- Configurações ----------
$destinatario   = 'contato@seudominio.com.br'; // <-- ALTERE AQUI
$assunto_prefixo = '[Site] Nova mensagem de contato';
$limite_por_minuto = 3; // rate limit simples por sessão

// ---------- Helpers ----------

function responder(bool $success, string $message, array $errors = [], int $status = 200): void
{
    http_response_code($status);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'errors'  => $errors,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function limpar(string $valor): string
{
    return trim(strip_tags($valor));
}

// ---------- Método ----------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método não permitido.', [], 405);
}

// ---------- Honeypot ----------

if (!empty($_POST['website'])) {
    // Bot preencheu o campo escondido: finge sucesso, mas não envia nada.
    responder(true, 'Mensagem enviada com sucesso!');
}

// ---------- CSRF token ----------

$tokenEnviado = $_POST['contato_token'] ?? '';
$tokenSessao  = $_SESSION['contato_token'] ?? '';

if (empty($tokenSessao) || !hash_equals($tokenSessao, $tokenEnviado)) {
    responder(false, 'Sessão expirada. Atualize a página e tente novamente.', [], 419);
}

// ---------- Rate limit simples ----------

$agora = time();
$ultimoEnvio = $_SESSION['contato_ultimo_envio'] ?? 0;
$contadorEnvio = $_SESSION['contato_contador'] ?? 0;

if ($agora - $ultimoEnvio < 60) {
    if ($contadorEnvio >= $limite_por_minuto) {
        responder(false, 'Muitas tentativas. Aguarde um instante e tente novamente.', [], 429);
    }
    $_SESSION['contato_contador'] = $contadorEnvio + 1;
} else {
    $_SESSION['contato_contador'] = 1;
}
$_SESSION['contato_ultimo_envio'] = $agora;

// ---------- Coleta e sanitização ----------

$nome     = limpar($_POST['nome'] ?? '');
$email    = limpar($_POST['email'] ?? '');
$telefone = limpar($_POST['telefone'] ?? '');
$assunto  = limpar($_POST['assunto'] ?? '');
$mensagem = limpar($_POST['mensagem'] ?? '');

// ---------- Validação ----------

$erros = [];

if (mb_strlen($nome) < 2) {
    $erros['nome'] = 'Informe seu nome completo.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros['email'] = 'Informe um e-mail válido.';
}

$telefoneDigitos = preg_replace('/\D/', '', $telefone);
if (strlen((string) $telefoneDigitos) < 10) {
    $erros['telefone'] = 'Informe um telefone/WhatsApp válido.';
}

if (mb_strlen($mensagem) < 10) {
    $erros['mensagem'] = 'Escreva uma mensagem com pelo menos 10 caracteres.';
}

if (!empty($erros)) {
    responder(false, 'Verifique os campos destacados e tente novamente.', $erros, 422);
}

// ---------- Monta e envia o e-mail ----------

$assuntoFinal = $assunto_prefixo . ($assunto !== '' ? ': ' . $assunto : '');

$corpo  = "Nova mensagem recebida pelo formulário de contato do site:\n\n";
$corpo .= "Nome: {$nome}\n";
$corpo .= "E-mail: {$email}\n";
$corpo .= "Telefone/WhatsApp: {$telefone}\n";
$corpo .= "Assunto: " . ($assunto !== '' ? $assunto : '(não informado)') . "\n\n";
$corpo .= "Mensagem:\n{$mensagem}\n";

$headers   = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'From: ' . 'Site <naoresponder@' . ($_SERVER['SERVER_NAME'] ?? 'seudominio.com.br') . '>';
$headers[] = 'Reply-To: ' . $nome . ' <' . $email . '>';
$headers[] = 'X-Mailer: PHP/' . phpversion();

$enviado = @mail($destinatario, $assuntoFinal, $corpo, implode("\r\n", $headers));

if (!$enviado) {
    responder(false, 'Não foi possível enviar sua mensagem agora. Tente novamente em instantes.', [], 500);
}

// Renova o token para o próximo envio
$_SESSION['contato_token'] = bin2hex(random_bytes(32));

responder(true, 'Mensagem enviada com sucesso! Em breve entrarei em contato.');