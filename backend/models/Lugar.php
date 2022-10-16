<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Lugar
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$prefijo,$padre,$nivel)
	{
		$sql="INSERT INTO lugar (nombre,prefijo,padre,nivel,condicion)
		VALUES ('$nombre','$prefijo', '$padre', '$nivel', '1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$prefijo,$padre,$nivel)
	{
		$sql="UPDATE lugar SET nombre='$nombre',
										prefijo='$prefijo',
										padre='$padre',
										nivel='$nivel'
										 WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($id)
	{
		$sql="UPDATE lugar SET condicion='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($id)
	{
		$sql="UPDATE lugar SET condicion='1' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT id,nombre,prefijo,padre,nivel,condicion FROM lugar
		 WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM lugar";
		return ejecutarConsulta($sql);		
	}
    //Implementar lista para select
    public function select()
	{
		$sql="SELECT id, nombre FROM lugar WHERE (condicion=1) ORDER BY nombre ASC";
		return ejecutarConsulta($sql);		
	}
	
}

?>