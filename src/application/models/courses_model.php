<?php
/**
* Courses Model
*
* PHP Version 5
* 
* @category  Course Finder
* @package   Course Finder
* @author    Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @copyright 2012 University of Lincoln
* @license   GNU Affero General Public License 3.0
* @link      coursedata.blogs.lincoln.ac.uk
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
        $returning = array();

        foreach($id_array as $key => $value)
        {
            $results = json_decode(file_get_contents('http://n2/programmes/course_code/' . $key));
            $returning[$value][] = array('id' => $key, 'title' => substr_replace($results->result->course_title, "", -8));
        }

        return $returning;
    }

    /**
    * Get overview information of a single course.
    *
    * @param int $id A course ID.
    *
    * @return Array containing overview of course information.
    * @access Public
    */
    function get_course($id)
    {
        return array('data' => json_decode(file_get_contents('http://n2/programmes/course_code/' . $id)), 'recommended' => $this->check_recommended($id, $this->session->userdata('search_id')));
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
        $sc = new Search_click_through;
        $sc->search_id = (int) $search_id;
        $sc->course_id = (int) $course_id;
        $sc->save();
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
        $sc = new Similar_course;
        $sc->where('source_course_id', $course_id);
        $sc->where('min_relevance >=', $relevance);
        $sc->group_by('target_course_id');
        $courses = $sc->get_iterated();

        $results = array();

        foreach($courses as $course)
        {
            $course_info = json_decode(file_get_contents('http://n2/programmes/course_code/' . $course->stored->target_course_id));
            $results[] = array('id' => $course->stored->target_course_id, 'title' => substr_replace($course_info->result->course_title, "", -8));
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
        $sr = new Search_recommended;
        $sr->where('course_id', (int) $course_id);
        $sr->where('search_id', (int) $search_id);
        $sr->get();
        $sr->course_id = (int) $course_id;
        $sr->search_id = (int) $search_id;
        $sr->save();
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
        $sr = new Search_recommended;
        $sr->where('course_id', $course_id);
        $sr->where('search_id', $search_id);
        $sr->get();
        $sr->delete();
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
        $sr = new Search_recommended();
        $sr->get_where(array('course_id' => $course_id, 'search_id' => $search_id));
        
        if(isset($sr->course_id))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}

//EOF