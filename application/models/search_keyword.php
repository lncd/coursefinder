<?php

class Search_keyword extends DataMapper {

	var $table = 'search_keywords';

	var $has_many = array(
		'search_instance' => array(),
		'keyword' => array()
	);

}

//EOF
