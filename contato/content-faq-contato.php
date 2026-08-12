<?php
/**
 * contato/content-faq-contato.php
 * Section 3 — FAQ em accordion, duas colunas.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$andrewp_faq_contato = array(
    array(
        'pergunta' => 'Como contratar uma palestra ou consultoria?',
        'resposta' => 'Entre em contato pelo formulário ou WhatsApp informando o tema de interesse, formato e data. Retornarei com uma proposta personalizada.',
    ),
    array(
        'pergunta' => 'Quais os formatos de palestras disponíveis?',
        'resposta' => 'Palestras presenciais, online e híbridas, com duração e conteúdo adaptados ao público e ao evento.',
    ),
    array(
        'pergunta' => 'Bruno Mota atende fora de Salvador?',
        'resposta' => 'Sim, atendimentos presenciais em outras cidades e estados são realizados sob agenda e condições combinadas previamente.',
    ),
    array(
        'pergunta' => 'É possível realizar palestras online?',
        'resposta' => 'Sim, palestras e consultorias também são realizadas em formato online, via plataformas de videoconferência.',
    ),
    array(
        'pergunta' => 'Qual o tempo de resposta para contato?',
        'resposta' => 'O retorno é feito em até 24 horas úteis após o envio da mensagem.',
    ),
    array(
        'pergunta' => 'Bruno Mota participa de eventos ou congressos?',
        'resposta' => 'Sim, participações em congressos, painéis e eventos corporativos são avaliadas conforme agenda disponível.',
    ),
    array(
        'pergunta' => 'É possível sugerir temas para palestras?',
        'resposta' => 'Sim, temas podem ser sugeridos e adaptados de acordo com a necessidade do evento ou empresa.',
    ),
    array(
        'pergunta' => 'Como funciona o processo de consultoria?',
        'resposta' => 'Após o primeiro contato, é feito um diagnóstico inicial para entender o escopo e propor um plano de trabalho.',
    ),
    array(
        'pergunta' => 'Quais informações são necessárias para solicitar um orçamento?',
        'resposta' => 'Tema, formato, data prevista, público estimado e local (ou se será online) ajudam a montar uma proposta precisa.',
    ),
    array(
        'pergunta' => 'Quais as formas de pagamento aceitas?',
        'resposta' => 'As formas de pagamento são combinadas conforme o tipo de serviço contratado, informadas na proposta.',
    ),
    array(
        'pergunta' => 'Vocês emitem nota fiscal?',
        'resposta' => 'Sim, nota fiscal é emitida para todos os serviços contratados.',
    ),
    array(
        'pergunta' => 'Há materiais de apoio ou conteúdos disponíveis?',
        'resposta' => 'Sim, materiais e conteúdos de apoio podem ser disponibilizados conforme o tipo de palestra ou consultoria.',
    ),
    array(
        'pergunta' => 'Com quanto tempo de antecedência devo entrar em contato?',
        'resposta' => 'Recomenda-se entrar em contato com pelo menos 30 dias de antecedência para garantir disponibilidade na agenda.',
    ),
);

$andrewp_faq_metade = ceil( count( $andrewp_faq_contato ) / 2 );
$andrewp_faq_col1   = array_slice( $andrewp_faq_contato, 0, $andrewp_faq_metade );
$andrewp_faq_col2   = array_slice( $andrewp_faq_contato, $andrewp_faq_metade );
?>
<section class="contato-faq">
    <div class="contato-faq__inner">

        <div class="contato-faq__intro">
            <span class="contato-faq__eyebrow">FAQ</span>
            <h2 class="contato-faq__title">Perguntas<br>frequentes</h2>
            <div class="contato-faq__divider"></div>
            <p class="contato-faq__text">
                Tire suas dúvidas sobre atendimentos, palestras, consultorias e parcerias.
            </p>

            <div class="contato-faq__help-box">
                <span class="contato-faq__help-icon" aria-hidden="true">
                    <i class="fa-regular fa-circle-question"></i>
                </span>
                <div>
                    <strong>Ainda tem dúvidas?</strong>
                    <span>Entre em contato conosco.</span>
                    <a href="#form-contato" class="contato-faq__help-link">
                        Falar com a equipe <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="contato-faq__columns">
            <?php foreach ( array( $andrewp_faq_col1, $andrewp_faq_col2 ) as $andrewp_faq_col ) : ?>
                <div class="contato-faq__column">
                    <?php foreach ( $andrewp_faq_col as $andrewp_item ) : ?>
                        <div class="contato-faq__item">
                            <button type="button" class="contato-faq__question" aria-expanded="false">
                                <span><?php echo esc_html( $andrewp_item['pergunta'] ); ?></span>
                                <i class="fa-solid fa-plus contato-faq__toggle-icon" aria-hidden="true"></i>
                            </button>
                            <div class="contato-faq__answer">
                                <p><?php echo esc_html( $andrewp_item['resposta'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>