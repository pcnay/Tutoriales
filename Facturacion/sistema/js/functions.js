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

  // ====== Seccion para la captura de Ventas. ===== //

  // Activa campos para registrar clientes en la captura de Ventas.
  $('.btn_new_cliente').click(function(e)
  {
    e.preventDefault();
    $('#nom_cliente').removeAttr('disabled'); // Elimina el "disabled" de la etiqueta 
    $('#tel_cliente').removeAttr('disabled');
    $('#dir_cliente').removeAttr('disabled');
    // Mostrar el boton "Guardar" ya que por defecto esta oculto este boton.
    $('#div_registro_cliente').slideDown(); 
  });
 
  // Buscar cliente desde la seccion de "clientes" (donde se captura el NIT) de Ventas.
  // Cuando se oprima una tecla ejecutara lo que contiene la función.
  $('#nit_cliente').keyup(function(e)
  {
    e.preventDefault(); // Evitar que se autorecargue.
    var cl = $(this).val(); // Extrae el valor del campo "nit_cliente"
    var action = 'searchCliente';
    $.ajax
    ({
      url:'ajax.php',
      type:"POST",
      async:true,
      data:{action:action,cliente:cl},

      // Lo que retorna el la ejecucion del archivo "Ajax.php"
      success: function(response)
      {
        // console.log(response);
        if (response == 0) // No existe cliente
        {
          $('#idcliente').val('');
          $('#nom_cliente').val('');
          $('#tel_cliente').val('');
          $('#dir_cliente').val('');
          // Mostrar boton Agregar
          $('.btn_new_cliente').slideDown();          
        }
        else
        {
          var data = $.parseJSON(response); // esta convirtiendo a un formato JSON
          $('#idcliente').val(data.idcliente);
          $('#nom_cliente').val(data.nombre);
          $('#tel_cliente').val(data.telefono);
          $('#dir_cliente').val(data.direccion);
          // Ocultar el boton de Agregar.
          $('.btn_new_cliente').slideUp();
          
          // Inhabilitar Campos
          $('#nom_cliente').attr('disabled','disabled');
          $('#tel_cliente').attr('disabled','disabled');
          $('#dir_cliente').attr('disabled','disabled');

          // Ocultar el boton de Guardar
          $('#div_registro_cliente').slideUp();
        }


      },
      error:function(error)
      {

      }
    });

  }); // $('#nit_cliente').keyup(function(e)

  // Crear Cliente desde el modulo de Ventas.
  $('#form_new_cliente_venta').submit(function(e)
  {
    e.preventDefault();
    $.ajax
    ({
      url:'ajax.php',
      type:"POST",
      async:true,
      data:$('#form_new_cliente_venta').serialize(), // Se envian los input del formulario con una sola linea.


      // Lo que retorna el la ejecucion del archivo "Ajax.php"
      success: function(response)
      {
        if (response != 'error')
        {
          // Se utiliza para verificar que retorna.
          // console.log(response);
          $('#idcliente').val(response); // Obtiene el valor del "id" del Cliente
          $('#nom_cliente').attr('disabled','disabled'); // inhabilita la etiqueta 
          $('#tel_cliente').attr('disabled','disabled');
          $('#dir_cliente').attr('disabled','disabled');

          // Oculta el boton "Agregar"        
          $('.btn_new_cliente').slideUp();
          // Oculta el boton "Guardar"        
          $('#div_registro_cliente').slideUp();
        }
      },
      error: function(error)
      {

      }

    });

  }); // $('#form_new_cliente_venta').submit(function(e)

  // Buscar producto desde la ventana de Ventas
  // <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
  $('#txt_cod_producto').keyup(function(e)
  {
    e.preventDefault();
    // Este valor proviene de la etiqueta : <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td> del archivo "nueva_venta.php"
    var producto = $(this).val();
    var action = 'infoProducto';
    if (producto != '')
    {
      $.ajax
      ({
        url:'ajax.php',
        type:"POST",
        async:true,
        // action1:action (action1 = Variable, action = contenido)
        // producto1:producto (producto1 = Variable, producto = contenido)
        data:{action:action,producto:producto},
  
  
        // Lo que retorna el la ejecucion del archivo "Ajax.php"
        success: function(response)
        {
          // Se utiliza para retornar el mensaje a la console de "Inspeccionar" en el navegador.
           //console.log(response);  
          if (response != 'error')
          {
            var info = JSON.parse(response); // Parse el valor JSON a objeto.
            // Estos campos se encuentran en la seccion de "Productos" de la pantalla "Ventas", se asigna el valor desde el objeto que se convirtio desde JSON.
            $('#txt_descripcion').html(info.descripcion);
            $('#txt_existencia').html(info.existencia);
            $('#txt_cant_producto').val('1');
            $('#txt_precio').html(info.precio);
            $('#txt_precio_total').html(info.precio);
            // Activar cantidad
            $('#txt_cant_producto').removeAttr('disabled');
            // Ocultar boton Agregar 
            $('#add_product_venta').slideDown();
          }
          else
          {
            $('#txt_descripcion').html('-');
            $('#txt_existencia').html('-');
            $('#txt_cant_producto').val('0');
            $('#txt_precio').html('0.00');
            $('#txt_precio_total').html('0.00');
            // Bloquear "Cantidad"
            $('#txt_cant_producto').attr('disabled','disabled');
            // Ocultar boton Agregar 
            $('#add_product_venta').slideUp();

          } // if (response != 'error')

        },
        error: function(error)
        {
  
        }
  
      }); // $.ajax

    } //  if (producto != '')

  }); // $('#txt_cod_producto').keyup(function(e)

  // Validar "Cantidad" del producto antes de agregar.
  $('#txt_cant_producto').keyup(function(e)
  {
    e.preventDefault();
    // $(this).val() = Etiqueta "Cant" de la pantalla de Venta
    // #txt_precio.html() = El contenido de la etiqueta.
    var precio_total = $(this).val()*$('#txt_precio').html();
    // Obtiene el valor de la celda de la tabla y la convierte a Entero.
    var existencia = parseInt($('#txt_existencia').html());
    $('#txt_precio_total').html(precio_total);


    //Ocultar el boton agregar si la cantidad es menor que 1
    // isNaN = No es un numero, y valida el campo "Cant"
    // Valida que no se venda mas de lo que se tiene en existencia.
    if ( ($(this).val() < 1 || isNaN ($(this).val())) || ($(this).val() > existencia) ) 
    {
      // Oculta el boton de agregar.
      $('#add_product_venta').slideUp();      
    }
    else
    {
      $('#add_product_venta').slideDown();
    }

  });
  
  // Se agregan productos a la tabla Detalle Temporal 
  $('#add_product_venta').click(function(e)
  {
    e.preventDefault();
    if ($('#txt_cant_producto').val() > 0)
    {
      var codproducto = $('#txt_cod_producto').val();
      var cantidad = $('#txt_cant_producto').val();
      var action = 'addProductoDetalle';

      $.ajax
      ({
        url:'ajax.php',
        type:"POST",
        async:true,
        data:{action:action,producto:codproducto,cantidad:cantidad},  
        // Lo que retorna el la ejecucion del archivo "Ajax.php" en lo referente al evento "click" de "$('#add_product_venta').click(function(e)"
        success: function(response)
        {
          // Se utiliza para retornar el mensaje a la console de "Inspeccionar" en el navegador.
          // console.log(response);  
          if (response != 'error')
          {
            // Convirtiendo el arreglo JSON que se retorno en "Ajax.php" para Objeto de JavaScript.
            var info = JSON.parse(response);
            // Asignando información del Objeto creado a las etiquetas de la "form"
            //console.log(info); 
            // Son del archivo "nueva_venta.php" 
            // <tbody id="detalle_venta"> ...
            // <tfoot id="detalle_totales">
            $('#detalle_venta').html(info.detalle);
            $('#detalle_totales').html(info.totales);
            // Una vez que se agregan los productos al detalle de venta, se tienen que limpiar los campos donde se capturan los productos.
            $('#txt_cod_producto').val(''); // Etiqueta "input"
            $('#txt_descripcion').html('-'); // Etiqueta "Label"
            $('#txt_existencia').html('-'); // Etiqueta "Label"
            $('#txt_cant_producto').val('0'); // Etiqueta "input"
            $('#txt_precio').html('0.00'); // Etiqueta "Label"
            $('#txt_precio_total').html('0.00'); // Etiqueta "Label"
            // Bloquear Cantidad
            $('#txt_cant_producto').attr('disabled','disabled'); 
            // Ocultar el boton Agregar
            $('#add_product_venta').slideUp(); 
          } 
          else
          {
            console.log('NO datos');
          }
          // Para que cada vez que agrege un registro, se muestre el boton de "Procesar"
          viewProcesar();

        },
        error: function(error)
        {
  
        }
  
      }); // $.ajax

    } // if ($('#txt_cant_producto').val() > 0)

  }); // $('#add_product_venta').click(function(e)
 
  // Anular Venta.
 // nueva_venta.php -> <div class="dato_venta"> -> #btn_anular_venta
 $('#btn_anular_venta').click(function(e){
  e.preventDefault();

  //// Accesa a la Form "detalle_venta", nueva_venta.php -> <tbody id="detalle_venta">, accesa a los renglones "tr", lo que determina que si tiene registros el detalle de la venta, cuando es mayor a 0.
  var rows = $('#detalle_venta tr').length;

  if (rows > 0)
  {
    var action = 'anularVenta';
    $.ajax
    ({
      url:'ajax.php',
      type:"POST",
      async:true,
      data:{action:action},

      success: function(response)
      {
        //console.log(response);
        if (response != 'error')
        {
          // Recarga toda la página
          location.reload();
        }
      },
      error:function(error)
      {
       
      }

    }); // $.ajax

  }

}); // $('#btn_anular_venta').click(function(e){

