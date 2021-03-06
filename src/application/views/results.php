<div class="page-header">
	<h1>Search Results</h1>
</div>

<div class="row">
	<section class="span8">
		<?php foreach($course_data as $key => $value) : ?>
			<h3>Matching <?php echo $key; ?> criteria: </h3>
			<table>
			<?php foreach($value as $row): ?>
				<tr>
					<?php if($row['recommended'] > 0) : ?>
						<td><i class="icon-star" style="margin-right: 5px"></i></td>
					<?php else: ?>
						<td></td>
					<?php endif;?>
					<td><p><a href="<?php echo base_url(); ?>course/<?php echo $row['id'];?>"><?php echo $row['title']; ?></a></p></td>
			<?php endforeach; ?>
			</table>
		<?php endforeach; ?>
	</section>

	<section class="span4">
		<!--<div class="well">
			<p>These search results are based on the following criteria: </p>
			<ul>
				<li>Some criteria</li>
				<li>Shown here</li>
				<li>And here</li>
			
		</div></ul>-->
		<p>Search results are generated from the criteria you specified previously.</p>
		<p>Courses that match the subject areas you specified, as well as the keywords and level of study are returned, and then prioritised based on the amount of criteria they each meet.</p>
		<p>Some search results are prioritised further when other people have recommended results from similar searches to your specified criteria.</p>
		<p>A <i class="icon-star" style="margin-right: 5px"></i> icon next to the course title shows that a previous user has entered the same criteria as you and has recommended this particular course as being relevant.</p>
	</section>
</div>