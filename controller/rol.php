<?php 
require_once "../models/Rol.php";

$rol=new Rol();

$idrol=isset($_POST["idrol"])? limpiarCadena($_POST["idrol"]):"";
$nombre=isset($_POST["nombre"])? mb_strtoupper(limpiarCadena($_POST["nombre"])):"";
$descripcion=isset($_POST["descripcion"])? mb_strtoupper(limpiarCadena($_POST["descripcion"])):"";

switch ($_GET["op"]){
	case '1':
		if (empty($idrol)){
			$rspta=$rol->insertar($nombre,$descripcion, $_POST["permisos"]);
			echo $rspta ? "1:Rol registrado" : "0:Rol no se pudo registrar";
		}
		else {
			$rspta=$rol->editar($idrol,$nombre,$descripcion, $_POST["permisos"]);
			echo $rspta ? "1:Rol actualizado" : "0:Rol no se pudo actualizar";
		}
	break;

	case '2':
		$rspta=$rol->desactivar($idrol);
 		echo $rspta ? "1:Rol Desactivado" : "0:Rol no se puede desactivar";
 		break;
	break;

	case '3':
		$rspta=$rol->activar($idrol);
 		echo $rspta ? "1:Rol activado" : "0:Rol no se puede activar";
 		break;
	break;

	case '4':
		$rspta=$rol->mostrar($idrol);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case '0':
		$rspta=$rol->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->rolnombre,
				"1"=>$reg->roldescripcion,
 				"2"=>($reg->rolcondicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
				 "3"=>($reg->rolcondicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idrol.')"><i class="bi bi-pencil-square"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idrol.')"><i class="bi bi-x-square"></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idrol.')"><i class="bi bi-pencil-square"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idrol.')"><i class="bi bi-check-circle-fill"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;	
	case '5':
		$rspta = $rol->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idrol . '>' . $reg->rolnombre . '</option>';
				}
		break;
}
?>