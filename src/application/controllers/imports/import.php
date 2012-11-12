<?php
/**
* Import
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
* Import
*
* @category Course_Finder
* @package Course_Finder
* @author Jamie Mahoney <jmahoney@lincoln.ac.uk>
* @license GNU Affero General Public License 3.0
* @link coursedata.blogs.lincoln.ac.uk
*
*/
class Import extends CI_Controller
{
	/**
    * Imports Keywords. 
    *
    * @return Nothing
    * @access Public
    */
	public function keywords()
	{
		$results = json_decode(file_get_contents( $_SERVER['CF_N2_ENDPOINT'] . 'keywords'));

		foreach($results->results as $keyword)
		{
			$keyword = new Keyword();
			$keyword->where('n2_id', $keyword->id)->get();
			$keyword->n2_id = (int) $keyword->id;
			$keyword->keyword = $keyword->keyword;
			$keyword->save();

			unset($keyword);
		}
	}

	/**
    * Imports Course Links. 
    *
    * @return Nothing
    * @access Public
    */
	public function keyword_course_links()
	{
		$results = json_decode(file_get_contents( $_SERVER['CF_N2_ENDPOINT'] . 'keyword_course_links'));

		foreach($results->results as $link)
		{
			$keyword_course_link = new Keyword_course_link;
			$keyword_course_link->where('n2_id', $link->id)->get();
			$keyword_course_link->n2_id = $link->id;
			$keyword_course_link->keyword_id = $link->keyword_id;
			$keyword_course_link->course_id = $link->course_code_id;
			$keyword_course_link->relevance = $link->relevance;
			$keyword_course_link->keyword_count = $link->count;
			$keyword_course_link->save();

			unset($keyword_course_link);
		}
	}

	/**
    * Imports Similar Courses. 
    *
    * @return Nothing
    * @access Public
    */
	public function similar_courses()
	{
		ini_set('memory_limit', '128M');

		$min = array(0.0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0);
		$max = array(0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0,1.1);
		
		for($i = 0; $i <= 10; $i++)
		{
			$results = json_decode(file_get_contents($_SERVER['CF_N2_ENDPOINT'] . 'related_courses?relevance_gte=' . $min[$i] . '&relevance_lt=' . $max[$i] . '&ignore_type_id=1,2,3,4,6,24,29,33,8,20'));

			foreach($results->results as $similar)
			{
				$similar = new Similar_course;
				$similar->where('source_course_id', $similar->source_course_id);
				$similar->where('target_course_id', $similar->target_course_id);
				$similar->where('keyword_id', (int) $similar->keyword_id);
				$similar->get();
				$similar->source_course_id = $similar->source_course_id;
				$similar->target_course_id = $similar->target_course_id;
				$similar->keyword_id = $similar->keyword_id;
				$similar->min_relevance = $min[$i];
				$similar->save();

				unset($similar);
			}
			unset($results);
		}
	}
}

// End of file import.php
// Location: ./controllers/imports/import.php