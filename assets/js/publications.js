// URL da REST API do site atual, injetada pelo PHP via wp_localize_script
// (ver functions.php: wp_localize_script('meu-tema-publications', 'publicationsData', ...))
const PUB_REST_BASE = (typeof publicationsData !== "undefined" && publicationsData.restUrl)
  ? publicationsData.restUrl
  : "/wp-json/wp/v2/"; // fallback, caso o script rode fora do WordPress

const PUB_QUANTIDADE = 2;
const PUB_CATEGORIA_SLUG = ""; // ex: "financas" para filtrar só uma categoria

async function carregarArtigosPublications() {
  const container = document.getElementById("publications-artigos-list");
  if (!container) return;

  try {
    let categoryParam = "";
    if (PUB_CATEGORIA_SLUG) {
      const catRes = await fetch(`${PUB_REST_BASE}categories?slug=${PUB_CATEGORIA_SLUG}`);
      const cats = await catRes.json();
      if (cats.length > 0) categoryParam = `&categories=${cats[0].id}`;
    }

    const res = await fetch(
      `${PUB_REST_BASE}posts?per_page=${PUB_QUANTIDADE}&_embed${categoryParam}`
    );
    if (!res.ok) throw new Error(`Erro HTTP ${res.status}`);

    const posts = await res.json();
    if (!posts.length) {
      container.innerHTML = `<p class="publications-status">Nenhum artigo encontrado.</p>`;
      return;
    }

    container.innerHTML = posts.map(post => {
      const titulo = post.title.rendered;
      const link = post.link;
      const media = post._embedded?.["wp:featuredmedia"]?.[0];
      const imagem = media?.source_url || "";

      return `
        <div class="publications-artigo-item">
          ${imagem ? `<img class="publications-artigo-thumb" src="${imagem}" alt="">` : `<div class="publications-artigo-thumb"></div>`}
          <div class="publications-artigo-body">
            <h4>${titulo}</h4>
            <a class="publications-leia-mais" href="${link}" target="_blank" rel="noopener">Leia mais &rarr;</a>
          </div>
        </div>
      `;
    }).join("");

  } catch (err) {
    console.error(err);
    container.innerHTML = `<p class="publications-status publications-status--error">Não foi possível carregar os artigos (${err.message}). Verifique se a REST API do WordPress está acessível nesse domínio.</p>`;
  }
}

carregarArtigosPublications();

/* =======================================================
   ENTREVISTAS E COLUNAS
   Conteúdo externo (não vem do WordPress). Edite este array
   com as entrevistas/colunas reais e os links de destino.
   ======================================================= */
const PUB_ENTREVISTAS = [
  {
    logo: "https://placehold.co/120x120/eb1c24/ffffff?text=Outras",
    label: "Coluna semanal",
    titulo: "Outras Palavras",
    link: "#" // troque pelo link real da coluna
  },
  {
    logo: "https://placehold.co/120x120/c1272d/ffffff?text=RED",
    label: "Artigo publicado no portal RED",
    titulo: "Rede Brasil Atual",
    link: "#" // troque pelo link real do artigo
  },
  {
    logo: "https://placehold.co/120x120/16233d/ffffff?text=CBN",
    label: "Entrevista em rádio",
    titulo: "CBN Salvador",
    link: "#"
  },
  {
    logo: "https://placehold.co/120x120/22345a/ffffff?text=A+Tarde",
    label: "Artigo de opinião",
    titulo: "Jornal A Tarde",
    link: "#"
  },
  {
    logo: "https://placehold.co/120x120/22345a/ffffff?text=A+Tarde",
    label: "Artigo de opinião",
    titulo: "Jornal A Tarde",
    link: "#"
  }
];

const PUB_ITENS_POR_PAGINA = 2;
const PUB_INTERVALO_MS = 5000;

function montarCarrosselEntrevistasPublications() {
  const track = document.getElementById("publications-entrevistas-track");
  const dotsWrap = document.getElementById("publications-entrevistas-dots");
  if (!track || !dotsWrap) return;

  const paginas = [];
  for (let i = 0; i < PUB_ENTREVISTAS.length; i += PUB_ITENS_POR_PAGINA) {
    paginas.push(PUB_ENTREVISTAS.slice(i, i + PUB_ITENS_POR_PAGINA));
  }

  track.innerHTML = paginas.map(pagina => `
    <div class="publications-entrevistas-page">
      ${pagina.map(item => `
        <div class="publications-entrevista-item">
          <div class="publications-entrevista-logo"><img src="${item.logo}" alt="${item.titulo}"></div>
          <div class="publications-entrevista-body">
            <p>${item.label}</p>
            <h4>${item.titulo}</h4>
            <a class="publications-leia-mais" href="${item.link}" target="_blank" rel="noopener">Leia mais &rarr;</a>
          </div>
        </div>
      `).join("")}
    </div>
  `).join("");

  dotsWrap.innerHTML = paginas.map((_, i) =>
    `<button data-index="${i}" class="${i === 0 ? "active" : ""}"></button>`
  ).join("");

  let atual = 0;
  const dots = [...dotsWrap.querySelectorAll("button")];

  function irPara(index) {
    atual = index;
    track.style.transform = `translateX(-${atual * 100}%)`;
    dots.forEach((d, i) => d.classList.toggle("active", i === atual));
  }

  dots.forEach(dot => {
    dot.addEventListener("click", () => irPara(Number(dot.dataset.index)));
  });

  if (paginas.length > 1) {
    setInterval(() => {
      irPara((atual + 1) % paginas.length);
    }, PUB_INTERVALO_MS);
  }
}

montarCarrosselEntrevistasPublications();