<?php

class Search_instance extends DataMapper {

	var $table = 'search_instances';

	var $has_one = array();

	var $has_many = array(
		'search_keyword' => array()
		);

}

//EOF
