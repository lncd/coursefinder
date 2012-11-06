<?php

class Course extends CI_Controller {

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

	function recommend()
	{
		if($this->session->userdata('search_id'))
		{
			$this->load->model('courses_model');
			$this->courses_model->recommend($this->uri->segment(3), $this->session->userdata('search_id'));
		}

		redirect(base_url() . 'course/' . $this->uri->segment(3), 'location');
	}

	function unrecommend()
	{
		if($this->session->userdata('search_id'))
		{
			$this->load->model('courses_model');
			$this->courses_model->unrecommend($this->uri->segment(3), $this->session->userdata('search_id'));
		}

		redirect(base_url() . 'course/' . $this->uri->segment(3), 'location');
	}

	function test()
	{
		$search_id = 147;
		//Get all keywords for this search
        $keyword_results = array();
        $k = new Search_keyword;
        $k->where('search_id', $search_id);
        $keywords = $k->get_iterated();

        foreach($keywords as $keyword)
        {
            $keyword_results[] = $keyword->stored->id;
        }

        //Get all studied for this search
        $studied_results = array();
    	$ss = new Search_studied;
    	$ss->where('search_id', $search_id);
    	$studieds = $ss->get_iterated();

    	foreach($studieds as $studied)
    	{
    		$studied_results[] = $studied->stored->id;
    	}

        //Get all interested for this search
    	$interested_results = array();
    	$si = new Search_interest;
    	$si->where('search_id', $search_id);
    	$interesteds = $si->get_iterated();

    	foreach($interesteds as $interested)
    	{
    		$interested_results[] = $interested->stored->id;
    	}

        //First, check if any searches match all of the keywords and subjects for this particular search
        $s = new Search_instance;

        foreach($keyword_results as $keyword)
        {
        	$s->where_related('search_keywords', 'keyword_id', $keyword);
        }

        $searches = $s->get_iterated();
        
        //If so, check for recommendations
        

        //If so, count how many and return

        //Else, return 0


        echo '<pre>';
        print_r($keyword_results);
        echo '</pre>';

       	echo '<pre>';
    	print_r($studied_results);
    	echo '</pre>';

    	echo '<pre>';
    	print_r($searches);
    	echo '</pre>';
	}

}
