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
            $('#producto_id').val(info.codproducto);
            // header.php -> form(form_add_product) ->class (nameProducto) se le asigna "
            $('.nameProducto').html(info.descripcion);
             
          }
        },
        error: function(error)
        {
          console.log(error);  
        }
    
      });

    $('.modal').fadeIn(); // Activando la ventana Modal de Insertar Registro. 

  }); // $('.add_product').click(function(e)

}); // $(document).ready(function(){

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
        $('.alertAddProduct').html('<p>Producto Guardado Guardado Correctamente</p>');
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