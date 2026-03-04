<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Awlr_backup extends CI_Controller {

function __construct() {
 		parent::__construct();
	$this->load->library('csvimport');
	$this->load->model('m_awlr');
 	}

### Dari Beranda ##########
	function set_sensordash()
	{
		$tabel=$this->input->get('tabel');
		$idparam=$this->input->get('id_param');

		$this->session->set_userdata('tabel',$tabel);
		$tgl=date('Y-m-d');
		$this->session->set_userdata('pada',$tgl);
		$this->session->set_userdata('data','hari');

		$q_parameter=$this->db->query("SELECT * FROM parameter_sensor where id_param='".$idparam."'");
		if($q_parameter->num_rows() > 0)
		{
		$parameter = $q_parameter->row();
            //data hasil seleksi dimasukkan ke dalam $session
            $session = array(
				'idlogger' => $parameter->logger_id,
                'idparameter' => $parameter->id_param,
            	'nama_parameter' => $parameter->nama_parameter,
            	'kolom' => $parameter->kolom_sensor,
				'satuan'=>$parameter->satuan,
				'tipe_grafik'=>$parameter->tipe_graf,
				'kolom_acuan'=>$parameter->kolom_acuan,
            );
            //data dari $session akhirnya dimasukkan ke dalam session
            $this->session->set_userdata($session);
			$querylogger=$this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="'.$parameter->logger_id.'";');
			$log=$querylogger->row();
			$lokasilog=$log->nama_lokasi;
			$this->session->set_userdata('namalokasi',$lokasilog);
	}
		
		redirect('awlr/analisa');
	}
############################################


### Dari Analisa ##########
	function set_sensorselect()
	{
		
		$idlogger=$this->uri->segment(3);
		$tabel=$this->uri->segment(4);
		$this->session->set_userdata('tabel',$tabel);
		$tgl=date('Y-m-d');
		$this->session->set_userdata('pada',$tgl);
		$this->session->set_userdata('data','hari');

		$q_parameter=$this->db->query("SELECT * FROM parameter_sensor where logger_id='".$idlogger."'");
		if($q_parameter->num_rows() > 0)
		{
		$parameter = $q_parameter->row();
            //data hasil seleksi dimasukkan ke dalam $session
            $session = array(
				'idlogger' => $parameter->logger_id,
                'idparameter' => $parameter->id_param,
            	'nama_parameter' => $parameter->nama_parameter,
            	'kolom' => $parameter->kolom_sensor,
				'satuan'=>$parameter->satuan,
				'tipe_grafik'=>$parameter->tipe_graf,
				'kolom_acuan'=>$parameter->kolom_acuan
            );
            //data dari $session akhirnya dimasukkan ke dalam session
            $this->session->set_userdata($session);
			$querylogger=$this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="'.$parameter->logger_id.'";');
			$log=$querylogger->row();
			$lokasilog=$log->nama_lokasi;
			$this->session->set_userdata('namalokasi',$lokasilog);
	}
		
		redirect('awlr/analisa');
	}
############################################

	function set_param()
	{
		$tabel=$this->uri->segment(3);
		$idparam=$this->uri->segment(4);
		$lok=str_replace('_', ' ', $this->uri->segment(5));
		$this->session->set_userdata('namalokasi',$lok);
		$this->session->set_userdata('tabel',$tabel);
		$tgl=date('Y-m-d');
		$this->session->set_userdata('pada',$tgl);
		$this->session->set_userdata('data','hari');
		$q_parameter=$this->db->query("SELECT * FROM parameter_sensor where id_param='".$idparam."'");
		if($q_parameter->num_rows() > 0)
		{
		$parameter = $q_parameter->row();
            //data hasil seleksi dimasukkan ke dalam $session
            $session = array(
				'idlogger' => $parameter->logger_id,
                'idparameter' => $parameter->id_param,
            	'nama_parameter' => $parameter->nama_parameter,
            	'kolom' => $parameter->kolom_sensor,
				'satuan'=>$parameter->satuan,
				'tipe_grafik'=>$parameter->tipe_graf,
				'kolom_acuan'=>$parameter->kolom_acuan
            );
            //data dari $session akhirnya dimasukkan ke dalam session
            $this->session->set_userdata($session);
	}
		redirect('awlr/analisa');
	}

### Set Pos #####
public function pilihposawlr()
	{
	 $data=array();
	$bidang = $this->session->userdata['bidang'];
	 $q_pos=$this->db->query("SELECT * FROM t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger = t_lokasi.idlokasi where kategori_log='2' AND t_logger.bidang='$bidang'");
	 foreach($q_pos->result() as $pos)
	 {
		 $data[]=array(
		 'idLogger'=>$pos->id_logger,'namaPos'=>$pos->nama_lokasi
		 );
	 }
        
       $data_pos = json_encode($data);
		return json_decode($data_pos);
	}

	function set_pos()
	{
		$idlog=$this->input->post('pilihpos');
		$querylogger=$this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="'.$idlog.'";');
		$log=$querylogger->row();
		$lokasilog=$log->nama_lokasi;
		$this->session->set_userdata('namalokasi',$lokasilog);

		$q_parameter=$this->db->query("SELECT * FROM parameter_sensor where logger_id='".$idlog."' order by id_param limit 1");
		if($q_parameter->num_rows() > 0)
		{
		$parameter = $q_parameter->row();
            //data hasil seleksi dimasukkan ke dalam $session
            $session = array(
				'idlogger' => $parameter->logger_id,
                'idparameter' => $parameter->id_param,
            	'nama_parameter' => $parameter->nama_parameter,
            	'kolom' => $parameter->kolom_sensor,
				'satuan'=>$parameter->satuan,
				'tipe_grafik'=>$parameter->tipe_graf,
				'kolom_acuan'=>$parameter->kolom_acuan
            );
            //data dari $session akhirnya dimasukkan ke dalam session
            $this->session->set_userdata($session);
			
	}
		
		redirect('awlr/analisa');
	}
##### set Parameter #####
 public function pilihparameter($idlogger)
	{
	 $data=array();
	 $q_parameter=$this->db->query("SELECT * FROM parameter_sensor where logger_id='".$idlogger."'");
	 foreach($q_parameter->result() as $param)
	 {
		 $data[]=array(
		 'idParameter'=>$param->id_param,'namaParameter'=>$param->nama_parameter,'fieldParameter'=>$param->kolom_sensor
		 );
	 }
        
       $data_param = json_encode($data);
		return json_decode($data_param);
	}

function set_parameter()
{
	$q_parameter=$this->db->query("SELECT * FROM parameter_sensor where id_param='".$this->input->post('mnsensor')."'");
		if($q_parameter->num_rows() > 0)
		{
		$parameter = $q_parameter->row();
            //data hasil seleksi dimasukkan ke dalam $session
            $session = array(
				'idlogger' => $parameter->logger_id,
                'idparameter' => $parameter->id_param,
            	'nama_parameter' => $parameter->nama_parameter,
            	'kolom' => $parameter->kolom_sensor,
				'satuan'=>$parameter->satuan,
				'tipe_grafik'=>$parameter->tipe_graf,
				'kolom_acuan'=>$parameter->kolom_acuan
            );
            //data dari $session akhirnya dimasukkan ke dalam session
            $this->session->set_userdata($session);
}
	redirect('awlr/analisa');
}


function sesi_data()
{
	if($this->input->post('data')=='hari')
	{
		$tgl=date('Y-m-d');
		$this->session->set_userdata('pada',$tgl);
	}
	elseif($this->input->post('data')=='bulan')
	{
		$tgl=date('Y-m');
		$this->session->set_userdata('pada',$tgl);

	}
	elseif($this->input->post('data')=='tahun')
	{
		$tgl=date('Y');
		$this->session->set_userdata('pada',$tgl);

	}
	elseif($this->input->post('data') == 'range')
	{
	    $dari=date('Y-m-d H:i',(mktime(date('H'),0,0,date('m'),date('d')-1,date('Y'))));
	   
	     $sampai=date('Y-m-d H:i',(mktime(date('H'),0,0,date('m'),date('d'),date('Y'))));
		
		$this->session->set_userdata('dari',$dari);
		$this->session->set_userdata('sampai',$sampai);

	}
	$this->session->set_userdata('data',$this->input->post('data'));
	redirect('awlr/analisa');
}

function settgl()
{
	$tgl=str_replace('/', '-', $this->input->post('tgl'));
	$this->session->set_userdata('pada',$tgl);	
	redirect('awlr/analisa');
}

function setbulan()
{
	$tgl=str_replace('/', '-', $this->input->post('bulan'));
	$this->session->set_userdata('pada',$tgl);	
	redirect('awlr/analisa');
}

function settahun()
{
	$tgl=str_replace('/', '-', $this->input->post('tahun'));
	$this->session->set_userdata('pada',$tgl);	
	redirect('awlr/analisa');
}

function setrange()
{
	$this->session->set_userdata('dari',$this->input->post('dari'));
	$this->session->set_userdata('sampai',$this->input->post('sampai'));
	redirect('awlr/analisa');
}


function analisa()
{
	
	if($this->session->userdata('logged_in'))
		{
			$data=array();
				$min=array();
				$max=array();
				$range=array();
		####################################################################################### HARI ##################
        	if($this->session->userdata('data')=='hari')
        	{
				

				$sensor=$this->session->userdata('kolom');
				$nama_sensor="Rerata_".$this->session->userdata('nama_parameter');
				if($sensor == 'debit')
				{
					$kolom=$this->session->userdata('kolom_acuan');
				}
				else{
					$kolom=$this->session->userdata('kolom');
				}
				$select='avg('.$kolom.') as '.$nama_sensor;
				$satuan=$this->session->userdata('satuan');		
		
				$query_data = $this->db->query("SELECT HOUR(waktu) as jam,DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun,".$select.",min(".$kolom.") as min,max(".$kolom.") as max FROM ".$this->session->userdata('tabel')." where code_logger='".$this->session->userdata('idlogger')."' and waktu like '".$this->session->userdata('pada')."%' group by HOUR(waktu),DAY(waktu),MONTH(waktu),YEAR(waktu) order by waktu asc;");
      		
			if($sensor == 'debit'){
				$query_datasheet=$this->db->query('select * from datasheet_debit where idlogger="'.$this->session->userdata('idlogger').'"');
					foreach($query_datasheet->result() as $dtsheet)
					{
						$c=$dtsheet->c;
						$a=$dtsheet->a;
						$b=$dtsheet->b;
					}
					foreach($query_data->result() as $datalog)
					{
						
						$tma=$datalog->$nama_sensor;
						$dta=$c*pow(($tma-$a),$b);
						$tmamin=$datalog->min;
						$dtamin=$c*pow(($tmamin-$a),$b);
						$tmamax=$datalog->max;
						$dtamax=$c*pow(($tmamax-$a),$b);
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dta,2)."]";
						$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
					}
					}
				else{
				foreach($query_data->result() as $datalog)
					{
								//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($datalog->$nama_sensor,3) ."]";
						$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),". $datalog->min.",". $datalog->max ."]";

					}
				}
				
		$dataAnalisa=array(
				'idLogger' =>$this->session->userdata('idlogger'),
				'namaSensor' =>$nama_sensor,
				'satuan'=>$satuan,
				'tipe_grafik'=>$this->session->userdata('tipe_grafik'),
				'data'=>$data,
				'nosensor'=>$kolom,
				'range'=>$range,
				'tooltip'=>"Waktu %d-%m-%Y %H:%M"				
			);
				$dataparam=json_encode($dataAnalisa);
        		$data['data_sensor']=json_decode($dataparam);
        	}
		####################################################################################### BULAN ##################
        	elseif($this->session->userdata('data')=='bulan')
        	{
				

				$sensor=$this->session->userdata('kolom');
				$nama_sensor="Rerata_".$this->session->userdata('nama_parameter');
				if($sensor == 'debit')
				{
					$kolom=$this->session->userdata('kolom_acuan');
				}
				else{
					$kolom=$this->session->userdata('kolom');
				}
				$select='avg('.$kolom.') as '.$nama_sensor;
				$satuan=$this->session->userdata('satuan');	
		
				$query_data = $this->db->query("SELECT DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun,".$select.",min(".$kolom.") as min,max(".$kolom.") as max FROM ".$this->session->userdata('tabel')." where code_logger='".$this->session->userdata('idlogger')."' and waktu like '".$this->session->userdata('pada')."%' group by DAY(waktu),MONTH(waktu),YEAR(waktu)  order by waktu asc;");
      		if($sensor == 'debit'){
				$query_datasheet=$this->db->query('select * from datasheet_debit where idlogger="'.$this->session->userdata('idlogger').'"');
					foreach($query_datasheet->result() as $dtsheet)
					{
						$c=$dtsheet->c;
						$a=$dtsheet->a;
						$b=$dtsheet->b;
					}
					foreach($query_data->result() as $datalog)
					{
						
						$tma=$datalog->$nama_sensor;
						$dta=$c*pow(($tma-$a),$b);
						$tmamin=$datalog->min;
						$dtamin=$c*pow(($tmamin-$a),$b);
						$tmamax=$datalog->max;
						$dtamax=$c*pow(($tmamax-$a),$b);
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari."),".number_format($dta,2)."]";
						$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari."),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
					}
					}
				else{
							foreach($query_data->result() as $datalog)
							{
								//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
								$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari."),".number_format($datalog->$nama_sensor,3) ."]";
								$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari."),". $datalog->min.",". $datalog->max ."]";

							}
					}
	
		
		$dataAnalisa=array(
				'idLogger' =>$this->session->userdata('idlogger'),
				'namaSensor' =>$nama_sensor,
				'satuan'=>$satuan,
				'tipe_grafik'=>$this->session->userdata('tipe_grafik'),
				'data'=>$data,
				'nosensor'=>$sensor,
				'range'=>$range,
				'tooltip'=>"Tanggal %d-%m-%Y"				
			);
				$dataparam=json_encode($dataAnalisa);
        		$data['data_sensor']=json_decode($dataparam);
        
        	}
		####################################################################################### TAHUN ##################
		elseif($this->session->userdata('data')=='tahun')
        	{
        		

				$sensor=$this->session->userdata('kolom');
				$nama_sensor="Rerata_".$this->session->userdata('nama_parameter');
				if($sensor == 'debit')
				{
					$kolom=$this->session->userdata('kolom_acuan');
				}
				else{
					$kolom=$this->session->userdata('kolom');
				}
				$select='avg('.$kolom.') as '.$nama_sensor;
				$satuan=$this->session->userdata('satuan');	
		
				$query_data = $this->db->query("SELECT MONTH(waktu) as bulan,YEAR(waktu) as tahun,".$select.",min(".$kolom.") as min,max(".$kolom.") as max FROM ".$this->session->userdata('tabel')." where code_logger='".$this->session->userdata('idlogger')."' and waktu like '".$this->session->userdata('pada')."%' group by MONTH(waktu),YEAR(waktu)  order by waktu asc;");
      					
			if($sensor == 'debit'){
				$query_datasheet=$this->db->query('select * from datasheet_debit where idlogger="'.$this->session->userdata('idlogger').'"');
					foreach($query_datasheet->result() as $dtsheet)
					{
						$c=$dtsheet->c;
						$a=$dtsheet->a;
						$b=$dtsheet->b;
					}
					foreach($query_data->result() as $datalog)
					{
						
						$tma=$datalog->$nama_sensor;
						$dta=$c*pow(($tma-$a),$b);
						$tmamin=$datalog->min;
						$dtamin=$c*pow(($tmamin-$a),$b);
						$tmamax=$datalog->max;
						$dtamax=$c*pow(($tmamax-$a),$b);
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1),".number_format($dta,2)."]";
						$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
					}
					}
				else{
							foreach($query_data->result() as $datalog)
							{
								//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
								$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1),".number_format($datalog->$nama_sensor,3) ."]";
								$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1),". $datalog->min.",". $datalog->max ."]";

							}
					}
	
		
		$dataAnalisa=array(
				'idLogger' =>$this->session->userdata('idlogger'),
				'namaSensor' =>$nama_sensor,
				'satuan'=>$satuan,
				'tipe_grafik'=>$this->session->userdata('tipe_grafik'),
				'data'=>$data,
				'nosensor'=>$sensor,
				'range'=>$range,
				'tooltip'=>"Tanggal %d-%m-%Y"				
			);
				$dataparam=json_encode($dataAnalisa);
        		$data['data_sensor']=json_decode($dataparam);
        	}
		####################################################################################### RANGE ##################
		elseif($this->session->userdata('data')=='range')
        	{

				$sensor=$this->session->userdata('kolom');
				$nama_sensor="Rerata_".$this->session->userdata('nama_parameter');
				if($sensor == 'debit')
				{
					$kolom=$this->session->userdata('kolom_acuan');
				}
				else{
					$kolom=$this->session->userdata('kolom');
				}
				$select='avg('.$kolom.') as '.$nama_sensor;
				$satuan=$this->session->userdata('satuan');		
		
				$query_data = $this->db->query("SELECT HOUR(waktu) as jam,DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun,".$select.",min(".$kolom.") as min,max(".$kolom.") as max FROM ".$this->session->userdata('tabel')." where code_logger='".$this->session->userdata('idlogger')."' and waktu >='".$this->session->userdata('dari')."' and waktu <='".$this->session->userdata('sampai')."' group by HOUR(waktu),DAY(waktu),MONTH(waktu),YEAR(waktu) order by waktu asc;");
      					
			if($sensor == 'debit'){
				$query_datasheet=$this->db->query('select * from datasheet_debit where idlogger="'.$this->session->userdata('idlogger').'"');
					foreach($query_datasheet->result() as $dtsheet)
					{
						$c=$dtsheet->c;
						$a=$dtsheet->a;
						$b=$dtsheet->b;
					}
					foreach($query_data->result() as $datalog)
					{
						
						$tma=$datalog->$nama_sensor;
						$dta=$c*pow(($tma-$a),$b);
						$tmamin=$datalog->min;
						$dtamin=$c*pow(($tmamin-$a),$b);
						$tmamax=$datalog->max;
						$dtamax=$c*pow(($tmamax-$a),$b);
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dta,2)."]";
						$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
					}
					}
				
				else{
							foreach($query_data->result() as $datalog)
							{
								//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
								$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($datalog->$nama_sensor,3) ."]";
								$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),". $datalog->min.",". $datalog->max ."]";

							}
					}
	
		
		$dataAnalisa=array(
				'idLogger' =>$this->session->userdata('idlogger'),
				'namaSensor' =>$nama_sensor,
				'satuan'=>$satuan,
				'tipe_grafik'=>$this->session->userdata('tipe_grafik'),
				'data'=>$data,
				'nosensor'=>$sensor,
				'range'=>$range,
				'tooltip'=>"Waktu %d-%m-%Y %H:%M",
				'tooltipper'=>"Waktu %d-%m-%Y %H:%M"				
			);
				$dataparam=json_encode($dataAnalisa);
        		$data['data_sensor']=json_decode($dataparam);
        	}
	

		$data['pilih_pos']=$this->pilihposawlr();
		$data['pilih_parameter']=$this->pilihparameter($this->session->userdata('idlogger'));
		$data['konten']='konten/back/awlr/analisa_awlr';
		$this->load->view('template_admin/site',$data);
		}
		else
		{
		    redirect('login');
		}
}

function livedata()
{
	if($this->session->userdata('logged_in'))
		{
		$data['konten']='konten/back/awlr/analisa_liveawlr';
		$this->load->view('template_admin/site',$data);
		}
		else
		{
		    redirect('login');
		}

}
	
	function editlengkungdebit()
	{
		if($this->session->userdata('logged_in'))
		{
			$logger=$this->session->userdata('idlogger');
				$data=array(
					'a'=>$this->input->post('a'),
					'b'=>$this->input->post('b'),
					'c'=>$this->input->post('c'),
					'tahun'=>$this->input->post('tahun')
					);
			$this->m_awlr->update_lengkungdebit($logger,$data);
			redirect('awlr/analisa');
		}
		else
		{
		    redirect('login');
		}
		
	}
	
	function editsiaga()
	{
		if($this->session->userdata('logged_in'))
		{
			$logger=$this->session->userdata('idlogger');
				$data=array(
					'siaga2'=>$this->input->post('waspada'),
					'siaga1'=>$this->input->post('siaga')
					);
			$this->m_awlr->update_siaga($logger,$data);
			redirect('awlr/analisa');
		}
		else
		{
		    redirect('login');
		}
		
	}
	



}
