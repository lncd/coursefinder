<?php

class Search_studied extends DataMapper {

	var $table = 'search_studied';

	var $has_one = array(
		'search' => array()
	);

}

//EOF
