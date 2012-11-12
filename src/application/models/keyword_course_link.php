<?php
/**
* Keyword Course Link
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
* Keyword Course Link
*
* @category Course_Finder
* @package  Course_Finder
* @author   Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license  GNU Affero General Public License 3.0
* @link     coursedata.blogs.lincoln.ac.uk
*/
class Keyword_course_link extends DataMapper {

	/**
	* @var string
	*/
	var $table = 'keyword_course_links';

	/**
	* @var array
	*/
	var $has_one = array(
		'keyword' => array()
	);

}

// End of file keyword_course_link.php
// Location: ./models/keyword_course_link.php
