function validarForm()
{
  // Procesando el formulario.
  var verificar = true;
  /* /^ = Inicia la expresion regular.
    $/ = Termina la expresión regular.
    /s = Para espacios de blanco.
  */
  var expRegNombre = /^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$/;
  var expRegEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  var formulario = document.getElementById("contacto-frm");
  var nombre = document.getElementById("nombre");
  var edad = document.getElementById("edad");
  var email = document.getElementById("email");  
  var masculino = document.getElementById("M");
  var femenino = document.getElementById("F");
  var asunto = document.getElementById("asunto");
  var comentarios = document.getElementById("comentarios");  

  // Validando si el campo esta vacio.
  if (!nombre.value) // (nombre.value =="")
  {
    alert("El campo nombre es requerido");
    nombre.focus();
    verificar = false;
  } // validando con expresiones regulares.
  else if (!expRegNombre.exec(nombre.value))
  {
    alert("El campo nombre solo acepta letras y espacios en blanco.");
    nombre.focus();
    verificar = false;
  }
  else if (!edad.value)
  {
    alert("El campo Edad es requerido");
    edad.focus();
    verificar = false;
  } 
  else if (isNaN(edad.value)) // is Not a Number
  {
    alert("El campo edad solo acepta números");
    edad.focus();
    verificar = false;
  } // Validando el rangos de Edad.
  else if (edad.value < 18 || edad.value > 60)
  {
    alert("Debes estas en el rango de edad de 18 y 60 años ");
    edad.focus();
    verificar = false;
  }
  else if (!email.value) 
  {
    alert("El campo email es requerido");
    email.focus();
    verificar = false;
  }
  else if (!expRegEmail.exec(email.value))
  {
    alert("El campo email no es valido");
    email.focus();
    verificar = false;
  }
  else if (!masculino.checked && !femenino.checked)
  {
    alert("El campo Sexo es requerido");
    femenino.focus();
    verificar = false;
  }
  else if (!asunto.value)
  {
    alert("El campo asunto es requerido");
    asunto.focus();
    verificar = false;
  }
  else if (!comentarios.value)
  {
    alert("El campo comentario es requerido");
    comentarios.focus();
    verificar = false;
  }
  else if (comentarios.value.length > 255)
  {
    alert("El campo comentario no puede tener mas de 255 caracteres ");
    comentarios.focus();
    verificar = false;
  }
 
  if (verificar == true)
  {
    alert("Se ha procesado");
    // document.getElementById("contacto-frm").submit();
  }
}

function limpiarForm()
{
  // Limpiando el formulario, se coloca el ID del formulario.
  document.getElementById("contacto-frm").reset();

}

// Cuando cargue la página.
window.onload = function()
{
  var botonEnviar,botonLimpiar;
  // Accesando a un elemento del HTML
  botonLimpiar = document.getElementById("limpiar");
  // Cuando se realice un click en la etiqueta boton se ejecuta la función "limpiarForm", es la manera correcta de invocar los eventos en JavaScript.
  botonLimpiar.onclick = limpiarForm;

  // otra forma de accesar a una etiqueta de HTML.
  // Se utiliza el nombre de la etiqueta (Class)
  botonEnviar = document.contacto_frm.enviar_btn; 
  botonEnviar.onclick = validarForm;


}