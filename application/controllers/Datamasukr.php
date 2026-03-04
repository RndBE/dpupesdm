<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datamasukr extends CI_Controller {
	function __construct() {
 		parent::__construct();
 		
 		$this->load->model('m_inputdata');
		$this->load->library('PhpMQTT');
 	}

#################### --ARR--########################
/* public function data_arr()
	{
		$data['data_arr']=$this->m_inputdata->view_arr($this->session->userdata('log_id'));
		$this->load->view('konten/inputdata/view_arr',$data);
	}
	*/
public function data_arr()
	{
		 if(empty($this->session->userdata('tgl_arr'))){
				$tgl=date('Y-m-d');
				$this->session->set_userdata('tgl_arr',$tgl);
			}
	 $data['data_arr']= $this->db->query('SELECT * FROM arr where code_logger="'.$this->session->userdata('log_id').'" and waktu like "'.$this->session->userdata('tgl_arr').'%" ORDER BY waktu desc');
		
		$this->load->view('konten/inputdata/view_arr',$data);
	}
	function tgl_arr()
	{
		$date=date_create($this->input->post('tgl'));
		$tgl=date_format($date,"Y-m-d");
		$this->session->set_userdata('tgl_arr',$tgl);
		redirect('datamasuk/data_arr');
	}	
      public function add_arr()
	{
		  $tgl=GETDATE();
                $tanggal = $this->input->post('tanggal');
                $jam = $this->input->post('jam');
                $waktu = $tanggal.' '.$jam;

		  if ($this->input->post('id_alat')=='10184') {
			  $query_ambilsn=$this->db->query('select * from t_informasi where logger_id="'.$this->input->post('id_alat').'"');
			  foreach($query_ambilsn->result() as $asn)
			  {
				$sn=$asn->serial_number;
			  }
			  $data = array (
				  'code_logger'=>$this->input->post('id_alat'),
				  //'user_id'=>$this->input->post('user_id'),
				  'waktu'=>$waktu,

				  'sensor1'=>$this->input->post('sensor1'),
				  'sensor2'=>$this->input->post('sensor2'),
				  'sensor3'=>$this->input->post('sensor3'),
				  'sensor4'=>$this->input->post('sensor4'),
				  'sensor5'=>$this->input->post('sensor5'),
				  'sensor6'=>$this->input->post('sensor6'),
				  'sensor7'=>$this->input->post('sensor7'),
				  'sensor8'=>$this->input->post('sensor8'),
				  'sensor9'=>$this->input->post('sensor9'),
				  'sensor10'=>$this->input->post('sensor10'),
				  'sensor11'=>$this->input->post('sensor11'),
				  'sensor12'=>"0",
				  'sensor13'=>$this->input->post('sensor13'),
				  'sensor14'=>$this->input->post('sensor14'),
				  'sensor15'=>$this->input->post('sensor15'),
				  'sensor16'=>$this->input->post('sensor16'),
			  );
			  
			  
			  $query_ambilsn=$this->db->query('select * from t_informasi where logger_id="'.$this->input->post('id_alat').'"');
			  foreach($query_ambilsn->result() as $asn)
			  {
				  $sn=$asn->serial_number;
			  }
			  if (!empty($this->input->post('sensor12')))
			  {
				 
				  if ($sn!=$this->input->post('sensor12')) {
					  $this->m_inputdata->update_sn($this->input->post('id_alat'),array("serial_number" => $this->input->post('sensor12')));
				  }
			  }

			 // if ($sn!=$this->input->post('sn')) { 
				//  $this->m_inputdata->update_sn($this->input->post('id_alat'),array("serial_number" => $this->input->post('sensor12')));
			  //}

		  }	else {
			  $data = array (
				  'code_logger'=>$this->input->post('id_alat'),
				  //'user_id'=>$this->input->post('user_id'),
				  'waktu'=>$waktu,

				  'sensor1'=>$this->input->post('sensor1'),
				  'sensor2'=>$this->input->post('sensor2'),
				  'sensor3'=>$this->input->post('sensor3'),
				  'sensor4'=>$this->input->post('sensor4'),
				  'sensor5'=>$this->input->post('sensor5'),
				  'sensor6'=>$this->input->post('sensor6'),
				  'sensor7'=>$this->input->post('sensor7'),
				  'sensor8'=>$this->input->post('sensor8'),
				  'sensor9'=>$this->input->post('sensor9'),
				  'sensor10'=>$this->input->post('sensor10'),
				  'sensor11'=>$this->input->post('sensor11'),
				  'sensor12'=>$this->input->post('sensor12'),
				  'sensor13'=>$this->input->post('sensor13'),
				  'sensor14'=>$this->input->post('sensor14'),
				  'sensor15'=>$this->input->post('sensor15'),
				  'sensor16'=>$this->input->post('sensor16'),

			  );
		  }
		  
		  
		 
	//	$this->m_inputdata->add_arr($data);
	//	$this->m_inputdata->update_temparr($this->input->post('id_alat'),$data);
		//echo "done";
		  
	/*	    if($jamkirim[1]=='00')
		  {
				$jamq=$jamkirim[0]-1;
				$query_akum = $this->db->query('select waktu,sum('.$sensor.') as hujan from arr where code_logger="'.$this->input->post('id_alat').'" and waktu >= "'.$this->input->post('tanggal').' '.$jamq.':00"');
				foreach($query_akum->result() as $data_akum){
					$curah_hujan=$data_akum->hujan;
				}
		   
		  	$datakirim=array(
			  'tanggal' => $this->input->post('tanggal'),
			  'jam' => $jamkirim[0],
			  'kode_database' => $this->input->post('id_alat'),
			  'nilai' => $curah_hujan,
			  'kode_penyedia' => 'telemetri2022',
			  'model' => 'hujan' 
		 	 );
				
		  	$ch = curl_init();  // initialize curl handle
			curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
			curl_setopt($ch, CURLOPT_FAILONERROR, 1); //Fail on error
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
			curl_setopt($ch, CURLOPT_POST, 1); // set POST method
			curl_setopt($ch, CURLOPT_POSTFIELDS, $datakirim); // add POST fields
			$result = curl_exec($ch); // run the whole process
			//curl_exec($ch);
			curl_close($ch);
			//echo $result;
			}
			*/
		  ################## MQTT ############
	/*		$server = 'coba.beacontelemetry.com';    
			$port = 8883;                  
			$username = 'userlog';               
			$password = 'b34c0n';                 
			$client_id = 'bemqtt-'.$this->input->post('id_alat');
			$ca="/etc/ssl/certs/ca-bundle.crt";

			$mqtt = new phpMQTT($server, $port, $client_id,$ca);
		//  $mqtt = new phpMQTT($server, $port, $client_id);
			
			if ($mqtt->connect(true, NULL, $username, $password)) {
				$mqtt->publish($this->input->post('id_alat'), json_encode($data), 0, false);
				$mqtt->close();
				echo 'data ARR dikirim dengan mqtt';
			} else {
				echo "Time out!\n";
			}
			*/
			################################

	}
	
	public function add_arr2()
	{
		  $tgl=GETDATE();
                $tanggal = $this->input->post('tanggal');
                $jam = $this->input->post('jam');
                $waktu = $tanggal.' '.$jam;

		$data = array (
			'code_logger'=>$this->input->post('id_alat'),
			//'user_id'=>$this->input->post('user_id'),
			'waktu'=>$waktu,
			
			'sensor1'=>$this->input->post('sensor1'),
			'sensor2'=>$this->input->post('sensor2'),
			'sensor3'=>$this->input->post('sensor3'),
			'sensor4'=>$this->input->post('sensor4'),
			'sensor5'=>$this->input->post('sensor5'),
			'sensor6'=>$this->input->post('sensor6'),
			'sensor7'=>$this->input->post('sensor7'),
			'sensor8'=>$this->input->post('sensor8'),
			'sensor9'=>$this->input->post('sensor9'),
			'sensor10'=>$this->input->post('sensor10'),
			'sensor11'=>$this->input->post('sensor11'),
			'sensor12'=>$this->input->post('sensor12'),
			'sensor13'=>$this->input->post('sensor13'),
			'sensor14'=>$this->input->post('sensor14'),
			'sensor15'=>$this->input->post('sensor15'),
			'sensor16'=>$this->input->post('sensor16'),
	
	);
		 
		$this->m_inputdata->add_arr($data);
		$this->m_inputdata->update_temparr($this->input->post('id_alat'),$data);
		  #################### Ke Server PUSDA Jatim ###########################
		 //  $url = "http://pusdajatim.monitoring4system.com/datamasuk/cek_sinkron"; 
		  if($this->input->post('id_alat')=='10109')
		  {
			 // $curah_hujan=$this->input->post('sensor8');
			  $sensor='sensor9';
			  $data = array(
				'id_logger'=>$this->input->post('id_alat'),
				//'user_id'=>$this->input->post('user_id'),
				'waktu'=>$waktu,

				'tma'=>$this->input->post('sensor9'),
			);
			$this->tes_notif($data,'arr',$tanggal,$jam);
		  }else{
			//  $curah_hujan=$this->input->post('sensor1');
			  $sensor='sensor1';
			  $data = array(
				'id_logger'=>$this->input->post('id_alat'),
				//'user_id'=>$this->input->post('user_id'),
				'waktu'=>$waktu,

				'tma'=>$this->input->post('sensor1'),
			);
			$this->tes_notif($data,'arr',$tanggal,$jam);
		  }
	}

        public function sesi_loggerarr()
	{
	    $this->session->set_userdata('log_id',$this->input->post('logger_id'));
	    redirect ('datamasuk/data_arr');
	}

#################### --AWLR--########################
 /*public function data_awlr()
	{
		$data['data_awlr']=$this->m_inputdata->view_awlr($this->session->userdata('log_id'));
		$this->load->view('konten/inputdata/view_awlr',$data);
	}*/
	
	public function data_awlr()
	{
		 if(empty($this->session->userdata('tgl_awlr'))){
				$tgl=date('Y-m-d');
				$this->session->set_userdata('tgl_awlr',$tgl);
			}
	 $data['data_awlr']= $this->db->query('SELECT * FROM awlr where code_logger="'.$this->session->userdata('log_id').'" and waktu like "'.$this->session->userdata('tgl_awlr').'%" ORDER BY waktu desc');
		
		$this->load->view('konten/inputdata/view_awlr',$data);
	}
	function tgl_awlr()
	{
		$date=date_create($this->input->post('tgl'));
		$tgl=date_format($date,"Y-m-d");
		$this->session->set_userdata('tgl_awlr',$tgl);
		redirect('datamasuk/data_awlr');
	}
	
      public function add_awlr()
	{
		  $tgl=GETDATE();
                $tanggal = $this->input->post('tanggal');
                $jam = $this->input->post('jam');
                $waktu = $tanggal.' '.$jam;

		$data = array (
			'code_logger'=>$this->input->post('id_alat'),
			//'user_id'=>$this->input->post('user_id'),
			'waktu'=>$waktu,
			
			'sensor1'=>$this->input->post('sensor1'),
			'sensor2'=>$this->input->post('sensor2'),
			'sensor3'=>$this->input->post('sensor3'),
			'sensor4'=>$this->input->post('sensor4'),
			'sensor5'=>$this->input->post('sensor5'),
			'sensor6'=>$this->input->post('sensor6'),
			'sensor7'=>$this->input->post('sensor7'),
			'sensor8'=>$this->input->post('sensor8'),
			'sensor9'=>$this->input->post('sensor9'),
			'sensor10'=>$this->input->post('sensor10'),
			'sensor11'=>$this->input->post('sensor11'),
			'sensor12'=>$this->input->post('sensor12'),
			'sensor13'=>$this->input->post('sensor13'),
			'sensor14'=>$this->input->post('sensor14'),
			'sensor15'=>$this->input->post('sensor15'),
			'sensor16'=>$this->input->post('sensor16'),
	
	);
		 
		$this->m_inputdata->add_awlr($data);
		$this->m_inputdata->update_tempawlr($this->input->post('id_alat'),$data);
	
		  $data2 = array(
				'id_logger'=>$this->input->post('id_alat'),
				//'user_id'=>$this->input->post('user_id'),
				'waktu'=>$waktu,

				'tma'=>$this->input->post('sensor1'),
			);
			$this->tes_notif($data2, 'awlr',$tanggal,$jam);
		  #################### Ke Server PUSDA Jatim ###########################
		  //$url = "http://dpuair.jatimprov.go.id/hidro/api/post_data_telemetri";
		  $url = "http://hidrologi.dpuair.jatimprov.go.id/api/post_data_telemetri";
		// $url = "http://pusdajatim.monitoring4system.com/datamasuk/cek_sinkron"; 
		  $jamkirim=explode(":", $this->input->post('jam'));
		  $query_sinkron = $this->db->query('select * from cek_sinkron where idlogger="'.$this->input->post('id_alat').'" and tanggal = "'.$this->input->post('tanggal').'" and jam="'.$jamkirim[0].'"');
		  if($query_sinkron->num_rows() == 0)
		  {
		 
			  $datakirim=array(
			  'tanggal' => $this->input->post('tanggal'),
			  'jam' => $jamkirim[0],
			  'kode_database' => $this->input->post('id_alat'),
			  'nilai' => $this->input->post('sensor1'),
			  'kode_penyedia' => 'telemetri2022',
			  'model' => 'duga' 
		  		);
			  $datasinkron=array(
			  'tanggal' => $this->input->post('tanggal'),
			  'jam' => $jamkirim[0],
			  'idlogger' => $this->input->post('id_alat'),
			  'nilai' =>$this->input->post('sensor1')
			  
		  );
			  
			  
		  	$ch = curl_init();  // initialize curl handle
			curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
			curl_setopt($ch, CURLOPT_FAILONERROR, 1); //Fail on error
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
			curl_setopt($ch, CURLOPT_POST, 1); // set POST method
			curl_setopt($ch, CURLOPT_POSTFIELDS, $datakirim); // add POST fields
			$result = curl_exec($ch); // run the whole process
			//curl_exec($ch);
			curl_close($ch);
			//echo $result;
			 $ceksink= json_decode($result);
			  if($ceksink->message == "Success Menambahkan Data")
			  {
				  $this->m_inputdata->add_sinkron($datasinkron);
			  }
			
		  }
		  /*else{
			  $datakirim=array(
			  'tanggal' => $this->input->post('tanggal'),
			  'jam' => $jamkirim[0],
			  'kode_database' => $this->input->post('id_alat'),
			  'nilai' => $this->input->post('sensor1'),
			  'kode_penyedia' => 'telemetri2022',
			  'model' => 'duga' 
		  		);
			  $datasinkron=array('nilai' =>$this->input->post('sensor1'));
			  $this->m_inputdata->update_sinkron($this->input->post('id_alat'),$this->input->post('tanggal'),$jamkirim[0],$datasinkron);
			  
		  	$ch = curl_init();  // initialize curl handle
			curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
			curl_setopt($ch, CURLOPT_FAILONERROR, 1); //Fail on error
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
			curl_setopt($ch, CURLOPT_POST, 1); // set POST method
			curl_setopt($ch, CURLOPT_POSTFIELDS, $datakirim); // add POST fields
			$result = curl_exec($ch); // run the whole process
			//curl_exec($ch);
			curl_close($ch);
			  
			  
		  }
		  */
		  
		  ################## MQTT ############
			$server = 'mqtt.beacontelemetry.com';    
			$port = 8883;                  
			$username = 'userlog';               
			$password = 'b34c0n';                 
			$client_id = 'bemqtt-'.$this->input->post('id_alat');
			$ca="/etc/ssl/certs/ca-bundle.crt";

			$mqtt = new phpMQTT($server, $port, $client_id,$ca);
			 // $mqtt = new phpMQTT($server, $port, $client_id);
			if ($mqtt->connect(true, NULL, $username, $password)) {
				$mqtt->publish($this->input->post('id_alat'), json_encode($data), 0, false);
				$mqtt->close();
				echo 'data AWLR dikirim dengan mqtt';
			} else {
				echo "Time out!\n";
			}
			
			################################

	}

        public function sesi_loggerawlr()
	{
	    $this->session->set_userdata('log_id',$this->input->post('logger_id'));
	    redirect ('datamasuk/data_awlr');
	}
		public function tes_add(){
			$tanggal = $this->input->post('tanggal');
			$jam = $this->input->post('jam');
			$tabel = $this->input->post('tabel');
			$waktu = $tanggal.' '.$jam;
			$data = array(
				'id_logger'=>$this->input->post('id_alat'),
				//'user_id'=>$this->input->post('user_id'),
				'waktu'=>$waktu,

				'tma'=>$this->input->post('sensor1'),
			);
			$this->tes_notif($data,$tabel,$tanggal,$jam);
		}	
	
		public function tes_notif($awlr, $tabel,$tanggal,$jam){
			if($tabel == 'awlr'){
				$data = $this->db->get('klasifikasi_tma')->result_array();
				foreach($data as $key=>$val){
					if($val['idlogger'] == $awlr['id_logger']){
						if($awlr['tma'] >= $val['siaga2'] and $awlr['tma'] < $val['siaga1']){

							$data2 = array(
								'id_logger' => $val['idlogger'],
								'status'=> 'Waspada',
								'waktu'=>$awlr['waktu'],
								'tma'=>$awlr['tma'],
								'warna'=> 'FCE22A',
								'tabel'=> $tabel
							);
							$this->db->insert('t_notif', $data2);
						}elseif($awlr['tma'] >= $val['siaga1']){
							$data2 = array(
								'id_logger' => $val['idlogger'],
								'status'=> 'Siaga',
								'waktu'=>$awlr['waktu'],
								'tma'=>$awlr['tma'],	
								'warna'=> 'F94A29',
								'tabel'=> $tabel
							);
							$this->db->insert('t_notif', $data2);
						}
					}
				}
			}else{
				$gabung = $tanggal . ' ' . $jam;
				$jam_awal = $tanggal . ' '. date('H',strtotime($gabung)).':00:00';
				$jam_akhir = $tanggal . ' '.date('H',strtotime($gabung)).':59:00';
				$data2 = $this->db->query("SELECT SUM(sensor1) as 'akm' FROM arr where code_logger='". $awlr['id_logger']."' and waktu >= '".$jam_awal."' and waktu <= '".$jam_akhir."' order by waktu asc")->row();
				$data3 = array();
				$data = $this->db->where('waktuper', 'perjam')->get('klasifikasi_hujan')->row();
				if($data2->akm >= $data->kuning and $data2->akm < $data->oranye){
					$data3 = array(
						'id_logger' => $awlr['id_logger'],
						'status'=> 'Hujan Sedang',
						'waktu'=>$awlr['waktu'],
						'tma'=>$data2->akm,
						'warna'=> 'FCE22A',
						'tabel'=> $tabel
					);
					$this->db->insert('t_notif', $data3);
				}elseif($data2->akm >= $data->oranye and $data2->akm < $data->merah){
					$data3 = array(
						'id_logger' => $awlr['id_logger'],
						'status'=> 'Hujan Lebat',
						'waktu'=>$awlr['waktu'],
						'tma'=>$data2->akm,
						'warna'=> 'f7963a',
						'tabel'=> $tabel
					);
					$this->db->insert('t_notif', $data3);
				}elseif($data2->akm >= $data->merah){
					$data3 = array(
						'id_logger' => $awlr['id_logger'],
						'status'=> 'Hujan Sangat Lebat',
						'waktu'=>$awlr['waktu'],
						'tma'=>$data2->akm,
						'warna'=> 'F94A29',
						'tabel'=> $tabel
					);
					$this->db->insert('t_notif', $data3);
				}
			}
			
			//$this->db->insert('t_notif', $awlr);
			
		}
	
		public function tes_akumulasi_arr(){
			$tanggal = $this->input->post('tanggal');
			$jam = $this->input->post('jam');
			$gabung = $tanggal . ' ' . $jam;
			$jam_awal = $tanggal . ' '. date('H',strtotime($gabung)).':00:00';
			$jam_akhir = $tanggal . ' '.date('H',strtotime($gabung)).':59:00';
			$data2 = $this->db->query("SELECT SUM(sensor1) as 'akm' FROM arr where code_logger='10124' and waktu >= '".$jam_awal."' and waktu <= '".$jam_akhir."' order by waktu asc")->row();
			$data3 = array();
			$data = $this->db->where('waktuper', 'perjam')->get('klasifikasi_hujan')->row();
				if($data2->akm >= $data->kuning and $data2->akm < $data->oranye){
					$data3 = array(
						'id_logger' => $awlr['id_logger'],
						'status'=> 'Hujan Sedang',
						'waktu'=>$awlr['waktu'],
						'tma'=>$awlr['tma'],
						'warna'=> 'fef21f',
						'tabel'=> $tabel
					);
					
				}elseif($data2->akm >= $data->oranye and $data2->akm < $data->merah){
					$data3 = array(
						'id_logger' => $awlr['id_logger'],
						'status'=> 'Hujan Lebat',
						'waktu'=>$awlr['waktu'],
						'tma'=>$awlr['tma'],
						'warna'=> 'f7963a',
						'tabel'=> $tabel
					);
				}elseif($data2->akm >= $data->merah){
				$data3 = array(
						'id_logger' => $awlr['id_logger'],
						'status'=> 'Hujan Sangat Lebat',
						'waktu'=>$awlr['waktu'],
						'tma'=>$awlr['tma'],
					'warna'=> 'ed1c24',
						'tabel'=> $tabel
					);
				}
			echo json_encode($data3);
			//echo $jam_awal;
			//$data = $this->db->query('')
		}
	##############################---EWS -----##########################
	
public function data_ews()
	{
		 if(empty($this->session->userdata('tgl_ews'))){
				$tgl=date('Y-m-d');
				$this->session->set_userdata('tgl_ews',$tgl);
			}
	 $data['data_ews']= $this->db->query('SELECT * FROM ews where code_logger="'.$this->session->userdata('log_id').'" and waktu like "'.$this->session->userdata('tgl_ews').'%" ORDER BY waktu desc');
		
		$this->load->view('konten/inputdata/view_ews',$data);
	}
	function tgl_ews()
	{
		$date=date_create($this->input->post('tgl'));
		$tgl=date_format($date,"Y-m-d");
		$this->session->set_userdata('tgl_ews',$tgl);
		redirect('datamasuk/data_ews');
	}
	
      public function add_ews()
	{
		  $tgl=GETDATE();
                $tanggal = $this->input->post('tanggal');
                $jam = $this->input->post('jam');
                $waktu = $tanggal.' '.$jam;

		$data = array (
			'code_logger'=>$this->input->post('id_alat'),
			//'user_id'=>$this->input->post('user_id'),
			'waktu'=>$waktu,
			
			'sensor1'=>$this->input->post('sensor1'),
			'sensor2'=>$this->input->post('sensor2'),
			'sensor3'=>$this->input->post('sensor3'),
			'sensor4'=>$this->input->post('sensor4'),
			'sensor5'=>$this->input->post('sensor5'),
			'sensor6'=>$this->input->post('sensor6'),
			'sensor7'=>$this->input->post('sensor7'),
			'sensor8'=>$this->input->post('sensor8'),
			'sensor9'=>$this->input->post('sensor9'),
			'sensor10'=>$this->input->post('sensor10'),
			'sensor11'=>$this->input->post('sensor11'),
			'sensor12'=>$this->input->post('sensor12'),
			'sensor13'=>$this->input->post('sensor13'),
			'sensor14'=>$this->input->post('sensor14'),
			'sensor15'=>$this->input->post('sensor15'),
			'sensor16'=>$this->input->post('sensor16'),
	
	);
		 
		$this->m_inputdata->add_ews($data);
		$this->m_inputdata->update_tempews($this->input->post('id_alat'),$data);
		

	}

        public function sesi_loggerews()
	{
	    $this->session->set_userdata('log_id',$this->input->post('logger_id'));
	    redirect ('datamasuk/data_ews');
	}

	
	
	############################################################################
function cek_sinkron()
	{
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$koded=$this->input->post('kode_database');
		$nilai=$this->input->post('nilai');
		$kodep=$this->input->post('kode_penyedia');
		$model=$this->input->post('model');
	
		$datakirim=array(
			  'tanggal' => $this->input->post('tanggal'),
			  'jam' => $this->input->post('jam'),
			  'idlogger' => $this->input->post('kode_database'),
			  'nilai' =>$this->input->post('nilai')
			  
		  );
		$data=array( 'data' =>json_encode($datakirim));
		$this->m_inputdata->add_sinkron($datakirim);
	
	}
	
			########################### CRUD ###############################################
			function hapus_awlr($id){
		$where = array('id' => $id);
		$this->m_inputdata->hapus_awlr($where,'awlr');
		redirect('datamasuk/data_awlr');
	}
 
	function edit_awlr($id){
		$where = array('id' => $id);
		$data['user'] = $this->m_inputdata->edit_data_awlr($where,'awlr')->result();
		$this->load->view('v_edit',$data);
	}

	function update_awlr_crud(){
		$id = $this->input->post('id');

		$data = array(
			"sensor1" => $this->input->post('sensor1'),
			"sensor2" => $this->input->post('sensor2'),
			"sensor3" => $this->input->post('sensor3'),
			"sensor4" => $this->input->post('sensor4'),
			"sensor5" => $this->input->post('sensor5'),
			"sensor6" => $this->input->post('sensor6'),
			"sensor7" => $this->input->post('sensor7'),
			"sensor8" => $this->input->post('sensor8'),
			"sensor9" => $this->input->post('sensor9'),
			"sensor10" => $this->input->post('sensor10'),
			"sensor11" => $this->input->post('sensor11'),
			"sensor12" => $this->input->post('sensor12'),
			"sensor13" => $this->input->post('sensor13'),
			"sensor14" => $this->input->post('sensor14'),
			"sensor15" => $this->input->post('sensor15'),
			"sensor16" => $this->input->post('sensor16'),
		);

		$where = array(
			'id' => $id
		);

		//print_r($data);
		$this->m_inputdata->update_data_awlr_crud($where,$data,'awlr');

		//print_r($where);
		redirect('datamasuk/data_awlr');
	}
	
	function hapus_arr($id){
		$where = array('id' => $id);
		$this->m_inputdata->hapus_ar($where,'arr');
		redirect('datamasuk/data_arr');
	}

	function edit_arr($id){
		$where = array('id' => $id);
		$data['user'] = $this->m_inputdata->edit_data_arr($where,'arr')->result();
		$this->load->view('v_edit_arr',$data);
	}

function update_arr_crud(){
	$id = $this->input->post('id');
	 
	$data = array(
		"sensor1" => $this->input->post('sensor1'),
		"sensor2" => $this->input->post('sensor2'),
		"sensor3" => $this->input->post('sensor3'),
		"sensor4" => $this->input->post('sensor4'),
		"sensor5" => $this->input->post('sensor5'),
		"sensor6" => $this->input->post('sensor6'),
		"sensor7" => $this->input->post('sensor7'),
		"sensor8" => $this->input->post('sensor8'),
		"sensor9" => $this->input->post('sensor9'),
		"sensor10" => $this->input->post('sensor10'),
		"sensor11" => $this->input->post('sensor11'),
		"sensor12" => $this->input->post('sensor12'),
		"sensor13" => $this->input->post('sensor13'),
		"sensor14" => $this->input->post('sensor14'),
		"sensor15" => $this->input->post('sensor15'),
		"sensor16" => $this->input->post('sensor16'),
	);
 
	$where = array(
		'id' => $id
	);
 
	//print_r($data);
	$this->m_inputdata->update_data_arr_crud($where,$data,'arr');

	//print_r($where);
	redirect('datamasuk/data_arr');
}
	
	function update_sn(){
	$id = $this->input->post('id_alat');
	 
	$data = array(
		"serial_number" => $this->input->post('sn')
	);
 
	//print_r($data);
	$this->m_inputdata->update_sn($id,$data);

}
	
	###################### END ########################################################


}
