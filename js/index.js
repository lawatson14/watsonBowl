if ("serviceWorker" in navigator){
	navigator.serviceWorker.register("serviceWorker.js").then(registration => {
		console.log("Service worker registered!");
		console.log(registration);	
	}).catch(error => {
		console.log("Service Worker registration failed!");
		console.log(error);
	});
} else {
	console("Browser does not support application");
}