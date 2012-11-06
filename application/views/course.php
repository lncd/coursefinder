<div class="page-header">
	<h1>Course Profile</h1>
	<h2><?php echo substr_replace($course['data']->result->course_title, "", -8); ?></h2>
</div>

<div class="row">
	<section class="span8">
		<?php if($course['data']->result->overview !== NULL): ?>
			<h3>Overview</h3>
			<?php echo nl2br($course['data']->result->overview); ?>
		<?php else: ?>
			<h3>Aims and Objectives</h3>
			<?php echo nl2br($course['data']->result->aims_and_objectives) ; ?>
		<?php endif; ?>
	</section>

	<section class="span4">
		<div class="well" style="text-align: center">
			<?php if($course['recommended'] > 0): ?>
				<i>You have recommended this course as matching your search criteria.</i>
				<a href="<?php echo base_url();?>course/unrecommend/<?php echo $this->uri->segment(2);?>" class="btn btn-info" style="margin-top: 10px"><i class= "icon-thumbs-down icon-large" style="margin-right: 10px"></i><i>Remove Recommendation</i></a>
			<?php else: ?>
				Does this course match your search criteria? Recommend it!
				<a href="<?php echo base_url();?>course/recommend/<?php echo $this->uri->segment(2);?>" class="btn btn-info" style="margin-top: 10px"><i class= "icon-thumbs-up icon-large" style="margin-right: 10px"></i><i>Recommend</i></a>
			<?php endif; ?>
			
		</div>
		<div class="well">
			<h5>Similar Courses</h5>
			<?php if(empty($similar)): ?>
				<p>No results, sorry.</p>
			<?php else: ?>	
				<?php foreach($similar as $course): ?>
					<p><a href="<?php echo base_url(); ?>course/<?php echo $course['id'];?>"><?php echo $course['title']; ?></a></p>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>
</div>