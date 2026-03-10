const CACHE_NAME = "controle-financeiro-v1";

const urlsToCache = [
	"/projetoControle/styles/stylePages.css",
	"/projetoControle/images/logoAtomtech.jpeg"
];

self.addEventListener("fetch", event => {

	if(event.request.method !== "GET") return;

	event.respondWith(

		fetch(event.request)
		.catch(() => caches.match(event.request))

		);

});

self.addEventListener("fetch", event => {

	event.respondWith(
		caches.match(event.request)
		.then(response => {

			if(response){
				return response;
			}

			return fetch(event.request);

		})
		);

});

self.addEventListener("activate", event => {

	event.waitUntil(
		caches.keys().then(keys => {
			return Promise.all(
				keys.filter(key => key !== CACHE_NAME)
				.map(key => caches.delete(key))
				);
		})
		);

});

