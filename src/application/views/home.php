<script type="text/javascript"> 
$(document).ready(function() {
    $("#keywords").tokenInput("<?php echo base_url();?>search/keyword", {
        theme: "facebook"
    });

    $("#interested").tokenInput("<?php echo base_url();?>search/subject", {
        theme: "facebook"
    });

     $("#studied").tokenInput("<?php echo base_url();?>search/subject", {
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
		<h4>What subjects have you studied?</h4>
		<?php echo form_input(array('name' => 'studied', 'id' => 'studied', 'value' => 'Studied',  'class' => 'span8')); ?>
		<h4>What subjects are you interested in?</h4>
		<?php echo form_input(array('name' => 'interested', 'id' => 'interested', 'value' => 'Interested',  'class' => 'span8')); ?>
		<h4>Add Keywords : </h4>
		<?php echo form_input(array('name' => 'keywords', 'id' => 'keywords', 'value' => 'This one',  'class' => 'span8')); ?>
		<?php echo form_submit(array('id' => 'submit', 'value' => 'Search', 'class' => 'btn btn-large', 'style' => 'margin-top: 10px')); ?>
		</form>
	</section>

	<section class="span4">
		<p>Select which topic areas you have previously studied, or are interested in as well as adding relevant keywords to your search.</p>
		<p>Your search results can then be generated.</p> 
	</section>
</div>