// Factura Venta  
// nueva_venta.php -> <div class="dato_venta"> -> <a href="#" class="btn_new textcenter" id="btn_facturar_venta" ...
  $('#btn_facturar_venta').click(function(e){
    e.preventDefault();

    //// Accesa a la Form "detalle_venta", nueva_venta.php -> <tbody id="detalle_venta">, accesa a los renglones "tr", lo que determina que si tiene registros el detalle de la venta, cuando es mayor a 0.
    var rows = $('#detalle_venta tr').length;

    if (rows > 0)
    {
      var action = 'procesarVenta';
      // nueva_venta.php
      // <input type="hidden" id="idcliente" name ="idcliente" value="" required>
      var codcliente = $('#idcliente').val();

      $.ajax
      ({
        url:'ajax.php',
        type:"POST",
        async:true,
        data:{action:action,codcliente:codcliente},

        success: function(response)
        {
          // console.log(response);
          
          if (response != 'error')
          {
            // Solo para verificar si los datos de la factura son recibidos
            var info = JSON.parse(response);
            //console.log(info);
            /*
            codcliente: "6"
            estatus: "1"​
            fecha: "2019-09-12 23:04:47"
            nofactura: "4"
            totalfactura: "150.00"
            usuario: "1"
            */            
            generarPDF(info.codcliente,info.nofactura);
            // Recarga toda la página
            location.reload();
          }
          else
          {
            console.log('no data');
          }          

        },
        error:function(error)
        {
        
        }

      }); // $.ajax

    }

  }); // $('#btn_facturar_venta').click(function(e){
 
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

