<?php
/**
 * Plugin Name: Team Members
 * Plugin URI: http://wpdarko.com/team-members/
 * Description: A responsive, simple and clean way to display your team. Create new members, add their positions, bios, social links and copy-paste the shortcode into any post/page. Find support and information on the <a href="http://wpdarko.com/team-members/">plugin's page</a>. This free version is NOT limited and does not contain any ad. Check out the <a href='http://wpdarko.com/team-members-pro/'>PRO version</a> for more great features.
 * Version: 1.3
 * Author: WP Darko
 * Author URI: http://wpdarko.com
 * License: GPL2
 */

function tmm_free_pro_check() {
    if (is_plugin_active('team-members-pro/tmm-pro.php')) {
        
        function my_admin_notice(){
        echo '<div class="updated">
                <p><strong>PRO</strong> version is activated.</p>
              </div>';
        }
        add_action('admin_notices', 'my_admin_notice');
        
        deactivate_plugins(__FILE__);
    }
}

add_action( 'admin_init', 'tmm_free_pro_check' );

/* adds stylesheet and script */
add_action( 'wp_enqueue_scripts', 'add_tmm_scripts' );
function add_tmm_scripts() {
	wp_enqueue_style( 'tmm', plugins_url('css/tmm_custom_style.min.css', __FILE__));
}

add_action( 'init', 'create_tmm_type' );

function create_tmm_type() {
  register_post_type( 'tmm',
    array(
      'labels' => array(
        'name' => 'Teams',
        'singular_name' => 'Team'
      ),
      'public' => true,
      'has_archive'  => false,
      'hierarchical' => false,
         'capabilities' => array(
    'edit_post'          => 'update_core',
    'read_post'          => 'update_core',
    'delete_post'        => 'update_core',
    'edit_posts'         => 'update_core',
    'edit_others_posts'  => 'update_core',
    'publish_posts'      => 'update_core',
    'read_private_posts' => 'update_core'
),
      'supports'     => array( 'title' ),
      'menu_icon'    => 'dashicons-plus',
    )
  );
}

