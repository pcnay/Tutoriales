<?php
	// Antes este archivo se encontraba en la carpeta de "Marcas", ahora estan en el mismo nivel
	// require_once('./Models/Model.php');
	// require_once('Model.php'); Se comenta por la funcion "AutoLoad()"
	class EquiposModel extends Model
	{
		//public $id_epo;
    //public $num_serie; 
    // ........ 


		public function __construct()
		{
			// Si se conectaran a mas de una base de datos, es aqui donde se define.
			$this->db_name = 'ordenservicios';			
		}

		public function __destruct()
		{
			//unset($this);
		}

		// Recibe un arreglo la funcion.
		//public function create($equipos_datos=array() )		
		public function set($equipos_datos=array() )		
		{
			foreach ($marcas_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "REPLACE INTO t_Equipo (id_epo,num_serie,num_inv,id_tipo_componente,num_parte,existencia,id_marca,id_modelo) VALUES ($id_epo,'$num_serie','$num_inv',$id_tipo_componente,'$num_parte',$existencia,$id_marca,$id_modelo)";
			// Insertando el valor nuevo.
			$this->set_query(); 
		}
		// Si "$id_epo" esta vacio, le asigna espacio en blanco
		public function get($id_epo='')
		{				
			// Se coloca en comillas para que tome el valor de la variable "$id_epo"
			$this->query = ($id_epo != '')
			?"SELECT epo.id_epo,epo.num_serie,epo.num_inv,epo.num_parte,tc.descripcion AS componente,marca.descripcion AS marca,modelo.descripcion AS modelo,epo.existencia FROM t_Equipo AS epo 
      INNER JOIN t_Tipo_Componente AS tc ON epo.id_tipo_componente = tc.id_tipo_componente
      INNER JOIN t_Marca AS marca ON epo.id_marca = marca.id_marca
      INNER JOIN t_Modelo AS modelo ON epo.id_modelo = modelo.id_modelo      
      WHERE epo.id_epo = $id_epo"
			:"SELECT epo.id_epo,epo.num_serie,epo.num_inv,epo.num_parte,tc.descripcion AS componente,marca.descripcion AS marca,modelo.descripcion AS modelo,epo.existencia FROM t_Equipo AS epo 
      INNER JOIN t_Tipo_Componente AS tc ON epo.id_tipo_componente = tc.id_tipo_componente
      INNER JOIN t_Marca AS marca ON epo.id_marca = marca.id_marca
      INNER JOIN t_Modelo AS modelo ON epo.id_modelo = modelo.id_modelo";

/*
				if ($id_epo != '')
				{
					$sql = "SELECT * FROM t_Equipo WHERE id_epo = $id_epo";
				}
				else
				{
					$sql = "SELECT * FROM t_Equipo";
				}
			*/ 
			//Ejecuta la consulta y la retorna en un arreglo.
			$this->get_query();
			// var_dump() = Convertir a cadena de texto el contenido de un objeto
			//var_dump($this->rows);
			
			// Se agrega código para mostrar en pantalla en forma de tabla la información que se obtuvo.
			// Obteniendo el numero de elementos del arreglo
			$num_renglones = count($this->rows);
			$datos = array();
			// Permite recorrer el arreglo de una forma optimizada.
			// $this->rows = Es el arreglo a recorrer.
			//https://www.php.net/manual/es/control-structures.foreach.php
			// Arreglo Asociativo es "$this->rows"
			foreach ($this->rows as $Campo => $Valor)
			{
				// Agrega al final del arreglo el valor de la interacción
				array_push($datos,$Valor);
				//$datos[$Campo] = $Valor;
			}			
			
			return $datos;
		}

/* Se desactiva por la instrucción REPLACE (funcion set)

	public function update($marca_datos=array())
		{
			foreach ($marca_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "UPDATE t_Marca SET id_marca = $id_marca,descripcion = '$descripcion' WHERE id_marca = $id_marca";
			
			$this->set_query(); 

		}
	*/

		// Si no se manda parámetro, le asigna en blanco
		public function del($id_epo='')
		{
			$this->query= "DELETE FROM t_Equipo WHERE id_epo = $id_epo";
			$this->set_query();
		}

	}
?>