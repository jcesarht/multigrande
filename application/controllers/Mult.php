<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mult extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('operacionesModel');
	}
	
	public function index()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
		$resultado = [];
		$calculadora = json_decode(file_get_contents('php://input'),true);
		if(isset($calculadora['multiplicando'])){
			
			$multiplicando = $calculadora['multiplicando'];
			$multiplicador = $calculadora['multiplicador'];
			$producto = bcmul($multiplicando, $multiplicador);
			$respuesta_database = $this->operacionesModel->registrarMult($multiplicando,$multiplicador,$producto);
			if($respuesta_database['error'] != true){
				$resultado = ['estado' => 'error','msg' => 'Problemas con guardar la operación de multiplicación','resultado' => null];
			}else{
				$resultado = ['estado' => 'success','msg' => 'El valor de la multiplicación es :'.$producto,'resultado' => $producto,'multiplicando' => $multiplicando, 'multiplicador'=> $multiplicador,'producto' => $producto];
			}
		}else{
			$historial['historial'] = null;
			$respuesta_database = $this->operacionesModel->consultarMult();
			if($respuesta_database['error'] !== false){
				$resultado = ['estado' => 'error','msg' => 'No se pudo consultar el historial de operaciones','resultado' => $historial];
			}else{
				$historial['historial'] = $respuesta_database['resultado'];
				$resultado = ['estado' => 'success','msg' => 'Historial de operaciones','resultado' => $historial];
			}
		}
		$this->load->view('mult/index',$resultado);
	}
	public function eliminar(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
		$resultado = [];
		$calculadora = json_decode(file_get_contents('php://input'),true);
		$id = $calculadora['id'];//$this->input->post('id');
		if($id != ''){
			
			if($id == 'all'){
				$respuesta_database = $this->operacionesModel->eliminar();
				if($respuesta_database['error'] !== false){
					$resultado = ['estado' => 'error', 'msg' => 'No se eliminaron los registros','resultado' =>$respuesta_database['mensaje']];
					
				}else{
					$resultado = ['estado' => 'success', 'msg' => 'Registros eliminados exitosamente','resultado' =>null];	
				}
			}else{
				$respuesta_database = $this->operacionesModel->eliminar($id);
				if($respuesta_database['error'] !== false){
					$resultado = ['estado' => 'error', 'msg' => 'No se eliminó el registro','resultado' =>$respuesta_database['mensaje']];
				}else{
					$resultado = ['estado' => 'success', 'msg' => 'Registro eliminado exitosamente','resultado' =>null];	
				}
			}	
		}else{
			$resultado = ['estado' => 'error', 'msg' => 'Debe enviar por lo menos un parametro id o all para eliminar todos los registros','resultado' =>null];
		}
		$this->load->view('mult/eliminar',$resultado);
	}
}
