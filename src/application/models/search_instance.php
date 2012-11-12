<?php
/**
* Search Instance
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
* Search Instance
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Search_instance extends DataMapper {

	/**
	* Name of the table that the model uses.
	*
	* @var String
	*/
	var $table = 'search_instances';

	/**
	* Array containing associated elements.
	*
	* @var Array
	*/
	var $has_one = array();

	/**
	* Array containing associated elements.
	*
	* @var Array
	*/
	var $has_many = array(
		'search_keyword' => array(),
		'search_studied' => array(),
		'search_interest' => array()
		);

}

// End of file search_instance.php
// Location: ./models/search_instance.php
