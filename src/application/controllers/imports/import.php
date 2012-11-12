<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

	public function keywords()
	{
		$results = json_decode(file_get_contents( $_SERVER['CF_N2_ENDPOINT'] . 'keywords'));

		foreach($results->results as $keyword)
		{
			$k = new Keyword();
			$k->where('n2_id', $keyword->id)->get();
			$k->n2_id = (int) $keyword->id;
			$k->keyword = $keyword->keyword;
			$k->save();

			unset($k);
		}
	}

	public function keyword_course_links()
	{
		$results = json_decode(file_get_contents( $_SERVER['CF_N2_ENDPOINT'] . 'keyword_course_links'));

		foreach($results->results as $link)
		{
			$kl = new Keyword_course_link;
			$kl->where('n2_id', $link->id)->get();
			$kl->n2_id = $link->id;
			$kl->keyword_id = $link->keyword_id;
			$kl->course_id = $link->course_code_id;
			$kl->relevance = $link->relevance;
			$kl->keyword_count = $link->count;
			$kl->save();

			unset($kl);
		}
	}

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
				$s = new Similar_course;
				$s->where('source_course_id', $similar->source_course_id);
				$s->where('target_course_id', $similar->target_course_id);
				$s->where('keyword_id', (int) $similar->keyword_id);
				$s->get();
				$s->source_course_id = $similar->source_course_id;
				$s->target_course_id = $similar->target_course_id;
				$s->keyword_id = $similar->keyword_id;
				$s->min_relevance = $min[$i];
				$s->save();

				unset($s);
			}
			unset($results);
		}
	}
}
