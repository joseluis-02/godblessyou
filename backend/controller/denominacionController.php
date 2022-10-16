<?php 
require_once "../models/Denominacion.php";

$denominacion=new Denominacion();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? mb_strtoupper(limpiarCadena($_POST["nombre"])):"";
$sigla=isset($_POST["sigla"])? mb_strtoupper(limpiarCadena($_POST["sigla"])):"";
$descripcion=isset($_POST["descripcion"])? mb_strtoupper(limpiarCadena($_POST["descripcion"])):"";
$logo=isset($_POST["logo"])? limpiarCadena($_POST["logo"]):"";
$imagenAnterior = isset($_POST["imagenactual"])? limpiarCadena($_POST["imagenactual"]):"";

switch ($_GET["op"]){
	case '1':
		/* Subir una imagen al servidor, para que se pueda almacenar*/ 
		if (file_exists($_FILES['logo']['tmp_name']) || is_uploaded_file($_FILES['logo']['tmp_name']))
		{
			$ext = explode(".", $_FILES["logo"]["name"]);
			if ($_FILES['logo']['type'] == "image/jpg" ||
			 $_FILES['logo']['type'] == "image/jpeg" ||
			  $_FILES['logo']['type'] == "image/png")
			{
				if($imagenAnterior!="")
				{
					unlink("../files/denominacion/".$imagenAnterior);
				}
				//$logo = round(microtime(true)) . '.' . end($ext);
				$logo = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["logo"]["tmp_name"], "../files/denominacion/" . $logo);
			}
		}
		else 
		{
			//imagen actual
			$logo=$imagenAnterior;
		}
		if (empty($id)){
		    $rspta=$denominacion->insertar($nombre,$sigla,$descripcion,$logo);
		    echo $rspta ? "1:denominación registrada" : "0:denominación no se pudo registrar";
		}
		else {
			$rspta=$denominacion->editar($id,$nombre,$sigla,$descripcion,$logo);
			echo $rspta ? "1:denominación actualizada" : "0:denominación no se pudo actualizar";
		}
	break;

	case '2':
		$rspta=$denominacion->desactivar($id);
 		echo $rspta ? "1:denominación Desactivada" : "0:denominación no se puede desactivar";
 		break;
	break;

	case '3':
		$rspta=$denominacion->activar($id);
 		echo $rspta ? "1:denominación activada" : "0:denominación no se puede activar";
 		break;
	break;

	case '4':
		$rspta=$denominacion->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case '0':
		$rspta=$denominacion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
				"1"=>$reg->sigla,
                "2"=>($reg->logo)?"<img src='../files/denominacion/".$reg->logo."' height='50px' width='50px' >":
				"<img src='../files/denominacion/default.png' height='50px' width='50px' >",
				"3"=>$reg->descripcion,
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
		$rspta = $denominacion->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->id. '>' . $reg->nombre . '</option>';
				}
		break;
}
?>