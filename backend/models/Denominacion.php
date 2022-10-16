<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Denominacion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$sigla,$descripcion,$logo)
	{
		$sql="INSERT INTO denominacion (nombre,sigla, descripcion,logo,condicion)
		VALUES ('$nombre','$sigla', '$descripcion', '$logo', '1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$sigla,$descripcion,$logo)
	{
		$sql="UPDATE denominacion SET nombre='$nombre',
										sigla='$sigla',
										descripcion='$descripcion',
										logo='$logo'
										 WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($id)
	{
		$sql="UPDATE denominacion SET condicion='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($id)
	{
		$sql="UPDATE denominacion SET condicion='1' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT id,nombre,sigla,descripcion,logo,condicion FROM denominacion
		 WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT id,nombre,sigla,descripcion,logo,condicion FROM denominacion";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	/*public function listarActivos()
	{
		$sql="SELECT id_marca,marca_nombre,marca_descripcion,marca_logo,marca_condicion FROM marca WHERE marca_condicion='1'";
		return ejecutarConsulta($sql);		
	}*/
    //Implementar lista para select
    public function select()
	{
		$sql="SELECT id, nombre FROM denominacion WHERE (condicion=1) ORDER BY nombre ASC";
		return ejecutarConsulta($sql);		
	}
	
}

?>