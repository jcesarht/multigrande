<?php
class operacionesModel extends CI_model
{
	public function __construct()
	{
		$this->load->database();
	}	

	public function registrarMult($multiplicando,$multiplicador,$producto)
	{
		$datos = ["multiplicando" => $multiplicando, "multiplicador" => $multiplicador, "producto" => $producto];
		return ['error' => $this->db->insert("multiplicaciones",$datos),'mensaje' => 'multiplicación guardada con exito'];
	}
	function consultarMult(){
		
		$consulta = $this->db->get('multiplicaciones');
		$error = $this->db->error();
        if ($error['code'] != NULL)
        {
            return array('error'=>true,'mensaje'=>'Error al consultar');
        }else{
        	return array('error'=>false,'mensaje'=>'Consulta realizada con exito','resultado'=>$consulta->result());
        }	
	}
	function consultarId($id){
		if($id != ''){
			$this->db->where("id",$id);
		}
		else{
			return array('error'=>true,'mensaje'=>'debe mandar como parametro el Id');
		}
		$consulta = $this->db->get('usuarios');
		$error = $this->db->error();
        if ($error['code'] != NULL)
        {
            return array('error'=>true,'mensaje'=>'Error al consultar');
        }else{
        	$check = false;
        	if ($consulta->num_rows() > 0) {
				$check = true;
			}
			if($check)
				return array('error'=>false,'mensaje'=>'Usuario Encontrado','resultado'=>$consulta->result());
			else
				return array('error'=>true,'mensaje'=>'Usuario con Id '.$id.' no existe');
        }	
	}
	public function eliminar($id = 'all')
	{	$consulta = '';
		$mensaje = '';
		if($id != 'all'){
			$this->db->where("id",$id);
			$consulta = $this->db->delete('multiplicaciones');
			$mensaje = 'Registro eliminado exitosamente';
		}else{
			$consulta = $this->db->empty_table('multiplicaciones');
			$mensaje = 'Todos los registros han sido eliminado';
		}		
		$error = $this->db->error();
        if ($error['code'] != NULL)
        {
            return array('error'=>true,'mensaje'=>$error);
        }else{
        	return array('error'=>false,'mensaje'=>$mensaje);
        }
	}
}
?>