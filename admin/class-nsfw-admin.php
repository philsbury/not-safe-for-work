<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://philsbury.uk
 * @since      0.1.0
 *
 * @package    Nsfw
 * @subpackage Nsfw/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nsfw
 * @subpackage Nsfw/admin
 * @author     Phil Baker
 */
class Nsfw_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


	/**
	 * Add NSFW field to media uploader
	 *
	 * @param $form_fields array, fields to include in attachment form
	 * @param $post object, attachment record in database
	 * @return $form_fields, modified form fields
	 */

	public function attachment_field_nsfw( $form_fields, $post ) {
			$checked = get_post_meta( $post->ID, 'nsfw', true );

			$all = get_post_meta( $post->ID, 'nsfw');

	    $form_fields['nsfw'] = array(
	        'label' => __('NSFW', 'nsfw'),
	       	'input' => 'html',
					'html' => "<input type='checkbox' name='attachments[{$post->ID}][nsfw]' id='attachments_{$post->ID}_nsfw'". ($checked ? ' checked' : '') ." />",
	        'value' => 1,
	        'helps' => __('Add to the NSFW list', $this->plugin_name),
	    );


	    return $form_fields;
	}


	/**
	 * Save values of NSFW in media uploader
	 *
	 * @param $post array, the post data for database
	 * @param $attachment array, attachment fields from $_POST form
	 * @return $post array, modified post data
	 */

	public function be_attachment_field_nsfw_save( $post, $attachment ) {
	    if( isset( $attachment['nsfw'] ) ){
	    	update_post_meta( $post['ID'], 'nsfw', 1 );
			} else {
				delete_post_meta($post['ID'], 'nsfw');
			}


	    return $post;
	}

	/**
	 * Add a checkbox to the post
	 * @return string checkbox markup
	 */
	public function post_nsfw()
	{
		?>
		<div class="misc-pub-section nsfw">

			<?php wp_nonce_field( 'nsfw_save_post', 'nsfw_nonce' ); ?>

			<input type="checkbox" name="nsfw" id="nsfw" value="1" <?php checked( 1, get_post_meta( get_the_ID(), 'nsfw', true ) ); ?> />
			<label for="nsfw" class="selectit">
				<?php esc_html_e( 'Content is NSFW', $this->plugin_name ); ?>
			</label>

		</div>
		<?php
	}

	/**
	 * Save the "restrict" checkbox value.
	 *
	 * @since 0.1.0
	 *
	 * @param int $post_id The current post ID.
	 * @return void
	 */
	public function save_post( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$nonce = ( isset( $_POST['nsfw_nonce'] ) ) ? $_POST['nsfw_nonce'] : '';

		if ( ! wp_verify_nonce( $nonce, 'nsfw_save_post' ) ) {
			return;
		}

		if( isset( $_POST['nsfw'] ) ){
			 update_post_meta( $post_id, 'nsfw', 1 );
		 } else {
			 delete_post_meta( $post_id, 'nsfw' );
		 }

	}



}