// Se utiliza para obtener los detalles de la Venta, utilizando el "Id" del Usuario del Sistema ("Admin, Supervisor, Vendedor, etc"), para cuando el vendedor se pasa a otra ventana, y después regresa se mantiene los productos en detalle de Venta, además se garantiza que el vendedor solo puede realizar una venta a la vez.
function searchForDetalle(id)
{
  var action = 'searchForDetalle';
  var user = id;

  $.ajax
  ({
    url:'ajax.php',
    type:"POST",
    async:true,
    data:{action:action,user:user},  
    // Esta funcion es llamada desdel el archivo "nueva_venta.php"

    success: function(response)
    {
      // Se utiliza para retornar el mensaje a la console de "Inspeccionar" en el navegador.
      //console.log(response);  
      if (response != 'error')
      {
        // Convirtiendo el arreglo JSON que se retorno en "Ajax.php" para Objeto de JavaScript.
        var info = JSON.parse(response);
        // Asignando información del Objeto creado a las etiquetas de la "form"
        //console.log(info); 
        // Son del archivo "nueva_venta.php" 
        // <tbody id="detalle_venta"> ...
        // <tfoot id="detalle_totales">
        $('#detalle_venta').html(info.detalle);
        $('#detalle_totales').html(info.totales);
      }  
      else
      {
        console.log('NO datos');
      }
      viewProcesar();

    },
    error: function(error)
    {

    }

  }); // $.ajax


} // function searchForDetalle(id)

