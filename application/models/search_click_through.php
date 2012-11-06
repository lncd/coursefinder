<?php

class Search_click_through extends DataMapper {

	var $table = 'search_click_throughs';

	var $has_one = array(
		'search_instance' => array()
	);

}

//EOF
