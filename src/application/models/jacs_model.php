<?php
/**
* JACS Model
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
* JACS Model
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/
class Jacs_model extends CI_Model
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
	* Get course IDs from JACS code
	*
	* @return Nothing
	* @access Public
	*/
	function get_course_ids_by_jacs_code($code)
	{
		$results = json_decode(file_get_contents('http://n2/course_codes?related_jacs_id=' . $code));
		$returning = array();

		foreach($results->results as $result)
		{
			$returning[] = $result->id;
		}

		return $returning;
	}
}

// End of file jacs_model.php
// Location: ./models/jacs_model.php