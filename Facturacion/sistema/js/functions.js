// alert ("Hola Mundo");
$(document).ready(function(){

  //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
  $("#foto").on("change",function(){
    var uploadFoto = document.getElementById("foto").value;
      var foto       = document.getElementById("foto").files;
      var nav = window.URL || window.webkitURL;
      var contactAlert = document.getElementById('form_alert');
      
          if(uploadFoto !='')
          {
              var type = foto[0].type;
              var name = foto[0].name;
              if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
              {
                  contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                  $("#img").remove();
                  $(".delPhoto").addClass('notBlock');
                  $('#foto').val('');
                  return false;
              }else{  
                      contactAlert.innerHTML='';
                      $("#img").remove();
                      $(".delPhoto").removeClass('notBlock');
                      var objeto_url = nav.createObjectURL(this.files[0]);
                      $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                      $(".upimg label").remove();
                      
                  }
            }else{
              alert("No selecciono foto");
              $("#img").remove();
            }              
  });

  $('.delPhoto').click(function(){
    $('#foto').val('');
    $(".delPhoto").addClass('notBlock');
    $("#img").remove();
    
    // Editar Producto, para cuando guarde el producto le asigne el nombre de archivo "img_producto.png"
  
    if ($("#foto_actual") && $("#foto_remove"))
    {
      $("#foto_remove").val('img_producto.png');
    }
  
  });

// Creando la ventana "Modal" Add Product
  $('.add_product').click(function(e)
  {  
    e.preventDefault(); // No recarga la ventana cuando se oprima el boton "Agregar".
    var producto = $(this).attr('product');
    var action = 'infoProducto';
    //alert(producto);
    // Se utiliza Ajax para obtener informacion del producto
      $.ajax
      ({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:{action:action,producto:producto},

        success: function(response)
        {
          // Muestra el formato JSon
          //console.log(response);
          // Verifica si esta retornando un arreglo en formato JSon
          if (response != 'error')
          {
            // Convertir el formato JSon(Texto) a un objeto
            var info = JSON.parse(response);
            //console.log(info);
            // header.php -> form(form_add_product) ->id (product_id) se le asigna "

            //$('#producto_id').val(info.codproducto);
            // header.php -> form(form_add_product) ->class (nameProducto) se le asigna "
            // $('.nameProducto').html(info.descripcion);

             // Se agrega la "form" para Ingregar Producto, antes se encontraba en "Header.php", se agrega por renglon, por lo que se tiene que agregar linea por línea, utilizando JavaScript.
            $('.bodyModal').html('<form action ="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault();  sendDataProduct();">'+
            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i><br> Agregar Producto</h1>'+
            '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
            '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad Del Producto" required><br>'+
            '<input type="text" name="precio" id="txtPrecio" placeholder="Precio Del Producto" required>'+
            '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
            '<input type="hidden" name="action" value="addProduct" required>'+
            '<div class="alert alertAddProduct"></div>'+
            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
            '<a href="#" class="btn_ok closeModal" onclick="closeModal();"><i class="fas fa-ban"></i> Cerrar</a>'+  
          '</form>');             
          }
        },
        error: function(error)
        {
          console.log(error);  
        }
    
      });

    $('.modal').fadeIn(); // Activando la ventana Modal de Insertar Registro. 

  }); // $('.add_product').click(function(e)

  // Creando la ventana "Modal" del Product Borrar un producto
  $('.del_product').click(function(e)
  {  
    e.preventDefault(); // No recarga la ventana cuando se oprima el boton "Borrar".
    var producto = $(this).attr('product'); // Es el nombre de la clase "<a class = "link_delete del_product" "... de lista_producto.php
    var action = 'infoProducto'; // Se utiliza para extraer la información del producto.
    //alert(producto);
    // Se utiliza Ajax para obtener informacion del producto
      $.ajax
      ({
        url:'ajax.php',
        type:'POST',
        async:true,
        data:{action:action,producto:producto},

        success: function(response)
        {
          // Muestra el formato JSon
          //console.log(response);
          // Verifica si esta retornando un arreglo en formato JSon
          if (response != 'error')
          {
            // Convertir el formato JSon(Texto) a un objeto
            var info = JSON.parse(response);
            //console.log(info);
            // header.php -> form(form_del_product) ->id (product_id) se le asigna "

            //$('#producto_id').val(info.codproducto);
            // header.php -> form(form_add_product) ->class (nameProducto) se le asigna "
            // $('.nameProducto').html(info.descripcion);

             // Se agrega la "form" para Borrar un Producto, antes se encontraba en "Header.php", se agrega por renglon, por lo que se tiene que agregar linea por línea, utilizando JavaScript.
             // Cuando se oprima el boton de "Submit" tiene un evento "sendDataProduct() para que se procese la form"
            $('.bodyModal').html('<form action ="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault();  delProduct();">'+
            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i><br> Eliminar Producto</h1>'+
            '<p>Estas Seguro de eliminar el Producto?</p>'+
            '<h2 class="nameProducto">'+info.descripcion+'</h2><br>'+
            '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
            '<input type="hidden" name="action" value="delProduct" required>'+
            '<div class="alert alertAddProduct"></div>'+
            '<a href ="#" class="btn_cancel" onclick="closeModal();"><i class="fas fa-ban"></i>Cerrar</a>'+
            '<button type="submit" class ="btn_ok"><i class="far fa-trash-alt"></i>Eliminar </button>'+    
          '</form>');             
          }
        },
        error: function(error)
        {
          console.log(error);  
        }
    
      });

    $('.modal').fadeIn(); // Activando la ventana Modal de Insertar Registro. 

  }); // $('.del_product').click(function(e)

  // Buscar proveedor, utilizando JQuery, otra forma de llamar a las archivos.
  $('#search_proveedor').change(function(e){
    e.preventDefault(); // NO se recargara, no hara nada 
    var sistema = getUrl();
    // alert(sistema); Para revisar que este correcta la URL donde esta el sistema de Facturacion.
    // $(this) = Es la etiqueta "SELECT" y se tome el valor que tiene "Value" en el momento que se escoge el proveedor
    // Cuando se ejecuta:, cambia el "codproveedor" al seleccionar del ComboBox Select
    // http://192.168.1.79/facturacion/sistema/buscar_producto.php?proveedor=8
    location.href = sistema+'buscar_productos.php?proveedor='+$(this).val();
  });
 
}); // $(document).ready(function(){

