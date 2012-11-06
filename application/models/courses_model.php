<?php
class Courses_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
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

    function get_course_overview($id)
    {
        return array('data' => json_decode(file_get_contents('http://n2/programmes/course_code/' . $id)), 'recommended' => $this->check_recommended($id, $this->session->userdata('search_id')));
    }

    function add_course_click_through($search_id, $course_id)
    {
        $sc = new Search_click_through;
        $sc->search_id = (int) $search_id;
        $sc->course_id = (int) $course_id;
        $sc->save();
    }

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

    function unrecommend($course_id, $search_id)
    {
        $sr = new Search_recommended;
        $sr->where('course_id', $course_id);
        $sr->where('search_id', $search_id);
        $sr->get();
        $sr->delete();
    }

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