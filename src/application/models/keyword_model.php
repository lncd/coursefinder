<?php
/**
* Keyword Model
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
* Keyword Model
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Keyword_model extends CI_Model
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
	* Get like keywords
	*
	* @param string $term The term to search for
	*
	* @return A JSON string containing like keywords
	* @access Public
	*/
	function get_like_keywords_json($term)
	{
		$results = $this->db->like('keyword', $term)->limit(10)->get('keywords');
		$json_string = '[';
		foreach($results->result() as $result)
		{
			$json_string.= '{"id": ' . $result->id . ',"name":"' . $result->keyword . '"},';
		}

		$json_string = substr_replace($json_string, '', -1);
		$json_string.= ']';
		return $json_string;
	}

	/**
	* Get courses that match ALL of the keywords specified
	*
	* @param array $keywords An array of keywords
	*
	* @return None
	* @access Public
	*/
	function get_courses_all_keywords($keywords)
	{
		$keyword = new Keyword;
		$keyword->where_in('id', $keywords);
		$keyword->limit(25);
		$keyword->get();
	}

	/**
	* Get courses that match a specific keyword for a defined relevancy
	*
	* @param int   $keyword_id The ID of a keyword
	* @param float $relevance  The minimum relevancy score that a link needs to be considered
	*
	* @return None
	* @access Public
	*/
	function get_course_ids_by_keyword($keyword_id, $relevance = 0.5)
	{
		$kc_link = new Keyword_course_link;
		$kc_link->where('keyword_id', (int) $keyword_id);
		$kc_link->where('relevance >=', $relevance);

		$links = $kc_link->get_iterated();

		$returning = array();

		foreach($links as $link)
		{
			$returning[] = $link->stored->course_id;
		}

		return $returning;
	}

	/**
	* Prioritises results
	*
	* @param array $input An array of results to order and prioritise
	*
	* @return An array with the top 25 results
	* @access Public
	*/
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

// End of file keyword_model.php
// Location: ./models/keyword_model.php