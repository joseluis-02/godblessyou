<?php 
//Incluímos inicialmente la conexión a la base de datos
require_once "../config/Conexion.php";

Class Pais
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$prefijo,$logo,$codigo)
	{
		$sql="INSERT INTO pais (pais_nombre, pais_prefijo,pais_bandera,pais_codigo,pais_condicion)
		VALUES ('$nombre','$prefijo','$logo','$codigo','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_pais,$nombre,$prefijo,$logo,$codigo)
	{
		$sql="UPDATE pais SET pais_nombre='$nombre',
								 pais_prefijo='$prefijo',
								 pais_bandera='$logo',
								 pais_codigo='$codigo'
		WHERE id_pais='$id_pais'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar 
	public function desactivar($id_pais)
	{
		$sql="UPDATE pais SET pais_condicion='0' WHERE id_pais='$id_pais'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar
	public function activar($id_pais)
	{
		$sql="UPDATE pais SET pais_condicion='1' WHERE id_pais='$id_pais'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_pais)
	{
		$sql="SELECT id_pais, pais_nombre, pais_prefijo,pais_bandera,pais_codigo, pais_condicion FROM pais WHERE id_pais='$id_pais'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT id_pais, pais_nombre, pais_prefijo,pais_bandera,pais_codigo, pais_condicion FROM pais";
		return ejecutarConsulta($sql);		
	}

	public function select()
	{
		$sql="SELECT id_pais, pais_nombre FROM pais WHERE (pais_condicion=1) ORDER BY pais_nombre ASC";
		return ejecutarConsulta($sql);		
	}
}

?>