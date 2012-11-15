<?php
/**
* Courses Model
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
* Courses_model
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Courses_model extends CI_Model
{
	/**
	* Constructor
	*
	* @return Nothing
	* @access Public
	*/
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/**
	* Get overview information of an array of courses
	*
	* @param array $id_array Array of course IDs
	*
	* @return Array containing overview information for specified courses.
	* @access Public
	*/
	function get_course_overviews($id_array)
	{
		$this->load->model('search_instance_model');

		$this_search = (int) $this->session->userdata('search_id');
		$this_instance = new Search_instance;
		$this_instance->where('id', $this_search)->get();

		$instances = array();

		$all_instances = new Search_instance;
		$all_instances->where('parameter_count', $this_instance->parameter_count)->get_iterated();

		$this->load->model('search_instance_model');

		foreach($all_instances as $an_instance)
		{
			if($this->search_instance_model->check_parameters_match($this_search ,$an_instance->id) === 1)
			{
				$instances[] = $an_instance->id;
			}
		}


		$returning = array();

		foreach($id_array as $a_key => $value)
		{
			$results = json_decode(file_get_contents('http://n2/programmes/course_code/' . $a_key));
			$returning[$value][] = array('id' => $a_key, 'title' => substr_replace($results->result->course_title, '', -8), 'recommended' => $this->search_instance_model->check_course_recommended($a_key, $instances));
		}

		return $returning;
	}

	/**
	* Get overview information of a single course.
	*
	* @param int $course_id A course ID.
	*
	* @return Array containing overview of course information.
	* @access Public
	*/
	function get_course($course_id)
	{
		return array('data' => json_decode(file_get_contents('http://n2/programmes/course_code/' . $course_id)), 'recommended' => $this->check_recommended($course_id, $this->session->userdata('search_id')));
	}

	/**
	* Stores the fact that a search result has been clicked.
	*
	* @param int $search_id The ID of the current search
	* @param int $course_id The ID of the course clicked on.
	*
	* @return Nothing
	* @access Public
	*/
	function add_course_click_through($search_id, $course_id)
	{
		$search_click = new Search_click_through;
		$search_click->search_id = (int) $search_id;
		$search_click->course_id = (int) $course_id;
		$search_click->save();
	}

	/**
	* Get courses that are similar to the one specified.
	*
	* @param int   $course_id The ID of the course
	* @param float $relevance The minimum relevancy threshold for similar courses
	*
	* @return An array containing similar courses and some meta information.
	* @access Public
	*/
	function get_similar_courses($course_id, $relevance = 0.5)
	{
		$similar_course = new Similar_course;
		$similar_course->where('source_course_id', $course_id);
		$similar_course->where('min_relevance >=', $relevance);
		$similar_course->group_by('target_course_id');
		$courses = $similar_course->get_iterated();

		$results = array();

		foreach($courses as $course)
		{
			$course_info = json_decode(file_get_contents('http://n2/programmes/course_code/' . $course->stored->target_course_id));
			$results[] = array('id' => $course->stored->target_course_id, 'title' => substr_replace($course_info->result->course_title, '', -8));
		}

		return $results;
	}

	/**
	* Processes a recommendation
	*
	* @param int $course_id The ID of the current course
	* @param int $search_id The ID of the current search instance.
	*
	* @return Nothing
	* @access Public
	*/
	function recommend($course_id, $search_id)
	{
		$search_rec = new Search_recommended;
		$search_rec->where('course_id', (int) $course_id);
		$search_rec->where('search_id', (int) $search_id);
		$search_rec->get();

		$search_rec->course_id = (int) $course_id;
		$search_rec->search_id = (int) $search_id;
		$search_rec->save();
	}

	/**
	* Processes an 'un-recommendation'
	*
	* @param int $course_id The ID of the current course
	* @param int $search_id The ID of the current search instance.
	*
	* @return Nothing
	* @access Public
	*/
	function unrecommend($course_id, $search_id)
	{
		$search_rec = new Search_recommended;
		$search_rec->where('course_id', $course_id);
		$search_rec->where('search_id', $search_id);
		$search_rec->get();
		$search_rec->delete();
	}

	/**
	* Checks if a course has already been recommended during this search instance.
	*
	* @param int $course_id The ID of the current course
	* @param int $search_id The ID of the current search instance.
	*
	* @return Bool indicating if the course has been recommended during this search instance.
	* @access Public
	*/
	function check_recommended($course_id, $search_id)
	{
		$search_rec = new Search_recommended();
		$search_rec->get_where(array('course_id' => $course_id, 'search_id' => $search_id));

		if(isset($search_rec->course_id))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

// End of file courses_model.php
// Location: ./models/courses_model.php