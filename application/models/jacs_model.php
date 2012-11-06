<?php
class Jacs_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
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

//EOF