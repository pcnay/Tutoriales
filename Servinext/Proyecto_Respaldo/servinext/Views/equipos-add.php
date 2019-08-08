<?php 

// Obtener los tipos de componentes
  $tc_controller = new TcController();
  $tc = $tc_controller->get();
  $tc_select = "";
  for ($n=0;$n<count($tc);$n++)
  {
    $tc_select .= '<option value = "'.$tc[$n]['id_tipo_componente'].'">'.$tc[$n]['descripcion'].'</option>';
  }
?>
