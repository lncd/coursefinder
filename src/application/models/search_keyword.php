<?php
/**
* Search Keyword
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
* Search Keyword
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/
class Search_keyword extends DataMapper {

	/**
	* Name of the table that the model uses.
	*
	* @var String
	*/
	var $table = 'search_keywords';

	/**
	* Array contaning associated elements.
	*
	* @var Array
	*/
	var $has_one = array(
		'search_instance' => array(),
		'keyword' => array()
	);

}

// End of file search_keyword.php
// Location: ./models/search_keyword.php
