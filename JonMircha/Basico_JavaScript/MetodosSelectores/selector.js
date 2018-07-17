
// Buscar por etiquetas que en este caso es por 'li' que lo devuelve en un Arreglo de la página Web en Cuestion
document.getElementsByTagName('li')

// Se utilizan los métodos de los arreglos.
document.getElementsByTagName('li').length
// Accesa a la posicion 3 del arreglo.
document.getElementsByTagName('li')[3]

// Ahora accesando por nombre de clase.
// Es tambien un arreglo, 
document.getElementsByClass('menu')

// Buscando por ID de la etiquetas de HTNL
document.getElementById('suscripcion')

// Con el valor "name" de la etiqueta HTML es como se comunica con los lenguajes Backend 
// De igualmente devuelve un arreglo de todas los names de las etiquetas de "HTML"
document.getElementsByName('email')

// Estos dos selectores solo se utilizan desde la version del navegador 9 de Internet Explorer.
// Devuelve un arreglo con todos los selectores buscados.
// Se puede buscar por "ID ( # )", "Etiqueta", "atributo", "Clase( . )"
document.querySelectorAll('.container')

// Ahora por etiquetas de HTML
document.querySelectorAll('section')

// Ahora por atributo de etiquetas de HTML
document.querySelectorAll('[href]')

// Ahora por ID etiquetas de HTML, es único.
document.querySelectorAll('#textoid').

// Devuelve un elemento (Ya no es arreglo, es solo un objeto) con el selector buscado
// Se utiliza para encontrar ID en el HTML solo es uno.
document.querySelector('#unicotexto')




