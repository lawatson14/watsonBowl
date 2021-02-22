self.addEventListener("install", e => {
	e.waitUntil(
		caches.open("Watson Bowl - static").then(cache => {
			return cache.addAll([
				"./",
				"./images/fitnessLogo16.png",
				"./images/fitnessLogo192.png",
				"./images/fitnessLogo512.png",
				"./css/stylesheet.css",
			]);
		})
	);
});

self.addEventListener("fetch", e => {
	e.respondWith(
		caches.match(e.request).then(response => {
			return response || fetch(e.request);
		})
	);
});
