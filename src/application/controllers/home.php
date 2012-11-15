<?php
/**
* Home
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
* Home
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Home extends CI_Controller {

	/**
	* Default function for controller. 
	*
	* @return Nothing
	* @access Public
	*/
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

	public function test()
	{
		$this_search = 146;
		$this_instance = new Search_instance;
		$this_instance->where('id', $this_search)->get();

		$all_instances = new Search_instance;
		$all_instances->where('parameter_count', $this_instance->parameter_count)->get_iterated();

		$this->load->model('search_instance_model');

		foreach($all_instances as $an_instance)
		{
			if($this->search_instance_model->check_parameters_match(146,$an_instance->id) === 1)
			{
				echo 'these match';
			}
		}
	}
}

// End of file home.php
// Location: ./controllers/home.php