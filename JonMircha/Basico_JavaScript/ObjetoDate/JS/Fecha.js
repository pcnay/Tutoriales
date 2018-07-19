// SECCION PARA DECLARAR LAS LIBRERIAS

// SECCION PARA DECLARAR LAS VARIABLES OBJETOS

// Definiendo las variables como globales.
// Para que pueda funcionar los eventos del Internvalos de Tiempo.
// Se agrega variables de ejemplo

var unaVez,muchasVeces;


// SECCION PARA DECLARAR LAS FUNCIONES

function mostrarFecha()
{
	var fecha,fechaDiames,fechaCompleta,fechaAsignada,horaCompleta;
	// document.getElementById("tiempo").innerHTML = Date();
	// Lo mismo del anterior, la ventaja es que se puede utilizar tanto en "id" que se representa con # o "class" se representa con . 
	fecha =  document.querySelector("#fecha");

	// No se coloca la almuadilla cuando este por este comando
	fechaDiaMes = document.getElementById("dia_mes");
	// No se coloca la almuadilla cuando este por este comando
	fechaDiaSemana = document.getElementById("dia_semana");
	fechaMes = document.getElementById("mes");
	
	fechaYear= document.getElementById("ans");
	fechaCompleta = document.querySelector("#fec_comp");
	horaCompleta = document.getElementById("horaCompleta");

	fechaAlmomento = new Date();	
	fechaAsignada = new Date(2018,6,19);

	// Escribe la fecha en el DIV con el nombre de "fecha".

	fecha.innerHTML = fechaAlmomento;

	// Arroja el número del día del mes, es un arreglo
	fechaDiaMes.innerHTML = fechaAlmomento.getDate(); 
	
	// Arroja el número del día de la semana, es un arreglo, el primer dia de la semana es Domingo "0"
	fechaDiaSemana.innerHTML = fechaAlmomento.getDay(); 

	// Arroja el número del Mes del año es un arreglo, el primer Mes es "0" Enero 
	fechaMes.innerHTML = fechaAlmomento.getMonth(); 
	fechaYear.innerHTML = fechaAlmomento.getFullYear(); 	
	fechaCompleta.innerHTML = fechaAsignada;

	// Mostrando la hora en formato Completo
	horaCompleta.innerHTML = fechaAlmomento.getHours()+' : '
	+fechaAlmomento.getMinutes()+' : '+fechaAlmomento.getSeconds()+' : '+fechaAlmomento.getMilliseconds();

	// Desplegando la fecha a cadena de texto en la pantalla
	document.write(fechaAlmomento.toString());

	document.write('<br/>'+fechaAlmomento.toDateString());

	// Despliega la fecha y hora en formato local (México DD/MM/AAAA)
	document.write('<br/>'+fechaAlmomento.toLocaleString());

// Despliega la fecha solamente en formato local (México DD/MM/AAAA)
	document.write('<br/>'+'Despliega la Fecha en formato Local usuario '+fechaAlmomento.toLocaleDateString());

	// Despliega la hora solamente en formato local (México HH:MM:SS)
document.write('<br/>'+'Despliega la Hora en formato Local usuario '+fechaAlmomento.toLocaleTimeString());

// Despliega la diferencia de horas del Meridiano de Grenwich 
// Son los minutos de diferencia con el MG., para este caso es 420 min.
document.write('<br/>'+'Despliega la diferencia de Horas con respecto MG : '+fechaAlmomento.getTimezoneOffset());
// Pera desplegar la fecha y hora del Meridiano de Gremwich 
document.write('<br/><br/>'+'UTC Fecha : '+fechaAlmomento.toUTCString());	
document.write('<br/>'+'UTC Fecha : '+fechaAlmomento.getUTCDate());	
document.write('<br/>'+'UTC Fecha : '+fechaAlmomento.getUTCDay());	
document.write('<br/>'+'UTC Fecha : '+fechaAlmomento.getMonth());	
// Todos los demas metodos anteriores pero se agrea la palabra UTC 

// Despliega la fecha pero en formato numerico y en segundos, el año inicial es 1970.
document.write('<br/>'+' Fecha  Formato númerico: '+Date.now());

document.write('<br/>'+' Fecha  Formato númerico: '+fechaAlmomento.valueOf());

}


// SECCION PARA DECLARAR LOS EVENTOS.
window.onload = mostrarFecha;

/* Otra manera de hacerlo.
window.onload = function()
{
	alert ("funciona");
}
*/
