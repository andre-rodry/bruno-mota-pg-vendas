<?php
/**
 * content-faq-contato.php
 * Partial: seção "Perguntas frequentes" (FAQ) em accordion.
 *
 * O accordion abre via <details>/<summary> nativos e é suavizado
 * pelo page-faq-contato.js (Web Animations API). Sem JS, ainda
 * funciona normalmente — só perde a animação suave.
 *
 * Para editar as perguntas/respostas, mexa apenas no array $faq_itens abaixo.
 * O último item do array é renderizado ocupando a linha inteira
 * (igual ao layout de referência).
 *
 * IMPORTANTE (layout em 2 colunas):
 * As perguntas são distribuídas em DUAS COLUNAS FIXAS (.faq-coluna),
 * uma div por coluna, e NÃO via `columns: 2` no CSS. Isso é proposital:
 * o balanceamento automático de colunas do navegador realoca itens entre
 * colunas sempre que a altura de um deles muda (abrir/fechar accordion),
 * fazendo um clique "mexer" visualmente em outro item que nem foi tocado.
 * Com colunas fixas, cada item tem posição definida no PHP e nunca migra
 * de coluna — abrir um item só afeta os itens abaixo dele na MESMA coluna
 * (empurrando para baixo, como é esperado num accordion normal).
 */

$faq_itens = [
    [
        'pergunta' => 'Como contratar uma palestra ou consultoria?',
        'resposta' => 'Entre em contato pelo formulário ou WhatsApp informando o tema de interesse, formato desejado e data prevista. A partir daí, alinhamos os detalhes e enviamos uma proposta.',
    ],
    [
        'pergunta' => 'Quais os formatos de palestras disponíveis?',
        'resposta' => 'As palestras podem ser presenciais, online ao vivo ou híbridas, com duração ajustável conforme o evento e o público.',
    ],
    [
        'pergunta' => 'Bruno Mota atende fora de Salvador?',
        'resposta' => 'Sim, atendimentos presenciais são realizados em todo o Brasil, mediante disponibilidade de agenda e custos de deslocamento.',
    ],
    [
        'pergunta' => 'É possível realizar palestras online?',
        'resposta' => 'Sim, palestras e treinamentos podem ser feitos totalmente online, ao vivo, via plataformas como Zoom, Teams ou Google Meet.',
    ],
    [
        'pergunta' => 'Qual o tempo de resposta para contato?',
        'resposta' => 'O retorno costuma acontecer em até 1 dia útil após o envio da mensagem pelo formulário ou WhatsApp.',
    ],
    [
        'pergunta' => 'Bruno Mota participa de eventos ou congressos?',
        'resposta' => 'Sim, participações em eventos, congressos e feiras do setor são avaliadas conforme tema, formato e agenda disponível.',
    ],
    [
        'pergunta' => 'É possível sugerir temas para palestras?',
        'resposta' => 'Sim, temas específicos podem ser propostos e adaptados de acordo com a necessidade do evento ou da empresa contratante.',
    ],
    [
        'pergunta' => 'Como funciona o processo de consultoria?',
        'resposta' => 'O processo começa com um diagnóstico inicial, seguido de um plano de ação personalizado e acompanhamento das etapas definidas.',
    ],
    [
        'pergunta' => 'Quais informações são necessárias para solicitar um orçamento?',
        'resposta' => 'É importante informar tipo de serviço, tema, data, local (ou se será online), público estimado e orçamento disponível, quando houver.',
    ],
    [
        'pergunta' => 'Quais as formas de pagamento aceitas?',
        'resposta' => 'As formas de pagamento são combinadas conforme o tipo de contratação e informadas na proposta comercial.',
    ],
    [
        'pergunta' => 'Vocês emitem nota fiscal?',
        'resposta' => 'Sim, nota fiscal é emitida para todos os serviços contratados.',
    ],
    [
        'pergunta' => 'Há materiais de apoio ou conteúdos disponíveis?',
        'resposta' => 'Sim, materiais complementares como slides, e-books ou resumos podem ser disponibilizados conforme o serviço contratado.',
    ],
    [
        'pergunta' => 'Com quanto tempo de antecedência devo entrar em contato?',
        'resposta' => 'O ideal é entrar em contato com pelo menos 30 dias de antecedência, garantindo disponibilidade de agenda e tempo para o planejamento do serviço.',
    ],
];

$total_itens = count($faq_itens);

// Último item ocupa a linha inteira; os demais se dividem, alternadamente,
// em duas colunas FIXAS (não usamos mais `columns:2` do CSS — ver nota acima).
$item_final    = $faq_itens[$total_itens - 1];
$itens_colunas = array_slice($faq_itens, 0, $total_itens - 1);

$coluna_esquerda = [];
$coluna_direita  = [];
foreach ($itens_colunas as $indice => $item) {
    if ($indice % 2 === 0) {
        $coluna_esquerda[] = $item;
    } else {
        $coluna_direita[] = $item;
    }
}

/**
 * Renderiza um único item do accordion.
 */
function faq_renderiza_item(array $item, string $classe_extra = ''): void
{
    ?>
    <details class="faq-item<?php echo $classe_extra ? ' ' . $classe_extra : ''; ?>">
        <summary class="faq-pergunta">
            <span class="faq-pergunta-texto"><?php echo htmlspecialchars($item['pergunta'], ENT_QUOTES, 'UTF-8'); ?></span>
            <span class="faq-toggle" aria-hidden="true"></span>
        </summary>
        <div class="faq-resposta">
            <p><?php echo htmlspecialchars($item['resposta'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </details>
    <?php
}
?>

<section class="faq-section" id="faq">
    <div class="faq-container">

        <div class="faq-info">
            <span class="faq-eyebrow">FAQ</span>
            <h2 class="faq-titulo">Perguntas<br>frequentes</h2>
            <div class="faq-divisor" aria-hidden="true"></div>
            <p class="faq-texto">
                Tire suas dúvidas sobre atendimentos,
                palestras, consultorias e parcerias.
            </p>

            <div class="faq-suporte">
                <span class="faq-suporte-icone" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="3.2" stroke="currentColor" stroke-width="1.6"/>
                        <path d="M5.5 19.5c1.2-3.3 3.9-5 6.5-5s5.3 1.7 6.5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </span>
                <div class="faq-suporte-texto">
                    <p class="faq-suporte-titulo">Ainda tem dúvidas?</p>
                    <p class="faq-suporte-sub">Fale diretamente comigo.</p>
                    <a href="#contato" class="faq-suporte-link">
                        Falar com Bruno Mota
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="faq-lista">
            <div class="faq-coluna">
                <?php foreach ($coluna_esquerda as $item): faq_renderiza_item($item); endforeach; ?>
            </div>
            <div class="faq-coluna">
                <?php foreach ($coluna_direita as $item): faq_renderiza_item($item); endforeach; ?>
            </div>
            <?php faq_renderiza_item($item_final, 'faq-item-full'); ?>
        </div>

    </div>
</section>

<script src="/assets/js/page-faq-contato.js" defer></script>