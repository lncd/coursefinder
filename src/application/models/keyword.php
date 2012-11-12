<?php
/**
* Keyword
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
* Keyword
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/
class Keyword extends DataMapper {

	/**
	* Name of the table that the model uses.
	*
	* @var string
	*/
	var $table = 'keywords';

	/**
	* Array containing related elements.
	*
	* @var array
	*/
	var $has_one = array(
	);

	/**
	* Array containing related elements.
	*
	* @var array
	*/
	var $has_many = array(
		'keyword_course_link' => array(),
		'search_keyword' => array()
	);
}

// End of file keyword.php
// Location: ./models/keyword.php
