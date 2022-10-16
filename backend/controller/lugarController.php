<?php 
require_once "../models/Lugar.php";

$lugar=new Lugar();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? mb_strtoupper(limpiarCadena($_POST["nombre"])):"";
$prefijo=isset($_POST["prefijo"])? mb_strtoupper(limpiarCadena($_POST["prefijo"])):"";
$padre=isset($_POST["padre"])? mb_strtoupper(limpiarCadena($_POST["padre"])):"";
$nivel=isset($_POST["nivel"])? mb_strtoupper(limpiarCadena($_POST["nivel"])):"";

switch ($_GET["op"]){
	case '1':
		if (empty($id)){
		    $rspta=$lugar->insertar($nombre,$prefijo,$padre,$nivel);
		    echo $rspta ? "1:lugar registrada" : "0:lugar no se pudo registrar";
		}
		else {
			$rspta=$lugar->editar($id,$nombre,$prefijo,$padre,$nivel);
			echo $rspta ? "1:lugar actualizada" : "0:lugar no se pudo actualizar";
		}
	break;

	case '2':
		$rspta=$lugar->desactivar($id);
 		echo $rspta ? "1:lugar Desactivada" : "0:lugar no se puede desactivar";
 		break;
	break;

	case '3':
		$rspta=$lugar->activar($id);
 		echo $rspta ? "1:lugar activada" : "0:lugar no se puede activar";
 		break;
	break;

	case '4':
		$rspta=$lugar->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case '0':
		$rspta=$lugar->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
				"1"=>$reg->prefijo,
				"2"=>$reg->padre,
                "3"=>$reg->nivel,
 				"4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
                "5"=>($reg->condicion)?'<button class="btn btn-link" onclick="mostrar('.$reg->id.')"><i class="bi bi-pencil-square"></i></button>'.
				 	' <button class="btn btn-link" onclick="desactivar('.$reg->id.')"><i class="bi bi-x-square"></i></button>':
 					'<button class="btn btn-link" onclick="mostrar('.$reg->id.')"><i class="bi bi-pencil-square"></i></button>'.
 					' <button class="btn btn-link" onclick="activar('.$reg->id.')"><i class="bi bi-check-circle-fill"></i></button>',
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
		$rspta = $lugar->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->id. '>' . $reg->nombre . '</option>';
				}
		break;
}
?>