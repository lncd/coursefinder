<?php
/**
* Search Studied
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
* Search Studied
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Search_studied extends DataMapper {

	/**
	* Name of the table that the model uses.
	*
	* @var string
	*/
	var $table = 'search_studied';

	/**
	* Array containing associated elements.
	*
	* @var array
	*/
	var $has_one = array(
		'search_instance' => array()
	);

}

// End of file search_studied.php
// Location: ./models/search_studied.php
