// Creando un elemento "li"
ol_list = document.querySelector('.tutorials').querySelector('ol')
li_item = document.createElement('li')
li_text = documento.createTextNode('Este es un elemento nuevo de la lista ')


// Agregando una etiqueta al HTML
ol_list.appendChild(li_item)
// Borrando una etiqueta al HTML
ol_list.removeChild(li_item)

// Genera un arreglo con todos los hijos del nodo en cuestion.
ol_list.children  

// Borrando un elemento hijo en cuestion.
ol_list.removeChildren(ol_listchildren[0])

// Otro ejemplo, agregando un elemento al final de una lista en HTML, esta lista ya esta creada.
var li_Fundamentos = document.createElement('li')
var li_H2_fundamentos = document.createElement('h2')
var li_H2_A_fundamentos = document.createElement('a') // Es un enlace href
var aTexto = document.createTextNode('Fundamentos')

// Agregando los atributos que contiene este enlace, como los es "href" y "_blank"
li_H2_A_fundamentos.href = 'https://www.google.com'
li_H2_A_fundamentos.target = '_blank' // LO abre en una nueva pestaña 

// Asociar los nodos
li_H2_A_fundamentos.appendChild(aTexto)
li_H2_fundamentos.appendChild(li_H2_A_fundamentos)
li_Fundamentos.appendChild(li_H2_fundamentos)
ol_list.appendChild(li_Fundamentos)

