<?php 
require_once "../models/Permiso.php";

$permiso=new Permiso();
$idpermiso=isset($_POST["idpermiso"])? limpiarCadena($_POST["idpermiso"]):"";
$nombre=isset($_POST["nombre"])? mb_strtoupper(limpiarCadena($_POST["nombre"])):"";

switch ($_GET["op"]){
		case '1':
			if (empty($idpermiso)){
				$rspta=$permiso->insertar($nombre);
				echo $rspta ? "1:Permiso registrada" : "0:Ups! No se pudo registrar";
			}
			else {
				$rspta=$permiso->editar($idpermiso,$nombre);
				echo $rspta ? "1:Permiso actualizada" : "0:Ups! No se pudo actualizar";
			}
		break;

		case '2':
			$rspta=$permiso->desactivar($idpermiso);
			echo $rspta ? "1:Permiso estado desactivada" : "0:No se puede desactivar";
			break;
		break;

		case '3':
			$rspta=$permiso->activar($idpermiso);
			echo $rspta ? "1:Permiso estado activada" : "0:No se puede activar";
			break;
		break;

		case '4':
			$rspta=$permiso->mostrar($idpermiso);
			//Codificar el resultado utilizando json
			echo json_encode($rspta);
			break;
		break;
	case '0':
		$rspta=$permiso->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->permisonombre,
				"1"=>($reg->permisocondicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
				"2"=>($reg->permisocondicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idpermiso.')"><i class="bi bi-pencil-square"></i></button>'.
				 	' <button class="btn btn-danger" onclick="desactivar('.$reg->idpermiso.')"><i class="bi bi-x-square"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idpermiso.')"><i class="bi bi-pencil-square"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idpermiso.')"><i class="bi bi-check-circle-fill"></i></button>'
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
		$rspta = $permiso->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idpermiso . '>' . $reg->permisonombre . '</option>';
				}
		break;
	case "6":
		$rspta = $permiso->listar();
		$id=$_GET['id'];
		$marcados = $permiso->listarmarcados($id);
		$valores=array();
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idpermiso);
			}
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idpermiso,$valores)?'selected="selected"':'';
				echo '<option value=' . $reg->idpermiso . ' '.$sw.'>'.$reg->permisonombre.'</option>';
			}
	break;
}
?>