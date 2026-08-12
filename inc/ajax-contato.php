<?php
/**
 * inc/ajax-contato.php
 * Processa o envio do formulário de contato via admin-ajax.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function andrewp_enviar_contato() {

    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'andrewp_contato_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Sessão inválida. Recarregue a página e tente novamente.' ) );
    }

    $nome      = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
    $email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $telefone  = isset( $_POST['telefone'] ) ? sanitize_text_field( wp_unslash( $_POST['telefone'] ) ) : '';
    $assunto   = isset( $_POST['assunto'] ) ? sanitize_text_field( wp_unslash( $_POST['assunto'] ) ) : '';
    $mensagem  = isset( $_POST['mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensagem'] ) ) : '';

    if ( empty( $nome ) || empty( $mensagem ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Preencha nome, e-mail válido e mensagem.' ) );
    }

    $destinatario = get_option( 'admin_email' );
    $titulo       = sprintf( '[Contato do site] %s', $assunto ? $assunto : 'Nova mensagem' );

    $corpo  = "Nome: {$nome}\n";
    $corpo .= "E-mail: {$email}\n";
    $corpo .= "Telefone: {$telefone}\n";
    $corpo .= "Assunto: {$assunto}\n\n";
    $corpo .= "Mensagem:\n{$mensagem}\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    if ( $email ) {
        $headers[] = "Reply-To: {$nome} <{$email}>";
    }

    $enviado = wp_mail( $destinatario, $titulo, $corpo, $headers );

    if ( $enviado ) {
        wp_send_json_success( array( 'message' => 'Mensagem enviada com sucesso! Retorno em breve.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Não foi possível enviar. Tente novamente mais tarde.' ) );
    }
}
add_action( 'wp_ajax_andrewp_enviar_contato', 'andrewp_enviar_contato' );
add_action( 'wp_ajax_nopriv_andrewp_enviar_contato', 'andrewp_enviar_contato' );