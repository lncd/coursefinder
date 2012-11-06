<?php

class Search_interest extends DataMapper {

	var $table = 'search_interests';

	var $has_many = array(
		'search_instance' => array()
	);

}

//EOF
