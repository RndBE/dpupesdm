
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Informasi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_setting');
		if(!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
			$data2 = array();
			$data['awlr_stts'] = $data2;
			$kb = $this->db->join('t_logger','t_alamat.id_logger=t_logger.code_logger')->join('t_lokasi','t_lokasi.id_lokasi = t_logger.lokasi_id')->get('t_alamat')->result_array();
			
			$s = [];
			foreach($kb as $key=>$val){
				$s[$val['kabupaten']][] = $val;
			}
			$data['kab'] = $s;
			$data['konten'] = "konten/back/v_setting";
			$this->load->view('template_admin/site', $data);
        } else {
            redirect('login');
        }
    }
	
	  public function index2()
    {
        if ($this->session->userdata('logged_in')) {
			$data2 = array();
			$data['awlr_stts'] = $data2;
			$kb = $this->db->join('t_logger','t_alamat.id_logger=t_logger.code_logger')->join('t_lokasi','t_lokasi.id_lokasi = t_logger.lokasi_id')->get('t_alamat')->result_array();
			
			$s = [];
			foreach($kb as $key=>$val){
				$s[$val['kabupaten']][] = $val;
			}
			$data['kab'] = $s;
			$data['konten'] = "konten/back/v_setting";
			$this->load->view('template_admin/site', $data);
        } else {
            redirect('login');
        }
    }
	 function tes(){
		 $jsonData = json_decode(file_get_contents('https://lolak.monitoring4system.com/welcome'));
		 
	 }
}
