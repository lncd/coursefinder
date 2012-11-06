<?php

class Keyword extends DataMapper {

	var $table = 'keywords';

	var $has_one = array(
	);

	var $has_many = array(
		'keyword_course_link' => array(),
		'search_keyword' => array()
	);
}

//EOF
