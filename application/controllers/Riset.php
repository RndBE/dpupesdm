<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riset extends CI_Controller {
	function __construct() {
		parent::__construct();

		//$this->load->model('m_ketinggian');
	}

	function dtakhir()
	{
		$idlog = $this->input->get('idlogger');
		$tabeldt = $this->input->get('tabel');
		$data_terakhir=array();

		$query_datasheet=$this->db->query('select * from datasheet_debit where idlogger="'.$idlog.'" ');

		foreach($query_datasheet->result() as $datasheet)
		{
			$a=$datasheet->a;
			$b=$datasheet->b;
			$c=$datasheet->c;
		}

		$query_perbaikan=$this->db->query('select * from t_perbaikan where id_logger="'.$idlog.'" ');
		if($query_perbaikan->num_rows() == null)
		{

			$qparam=$this->db->query("SELECT * FROM parameter_sensor where logger_id='".$idlog."'");		
			foreach($qparam->result() as $sensor)
			{
				$kolom=$sensor->kolom_sensor;
				$kolom2=$sensor->kolom_acuan;
				$qdataparam=$this->db->query("SELECT * FROM ".$tabeldt." where code_logger='".$idlog."' order by waktu desc limit 1");

				if(preg_match("/debit/i", $sensor->nama_parameter)){
					foreach($qdataparam->result() as $data)
					{
						if ($b==0){
							$datasensor="-";
							$waktu=$data->waktu;
						} else {
							$datasensor=number_format($c*(pow($data->$kolom2-$a,$b)),3);
							$waktu=$data->waktu;
						}
						//$datasensor=number_format(1380*(pow($data->$kolom2/100,2.5)),3);

					}
				}
				else{
					foreach($qdataparam->result() as $data)
					{
						$datasensor=$data->$kolom;
						$waktu=$data->waktu;
					}
				}


				$data_terakhir[]=array(

					'idsensor'=>$sensor->id_param,
					'sensor'=>$sensor->nama_parameter,
					'data'=>$datasensor,
					'satuan'=>$sensor->satuan,
					'icon'=>$sensor->icon_sensor,
					'tipe_graf'=>$sensor->tipe_graf,
				);

			}
			$data_akhir=array(
				'waktu'=>$waktu,
				'data_terakhir'=>$data_terakhir
			);
			echo json_encode($data_akhir);
		}
		else {
			foreach($query_perbaikan->result() as $data_perbaikan) {
				$d_per=	$data_perbaikan->data_terakhir;
				$data_per = json_decode($d_per);
				$data_akhir = $data_per->kolom;
				$data_terakhir[]=array(

					'idsensor'=>$data_per->id_param,
					'sensor'=>$data_per->nama_parameter,
					'data'=>$data_akhir,
					'satuan'=>$data_per->satuan,
					'icon'=>$data_per->icon_sensor
				);

			}
			$data_akhir=array(
				'waktu'=>$data_per->waktu,
				'data_terakhir'=>$data_terakhir
			);
			echo json_encode($data_akhir);

		}

	}
	
	function history_chat() {
		$data['history'] = $this->db->order_by('date','desc')->get('t_history')->result_array();
		
		$this->load->view('history',$data);
	}

	public function aggregasi () {
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date('Y-m-d',strtotime('2023-11-04 12:00'));
		$jam = date('H',strtotime('2023-11-04 12:00'));
		$awal =date("H", strtotime(date('Y-m-d H:i',strtotime('2023-11-04 12:00')) . " -1 hour"));
		
		$get_awr = $this->db->where('icon','ws')->where('user_id','4')->group_by('code_logger')->get('t_logger')->result_array();
		
		foreach($get_awr as $v){
			$id_logger = $v['code_logger'];
			
			$logger = $this->db->where('code_logger',$id_logger)->join('kategori_logger','t_logger.katlog_id = kategori_logger.id_katlogger')->get('t_logger')->row();
			
			if($logger){
				$tabel = $logger->tabel;
				$query = $this->db->query( "SELECT user_id,code_logger,waktu,
CONCAT('[',FORMAT(min(sensor1),3),',',FORMAT(avg(sensor1),3),',',FORMAT(max(sensor1),3), ']')  as sensor1,
CONCAT('[',FORMAT(min(sensor2),3),',',FORMAT(avg(sensor2),3),',',FORMAT(max(sensor2),3), ']')  as sensor2,
CONCAT('[',FORMAT(min(sensor3),3),',',FORMAT(avg(sensor3),3),',',FORMAT(max(sensor3),3), ']')  as sensor3,
CONCAT('[',FORMAT(min(sensor4),3),',',FORMAT(avg(sensor4),3),',',FORMAT(max(sensor4),3), ']')  as sensor4,
CONCAT('[',FORMAT(min(sensor5),3),',',FORMAT(avg(sensor5),3),',',FORMAT(max(sensor5),3), ']')  as sensor5,
CONCAT('[',FORMAT(min(sensor6),3),',',FORMAT(avg(sensor6),3),',',FORMAT(max(sensor6),3), ']')  as sensor6,
CONCAT('[',FORMAT(min(sensor7),3),',',FORMAT(avg(sensor7),3),',',FORMAT(max(sensor7),3), ']')  as sensor7,
CONCAT('[',0,',',FORMAT(sum(sensor8),3),',',0, ']')  as sensor8,
CONCAT('[',0,',',FORMAT(sum(sensor9),3),',',0, ']')  as sensor9,
CONCAT('[',FORMAT(min(sensor10),3),',',FORMAT(avg(sensor10),3),',',FORMAT(max(sensor10),3), ']')  as sensor10,
CONCAT('[',FORMAT(min(sensor11),3),',',FORMAT(avg(sensor11),3),',',FORMAT(max(sensor11),3), ']')  as sensor11,
CONCAT('[',FORMAT(min(sensor12),3),',',FORMAT(avg(sensor12),3),',',FORMAT(max(sensor12),3), ']')  as sensor12,
CONCAT('[',FORMAT(min(sensor13),3),',',FORMAT(avg(sensor13),3),',',FORMAT(max(sensor13),3), ']')  as sensor13,
CONCAT('[',FORMAT(min(sensor14),3),',',FORMAT(avg(sensor14),3),',',FORMAT(max(sensor14),3), ']')  as sensor14,
CONCAT('[',FORMAT(min(sensor15),3),',',FORMAT(avg(sensor15),3),',',FORMAT(max(sensor15),3), ']')  as sensor15,
CONCAT('[',FORMAT(min(sensor16),3),',',FORMAT(avg(sensor16),3),',',FORMAT(max(sensor16),3), ']')  as sensor16
FROM weather_station where code_logger='".$id_logger."' and waktu >= '".$tanggal." ".$awal.":00' and waktu < '".$tanggal." ".$jam.":00' group by HOUR(waktu),DAY(waktu),MONTH(waktu),YEAR(waktu)")->row();
					
				if($query){
					$hari_jam =date("Y-m-d H", strtotime($query->waktu));

					$cek = $this->db->where('code_logger',$id_logger)->like('waktu',$hari_jam)->get('ag_awr')->row();
					if(!$cek){
						$this->db->insert('ag_awr',$query);
						echo 'data berhasil diinput';
					}else{
						echo 'data sudah ada';
					}
				}
				
				
			}
		}

	}

}
