

<?php 
if(isset($_POST['id']))
{
    global $wpdb;
  $table='wp_posts';
  $id = $_POST['id'];
  $wpdb->delete( $table, array( 'ID' => $id ) );
   $table='wp_postmeta'; 
  $wpdb->delete( $table, array( 'post_id' => $id ) ); 
}
?>
<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'UM_Functions' ) ) {


	/**
	 * Class UM_Functions
	 */
	class UM_Functions {


		/**
		 * UM_Functions constructor.
		 */
		function __construct() {
		}


		/**
		 * Check frontend nonce
		 *
		 * @param bool $action
		 */
		function check_ajax_nonce( $action = false ) {
			$nonce = isset( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : '';
			$action = empty( $action ) ? 'um-frontend-nonce' : $action;

			if ( ! wp_verify_nonce( $nonce, $action ) ) {
				wp_send_json_error( esc_js( __( 'Wrong Nonce', 'ultimate-member' ) ) );
			}
		}


		/**
		 * What type of request is this?
		 *
		 * @param string $type String containing name of request type (ajax, frontend, cron or admin)
		 *
		 * @return bool
		 */
		public function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}

			return false;
		}


		/**
		 * Help Tip displaying
		 *
		 * Function for render/displaying UltimateMember help tip
		 *
		 * @since  2.0.0
		 *
		 * @param string $tip Help tip text
		 * @param bool $allow_html Allow sanitized HTML if true or escape
		 * @param bool $echo Return HTML or echo
		 * @return string
		 */
		function tooltip( $tip, $allow_html = false, $echo = true ) {
			if ( $allow_html ) {

				$tip = htmlspecialchars( wp_kses( html_entity_decode( $tip ), array(
					'br'     => array(),
					'em'     => array(),
					'strong' => array(),
					'small'  => array(),
					'span'   => array(),
					'ul'     => array(),
					'li'     => array(),
					'ol'     => array(),
					'p'      => array(),
				) ) );

			} else {
				$tip = esc_attr( $tip );
			}

			ob_start(); ?>

			<span class="um_tooltip dashicons dashicons-editor-help" title="<?php echo $tip ?>"></span>

			<?php if ( $echo ) {
				ob_get_flush();
				return '';
			} else {
				return ob_get_clean();
			}

		}


		/**
		 * @return mixed|void
		 */
		function excluded_taxonomies() {
			$taxes = array(
				'nav_menu',
				'link_category',
				'post_format',
			);

			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_excluded_taxonomies
			 * @description Exclude taxonomies for UM
			 * @input_vars
			 * [{"var":"$taxes","type":"array","desc":"Taxonomies keys"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'um_excluded_taxonomies', 'function_name', 10, 1 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'um_excluded_taxonomies', 'my_excluded_taxonomies', 10, 1 );
			 * function my_excluded_taxonomies( $taxes ) {
			 *     // your code here
			 *     return $taxes;
			 * }
			 * ?>
			 */
			return apply_filters( 'um_excluded_taxonomies', $taxes );
		}


		/**
		 * Output templates
		 *
		 * @access public
		 * @param string $template_name
		 * @param string $basename (default: '')
		 * @param array $t_args (default: array())
		 * @param bool $echo
		 *
		 * @return string|void
		 */
		function get_template( $template_name, $basename = '', $t_args = array(), $echo = false ) {
			if ( ! empty( $t_args ) && is_array( $t_args ) ) {
				extract( $t_args );
			}

			$path = '';
			if( $basename ) {
				$array = explode( '/', trim( $basename, '/' ) );
				$path  = $array[0];
			}

			$located = $this->locate_template( $template_name, $path );
			if ( ! file_exists( $located ) ) {
				_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
				return;
			}


			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_get_template
			 * @description Change template location
			 * @input_vars
			 * [{"var":"$located","type":"string","desc":"template Located"},
			 * {"var":"$template_name","type":"string","desc":"Template Name"},
			 * {"var":"$path","type":"string","desc":"Template Path at server"},
			 * {"var":"$t_args","type":"array","desc":"Template Arguments"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_get_template', 'function_name', 10, 4 );
			 * @example
			 * <?php
			 * add_filter( 'um_get_template', 'my_get_template', 10, 4 );
			 * function my_get_template( $located, $template_name, $path, $t_args ) {
			 *     // your code here
			 *     return $located;
			 * }
			 * ?>
			 */
			$located = apply_filters( 'um_get_template', $located, $template_name, $path, $t_args );

			ob_start();

			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_before_template_part
			 * @description Make some action before include template file
			 * @input_vars
			 * [{"var":"$template_name","type":"string","desc":"Template Name"},
			 * {"var":"$path","type":"string","desc":"Template Path at server"},
			 * {"var":"$located","type":"string","desc":"template Located"},
			 * {"var":"$t_args","type":"array","desc":"Template Arguments"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_before_template_part', 'function_name', 10, 4 );
			 * @example
			 * <?php
			 * add_action( 'um_before_template_part', 'my_before_template_part', 10, 4 );
			 * function my_before_template_part( $template_name, $path, $located, $t_args ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( 'um_before_template_part', $template_name, $path, $located, $t_args );
			include( $located );

			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_after_template_part
			 * @description Make some action after include template file
			 * @input_vars
			 * [{"var":"$template_name","type":"string","desc":"Template Name"},
			 * {"var":"$path","type":"string","desc":"Template Path at server"},
			 * {"var":"$located","type":"string","desc":"template Located"},
			 * {"var":"$t_args","type":"array","desc":"Template Arguments"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_after_template_part', 'function_name', 10, 4 );
			 * @example
			 * <?php
			 * add_action( 'um_after_template_part', 'my_after_template_part', 10, 4 );
			 * function my_after_template_part( $template_name, $path, $located, $t_args ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( 'um_after_template_part', $template_name, $path, $located, $t_args );
			$html = ob_get_clean();

			if ( ! $echo ) {
				return $html;
			} else {
				echo $html;
				return;
			}
		}


		/**
		 * Locate a template and return the path for inclusion.
		 *
		 * @access public
		 * @param string $template_name
		 * @param string $path (default: '')
		 * @return string
		 */
		function locate_template( $template_name, $path = '' ) {
			// check if there is template at theme folder
			$template = locate_template( array(
				trailingslashit( 'ultimate-member/' . $path ) . $template_name
			) );

			if( !$template ) {
				if( $path ) {
					$template = trailingslashit( trailingslashit( WP_PLUGIN_DIR ) . $path );
				} else {
					$template = trailingslashit( um_path );
				}
				$template .= 'templates/' . $template_name;
			}


			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_locate_template
			 * @description Change template locate
			 * @input_vars
			 * [{"var":"$template","type":"string","desc":"Template locate"},
			 * {"var":"$template_name","type":"string","desc":"Template Name"},
			 * {"var":"$path","type":"string","desc":"Template Path at server"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_locate_template', 'function_name', 10, 3 );
			 * @example
			 * <?php
			 * add_filter( 'um_locate_template', 'my_locate_template', 10, 3 );
			 * function my_locate_template( $template, $template_name, $path ) {
			 *     // your code here
			 *     return $template;
			 * }
			 * ?>
			 */
			return apply_filters( 'um_locate_template', $template, $template_name, $path );
		}


		/**
		 * @return mixed|void
		 */
		function cpt_list() {
			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_cpt_list
			 * @description Extend UM Custom Post Types
			 * @input_vars
			 * [{"var":"$list","type":"array","desc":"Custom Post Types list"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'um_cpt_list', 'function_name', 10, 1 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'um_cpt_list', 'my_cpt_list', 10, 1 );
			 * function my_admin_pending_queue( $list ) {
			 *     // your code here
			 *     return $list;
			 * }
			 * ?>
			 */
			$cpt = apply_filters( 'um_cpt_list', array( 'um_form', 'um_directory' ) );
			return $cpt;
		}
		
		
		
		
		
		
		
		
		
		
		
		
	}
}





function retrieve_orders_ids_from_a_product_id( $product_id ) {
    global $wpdb;

    // Define HERE the orders status to include in  <==  <==  <==  <==  <==  <==  <==
    $orders_statuses = "'wc-completed', 'wc-processing', 'wc-on-hold'";

    # Requesting All defined statuses Orders IDs for a defined product ID
    $orders_ids = $wpdb->get_col( "
        SELECT DISTINCT woi.order_id
        FROM {$wpdb->prefix}woocommerce_order_itemmeta as woim, 
             {$wpdb->prefix}woocommerce_order_items as woi, 
             {$wpdb->prefix}posts as p
        WHERE  woi.order_item_id = woim.order_item_id
        AND woi.order_id = p.ID
        AND p.post_status IN ( $orders_statuses )
        AND woim.meta_key LIKE '_product_id'
        AND woim.meta_value LIKE '$product_id'
        ORDER BY woi.order_item_id DESC"
    );
    // Return an array of Orders IDs for the given product ID
    return $orders_ids;
}















function showExtraFields()
{
global $current_user;


	$custom_fields = [
	
		"Address_Line_1" => "Address Line 1",
		"Address_Line_2" => "Address Line 2",
		"City"=>"City",
		"State"=>"State",
		"Zip"=>"Zip",
		"License_Info"=>"License_Info"
		
	
	];


	foreach ($custom_fields as $key => $value) {

		$fields[ $key ] = array(
				'title' => $value,
				'metakey' => $key,
				'type' => 'select',
				'label' => $value,
		);


		apply_filters('um_account_secure_fields', $fields, 'general' );

		$field_value = get_user_meta(um_user('ID'), $key, true) ? : '';
		

		$html = '<div class="um-field um-field-'.$key.'" data-key="'.$key.'">
		<div class="um-field-label">
		<label for="'.$key.'">'.$value.'</label>
		<div class="um-clear"></div>
		</div>
		<div class="um-field-area">
		<input class="um-form-field valid "
		type="text" name="'.$key.'"
		id="'.$key.'" value="'.$field_value.'"
		placeholder=""
		data-validate="" data-key="'.$key.'">
		</div>
		</div>';

		echo $html; 

	}
}









                add_action('um_after_account_general', 'showExtraFields', 100);              
                            
                            
                       

function getUMFormData(){
  $id = um_user('ID');
  $names = array('Address_Line_1', 'Address_Line_2','City','State','Zip','License_Info');

  foreach( $names as $name )
    update_user_meta( $id, $name, $_POST[$name] );
}  
                            

   add_action('um_account_pre_update_profile', 'getUMFormData', 100);






add_filter('um_account_page_default_tabs_hook', 'my_custom_tab_in_um', 100 );
function my_custom_tab_in_um( $tabs ) {
	$tabs[800]['mytab']['icon'] = 'um-faicon-pencil';
	$tabs[800]['mytab']['title'] = 'Input Menus';
	$tabs[800]['mytab']['custom'] = true;
	return $tabs;
}
	
/* make our new tab hookable */

add_action('um_account_tab__mytab', 'um_account_tab__mytab');
function um_account_tab__mytab( $info ) {
	global $ultimatemember;
	extract( $info );

	$output = $ultimatemember->account->get_tab_output('menus');
	if ( $output ) { echo $output; }
}

/* Finally we add some content in the tab */

add_filter('um_account_content_hook_mytab', 'um_account_content_hook_menus');
function um_account_content_hook_menus( $output ){
	ob_start();
	
        include(get_theme_root().'/porto-child/input_menus.php'); 
     	
        $output = ob_get_contents();
	ob_end_clean();
	return $output;
}


	


	
