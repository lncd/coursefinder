<?php
/**
* Search Click Through
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
* Search Click Through
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Search_click_through extends DataMapper {

	/**
	* Name of the table that the model uses.
	*
	* @var String
	*/
	var $table = 'search_click_throughs';

	/**
	* Array containing associated elements.
	*
	* @var Array
	*/
	var $has_one = array(
		'search_instance' => array()
	);

}

// End of file search_click_through.php
// Location: ./models/search_click_through.php
