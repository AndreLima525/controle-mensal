const CACHE_NAME = "controle-financeiro-v2";

const urlsToCache = [
    "/projetoControle/styles/stylePages.css",
    "/projetoControle/images/logoAtomtech.jpeg"
];


// ================================
// INSTALAÇÃO
// ================================
self.addEventListener("install", event => {

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );

    self.skipWaiting();
});


// ================================
// ATIVAÇÃO
// ================================
self.addEventListener("activate", event => {

    event.waitUntil(

        caches.keys().then(keys => {

            return Promise.all(

                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))

            );

        }).then(() => {

            return self.clients.claim();

        })

    );

});


// ================================
// REQUISIÇÕES
// ================================
self.addEventListener("fetch", event => {

    // NÃO interceptar POST
    if (event.request.method !== "GET") {
        return;
    }

    // Para GET:
    // tenta buscar a versão atual no servidor.
    // Se estiver offline, usa o cache.
    event.respondWith(

        fetch(event.request)
            .then(response => {

                // Não cacheia respostas inválidas
                if (!response || response.status !== 200) {
                    return response;
                }

                return response;

            })
            .catch(() => {

                return caches.match(event.request);

            })

    );

});