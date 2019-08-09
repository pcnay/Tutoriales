<?php 
// Valida que sea la opción de "movieseries-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
// User = Solo podra ver información.


if ($_POST['r']== 'equipos-add' && $_SESSION['perfil'] == 'Admin' && !isset($_POST['crud']))
{
  // Obtener los tipos de componentes
  $tc_controller = new TcController();
  $tc = $tc_controller->get();
  $tc_select = '';
  for ($n=0;$n<count($tc);$n++)
  {
    $tc_select .= '<option value = "'.$tc[$n]['id_tipo_componente'].'">'.$tc[$n]['descripcion'].'</option>';
  }
// Obtener las marcas
$marcas_controller = new MarcasController();
$marcas = $marcas_controller->get();
$marcas_select = '';
for ($n=0;$n<count($marcas);$n++)
{
  $marcas_select .= '<option value = "'.$marcas[$n]['id_marca'].'">'.$marcas[$n]['descripcion'].'</option>';
}
  
// Obtener los modelos
$modelos_controller = new ModelosController();
$modelos = $modelos_controller->get();
$modelos_select = '';
for ($n=0;$n<count($modelos);$n++)
{
  $modelos_select .= '<option value = "'.$modelos[$n]['id_modelo'].'">'.$modelos[$n]['descripcion'].'</option>';
}

  printf('
    <h2 class = "p1">Agregar Equipos</h2>

    <!-- Se agrega el formulario para la captura de Equipos -->
    <form method="POST" class="item">
      <div class="p_25">
        <input type = "text" name="num_serie" placeholder="Numero De Serie">
      </div>
      <div class="p_25">
        <input type = "text" name="num_inv" placeholder="Numero De Inventario">
      </div>
      <div class="p_25">
        <input type = "text" name="num_parte" placeholder="Numero De Parte">
      </div>
      <div class="p_25">
        <input type = "number" name="existencia" placeholder="Existencia" required>
      </div>

      <div class="p_25">
        <select name="id_tipo_componente" placeholder="Componente" required>
          <option value = "">Componente</option>
          %s
        </select>
      </div>
      <div class="p_25">
        <select name="id_marca" placeholder="Marca" required>
          <option value = "">Marca</option>
          %s
        </select>
      </div>
      <div class="p_25">
        <select name="id_modelo" placeholder="Modelo" required>
          <option value = "">Modelo</option>
          %s
        </select>
      </div>

      <div class="p_25">
        <textarea name="comentarios" cols="120" rows = "10" placeholder="Comentarios"></textarea>
      </div>

      <div class="p_25">
        <input class="button add" type="submit" value="Agregar">
        <input type="hidden" name="r" value="equipos-add">
        <input type="hidden" name="crud" value="set">
      </div>
    </form>
  ',$tc_select,$marcas_select,$modelos_select);
}
// Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
else if ($_POST['r']== 'equipos-add' && $_SESSION['perfil'] == 'Admin' && $_POST['crud'] == 'set')
{
  // programar la inserción de los datos
  $equipos_controller = new EquiposController();
  $new_equipo = array(
    'id_epo'  => 0, // Para que se autoincremente este número, partiendo del que esta actualmente
    'num_serie' => $_POST['num_serie'],
    'num_inv' => $_POST['num_inv'],
    'num_parte' => $_POST['num_parte'],
    'existencia' => $_POST['existencia'],
    'id_tipo_componente' => $_POST['id_tipo_componente'],
    'id_marca' => $_POST['id_marca'],
    'id_modelo' => $_POST['id_modelo'],
    'comentarios' => $_POST['comentarios']
  );
  
  $equipos = $equipos_controller->set($new_equipo); // Graba a la Tabla de "t_Equipo" lo que tecleo el usuario.

  $template = '
    <div class = "container">
      <p class = "item add">Equipo <b>%s </b> Guardado En La Base De Datos </p>
    </div>
    <script>
      window.onload = function()
      {
        reloadPage("equipos")
      }

    </script>

  ';
  printf($template,$_POST['id_tipo_componente']);
}
else
{
  // Para generar la vista de NO autorizado.
  $controller = new ViewControllers();
  $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
}
?>





















