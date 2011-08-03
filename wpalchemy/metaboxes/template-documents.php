<div class="my_meta_control">
 	
 	<?php global $custom_upload; ?>
	<label>Sample Image Upload(s)</label>
	<?php while($mb->have_fields_and_multi('images')): ?>
		<?php $mb->the_group_open(); ?>
 
			<?php $mb->the_field('sample_image'); ?>
			<?php $custom_upload->setGroupName('img-n'.$mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
			<p class="long-input">
				<?php echo $custom_upload->getField(array('name'=> $mb->get_the_name(),'value' => $mb->get_the_value())); ?>
				<?php echo $custom_upload->getButton(); ?>
				<?php if(!$mb->is_first()) { ?>
					<a href="#" class="dodelete button clear">- remove</a>		
				<?php } ?>
			</p>
 	
		<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>

	<p><a id="add-panel" href="#" class="docopy-images button clear">Add +</a></p>
	<hr size="1"/>
	 <div class="clear"></div>	
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras orci lorem, bibendum in pharetra ac, luctus ut mauris.</p>
 
	<label>Title</label>
 
	<p>
		<?php $mb->the_field('title'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>
 
	<label>Description <span>(optional)</span></label>
 
	<p>
		<?php $mb->the_field('description'); ?>
		<textarea name="<?php $mb->the_name(); ?>" rows="3"><?php $mb->the_value(); ?></textarea>
	</p>

	<label>Author</label>
 
	<p>
		<?php $mb->the_field('author'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
	</p>

	<label>Year Published</label>
 
	<p>
		<?php $mb->the_field('date_published'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>		
	</p>

	<h3>Details</h3>
	<p>
		<label>Author Alive?</label><br/>
	
		<?php $mb->the_field('alive'); ?>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="yes" <?php $mb->the_radio_state('yes'); ?>/> Yes<br/>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="no" <?php $mb->the_radio_state('no'); ?>/> No<br/>
	</p>

	<p>	
		<label>Document Category(s)</label><br/>
	
		<?php $categories = array('Politics','Religion','Philosophy','Advocacy'); ?>
	
		<?php foreach ($categories as $i => $cat): ?>
			<?php $mb->the_field('categories'); ?>
			<input type="checkbox" name="<?php $mb->the_name(); ?>[]" value="<?php echo $cat; ?>"<?php $mb->the_radio_state($cat); ?>/> <?php echo $cat; ?><br/>
		<?php endforeach; ?>
	</p>
	
	<p>
		<label>Select Era</label><br/>
		
		<?php $mb->the_field('era'); ?>
		<select name="<?php $mb->the_name(); ?>">
			<option value="">Select...</option>
			<option value="21st Century"<?php $mb->the_select_state('21st Century'); ?>>21st Century</option>
			<option value="20th Century"<?php $mb->the_select_state('20th Century'); ?>>20th Century</option>
			<option value="19th Century"<?php $mb->the_select_state('19th Century'); ?>>19th Century</option>
		</select>
	</p>
	
	<p>	
		<label>Sample Multi Select</label><br/>
	
		<?php $mb->the_field('multi', WPALCHEMY_FIELD_HINT_SELECT_MULTIPLE); ?>
		<select name="<?php $mb->the_name(); ?>" multiple="multiple" class="multi-select" size="5">
			<option value="e"<?php $mb->the_select_state('e'); ?>>e</option>
			<option value="f"<?php $mb->the_select_state('f'); ?>>f</option>
			<option value="g"<?php $mb->the_select_state('g'); ?>>g</option>
			<option value="h"<?php $mb->the_select_state('h'); ?>>h</option>
			<option value="i"<?php $mb->the_select_state('i'); ?>>i</option>
			<option value="j"<?php $mb->the_select_state('j'); ?>>j</option>
		</select>
	</p>

	 	<br/>
	<h3>Panels</h3>
	<div id="dynamic_fields">
		<?php while($mb->have_fields_and_multi('panel')): ?>
			<?php $mb->the_group_open(); ?>

				<label>Panel</label>	
				<?php $mb->the_field('panel'); ?>
				<div class="customEditor"><textarea name="<?php $mb->the_name(); ?>"><?php echo wp_richedit_pre($mb->get_the_value()); ?></textarea></div>
				<a href="#" class="dodelete button clear">- remove</a>		
		
			<?php $mb->the_group_close(); ?>
		<?php endwhile; ?>
		<div class="clear"></div>
	</div>
	<a id="add-panel" href="#" class="docopy-panel button">Add +</a>
	<br/><br/>
			
	
</div>

<script>
	(function($) {     
	
		$(document).ready(function() {          
			// Make the first editor by default 
			var i=1;
             $('.customEditor textarea').livequery(function(e){
                var id = $(this).attr('id');
 
				if (!id) {
					id = 'customEditor-' + i++;
					$(this).attr('id',id);
				}
				tinyMCE.execCommand('mceAddControl', false, id);
 
			});

			
		});
	})(jQuery);

/*
var tinymceConfigs = [ {theme : "advanced",
        mode : "none",
        language : "en",
        height:"200",
        width:"100%",
        theme_advanced_layout_manager : "SimpleLayout",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "" },{ theme : "advanced",
        mode : "none",
        language : "en",
        height:"200",
        width:"100%",
        theme_advanced_layout_manager : "SimpleLayout",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left"}];

function tinyfy(settingid,el_id) {
    tinyMCE.settings = tinymceConfigs[settingid];
    tinyMCE.execCommand('mceAddControl', true, el_id);
}
	
*/
</script>