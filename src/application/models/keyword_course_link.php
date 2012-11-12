<?php

class Keyword_course_link extends DataMapper {

	var $table = 'keyword_course_links';

	var $has_one = array(
		'keyword' => array()
	);

}

//EOF