// Esta funcion es llamada desdel el archivo "ajax.php"->$detalleTabla .=
function del_product_detalle(correlativo)
{
  var action = 'delProductoDetalle';
  var id_detalle = correlativo;

  $.ajax
  ({
    url:'ajax.php',
    type:"POST",
    async:true,
    data:{action:action,id_detalle:id_detalle},  
    

    success: function(response)
    {
      // Se utiliza para retornar el mensaje a la console de "Inspeccionar" en el navegador.
      //console.log(response);  
      if(response != 'error')
      {
        //Convirtiendo a formato JSON
        var info = JSON.parse(response);        
        // Asignando información del Objeto creado a las etiquetas de la "form"
        //console.log(info); 
        // Son del archivo "nueva_venta.php" 
        // <tbody id="detalle_venta"> ...
        // <tfoot id="detalle_totales">
        $('#detalle_venta').html(info.detalle);
        $('#detalle_totales').html(info.totales);
        // Una vez que se agregan los productos al detalle de venta, se tienen que limpiar los campos donde se capturan los productos.
        $('#txt_cod_producto').val(''); // Etiqueta "input"
        $('#txt_descripcion').html('-'); // Etiqueta "Label"
        $('#txt_existencia').html('-'); // Etiqueta "Label"
        $('#txt_cant_producto').val('0'); // Etiqueta "input"
        $('#txt_precio').html('0.00'); // Etiqueta "Label"
        $('#txt_precio_total').html('0.00'); // Etiqueta "Label"
        // Bloquear Cantidad
        $('#txt_cant_producto').attr('disabled','disabled'); 
        // Ocultar el boton Agregar
        $('#add_product_venta').slideUp(); 
      
      }
      else
      {
        $('#detalle_venta').html('');
        $('#detalle_totales').html('');

      } // if(response != 'error')
      viewProcesar();
       
    },
    error: function(error)
    {

    }

  }); // $.ajax

} // function del_product_detalle(correlativo)

// Cuando no se tengan regitros en el detalle de la venta, se oculta el boton de "Procesar"
function viewProcesar()
{
  //// Accesa a la Form "detalle_venta", nueva_venta.php -> <tbody id="detalle_venta">, accesa a los renglones "tr", lo que determina que si tiene registros el detalle de la venta, cuando es mayor a 0.

  if($('#detalle_venta tr').length >0)
  {
    $('#btn_facturar_venta').show();
  }
  else
  {
    $('#btn_facturar_venta').hide();
  }
}

// Generar la Factura en PDF
function generarPDF(cliente,factura)
{
  // Son las dimensiones del PDF.
  var ancho = 1000;
  var alto = 800;
  //Calcula posicion x,y para centrar la ventana
  var x = parseInt((window.screen.width/2) - (ancho / 2));
  var y = parseInt((window.screen.height/2) - (alto / 2));

  $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;

  // Para mostrar la ventana.
  window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}


// Cerrar la ventana Modal de Insertar Producto.
function closeModal()
{
  $('.alertAddProduct').html('');
  $('#txtCantidad').val('');
  $('#txtPrecio').val('');
  $('.modal').fadeOut();
}


