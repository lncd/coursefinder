<?php
/**
* Subject Model
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
* Subject Model
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Subject_model extends CI_Model
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
	* Get like subjects
	*
	* @param string $term The term to search for
	*
	* @return A JSON string containing like keywords
	* @access Public
	*/
	function get_like_subjects_json($term)
	{
		$results = $this->db->like('title', $term)->limit(10)->get('subjects');
		$json_string = '[';
		foreach($results->result() as $result)
		{
			$json_string.= '{"id": ' . $result->n2_id . ',"name":"' . $result->title . '"},';
		}

		$json_string = substr_replace($json_string, '', -1);
		$json_string.= ']';
		return $json_string;
	}
}

// End of file subject_model.php
// Location: ./models/subject_model.php