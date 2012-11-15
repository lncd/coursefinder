<?php
/**
* Search
*
* PHP Version 5
* 
* @category  Course_Finder
* @package   Course_Finder
* @author    Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @copyright 2012 University of Lincoln
* @license   GNU Affero General Public License 3.0
* @link      coursedata.blogs.lincoln.ac.uk
*/

/**
* Search
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Search extends CI_Controller {

	/**
	* Default function for controller. 
	*
	* @return Nothing
	* @access Public
	*/
	public function index()
	{	
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}

	/**
	* Get keywords
	*
	* @return Nothing
	* @access Public
	*/
	public function keyword()
	{
		$search_term = $this->input->get('q');
		$this->load->model('keyword_model');
		
		$results = $this->keyword_model->get_like_keywords_json($search_term);
		
		echo $results;
	}

	/**
	* Orchestrates a search and shows results
	*
	* @return Nothing
	* @access Public
	*/
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
		$search_instance = new Search_instance;
		$search_instance->search_time = time();
		$search_instance->parameter_count = $count_studied + $count_interested + $count_keywords;
		$search_instance->save();
		
		//Save current search instance, for tracking click throughs and recommends etc.
		$this->session->set_userdata(array('search_id' => $search_instance->stored->id));

		if($this->input->post('studied'))
		{
			foreach($this->input->post('studied') as $studied)
			{
				//Save search parameters
				$search_studied = new Search_studied;
				$search_studied->jacs_code_id = $studied;
				$search_studied->save($search_instance);

				//Get courses by JACS code
				$results[] = $this->jacs_model->get_course_ids_by_jacs_code($studied);
			}
		}

		if($this->input->post('interested'))
		{
			foreach($this->input->post('interested') as $interested)
			{
				//Save search parameters
				$search_interest = new Search_interest;
				$search_interest->jacs_code_id = $interested;
				$search_interest->save($search_instance);

				//Get courses by JACS code
				$results[] = $this->jacs_model->get_course_ids_by_jacs_code($interested);
			}
		}

		if($this->input->post('keywords') !== '')
		{
			foreach($keywords as $keyword)
			{
				//Save search parameters
				$search_keyword = new Search_keyword;
				$search_keyword->keyword_id = $keyword;
				$search_keyword->save($search_instance);

				$results[] = $this->keyword_model->get_course_ids_by_keyword($keyword, 0.5);
			}
		}

		$data['course_data'] = $this->courses_model->get_course_overviews($this->keyword_model->prioritise_results($results));

		$this->load->view('header');
		$this->load->view('results', $data);
		$this->load->view('footer');
	}
}

// End of file search.php
// Location: ./controllers/search.php