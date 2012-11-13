<?php
/**
* Course
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
* Course
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Course extends CI_Controller {

	/**
	* Default function for controller. 
	*
	* @return Nothing
	* @access Public
	*/
	public function index()
	{
		if($this->uri->segment(2))
		{
			$this->load->model('courses_model');

			if($this->session->userdata('search_id'))
			{
				$this->courses_model->add_course_click_through($this->session->userdata('search_id'), $this->uri->segment(2));
			}

			$data['course'] = $this->courses_model->get_course_overview($this->uri->segment(2));
			$data['similar'] = $this->courses_model->get_similar_courses($this->uri->segment(2));
			$this->load->view('header');
			$this->load->view('course', $data);
			$this->load->view('footer');
		}
	}

	/**
	* Processes the 'recommend' action
	*
	* @return Nothing
	* @access Public
	*/
	function recommend()
	{
		if($this->session->userdata('search_id'))
		{
			$this->load->model('courses_model');
			$this->courses_model->recommend($this->uri->segment(3), $this->session->userdata('search_id'));
		}

		redirect(base_url() . 'course/' . $this->uri->segment(3), 'location');
	}

	/**
	* Processes the 'unrecommend' action
	*
	* @return Nothing
	* @access Public
	*/
	function unrecommend()
	{
		if($this->session->userdata('search_id'))
		{
			$this->load->model('courses_model');
			$this->courses_model->unrecommend($this->uri->segment(3), $this->session->userdata('search_id'));
		}

		redirect(base_url() . 'course/' . $this->uri->segment(3), 'location');
	}
}

// End of file course.php
// Location: ./controllers/course.php