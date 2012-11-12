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
* @package Course_Finder
* @author Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license GNU Affero General Public License 3.0
* @link coursedata.blogs.lincoln.ac.uk
*
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

    /**
    * Test function. 
    *
    * @return Nothing
    * @access Public
    */
	function test()
	{
        $this->output->enable_profiler(TRUE);
		$search_id = 20;

        //get amount of keywords for search
        $keyword_count = $this->db->select()
                                    ->where('search_instance_id', $search_id)
                                    ->from('search_keywords')
                                    ->count_all_results();

        //get amount of interests for search
        $interest_count = $this->db->select()
                                    ->where('search_instance_id', $search_id)
                                    ->from('search_interests')
                                    ->count_all_results();

        //get amount of studied for search
        $studied_count = $this->db->select()
                                    ->where('search_instance_id', $search_id)
                                    ->from('search_studied')
                                    ->count_all_results();

        echo $keyword_count. ' - ' . $interest_count . ' - ' . $studied_count;
        

		//Get all keywords for this search
        $keyword = new Search_keyword;
        $si_keywword = new Search_instance;
        $si_interest = new Search_instance;
        $si_studied = new Search_instance;

        $keyword->where('search_instance_id', $search_id);
        $keywords = $keywords->get_iterated();

        foreach($keywords as $keyword)
        {
            $si_keywword->or_where_related('search_keywords', 'keyword_id', $keyword->stored->keyword_id);
        }

        //Get all studied for this search
        $search_stud = new Search_studied;
        $search_stud->where('search_instance_id', $search_id);
        $studieds = $search_stud->get_iterated();

    	foreach($studieds as $studied)
    	{
            $si_interest->or_where_related('search_studied', 'jacs_code_id', $studied->stored->jacs_code_id);
    	}

        $kwords = $si_keyword->get_iterated();

        foreach($kwords as $kword)
        {
            $kword_ids[] = $kword->stored->id;
        }

        //Get all interested for this search
        $search_interest = new Search_interest;
    	$search_interest->where('search_instance_id', $search_id);
    	$interesteds = $search_interest->get_iterated();

    	foreach($interesteds as $interested)
    	{
            $si_studied->or_where_related('search_interest', 'jacs_code_id', $interested->stored->jacs_code_id);
    	}

        //First, check if any searches match all of the keywords and subjects for this particular search

        $searches = $si_keywword->get_iterated();


        echo '<pre>';
        print_r($keywords->stored);
        echo '</pre>';
        $search_ids = array();

        foreach($searches as $search)
        {
            echo '<pre>';
            print_r($search->stored);
            echo '</pre>';
            $search_ids[] = $search->stored->id;
        }

        $count_array = array_count_values($search_ids);

        echo '<pre>';
        print_r($count_array);
        echo '</pre>';

        unset($count_array);
    	
	}

}

// End of file course.php
// Location: ./controllers/course.php