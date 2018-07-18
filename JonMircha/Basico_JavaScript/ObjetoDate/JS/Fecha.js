// SECCION PARA DECLARAR LAS LIBRERIAS

// SECCION PARA DECLARAR LAS VARIABLES OBJETOS

// Definiendo las variables como globales.
// Para que pueda funcionar los eventos del Internvalos de Tiempo.
// Se agrega variables de ejemplo

var unaVez,muchasVeces;


// SECCION PARA DECLARAR LAS FUNCIONES

function mostrarFecha()
{
	var fecha,fechaDiames;
	// document.getElementById("tiempo").innerHTML = Date();
	// Lo mismo del anterior, la ventaja es que se puede utilizar tanto en "id" que se representa con # o "class" se representa con . 
	fecha =  document.querySelector("#fecha");

	// No se coloca la almuadilla cuando este por este comando
	fechaDiaMes = document.getElementById("dia_mes");
	// No se coloca la almuadilla cuando este por este comando
	fechaDiaSemana = document.getElementById("dia_semana");
	fechaMes = document.getElementById("mes");
	
	fechaYear= document.getElementById("ans");

	fechaAlmomento = new Date();	

	// Escribe la fecha en el DIV con el nombre de "fecha".

	fecha.innerHTML = fechaAlmomento;

	// Arroja el número del día del mes, es un arreglo
	fechaDiaMes.innerHTML = fechaAlmomento.getDate(); 
	
	// Arroja el número del día de la semana, es un arreglo, el primer dia de la semana es Domingo "0"
	fechaDiaSemana.innerHTML = fechaAlmomento.getDay(); 

	// Arroja el número del Mes del año es un arreglo, el primer Mes es "0" Enero 
	fechaMes.innerHTML = fechaAlmomento.getMonth(); 
	fechaYear.innerHTML = fechaAlmomento.getFullYear(); 		
}

// SECCION PARA DECLARAR LOS EVENTOS.
window.onload = mostrarFecha;

/* Otra manera de hacerlo.
window.onload = function()
{
	alert ("funciona");
}
*/