/**
* Define the metabox and field configurations.
*
* @param array $meta_boxes
* @return array
*/
function tmm_metaboxes( array $meta_boxes ) {
    $fields = array(
        array( 'id' => 'tmm_content_head', 'name' => 'Staff details', 'type' => 'title' ),
        array( 'id' => 'tmm_firstname', 'name' => 'Firstname', 'type' => 'text', 'cols' => 4 ),
        array( 'id' => 'tmm_lastname', 'name' => 'Lastname', 'type' => 'text', 'cols' => 4),
        array( 'id' => 'tmm_job', 'name' => 'Job/role', 'type' => 'text', 'cols' => 4),
        array( 'id'   => 'tmm_photo', 'name' => 'Photo', 'type' => 'image', 'cols' => 3),
        array( 'id' => 'tmm_desc', 'name' => 'Description/bio', 'type' => 'textarea', 'rows' => 8, 'cols' => 9),
        array( 'id' => 'tmm_links_head', 'name' => 'Links', 'type' => 'title' ),
        array( 
            'id'      => 'tmm_sc_type1',  
            'type'    => 'select',
            'desc' => 'Icon',
            'cols' => 3,
            'options' => array(
                'nada' => '-',
                'twitter' => 'Twitter',
                'linkedin' => 'LinkedIn',
                'googleplus' => 'Google+',
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'tumblr' => 'Tumblr',
                'pinterest' => 'Pinterest',
                'website' => 'Website',
                'customlink' => 'Other links',
            )
        ),
        array( 'id' => 'tmm_sc_title1',  'desc' => 'Title', 'type' => 'text', 'cols' => 4),
        array( 'id' => 'tmm_sc_url1',  'default' => 'http://', 'desc' => 'URL', 'type' => 'text', 'cols' => 5),
        array( 
            'id'      => 'tmm_sc_type2', 
            'type'    => 'select',
            'cols' => 3,
            'options' => array(
                'nada' => '-',
                'twitter' => 'Twitter',
                'linkedin' => 'LinkedIn',
                'googleplus' => 'Google+',
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'tumblr' => 'Tumblr',
                'pinterest' => 'Pinterest',
                'website' => 'Website',
                'customlink' => 'Other links',
            )
        ),
        array( 'id' => 'tmm_sc_title2', 'type' => 'text', 'cols' => 4),
        array( 'id' => 'tmm_sc_url2', 'default' => 'http://', 'type' => 'text', 'cols' => 5),
        array( 
            'id'      => 'tmm_sc_type3',  
            'type'    => 'select',
            'cols' => 3,
            'options' => array(
                'nada' => '-',
                'twitter' => 'Twitter',
                'linkedin' => 'LinkedIn',
                'googleplus' => 'Google+',
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'tumblr' => 'Tumblr',
                'pinterest' => 'Pinterest',
                'website' => 'Website',
                'customlink' => 'Other links',
            )
        ),
        array( 'id' => 'tmm_sc_title3', 'type' => 'text', 'cols' => 4),
        array( 'id' => 'tmm_sc_url3', 'default' => 'http://', 'type' => 'text', 'cols' => 5),
    );
    
    $group_settings = array(
        array( 'id' => 'tmm_columns', 'name' => 'Number of columns', 'type' => 'text', 'desc' => 'Number of members to show per line.' ),
        array( 'id' => 'tmm_color', 'name' => 'Main color', 'type' => 'colorpicker', 'default' => '#57c9e0' ),
        array( 
            'id'      => 'tmm_columns',  
            'type'    => 'select',
            'desc' => 'Number of members to show per line.',
            'options' => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
            )
        ),
    );
    // Example of repeatable group. Using all fields.
    // For this example, copy fields from $fields, update I
    $group_fields = $fields;
    foreach ( $group_fields as &$field ) {
        $field['id'] = str_replace( 'field', 'gfield', $field['id'] );
    }
    $meta_boxes[] = array(
        'title' => 'Create/remove/sort team members',
        'pages' => 'tmm',
        'fields' => array(
            array(
                'id' => 'tmm_head',
                'type' => 'group',
                'repeatable' => true,
                'sortable' => true,
                'fields' => $group_fields,
                'desc' => 'Create new members here and drag and drop to reorder.',
            )
        )
    );
    $meta_boxes[] = array(
        'title' => 'Settings',
        'pages' => 'tmm',
        'context' => 'side',
        'priority' => 'high',
        'fields' => array(
            array(
                'id' => 'tmm_settings_head',
                'type' => 'group',
                'fields' => $group_settings,
            )
        )
    );
    
    
    function tmm_pro_side_meta() {
        return "<p style='font-size:14px; color:#333; font-style:normal;'>This free version is <strong>NOT</strong> limited and does <strong>not</strong> contain any ad. Check out the <a href='http://wpdarko.com/items/team-members-pro/'><span style='color:#61d1aa !important;'>PRO version</span></a> for more great features.</p>";
    }
    
     $meta_boxes[] = array(
        'title' => 'Meet The Team PRO',
        'pages' => 'tmm',
        'context' => 'side',
        'priority' => 'low',
        'fields' => array(
            array(
                'id' => 'tmm_pro_head',
                'type' => 'group',
                'desc' => tmm_pro_side_meta(),
            )
        )
    );
    
    return $meta_boxes;
}
add_filter( 'drkfr_meta_boxes', 'tmm_metaboxes' );

if (!class_exists('drkfr_Meta_Box')) {
    require_once( 'drkfr/custom-meta-boxes.php' );
}

//shortcode columns
add_action( 'manage_tmm_posts_custom_column' , 'dktmm_custom_columns', 10, 2 );

