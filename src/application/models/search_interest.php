<?php
/**
* Search Interest
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
* Search Interest
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/

class Search_interest extends DataMapper {

	/**
	* Name of the table that the model uses.
	*
	* @var string
	*/
	var $table = 'search_interests';

	/**
	* Array contaning associated elements.
	*
	* @var array
	*/
	var $has_one = array(
		'search_instance' => array()
	);

}

// End of file search_interest.php
// Location: ./models/search_interest.php
