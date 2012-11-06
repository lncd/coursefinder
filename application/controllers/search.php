<?php

class Search extends CI_Controller {

	public function index()
	{	
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}

	public function keyword()
	{
		$search_term = $this->input->get('q');
		$this->load->model('keyword_model');
		
		$results = $this->keyword_model->get_like_keywords_json($search_term);
		
		echo $results;
	}

	public function results()
	{
		$this->load->model('keyword_model');
		$this->load->model('jacs_model');
		$this->load->model('courses_model');

		$results = array();

		//Explode keywords
		$keywords = explode(',', $this->input->post('keywords'));

		//Count items
		$count_studied = count($this->input->post('studied'));
		$count_interested = count($this->input->post('interested'));
		$count_keywords = count($keywords);

		//Construct search object
		$s = new Search_instance;
		$s->search_time = time();
		$s->parameter_count = $count_studied + $count_interested + $count_keywords;
		$s->save();

		//Save current search instance, for tracking click throughs and recommends etc.
		$this->session->set_userdata(array('search_id' => $s->id));

		if($this->input->post('studied'))
		{
			foreach($this->input->post('studied') as $studied)
			{
				//Save search parameters
				$ss = new Search_studied;
				$ss->search_id = $s->id;
				$ss->jacs_code_id = $studied;
				$ss->save();

				//Get courses by JACS code
				$results[] = $this->jacs_model->get_course_ids_by_jacs_code($studied);
			}
		}

		if($this->input->post('interested'))
		{
			foreach($this->input->post('interested') as $interested)
			{
				//Save search parameters
				$si = new Search_interest;
				$si->search_id = $s->id;
				$si->jacs_code_id = $interested;
				$si->save();

				//Get courses by JACS code
				$results[] = $this->jacs_model->get_course_ids_by_jacs_code($interested);
			}
		}

		if($this->input->post('keywords') !== '')
		{
			foreach($keywords as $keyword)
			{
				//Save search parameters
				$sk = new Search_keyword;
				$sk->search_id = $s->id;
				$sk->keyword_id = $keyword;
				$sk->save();

				$results[] = $this->keyword_model->get_course_ids_by_keyword($keyword, 0.5);
			}
		}

		$data['course_data'] = $this->courses_model->get_course_overviews($this->keyword_model->prioritise_results($results));

		$this->load->view('header');
		$this->load->view('results', $data);
		$this->load->view('footer');
	}

	function test()
	{
		$results = json_decode(file_get_contents($_SERVER['CF_N2_ENDPOINT'] . 'programmes/course_code/' . 64));
		echo '<pre>';
		print_r($results->result);
		echo '</pre>';
	}
}