function dktmm_custom_columns( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$slug = '' ;
		$slug = $post->post_name;
   
    
    	    $shortcode = '<span style="border: solid 3px lightgray; background:white; padding:7px; font-size:17px; line-height:40px;">[tmm name="'.$slug.'"]</strong>';
	    echo $shortcode; 
	    break;
    }
}

function add_tmm_columns($columns) {
    return array_merge($columns, 
              array('shortcode' => __('Shortcode'),
                    ));
}
add_filter('manage_tmm_posts_columns' , 'add_tmm_columns');

//tmm shortcode
function tmm_sc($atts) {
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));
	
    query_posts( array( 'post_type' => 'tmm', 'name' => $name, ) );
    if ( have_posts() ) : while ( have_posts() ) : the_post();

    global $post;
    
	$members = get_post_meta( get_the_id(), 'tmm_head', false );
    $options = get_post_meta( get_the_id(), 'tmm_settings_head', false );
  
    foreach ($options as $key => $option) {
        $tmm_columns = $option['tmm_columns'];
        $tmm_color = $option['tmm_color'];
    }

    $output .= '<div class="tmm tmm_'.$name.'">';
    $output .= '<div class="tmm_'.$tmm_columns.'_columns">';
    $output .= '
        <div class="tmm_wrap">
                ';
                
                $i = 0;
    
                foreach ($members as $key => $member) {
            
                    if($i%$tmm_columns == 0) {
                        if($i > 0) { 
                            $output .= "</div>";
                            $output .= '<div class="clearer"></div>';
                        } // close div if it's not the first
                        
                        
                        $output .= "<div class='tmm_container'>";
                    }
                    
                    $output .= '<div class="tmm_member" style="border-top:'.$tmm_color.' solid 5px;">';
                        $output .= wp_get_attachment_image( $member['tmm_photo'] );
                        $output .= '<div class="tmm_textblock">';
                            $output .= '<div class="tmm_names">';
                                $output .= '<span class="tmm_fname">'.$member['tmm_firstname'].'</span>';
                                $output .= '&nbsp;';
                                $output .= '<span class="tmm_lname">'.$member['tmm_lastname'].'</span>';
                            $output .= '</div>';
                            $output .= '<div class="tmm_job">'.$member['tmm_job'].'</div>';
                            $output .= '<div class="tmm_desc">'.$member['tmm_desc'].'</div>';
                            $output .= '<div class="tmm_scblock">';
                            if ($member['tmm_sc_type1'] != 'nada') {
                                $output .= '<a class="tmm_sociallink" href="'.$member['tmm_sc_url1'].'" title="'.$member['tmm_sc_title1'].'">';
                                $output .= '<img src="'.plugins_url('img/links/', __FILE__).$member['tmm_sc_type1'].'.png"/>';
                                $output .= '</a>';
                            }
                    
                            if ($member['tmm_sc_type2'] != 'nada') {
                                $output .= '<a class="tmm_sociallink" href="'.$member['tmm_sc_url2'].'" title="'.$member['tmm_sc_title2'].'">';
                                $output .= '<img src="'.plugins_url('img/links/', __FILE__).$member['tmm_sc_type2'].'.png"/>';
                                $output .= '</a>';
                            }
                            
                            if ($member['tmm_sc_type3'] != 'nada') {
                                $output .= '<a class="tmm_sociallink" href="'.$member['tmm_sc_url3'].'" title="'.$member['tmm_sc_title3'].'">';
                                $output .= '<img src="'.plugins_url('img/links/', __FILE__).$member['tmm_sc_type3'].'.png"/>';
                                $output .= '</a>';
                            }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    
                    $pages_count = count( $members );
                    if ($key == $pages_count - 1) {
                        $output .= '<div class="clearer"></div>';
                    }
                    
                    $i++;
                    
                }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
   

  endwhile; endif; wp_reset_query(); 
	
  return $output;

}
add_shortcode("tmm", "tmm_sc"); 

?>