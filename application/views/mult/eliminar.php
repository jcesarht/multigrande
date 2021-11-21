<?php
	header('Content-type: text/javascript');
	$respuesta = ['estado' => $estado, 'msg'=>$msg, 'resultado' => $resultado];
	echo json_encode($respuesta,JSON_PRETTY_PRINT);
?>