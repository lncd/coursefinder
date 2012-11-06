<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$jacs_codes = json_decode(file_get_contents($_SERVER['CF_N2_ENDPOINT'] . 'jacs_codes?code_like=000'));
		
		$data['codes'] = array();
		foreach($jacs_codes->results as $jacs_code)
		{
			$data['codes'][] = array('id' => $jacs_code->id, 'title' => $jacs_code->title);
		}

		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}
}
