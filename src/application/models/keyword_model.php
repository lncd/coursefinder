<?php
class Keyword_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_like_keywords_json($term)
	{
		$results = $this->db->like('keyword', $term)->limit(10)->get('keywords');
		$json_string = '[';
		foreach($results->result() as $result)
		{
			$json_string.= '{"id": ' . $result->id . ',"name":"' . $result->keyword . '"},';
		}

		$json_string = substr_replace($json_string ,"",-1);
		$json_string.= ']';
		return $json_string;
	}

	function get_courses_all_keywords($keywords)
	{
		$k = new Keyword;
		$k->where_in('id', $keywords);
		$k->limit(25);
		$k->get();
	}

	function get_course_ids_by_keyword($keyword_id, $relevance = 0.5)
	{
		$kc = new Keyword_course_link;
		$kc->where('keyword_id', (int) $keyword_id);
		$kc->where('relevance >=', $relevance);

		$links = $kc->get_iterated();

		$returning = array();

		foreach($links as $link)
		{
			$returning[] = $link->stored->course_id;
		}

		return $returning;
	}

	function prioritise_results($input)
	{
		$all_courses = array();

		foreach($input as $input_array)
		{
			foreach($input_array as $value)
			{
				$all_courses[] = $value;
			}
		}

		$id_counts = array_count_values($all_courses);
		//Sort the ids!
		arsort($id_counts);

		$slice = array_slice($id_counts, 0, 25, TRUE);
		return $slice;
	}
}

//EOF