<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Iglesia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$ubicacion,$denominacion,$lugar)
	{
		$sql="INSERT INTO iglesia (nombre,ubicacion, denominacion,lugar,condicion)
		VALUES ('$nombre','$ubicacion', '$denominacion', '$lugar', '1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$ubicacion,$denominacion,$lugar)
	{
		$sql="UPDATE iglesia SET nombre='$nombre',
										ubicacion='$ubicacion',
										denominacion='$denominacion',
										lugar='$lugar'
										 WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($id)
	{
		$sql="UPDATE iglesia SET condicion='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($id)
	{
		$sql="UPDATE iglesia SET condicion='1' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT id,nombre,ubicacion,denominacion,lugar,condicion FROM iglesia
		 WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.id, i.nombre,i.ubicacion,d.nombre as denominacion,l.nombre as lugar,i.condicion FROM `iglesia` as i INNER JOIN denominacion as d on i.denominacion=d.id INNER JOIN lugar as l on i.lugar=l.id";
		return ejecutarConsulta($sql);		
	}
    //Implementar lista para select
    public function select()
	{
		$sql="SELECT id, nombre FROM iglesia WHERE (condicion=1) ORDER BY nombre ASC";
		return ejecutarConsulta($sql);		
	}
	
}

?>