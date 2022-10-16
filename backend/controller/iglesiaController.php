<?php 
require_once "../models/Iglesia.php";

$iglesia=new Iglesia();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? mb_strtoupper(limpiarCadena($_POST["nombre"])):"";
$ubicacion=isset($_POST["ubicacion"])? mb_strtoupper(limpiarCadena($_POST["ubicacion"])):"";
$denominacion=isset($_POST["denominacion"])? mb_strtoupper(limpiarCadena($_POST["denominacion"])):"";
$lugar=isset($_POST["lugar"])? mb_strtoupper(limpiarCadena($_POST["lugar"])):"";

switch ($_GET["op"]){
	case '1':
		if (empty($id)){
		    $rspta=$iglesia->insertar($nombre,$ubicacion,$denominacion,$lugar);
		    echo $rspta ? "1:Iglesia registrada" : "0:Iglesia no se pudo registrar";
		}
		else {
			$rspta=$iglesia->editar($id,$nombre,$ubicacion,$denominacion,$lugar);
			echo $rspta ? "1:Iglesia actualizada" : "0:Iglesia no se pudo actualizar";
		}
	break;

	case '2':
		$rspta=$iglesia->desactivar($id);
 		echo $rspta ? "1:Iglesia Desactivada" : "0:Iglesia no se puede desactivar";
 		break;
	break;

	case '3':
		$rspta=$iglesia->activar($id);
 		echo $rspta ? "1:Iglesia activada" : "0:Iglesia no se puede activar";
 		break;
	break;

	case '4':
		$rspta=$iglesia->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case '0':
		$rspta=$iglesia->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
				"1"=>$reg->ubicacion,
				"2"=>$reg->denominacion,
                "3"=>$reg->lugar,
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
		$rspta = $iglesia->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->id. '>' . $reg->nombre . '</option>';
				}
		break;
}
?>