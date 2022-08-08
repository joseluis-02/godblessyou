<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Rol
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion, $idpermiso)
	{
		$sql="INSERT INTO rol (rolnombre, roldescripcion, rolcondicion)
		VALUES ('$nombre', '$descripcion', '1')";
		$idrol = ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		while ($num_elementos < count($idpermiso))
		{
			$sql_detalle = "INSERT INTO rol_permiso(idrol, idpermiso) VALUES('$idrol', '$idpermiso[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idrol,$nombre,$descripcion, $idpermiso)
	{
		$sql="UPDATE rol SET rolnombre='$nombre',roldescripcion='$descripcion' WHERE idrol='$idrol'";
		$idrolx= ejecutarConsulta_retornarID($sql);
		$sqldel="DELETE FROM rol_permiso WHERE idrol='$idrol'";
		ejecutarConsulta($sqldel);
		$num_elementos=0;
		$sw=true;
		while ($num_elementos < count($idpermiso))
		{
			$sql_detalle = "INSERT INTO rol_permiso(idrol, idpermiso) VALUES('$idrol', '$idpermiso[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
}

	//Implementamos un método para desactivar registros
	public function desactivar($idrol)
	{
		$sql="UPDATE rol SET rolcondicion='0' WHERE idrol='$idrol'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idrol)
	{
		$sql="UPDATE rol SET rolcondicion='1' WHERE idrol='$idrol'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idrol)
	{
		$sql="SELECT idrol,rolnombre,roldescripcion,rolcondicion FROM rol WHERE idrol='$idrol'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idrol,rolnombre,roldescripcion,rolcondicion FROM rol";
		return ejecutarConsulta($sql);		
	}

	public function select()
	{
		$sql="SELECT idrol, rolnombre FROM rol WHERE (rolcondicion=1) ORDER BY rolnombre ASC";
		return ejecutarConsulta($sql);		
	}
}

?>