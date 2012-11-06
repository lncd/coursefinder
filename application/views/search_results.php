<div class="page-header">
	<h2>Search Results...</h2>
</div>

<div class="row">
	<section class="span12">
		<h4>The following courses were found: </h4>
		<?php foreach($results->results as $course): ?>
			<p><?php echo $course->code; ?></p>
		<?php endforeach; ?>
	</section>
</div>