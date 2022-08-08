<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO permiso (permisonombre,permisocondicion)
		VALUES ('$nombre','1')";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para editar registros
	public function editar($id,$nombre)
	{
		$sql="UPDATE permiso SET permisonombre='$nombre'
		WHERE idpermiso='$id'";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para desactivar 
	public function desactivar($id)
	{
		$sql="UPDATE permiso SET permisocondicion='0' WHERE idpermiso='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar
	public function activar($id)
	{
		$sql="UPDATE permiso SET permisocondicion='1' WHERE idpermiso='$id'";
		return ejecutarConsulta($sql);
	}
	public function mostrar($id)
	{
		$sql="SELECT idpermiso, permisonombre, permisocondicion FROM permiso WHERE idpermiso='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idpermiso, permisonombre, permisocondicion FROM permiso ORDER BY permisonombre ASC";
		return ejecutarConsulta($sql);		
	}

	public function select()
	{
		$sql="SELECT idpermiso, permisonombre FROM permiso  WHERE (permisocondicion=1) ORDER BY permisonombre ASC";
		return ejecutarConsulta($sql);		
	}

	public function listarmarcados($idrol)
	{
		$sql="SELECT idpermiso FROM rol_permiso WHERE idrol='$idrol'";
		return ejecutarConsulta($sql);
	}
}

?>