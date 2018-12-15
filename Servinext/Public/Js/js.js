function reloadPage(url)
 {
   // Recarga la página que se indica en "url" después de 3 seg. La URL son las rutas amigables del menú general.
	setTimeout(function (){
		window.location.href = url
  }, 3000);
}
