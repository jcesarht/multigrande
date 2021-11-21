<?php
	header('Content-type: text/javascript');
	$respuesta = ['estado' => $estado, 'msg'=>$msg];
	if($estado == 'success'){
		if(isset($resultado['historial'])){
			$json_format = []; 
			$historial = $resultado['historial'];

			foreach ($historial as $value) {
				$json_format[] = $value;
			}
			$respuesta['historial'] = $json_format;
		}else{
			$respuesta = ['estado' => $estado, 'msg'=>$msg,"multiplicando"=>$multiplicando,"multiplicador"=>$multiplicador, "producto" => $producto];
		}
	}
	echo json_encode($respuesta,JSON_PRETTY_PRINT);
?>