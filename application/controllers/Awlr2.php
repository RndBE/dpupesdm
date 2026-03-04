<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Awlr2 extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('csvimport');
		$this->load->model('m_awlr');
	}

	### Dari Beranda ##########
	function set_sensordash()
	{
		$tabel = $this->input->get('tabel');
		$idparam = $this->input->get('id_param');

		$this->session->set_userdata('id_param', $this->input->get('id_param'));
		$this->session->set_userdata('tabel', $tabel);
		$tgl = date('Y-m-d');
		$this->session->set_userdata('pada', $tgl);
		$this->session->set_userdata('data', 'hari');
		$this->session->set_userdata('tanggal', $tgl);
		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where id_param='" . $idparam . "'");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan,
			);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
			$querylogger = $this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="' . $parameter->logger_id . '";');
			$log = $querylogger->row();
			$lokasilog = $log->nama_lokasi;
			$this->session->set_userdata('namalokasi', $lokasilog);
		}

		redirect('awlr/analisa');
	}

	function set_sensordash2()
	{
		$tabel = $this->input->get('tabel');
		$idparam = $this->input->get('id_param');

		$this->session->set_userdata('id_param', $this->input->get('id_param'));
		$this->session->set_userdata('tabel', $tabel);
		$tgl = date('Y-m-d');
		$this->session->set_userdata('pada', $tgl);
		$this->session->set_userdata('data', 'hari');
		$this->session->set_userdata('tanggal', $tgl);
		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where id_param='" . $idparam . "'");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan,
			);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
			$querylogger = $this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="' . $parameter->logger_id . '";');
			$log = $querylogger->row();
			$lokasilog = $log->nama_lokasi;
			$this->session->set_userdata('namalokasi', $lokasilog);
		}

		redirect('komparasi');
	}
	############################################


	### Dari Analisa ##########
	function set_sensorselect()
	{

		$idlogger = $this->uri->segment(3);
		$tabel = $this->uri->segment(4);
		$this->session->set_userdata('tabel', $tabel);
		$tgl = date('Y-m-d');
		$this->session->set_userdata('pada', $tgl);
		$this->session->set_userdata('data', 'hari');

		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where logger_id='" . $idlogger . "'");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan
			);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
			$querylogger = $this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="' . $parameter->logger_id . '";');
			$log = $querylogger->row();
			$lokasilog = $log->nama_lokasi;
			$this->session->set_userdata('namalokasi', $lokasilog);
		}

		redirect('awlr/analisa');
	}
	############################################

	function set_param()
	{
		$tabel = $this->uri->segment(3);
		$idparam = $this->uri->segment(4);
		$lok = str_replace('_', ' ', $this->uri->segment(5));
		$this->session->set_userdata('namalokasi', $lok);
		$this->session->set_userdata('tabel', $tabel);
		$tgl = date('Y-m-d');
		$this->session->set_userdata('pada', $tgl);
		$this->session->set_userdata('data', 'hari');
		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where id_param='" . $idparam . "'");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan
			);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
		}
		redirect('awlr/analisa');
	}

	### Set Pos #####
	public function pilihposawlr()
	{
		$data = array();
		$bidang = $this->session->userdata['bidang'];
		if($this->session->userdata('leveluser') == 'admin' or $this->session->userdata('leveluser') == 'user'){
			$q_pos = $this->db->query("SELECT * FROM t_logger INNER JOIN t_lokasi ON t_logger.lokasi_id = t_lokasi.id_lokasi where katlog_id='2'");
		}else{
			$q_pos = $this->db->query("SELECT * FROM t_logger INNER JOIN t_lokasi ON t_logger.lokasi_id = t_lokasi.id_lokasi where katlog_id='2' ");
		}

		foreach ($q_pos->result() as $pos) {
			$data[] = array(
				'idLogger' => $pos->id_logger, 'namaPos' => $pos->nama_lokasi
			);
		}

		$data_pos = json_encode($data);
		return json_decode($data_pos);
	}

	public function pilihposarr()
	{
		$data = array();
		$bidang = $this->session->userdata['bidang'];
		if($this->session->userdata('leveluser') == 'admin' or $this->session->userdata('leveluser') == 'user'){
			$q_pos = $this->db->query("SELECT * FROM t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger = t_lokasi.idlokasi where kategori_log='1'");
		}else{
			$q_pos = $this->db->query("SELECT * FROM t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger = t_lokasi.idlokasi where kategori_log='1' AND t_logger.bidang='$bidang'");
		}

		foreach ($q_pos->result() as $pos) {
			$data[] = array(
				'idLogger' => $pos->id_logger, 'namaPos' => $pos->nama_lokasi
			);
		}

		$data_pos = json_encode($data);
		return json_decode($data_pos);
	}

	function set_pos()
	{
		$idlog = $this->input->post('pilihpos');
		$querylogger = $this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="' . $idlog . '";');
		$log = $querylogger->row();
		$lokasilog = $log->nama_lokasi;
		$id_logger = $log->id_logger;
		$this->session->set_userdata('namalokasi', $lokasilog);
		$this->session->set_userdata('id_logger', $id_logger);

		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where logger_id='" . $idlog . "' order by id_param limit 1");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan
			);
			$this->session->set_userdata('id_param', $parameter->id_param);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
		}

		redirect('awlr/analisa');
	}

	function set_pos2()
	{
		$idlog = $this->input->post('pilihpos');
		$querylogger = $this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="' . $idlog . '";');
		$log = $querylogger->row();
		$lokasilog = $log->nama_lokasi;
		$id_logger = $log->id_logger;
		$this->session->set_userdata('namalokasi', $lokasilog);
		$this->session->set_userdata('id_logger', $id_logger);

		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where logger_id='" . $idlog . "' order by id_param limit 1");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan
			);
			$this->session->set_userdata('id_param', $parameter->id_param);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
		}

		redirect('komparasi');
	}

	function set_pos3()
	{
		$idlog = $this->input->post('pilihpos2');
		$querylogger = $this->db->query('select * from t_logger INNER JOIN t_lokasi ON t_logger.lokasi_logger=t_lokasi.idlokasi where id_logger="' . $idlog . '";');
		$log = $querylogger->row();
		$lokasilog = $log->nama_lokasi;
		$id_logger = $log->id_logger;
		$this->session->set_userdata('namalokasi2', $lokasilog);
		$this->session->set_userdata('id_logger2', $id_logger);

		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where logger_id='" . $idlog . "' order by id_param limit 1");
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger2' => $parameter->logger_id,
				'idparameter2' => $parameter->id_param,
				'nama_parameter2' => $parameter->nama_parameter,
				'kolom2' => $parameter->kolom_sensor,
				'satuan2' => $parameter->satuan,
				'tipe_grafik2' => $parameter->tipe_graf,
				'kolom_acuan2' => $parameter->kolom_acuan
			);
			$this->session->set_userdata('id_param2', $parameter->id_param);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
		}

		redirect('komparasi');
	}
	##### set Parameter #####
	public function pilihparameter($idlogger)
	{
		$data = array();
		$q_parameter = $this->db->query("SELECT * FROM t_sensor where logger_code='" . $idlogger . "'");
		foreach ($q_parameter->result() as $param) {
			$data[] = array(
				'idParameter' => $param->id, 'namaParameter' => $param->alias_sensor, 'fieldParameter' => $param->field_sensor
			);
		}

		$data_param = json_encode($data);
		return json_decode($data_param);
	}

	function set_parameter()
	{
		$q_parameter = $this->db->query("SELECT * FROM parameter_sensor where id_param='" . $this->input->post('mnsensor') . "'");
		$this->session->set_userdata('id_param', $this->input->post('mnsensor'));
		if ($q_parameter->num_rows() > 0) {
			$parameter = $q_parameter->row();
			//data hasil seleksi dimasukkan ke dalam $session
			$session = array(
				'idlogger' => $parameter->logger_id,
				'idparameter' => $parameter->id_param,
				'nama_parameter' => $parameter->nama_parameter,
				'kolom' => $parameter->kolom_sensor,
				'satuan' => $parameter->satuan,
				'tipe_grafik' => $parameter->tipe_graf,
				'kolom_acuan' => $parameter->kolom_acuan
			);
			//data dari $session akhirnya dimasukkan ke dalam session
			$this->session->set_userdata($session);
		}
		redirect('awlr/analisa');
	}


	function sesi_data()
	{
		if ($this->input->post('data') == 'hari') {
			$tgl = date('Y-m-d');
			$this->session->set_userdata('pada', $tgl);
		} elseif ($this->input->post('data') == 'bulan') {
			$tgl = date('Y-m');
			$this->session->set_userdata('bulan', $tgl);
			$this->session->set_userdata('pada', $tgl);
		} elseif ($this->input->post('data') == 'tahun') {
			$tgl = date('Y');
			$this->session->set_userdata('tahun', $tgl);
			$this->session->set_userdata('pada', $tgl);
		} elseif ($this->input->post('data') == 'range') {
			$dari = date('Y-m-d H:i', (mktime(date('H'), 0, 0, date('m'), date('d') - 1, date('Y'))));

			$sampai = date('Y-m-d H:i', (mktime(date('H'), 0, 0, date('m'), date('d'), date('Y'))));

			$this->session->set_userdata('dari', $dari);
			$this->session->set_userdata('sampai', $sampai);
		}
		$this->session->set_userdata('data', $this->input->post('data'));
		redirect('awlr/analisa');
	}

	function settgl()
	{
		$tgl = str_replace('/', '-', $this->input->post('tgl'));
		$this->session->set_userdata('tanggal', $tgl);
		$this->session->set_userdata('pada', $tgl);
		redirect('awlr/analisa');
	}
	
	function settgl2()
	{
		$tgl = str_replace('/', '-', $this->input->post('tgl'));
		$this->session->set_userdata('tanggal', $tgl);
		$this->session->set_userdata('pada', $tgl);
		redirect('komparasi');
	}

	function setbulan()
	{
		$tgl = str_replace('/', '-', $this->input->post('bulan'));
		$this->session->set_userdata('bulan', $tgl);
		$this->session->set_userdata('pada', $tgl);
		redirect('awlr/analisa');
	}

	function settahun()
	{
		$tgl = str_replace('/', '-', $this->input->post('tahun'));
		$this->session->set_userdata('tahun', $tgl);
		$this->session->set_userdata('pada', $tgl);
		redirect('awlr/analisa');
	}

	function setrange()
	{
		$this->session->set_userdata('dari', $this->input->post('dari'));
		$this->session->set_userdata('sampai', $this->input->post('sampai'));
		redirect('awlr/analisa');
	}

	
	function analisa()
	{

		if ($this->session->userdata('logged_in')) {
			$data = array();
			$data_tabel = array();
			$min = array();
			$max = array();
			$range = array();
			####################################################################################### HARI ##################
			if ($this->session->userdata('data') == 'hari') {
				$sensor = $this->session->userdata('kolom');
				$nama_sensor = "Rerata_" . $this->session->userdata('nama_parameter');
				if ($sensor == 'debit') {
					$kolom = $this->session->userdata('kolom_acuan');
				} else {
					$kolom = $this->session->userdata('kolom');
				}
				$select = 'avg(' . $kolom . ') as ' . $nama_sensor;
				$satuan = $this->session->userdata('satuan');
				echo "SELECT waktu, HOUR(waktu) as jam,DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun," . $select . ",min(" . $kolom . ") as min,max(" . $kolom . ") as max FROM " . $this->session->userdata('tabel') . "  USE INDEX (waktu) where code_logger='" . $this->session->userdata('idlogger') . "' and waktu >= '" . $this->session->userdata('pada') . " 00:00' and waktu <= '" . $this->session->userdata('pada') . " 23:59' group by HOUR(waktu),DAY(waktu),MONTH(waktu),YEAR(waktu) order by waktu asc;";
				exit;
				$query_data = $this->db->query("SELECT waktu, HOUR(waktu) as jam,DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun," . $select . ",min(" . $kolom . ") as min,max(" . $kolom . ") as max FROM " . $this->session->userdata('tabel') . "  USE INDEX (waktu) where code_logger='" . $this->session->userdata('idlogger') . "' and waktu >= '" . $this->session->userdata('pada') . " 00:00' and waktu <= '" . $this->session->userdata('pada') . " 23:59' group by HOUR(waktu),DAY(waktu),MONTH(waktu),YEAR(waktu) order by waktu asc;")->result_array();
				echo json_encode($query_data);
				exit;
				if ($sensor == 'debit') {
					$rumus = $this->db->where('idlogger', $this->session->userdata('idlogger'))->where('tanggal_berlaku <=', date('Y-m-d'))->limit(1)->order_by('tanggal_berlaku', 'desc')->get('rumus_debit')->row();
					$jenis_rumus = '0';
					$a = 0;
					$b = 0;
					$c = 0;
					if ($rumus->tanggal_berlaku <= $this->session->userdata('pada')) {
						$rumus_dbt = json_decode($rumus->parameter_rumus);
						$c = $rumus_dbt->C;
						if ($rumus->jenis_rumus == 'type01') {
							$a = $rumus_dbt->A;
						}
						$b = $rumus_dbt->B;
						$jenis_rumus = $rumus->jenis_rumus;
						foreach ($query_data->result() as $datalog) {
						$tma = $datalog->$nama_sensor;
						if ($jenis_rumus == 'type01') {
							$dta = $c * pow(($tma - $a), $b);
							$tmamin = $datalog->min;
							$dtamin = $c * pow(($tmamin - $a), $b);
							$tmamax = $datalog->max;
							$dtamax = $c * pow(($tmamax - $a), $b);
						} elseif ($jenis_rumus == 'type02') {
							$dta = $c * $b * pow(($tma), 1.5);
							$tmamin = $datalog->min;
							$dtamin = $c * $b * pow(($tmamin), 1.5);
							$tmamax = $datalog->max;
							$dtamax = $c * $b * pow(($tmamax), 1.5);
						} else {
							$dta = 0;
							$dtamin = 0;
							$dtamax = 0;
						}
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . "," . $datalog->jam . ")," . number_format($dta, 2) . "]";
						$data_tabel[] = array(
							'waktu' => date('Y-m-d H',strtotime($datalog->waktu)) .':00:00',
							'dta' => number_format($dta, 2),
							'min' => number_format($dtamin, 2),
							'max' => number_format($dtamax, 2)
						);
						$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . "," . $datalog->jam . ")," . number_format($dtamin, 2) . "," . number_format($dtamax, 2) . "]";
					}
					}
					
				} else {
					foreach ($query_data->result() as $datalog) {
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . "," . $datalog->jam . ")," . number_format($datalog->$nama_sensor, 3) . "]";
						$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . "," . $datalog->jam . ")," . $datalog->min . "," . $datalog->max . "]";
						$data_tabel[] = array(
							'waktu' => date('Y-m-d H',strtotime($datalog->waktu)) .':00:00',
							'dta' => number_format($datalog->$nama_sensor, 2),
							'min' => number_format($datalog->min, 2),
							'max' => number_format($datalog->max, 2)
						);
					}
				}

				$dataAnalisa = array(
					'idLogger' => $this->session->userdata('idlogger'),
					'namaSensor' => $nama_sensor,
					'satuan' => $satuan,
					'tipe_grafik' => $this->session->userdata('tipe_grafik'),
					'data' => $data,
					'data_tabel' => $data_tabel,
					'nosensor' => $kolom,
					'range' => $range,
					'tooltip' => "Waktu %d-%m-%Y %H:%M"
				);
				$dataparam = json_encode($dataAnalisa);
				$data['data_sensor'] = json_decode($dataparam);
			}
			####################################################################################### BULAN ##################
			elseif ($this->session->userdata('data') == 'bulan') {
				$sensor = $this->session->userdata('kolom');
				$nama_sensor = "Rerata_" . $this->session->userdata('nama_parameter');
				if ($sensor == 'debit') {
					$kolom = $this->session->userdata('kolom_acuan');
				} else {
					$kolom = $this->session->userdata('kolom');
				}
				$select = 'avg(' . $kolom . ') as ' . $nama_sensor;
				$satuan = $this->session->userdata('satuan');
				$query_data = $this->db->query("SELECT waktu, DATE(waktu) as tanggal, DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun," . $select . ",min(" . $kolom . ") as min,max(" . $kolom . ") as max FROM " . $this->session->userdata('tabel') . " where code_logger='" . $this->session->userdata('idlogger') . "' and waktu like '" . $this->session->userdata('pada') . "%' group by DAY(waktu),MONTH(waktu),YEAR(waktu)  order by waktu asc;");
				if ($sensor == 'debit') {
					$rumus_now = $this->db->where('idlogger', $this->session->userdata('idlogger'))->order_by('tanggal_berlaku', 'asc')->get('rumus_debit')->result_array();

					foreach ($query_data->result() as $k => $datalog) {
						$tma = $datalog->$nama_sensor;
						if ($rumus_now) {
							$co = count($rumus_now) - 1;

							for ($x = 0; $x <= $co; $x++) {
								if($datalog->tanggal < $rumus_now[$x]['tanggal_berlaku']){
									$dta = 0;
									$dtamin = 0;
									$dtamax = 0;
									$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($dta, 2) . "]";
									$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($dtamin, 2) . "," . number_format($dtamax, 2) . "]";
									$data_tabel[] = array(
										'waktu' => $datalog->tahun .'-' . $datalog->bulan . '-' . $datalog->hari,
										'dta' => number_format($dta, 2),
										'min' => number_format($dtamin, 2),
										'max' => number_format($dtamax, 2)
									);
								}
								if ($x != $co) {
									$x2 = $x + 1;

									if ($datalog->tanggal >= $rumus_now[$x]['tanggal_berlaku'] and $datalog->tanggal < $rumus_now[$x2]['tanggal_berlaku']) {
										$rum = json_decode($rumus_now[$x]['parameter_rumus']);
										$c = $rum->C;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$a = $rum->A;
										}
										$b = $rum->B;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$dta = $c * pow(($tma - $a), $b);
											$tmamin = $datalog->min;
											$dtamin = $c * pow(($tmamin - $a), $b);
											$tmamax = $datalog->max;
											$dtamax = $c * pow(($tmamax - $a), $b);
										} elseif ($rumus_now[$x]['jenis_rumus'] == 'type02') {
											$dta = $c * $b * pow(($tma), 1.5);
											$tmamin = $datalog->min;
											$dtamin = $c * $b * pow(($tmamin), 1.5);
											$tmamax = $datalog->max;
											$dtamax = $c * $b * pow(($tmamax), 1.5);
										} else {
											$dta = 0;
											$dtamin = 0;
											$dtamax = 0;
										}
										$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($dta, 2) . "]";
										$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($dtamin, 2) . "," . number_format($dtamax, 2) . "]";
										$data_tabel[] = array(
											'waktu' => date('Y-m-d',strtotime($datalog->waktu)) ,
											'dta' => number_format($dta, 2),
											'min' => number_format($dtamin, 2),
											'max' => number_format($dtamax, 2)
										);
									}
								} else {
									if ($datalog->tanggal >= $rumus_now[$x]['tanggal_berlaku']) {
										$rum = json_decode($rumus_now[$x]['parameter_rumus']);
										$c = $rum->C;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$a = $rum->A;
										}
										$b = $rum->B;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$dta = $c * pow(($tma - $a), $b);
											$tmamin = $datalog->min;
											$dtamin = $c * pow(($tmamin - $a), $b);
											$tmamax = $datalog->max;
											$dtamax = $c * pow(($tmamax - $a), $b);
										} elseif ($rumus_now[$x]['jenis_rumus'] == 'type02') {
											$dta = $c * $b * pow(($tma), 1.5);
											$tmamin = $datalog->min;
											$dtamin = $c * $b * pow(($tmamin), 1.5);
											$tmamax = $datalog->max;
											$dtamax = $c * $b * pow(($tmamax), 1.5);
										} else {
											$dta = 0;
											$dtamin = 0;
											$dtamax = 0;
										}
										$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($dta, 2) . "]";
										$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($dtamin, 2) . "," . number_format($dtamax, 2) . "]";
										$data_tabel[] = array(
											'waktu' => date('Y-m-d',strtotime($datalog->waktu)) ,
											'dta' => number_format($dta, 2),
											'min' => number_format($dtamin, 2),
											'max' => number_format($dtamax, 2)
										);
									}
								}
							}
						}
					}
					//echo json_encode($v);

				} else {
					foreach ($query_data->result() as $datalog) {
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . number_format($datalog->$nama_sensor, 3) . "]";
						$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1," . $datalog->hari . ")," . $datalog->min . "," . $datalog->max . "]";
						$data_tabel[] = array(
							'waktu' => date('Y-m-d',strtotime($datalog->waktu)) ,
							'dta' => number_format($datalog->$nama_sensor, 2),
							'min' => number_format($datalog->min, 2),
							'max' => number_format($datalog->max, 2)
						);
					}
				}


				$dataAnalisa = array(
					'idLogger' => $this->session->userdata('idlogger'),
					'namaSensor' => $nama_sensor,
					'satuan' => $satuan,
					'tipe_grafik' => $this->session->userdata('tipe_grafik'),
					'data' => $data,
					'data_tabel' => $data_tabel,
					'nosensor' => $sensor,
					'range' => $range,
					'tooltip' => "Tanggal %d-%m-%Y"
				);
				$dataparam = json_encode($dataAnalisa);
				$data['data_sensor'] = json_decode($dataparam);
			}
			####################################################################################### TAHUN ##################
			elseif ($this->session->userdata('data') == 'tahun') {


				$sensor = $this->session->userdata('kolom');
				$nama_sensor = "Rerata_" . $this->session->userdata('nama_parameter');
				if ($sensor == 'debit') {
					$kolom = $this->session->userdata('kolom_acuan');
				} else {
					$kolom = $this->session->userdata('kolom');
				}
				$select = 'avg(' . $kolom . ') as ' . $nama_sensor;
				$satuan = $this->session->userdata('satuan');

				$query_data = $this->db->query("SELECT DATE(waktu) as tanggal, DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun," . $select . ",min(" . $kolom . ") as min,max(" . $kolom . ") as max FROM " . $this->session->userdata('tabel') . " where code_logger='" . $this->session->userdata('idlogger') . "' and waktu like '" . $this->session->userdata('pada') . "%' group by MONTH(waktu),YEAR(waktu)  order by waktu asc;");
				$dbt = 0;
				if ($sensor == 'debit') {
					
					$rumus_now = $this->db->where('idlogger', $this->session->userdata('idlogger'))->order_by('tanggal_berlaku', 'asc')->get('rumus_debit')->result_array();
					$data2 = array();
					foreach ($query_data->result() as $k => $datalog) {
						$tma = $datalog->$nama_sensor;
						if ($rumus_now) {
							$co = count($rumus_now) - 1;
							$mods    = array();
							for ($x = 0; $x <= $co; $x++) {
								if ($x != $co) {
									$x2 = $x + 1;

									if ($datalog->tanggal >= $rumus_now[$x]['tanggal_berlaku'] and $datalog->tanggal < $rumus_now[$x2]['tanggal_berlaku']) {
										$rum = json_decode($rumus_now[$x]['parameter_rumus']);
										$c = $rum->C;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$a = $rum->A;
										}
										$b = $rum->B;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$dta = $c * pow(($tma - $a), $b);
											$tmamin = $datalog->min;
											$dtamin = $c * pow(($tmamin - $a), $b);
											$tmamax = $datalog->max;
											$dtamax = $c * pow(($tmamax - $a), $b);
										} elseif ($rumus_now[$x]['jenis_rumus'] == 'type02') {
											$dta = $c * $b * pow(($tma), 1.5);
											$tmamin = $datalog->min;
											$dtamin = $c * $b * pow(($tmamin), 1.5);
											$tmamax = $datalog->max;
											$dtamax = $c * $b * pow(($tmamax), 1.5);
										} else {
											$dta = 0;
											$dtamin = 0;
											$dtamax = 0;
										}
										$dta_avg[] = array(
											'bulan'=> $datalog->bulan,
											'debit'=> $dta
										);
										$dta_min[] = array(
											'bulan'=> $datalog->bulan,
											'debit'=> $dtamin
										);
										$dta_max[] = array(
											'bulan'=> $datalog->bulan,
											'debit'=> $dtamax
										);
									}
								} else {
									if ($datalog->tanggal >= $rumus_now[$x]['tanggal_berlaku']) {
										$rum = json_decode($rumus_now[$x]['parameter_rumus']);
										$c = $rum->C;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$a = $rum->A;
										}
										$b = $rum->B;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$dta = $c * pow(($tma - $a), $b);
											$tmamin = $datalog->min;
											$dtamin = $c * pow(($tmamin - $a), $b);
											$tmamax = $datalog->max;
											$dtamax = $c * pow(($tmamax - $a), $b);
										} elseif ($rumus_now[$x]['jenis_rumus'] == 'type02') {
											$dta = $c * $b * pow(($tma), 1.5);
											$tmamin = $datalog->min;
											$dtamin = $c * $b * pow(($tmamin), 1.5);
											$tmamax = $datalog->max;
											$dtamax = $c * $b * pow(($tmamax), 1.5);
										} else {
											$dta = 0;
											$dtamin = 0;
											$dtamax = 0;
										}
										$dta_avg[] = array(
											'bulan'=> $datalog->bulan,
											'debit'=> $dta
										);
										$dta_min[] = array(
											'bulan'=> $datalog->bulan,
											'debit'=> $dtamin
										);
										$dta_max[] = array(
											'bulan'=> $datalog->bulan,
											'debit'=> $dtamax
										);
									}
								}

							}
						}else{
							$dbt=1;
						}
					}
					if($dbt == 0){
						$avg = array();
						$min = array();
						$max = array();
						foreach($dta_avg as $field) {
							$avg[$field['bulan']][] = $field['debit'];
						}
						foreach($dta_min as $field) {
							$min[$field['bulan']][] = $field['debit'];
						}
						foreach($dta_max as $field) {
							$max[$field['bulan']][] = $field['debit'];
						}
						foreach($avg as $name => $mod) {
							$m = array_sum($mod) / count($mod);
							$n = array_sum($min[$name]) / count($min[$name]);
							$l = array_sum($max[$name]) / count($max[$name]);

							$data[]= "[ Date.UTC(".$this->session->userdata('pada').",".$name."-1),".number_format($m,2)."]";
							$range[] ="[ Date.UTC(".$this->session->userdata('pada').",".$name."-1),".number_format($n,2).",". number_format($l,2) ."]";
							$data_tabel[] = array(
								'waktu' => $this->session->userdata('pada').'-'.$name,
								'dta' => number_format($m, 2),
								'min' => number_format($n, 2),
								'max' => number_format($l, 2)
							);
						}
					}
					
				} else {
					$query_data = $this->db->query("SELECT waktu, MONTH(waktu) as bulan,YEAR(waktu) as tahun,".$select.",min(".$kolom.") as min,max(".$kolom.") as max FROM ".$this->session->userdata('tabel')." where code_logger='".$this->session->userdata('idlogger')."' and waktu like '".$this->session->userdata('pada')."%' group by MONTH(waktu),YEAR(waktu)  order by waktu asc;");
					foreach ($query_data->result() as $datalog) {
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1)," . number_format($datalog->$nama_sensor, 3) . "]";
						$range[] = "[ Date.UTC(" . $datalog->tahun . "," . $datalog->bulan . "-1)," . $datalog->min . "," . $datalog->max . "]";
						$data_tabel[] = array(
							'waktu' => date('Y-m',strtotime($datalog->waktu)) ,
							'dta' => number_format(number_format($datalog->$nama_sensor, 3), 2),
							'min' => number_format($datalog->min, 2),
							'max' => number_format($datalog->max, 2)
						);
					}
				}

				$dataAnalisa = array(
					'idLogger' => $this->session->userdata('idlogger'),
					'namaSensor' => $nama_sensor,
					'satuan' => $satuan,
					'tipe_grafik' => $this->session->userdata('tipe_grafik'),
					'data' => $data,
					'data_tabel' => $data_tabel,
					'nosensor' => $sensor,
					'range' => $range,
					'tooltip' => "Tanggal %d-%m-%Y"
				);
				$dataparam = json_encode($dataAnalisa);
				$data['data_sensor'] = json_decode($dataparam);
			}
			####################################################################################### RANGE ##################
			elseif ($this->session->userdata('data') == 'range') {

				$sensor = $this->session->userdata('kolom');
				$nama_sensor = "Rerata_" . $this->session->userdata('nama_parameter');
				if ($sensor == 'debit') {
					$kolom = $this->session->userdata('kolom_acuan');
				} else {
					$kolom = $this->session->userdata('kolom');
				}
				$select = 'avg(' . $kolom . ') as ' . $nama_sensor;
				$satuan = $this->session->userdata('satuan');

				$query_data = $this->db->query("SELECT waktu,DATE(waktu) as tanggal, HOUR(waktu) as jam,DAY(waktu) as hari,MONTH(waktu) as bulan,YEAR(waktu) as tahun," . $select . ",min(" . $kolom . ") as min,max(" . $kolom . ") as max FROM " . $this->session->userdata('tabel') . " where code_logger='" . $this->session->userdata('idlogger') . "' and waktu >='" . $this->session->userdata('dari') . "' and waktu <='" . $this->session->userdata('sampai') . "' group by HOUR(waktu),DAY(waktu),MONTH(waktu),YEAR(waktu) order by waktu asc;");

				if ($sensor == 'debit') {
					$rumus_now = $this->db->where('idlogger', $this->session->userdata('idlogger'))->order_by('tanggal_berlaku', 'asc')->get('rumus_debit')->result_array();

					foreach ($query_data->result() as $k => $datalog) {
						$tma = $datalog->$nama_sensor;
						if ($rumus_now['tanggal_berlaku'] <= $this->session->userdata('pada')) {
							$co = count($rumus_now) - 1;

							for ($x = 0; $x <= $co; $x++) {
								if($datalog->tanggal < $rumus_now[$x]['tanggal_berlaku']){
									$dta = 0;
									$dtamin = 0;
									$dtamax = 0;
									$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dta,2)."]";
									$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
								}
								if ($x != $co) {
									$x2 = $x + 1;

									if ($datalog->tanggal >= $rumus_now[$x]['tanggal_berlaku'] and $datalog->tanggal < $rumus_now[$x2]['tanggal_berlaku']) {
										$rum = json_decode($rumus_now[$x]['parameter_rumus']);
										$c = $rum->C;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$a = $rum->A;
										}
										$b = $rum->B;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$dta = $c * pow(($tma - $a), $b);
											$tmamin = $datalog->min;
											$dtamin = $c * pow(($tmamin - $a), $b);
											$tmamax = $datalog->max;
											$dtamax = $c * pow(($tmamax - $a), $b);
										} elseif ($rumus_now[$x]['jenis_rumus'] == 'type02') {
											$dta = $c * $b * pow(($tma), 1.5);
											$tmamin = $datalog->min;
											$dtamin = $c * $b * pow(($tmamin), 1.5);
											$tmamax = $datalog->max;
											$dtamax = $c * $b * pow(($tmamax), 1.5);
										} else {
											$dta = 0;
											$dtamin = 0;
											$dtamax = 0;
										}
										$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dta,2)."]";
										$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
										$data_tabel[] = array(
											'waktu' => $datalog->waktu,
											'dta' => number_format($dta, 2),
											'min' => number_format($dtamin, 2),
											'max' => number_format($dtamax, 2)
										);
									}
								} else {
									if ($datalog->tanggal >= $rumus_now[$x]['tanggal_berlaku']) {
										$rum = json_decode($rumus_now[$x]['parameter_rumus']);
										$c = $rum->C;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$a = $rum->A;
										}
										$b = $rum->B;
										if ($rumus_now[$x]['jenis_rumus'] == 'type01') {
											$dta = $c * pow(($tma - $a), $b);
											$tmamin = $datalog->min;
											$dtamin = $c * pow(($tmamin - $a), $b);
											$tmamax = $datalog->max;
											$dtamax = $c * pow(($tmamax - $a), $b);
										} elseif ($rumus_now[$x]['jenis_rumus'] == 'type02') {
											$dta = $c * $b * pow(($tma), 1.5);
											$tmamin = $datalog->min;
											$dtamin = $c * $b * pow(($tmamin), 1.5);
											$tmamax = $datalog->max;
											$dtamax = $c * $b * pow(($tmamax), 1.5);
										} else {
											$dta = 0;
											$dtamin = 0;
											$dtamax = 0;
										}
										$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dta,2)."]";
										$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($dtamin,2).",". number_format($dtamax,2) ."]";
										$data_tabel[] = array(
											'waktu' => date('Y-m-d H',strtotime($datalog->waktu)). ':00:00' ,
											'dta' => number_format($dta, 2),
											'min' => number_format($dtamin, 2),
											'max' => number_format($dtamax, 2)
										);
									}
								}
							}
						}
					}
				} else {
					foreach ($query_data->result() as $datalog) {
						//$waktu[]= date('Y-m-d H',strtotime($datalog->waktu)).":00";
						$data[]= "[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),".number_format($datalog->$nama_sensor,3) ."]";
						$range[] ="[ Date.UTC(".$datalog->tahun.",".$datalog->bulan."-1,".$datalog->hari.",".$datalog->jam."),". $datalog->min.",". $datalog->max ."]";
						$data_tabel[] = array(
							'waktu' => date('Y-m-d H',strtotime($datalog->waktu)) .':00:00' ,
							'dta' => number_format($datalog->$nama_sensor, 3),
							'min' => number_format($datalog->min, 2),
							'max' => number_format($datalog->max, 2)
						);
					}
				}


				$dataAnalisa = array(
					'idLogger' => $this->session->userdata('idlogger'),
					'namaSensor' => $nama_sensor,
					'satuan' => $satuan,
					'tipe_grafik' => $this->session->userdata('tipe_grafik'),
					'data' => $data,
					'data_tabel' => $data_tabel,
					'nosensor' => $sensor,
					'range' => $range,
					'tooltip' => "Waktu %d-%m-%Y %H:%M",
					'tooltipper' => "Waktu %d-%m-%Y %H:%M"
				);
				$dataparam = json_encode($dataAnalisa);
				$data['data_sensor'] = json_decode($dataparam);
			}

			$data['pilih_pos'] = $this->pilihposawlr();
			$data['pilih_parameter'] = $this->pilihparameter($this->session->userdata('idlogger'));
			$data['konten'] = 'konten/back/awlr/analisa_awlr';
			$this->load->view('template_admin/site', $data);
		} else {
			redirect('login');
		}
	}
	
	

	function livedata()
	{
		if ($this->session->userdata('logged_in')) {
			$data['konten'] = 'konten/back/awlr/analisa_liveawlr';
			$this->load->view('template_admin/site', $data);
		} else {
			redirect('login');
		}
	}

	function editlengkungdebit()
	{
		if ($this->session->userdata('logged_in')) {
			$logger = $this->session->userdata('idlogger');
			$data = array(
				'a' => $this->input->post('a'),
				'b' => $this->input->post('b'),
				'c' => $this->input->post('c'),
				'tahun' => $this->input->post('tahun')
			);
			$this->m_awlr->update_lengkungdebit($logger, $data);
			redirect('awlr/analisa');
		} else {
			redirect('login');
		}
	}

	function editsiaga()
	{
		if ($this->session->userdata('logged_in')) {
			$logger = $this->session->userdata('idlogger');
			$data = array(
				'siaga2' => $this->input->post('waspada'),
				'siaga1' => $this->input->post('siaga')
			);
			$this->m_awlr->update_siaga($logger, $data);
			redirect('awlr/analisa');
		} else {
			redirect('login');
		}
	}
}
