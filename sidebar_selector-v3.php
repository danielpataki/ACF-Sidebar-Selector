<?php

class acf_field_sidebar_selector extends acf_Field
{

	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options


	/*--------------------------------------------------------------------------------------
	*
	*	Constructor
	*	- This function is called when the field class is initalized on each page.
	*	- Here you can add filters / actions and setup any other functionality for your field
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function __construct($parent)
	{

		// do not delete!
  	parent::__construct($parent);

  	// set name / title
  	$this->name = 'sidebar_selector';
	  $this->title = __('Sidebar Selector', 'acf');
	  $this->defaults = array(
			'allow_null' => '1',
			'default_value' => ''
	  );

		// settings
		$this->settings = array(
			'path' => $this->helpers_get_path(__FILE__),
			'dir' => $this->helpers_get_dir(__FILE__),
			'version' => '1.0.0'
		);

  }


 	/*
  *  helpers_get_path
  *
  *  @description: calculates the path (works for plugin / theme folders)
  *  @since: 3.6
  *  @created: 30/01/13
  */

  function helpers_get_path($file)
  {
    return trailingslashit(dirname($file));
  }


  /*
  *  helpers_get_dir
  *
  *  @description: calculates the directory (works for plugin / theme folders)
  *  @since: 3.6
  *  @created: 30/01/13
  */

  function helpers_get_dir($file)
  {
    $dir = trailingslashit(dirname($file));
    $count = 0;


    // sanitize for Win32 installs
    $dir = str_replace('\\', '/', $dir);


    // if file is in plugins folder
    $wp_plugin_dir = str_replace('\\', '/', WP_PLUGIN_DIR);
    $dir = str_replace($wp_plugin_dir, WP_PLUGIN_URL, $dir, $count);


    if($count < 1)
    {
      // if file is in wp-content folder
      $wp_content_dir = str_replace('\\', '/', WP_CONTENT_DIR);
      $dir = str_replace($wp_content_dir, WP_CONTENT_URL, $dir, $count);
    }


    if($count < 1)
    {
      // if file is in ??? folder
      $wp_dir = str_replace('\\', '/', ABSPATH);
      $dir = str_replace($wp_dir, site_url('/'), $dir);
    }

    return $dir;
  }


	/*--------------------------------------------------------------------------------------
	*
	*	create_options
	*	- this function is called from core/field_meta_box.php to create extra options
	*	for your field
	*
	*	@params
	*	- $key (int) - the $_POST obejct key required to save the options to the field
	*	- $field (array) - the field object
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function create_options($key, $field)
	{
		$field = array_merge($this->defaults, $field);
		$key = $field['name'];


		// Create Field Options HTML
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Allow Null", 'acf'); ?></label>
	</td>
	<td>
		<?php

		do_action('acf/create_field', array(
			'type'    =>  'radio',
			'name'    =>  'fields[' . $key . '][allow_null]',
			'value'   =>  $field['allow_null'],
			'layout'  =>  'horizontal',
			'choices' =>  array(
				'1' => __('Yes', 'acf'),
				'0' => __('No', 'acf'),
			)
		));

		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Default Value", 'acf'); ?></label>
	</td>
	<td>
		<?php

		do_action('acf/create_field', array(
			'type'    =>  'text',
			'name'    =>  'fields[' . $key . '][default_value]',
			'value'   =>  $field['default_value'],
		));

		?>
	</td>
</tr>

		<?php
	}



	/*--------------------------------------------------------------------------------------
	*
	*	create_field
	*	- this function is called on edit screens to produce the html for this field
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/

	function create_field($field)
	{

		global $wp_registered_sidebars;

		// create Field HTML
		?>
		<div>
			<select name='<?php echo $field['name'] ?>'>
				<?php if ( !empty( $field['allow_null'] ) ) : ?>
					<option value=''><?php _e( 'Select a Sidebar', 'acf' ) ?></option>
				<?php endif ?>
				<?php
					foreach( $wp_registered_sidebars as $sidebar ) :
					$selected = ( ( $field['value'] == $sidebar['id'] ) || ( empty( $field['value'] ) && $sidebar['id'] == $field['default_value'] ) ) ? 'selected="selected"' : '';
				?>
					<option <?php echo $selected ?> value='<?php echo $sidebar['id'] ?>'><?php echo $sidebar['name'] ?></option>
				<?php endforeach; ?>

			</select>
		</div>
		<?php
	}


}

?>
