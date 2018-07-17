// SECCION PARA DECLARAR LAS LIBRERIAS

// SECCION PARA DECLARAR LAS VARIABLES OBJETOS

// Definiendo las variables como globales.
// Para que pueda funcionar los eventos del Internvalos de Tiempo.
// Se agrega variables de ejemplo

var unaVez,muchasVeces;


// SECCION PARA DECLARAR LAS FUNCIONES

function reloj()
{
	var tiempo;
	// document.getElementById("tiempo").innerHTML = Date();
	// Lo mismo del anterior, la ventaja es que se puede utilizar tanto en "id" que se representa con # o "class" se representa con . 
	tiempo = document.querySelector("#tiempo");
	// EScribe la fecha en el DIV con el nombre de "tiempo".
	tiempo.innerHTML = Date();
}

function ejecutarIntervalos(evento)
{
	var queBoton;
	// Es donde se ejecutan los botones.
	// El evento que lo desencadena es sT.onclick para el caso de "set-timeout"\
	//alert("Se ejecuta la funcion ejecutarIntervalos");

	//Analizando el evento:
	// un atributo (target) que contiene una su vez el atributo "id" que es el que nos identifica como único, se encuentra que se utilizara para determinar que boton se oprimio.
	//console.log(evento);
	//alert (evento.target.id);
	queBoton  = evento.target.id;
	switch (queBoton)
	{		
		case "set-timeout":
			// Esta función requiere como parámetro  una funcion y cuanto tiempo (milesegundos) lo realizará. Además solo se ejecuta una sola vez.
			unaVez = setTimeout("reloj()",2000);
			break;
		case "clear-timeout":
			// Esta función requiere el objeto de setTimeout, por esta razon se asigna a una variable.
			clearTimeout(unaVez);
			break;
		case "set-interval":
			// Se ejecuta cada tiempo que se establezca
			// Se requiere como parametros una función y el tiempo que cada vez se ejecutara.
			muchasVeces = setInterval("reloj()",1000);
			break;
		case "clear-interval":
			// Esta función requiere el objeto de setTimeout, por esta razon se asigna a una variable.
			clearInterval(muchasVeces);
			break;

	}
}

function intervalosTiempo(evento)
{
	// En Javascript tiene 3 objetos padre: Window, Document, Navigator
	// Cuando se trabaja con eventos en JavaScript, se le pasan como parametros a la función su propio evento que lo llamo
	
	// Cuando se quiera analizar un objeto complejo en JavaScript, se utiliza el comando "Console.log"
	// Se utiliza el inspector de objetos del navegador para analizar los métodos y atributos que posee,
	//console.log(evento)
	
	// Los botones son los que originan que se ejecuten las instrucciones para los intervalos de tiempo, que su vez que tiene que asociar al evento click.

	// Ejecutando los botones.
	var sT = document.getElementById("set-timeout"); 
	var cT = document.getElementById("clear-timeout"); 
	var sI = document.getElementById("set-interval"); 
	var cI = document.getElementById("clear-interval"); 

	//<input id ="clear-interval" onclick = "ejecutarIntervalo" type = "button" value = "clear-interval"/>
	// Es lo mismo del anterior, pero con la diferencia que aqui se utilizan buenas practicas de programación. 
	// Se esta relacionando el boton con el evento click del raton, en cad uno de ellos.
	sT.onclick = ejecutarIntervalos;
	cT.onclick = ejecutarIntervalos;
	sI.onclick = ejecutarIntervalos;
	cI.onclick = ejecutarIntervalos;

}


// SECCION PARA DECLARAR LOS EVENTOS.
window.onload = intervalosTiempo;

/* Otra manera de hacerlo.
window.onload = function()
{
	alert ("funciona");
}
*/
