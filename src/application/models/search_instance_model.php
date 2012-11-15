<?php
/**
* Search Instance Model
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
* Search Instance Model
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Search_instance_model extends CI_Model
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
	* Check if a search instance matches all of the criteria of another instance.
	*
	* @param int $original_instance    ID of originals search instance
	* @param int $comparitive_instance ID of the instance to check
	*
	* @return Bool
	* @access Public
	*/
	function check_parameters_match($original_instance, $comparitive_instance)
	{
		if($original_instance !== $comparitive_instance)
		{
			$count = 0;
			$match_count = 0;

			//Get original instance keywords
			$orig_keywords = new Search_keyword;
			$orig_keywords->where('search_instance_id', $original_instance)->get_iterated();

			$keyword_id_array = array();

			foreach($orig_keywords as $orig_keyword)
			{
				$keyword_id_array = $orig_keyword->stored->keyword_id;
			}
			$match_count+= count($keyword_id_array);

			if(count($keyword_id_array))
			{
				$keyword_matches = $this->db->select()
											->where('search_instance_id', $comparitive_instance)
											->where_in('keyword_id', $keyword_id_array)
											->from('search_keywords')
											->count_all_results();

				$count+= $keyword_matches;
			}
			//Get original instance studied
			$orig_studieds = new Search_studied;
			$orig_studieds->where('search_instance_id', $original_instance)->get_iterated();

			$studied_id_array = array();

			foreach($orig_studieds as $orig_studied)
			{
				$studied_id_array[] = $orig_studied->stored->jacs_code_id;
			}

			$match_count+= count($studied_id_array);

			if(count($studied_id_array) > 0)
			{
				$studied_matches = $this->db->select()
											->where('search_instance_id', $comparitive_instance)
											->where_in('jacs_code_id', $studied_id_array)
											->from('search_studied')
											->count_all_results();

				$count+= $studied_matches;
			}

			//Get original instance interests
			$orig_interests = new Search_interest;
			$orig_interests->where('search_instance_id', $original_instance)->get_iterated();

			$interests_id_array = array();

			foreach($orig_interests as $orig_studied)
			{
				$interests_id_array[] = $orig_studied->stored->jacs_code_id;
			}

			$match_count+= count($interests_id_array);

			if(count($interests_id_array) > 0)
			{
				$interested_matches = $this->db->select()
											->where('search_instance_id', $comparitive_instance)
											->where_in('jacs_code_id', $interests_id_array)
											->from('search_interests')
											->count_all_results();

				$count+= $interested_matches;
			}
			
			if($count === $match_count)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}

	/**
	* Get an array of all recommended courses from an array of search instance IDs
	*
	* @param int $course_id The ID of the course to check
	* @param array $instance_ids An array contaning search instance ids
	* 
	* @return Array contaning unique course IDs 
	* @access Public
	*/
	public function check_course_recommended($course_id, $instance_ids)
	{
		if(count($instance_ids) > 0)
		{
			return $this->db->select()
							->where('course_id', $course_id)
							->where_in('search_instance_id', $instance_ids)
							->from('search_recommended')
							->count_all_results();
		}
		else
		{
			return 0;
		}
	}
}

// End of file search_instance_model.php
// Location: ./models/search_instance_model.php