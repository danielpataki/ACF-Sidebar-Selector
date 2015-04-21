<?php
/**
 * ACF 4 Field Class
 *
 * This file holds the class required for our field to work with ACF 4
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */

/**
 * ACF 4 Sidebar Selector Class
 *
 * The role selector class enables users to select sidebars. This is the class
 * that is used for ACF 4.
 *
 * @author Daniel Pataki
 * @since 3.0.0
 *
 */

class acf_field_sidebar_selector extends acf_field {
	var $settings;
	var $defaults;


	/**
	 * Field Constructor
	 *
	 * Sets basic properties and runs the parent constructor
	 *
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function __construct() {

		$this->name = 'sidebar_selector';
		$this->label = __( 'Sidebar Selector', 'acf-sidebar-selector-field' );
		$this->category = __( "Choice",'acf' );
		$this->defaults = array(
			'allow_null' => '1',
			'default_value' => ''
		);


    	parent::__construct();


		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}


	/**
	 * Field Options
	 *
	 * Creates the options for the field, they are shown when the user
	 * creates a field in the back-end. Currently there are two fields.
	 *
	 * Allowing null determines if the user is allowed to select no sidebars
	 *
	 * The default value can set the dropdown to a pre-set value when loaded
	 *
	 * @param array $field The details of this field
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function create_options($field) {

		$field = array_merge($this->defaults, $field);
		$key = $field['name'];


		?>
		<!-- Allow Null Field -->
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

	<!-- Default Value Field -->

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


	/**
	 * Field Display
	 *
	 * This function takes care of displaying our field to the users, taking
	 * the field options into account.
	 *
	 * @param array $field The details of this field
	 * @author Daniel Pataki
	 * @since 3.0.0
	 *
	 */
	function create_field( $field ) {

		global $wp_registered_sidebars;

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


// create field
new acf_field_sidebar_selector();

?>