// Obtiene la URL del Proyecto
function getUrl()
{
  var loc = window.location;
  var pathName = loc.pathname.substring(0,loc.pathname.lastIndexOf('/')+1);
  return loc.href.substring(0,loc.href.length-((loc.pathname+loc.search+loc.hash).length - pathName.length));
}
// Funcion para el boton de "Agregar" de la Ventana Modal
//<form action ="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault();  sendDataProduct();">
function sendDataProduct()
{
  $('.alertAddProduct').html('');
  $.ajax
  ({
    url:'ajax.php',
    type:'POST',
    async:true,
    // Envia todos los input del form (Ventana Modal) a parámetro "data"
    data:$('#form_add_product').serialize(),

    success: function(response)
    {
      // console.log(response);
      // El valor de "error" viene desde ajax.php seccion : if ($_POST['action'] == 'addProduct'), <div>
      if (response == 'error')
      {
        $('.alertAddProduct').html('<p style="color:red;">Error Al Agregar El Producto</p>');
      }
      else
      {
        // Convertir el formato JSon(Texto) a un objeto
        var info = JSON.parse(response);
        $('.row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
        $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
        $('#txtCantidad').val(''); // Limpiar los input Cantidad cuando se haya oprimido el boton "Agregar"
        $('#txtPrecio').val(''); // Limpiar los input Existencia cuando se haya oprimido el boton "Agregar"
        $('.alertAddProduct').html('<p>Producto Guardado Correctamente</p>');
      } 
    },
    error: function(error)
    {
      console.log(error);  
    }

  });

}

// Funcion para el boton de "Eliminar" de la Ventana Modal
//<form action ="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault();  delProduct();">
function delProduct()
{
  // $('.del_product').click(function(e) ...
  // se obtiene de : <input type="hidden" name="producto_id" id="producto_id" value="'
  var pr = $('#producto_id').val();

  $('.alertAddProduct').html('');
  $.ajax
  ({
    url:'ajax.php',
    type:'POST',
    async:true,
    // Envia todos los input del form (Ventana Modal) a parámetro "data"
    data:$('#form_del_product').serialize(),
    // Determina lo que retorno el archivo "ajax.php" de la condicion = "delProduct"
    success: function(response)
    {
      console.log(response); // Para saber que respuesta devuel el Ajax., en el navegador se hace click derecho para activar "inspeccionar elemento " -> console
      
      // console.log(response);
      // El valor de "error" viene desde ajax.php seccion : if ($_POST['action'] == 'addProduct'), <div>
      if (response == 'error')
      {
        // onsubmit="event.preventDefault();  delProduct();">'
        //       '<div class="alert alertAddProduct"></div>'
        $('.alertAddProduct').html('<p style="color:red;">Error Al Eliminar El Producto</p>');
      }
      else
      {
        // se elimina el renglon que se elimino, ya que no recarga se modifica por nodos del DOM.
        $('.row'+pr).remove();

        // Para eliminar el boton de Eliminar de la ventana "Modal", ya que no se cierra cuando se elimina (de forma lógica el boton)
        //<form action ="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault();  delProduct();">
        $('#form_del_product .btn_ok').remove(); 
        $('.alertAddProduct').html('<p>Producto Eliminado Correctamente</p>');
      } 
      

    },
    error: function(error)
    {
      console.log(error);  
    }

  });

}





// Cerrar la ventana Modal de Insertar Producto.
function closeModal()
{
  $('.alertAddProduct').html('');
  $('#txtCantidad').val('');
  $('#txtPrecio').val('');
  $('.modal').fadeOut();
}


