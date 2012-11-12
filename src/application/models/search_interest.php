<?php

class Search_interest extends DataMapper {

	var $table = 'search_interests';

	var $has_one = array(
		'search_instance' => array()
	);

}

//EOF
