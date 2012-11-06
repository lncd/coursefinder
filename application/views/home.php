<script type="text/javascript"> 
$(document).ready(function() {
    $("#keywords").tokenInput("<?php echo base_url();?>search/keyword", {
        theme: "facebook"
    });

    $('form').submit(function(e) {
    	
		var token = $('input[name="keywords"]').tokenInput('get');
		var tokenString = '';

		for(var i in token)
		{
			tokenString += token[i].name + ",";
		}
		$('token_input').val(tokenString);

		return true;
	});
});
</script>

<div class="page-header">
	<h1>Find Me A Course!!!<small>Please?</small></h1>
</div>

<div class="row">
	<section class="span8">
		<form action="<?php echo base_url();?>search/results" method="post" id="search_form">
		<h4>I have studied, or I am interested in : </h4>
		<table>
			<thead>
				<th>Subject</th>
				<th>Previously Studied</th>
				<th>Interested In</th>
			</thead>
			<tbody>
			<?php foreach($codes as $code): ?>
				<tr><td><?php echo $code['title'];?></td><td style="text-align: center"><?php echo form_checkbox(array('name' => 'studied[]', 'id' => 'studied[]', 'value' => $code['id'], 'checked' => FALSE, 'style' => 'margin-top: 0px; margin-right: 5px'));?></td><td style="text-align: center"><?php echo form_checkbox(array('name' => 'interested[]', 'id' => 'interested[]', 'value' => $code['id'], 'checked' => FALSE, 'style' => 'margin-top: 0px; margin-right: 5px'));?></td></tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<h4>Add Keywords : </h4>
		<?php echo form_input(array('name' => 'keywords', 'id' => 'keywords', 'value' => 'This one',  'class' => 'span8')); ?>
		<h4>Level of Study : </h4>
		<p>Undergraduate<?php echo form_radio(array('name' => 'level', 'id' => 'level', 'checked' => TRUE, 'value' => 'undergrad', 'style' => 'margin-top: 0px; margin-right: 5px')); ?>
		Postgraduate<?php echo form_radio(array('name' => 'level', 'id' => 'level', 'checked' => FALSE, 'value' => 'undergrad', 'style' => 'margin-top: 0px; margin-right: 5px')); ?></p>
		<?php echo form_submit(array('id' => 'submit', 'value' => 'Search', 'class' => 'btn btn-large', 'style' => 'margin-top: 10px')); ?>
		</form>
	</section>

	<section class="span4">
		<p>Some explaining stuffs here. </p> 
	</section>
</div>