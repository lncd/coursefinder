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
}

// End of file home.php
// Location: ./controllers/home.php