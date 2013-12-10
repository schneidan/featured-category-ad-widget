<?php
/*
Plugin Name: Featured Category Ad Widget
Plugin URI: 
Description: Based on BNS Featured Category Widget and esigned to create a Sponsored content block similar in style and design to the output of our modified BNS-Featured-Category widgets. Place widget second in "Main Lower" sidebar.
Version: 0.1
Author: Daniel J. Schneider for The Denver Post
Author URI:
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * BNS Featured Category WordPress plugin
 *
 * Based on BNS Featured Category Widget and esigned to create a Sponsored
 * content block similar in style and design to the output of our modified
 * BNS-Featured-Category widgets. Place widget second in "Main Lower" sidebar.
 *
 * @package     Featured Category Ad Widget
 * @link        https://github.com/Cais/bns-featured-category/
 * @version     0.1
 * @author      Daniel J. Schneider <dschneider@denverpost.com> with Edward Caissie
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @version 0.1
 * @date    December 2013
 * Created.
 */

class Featured_Category_Ad_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @package Featured_Category_Ad_Widget
     *
     * @class   WP_Widget
     * @uses    add_action
     * @uses    add_shortcode
     */
    function __construct() {
        /** Widget settings. */
        $widget_ops = array( 'classname' => 'featured-category-ad-widget', 'description' => __( 'Displays Sponsored content to match similar featured category widgets.', 'fc-ad' ) );

        /** Widget control settings. */
        $control_ops = array( 'width' => 200, 'id_base' => 'featured-category-ad-widget' );

        /** Create the widget. */
        $this->WP_Widget( 'featured-category-ad-widget', 'Featured Category Ad Widget', $widget_ops, $control_ops );

        /**
         * Check installed WordPress version for compatibility
         * @internal    Requires WordPress version 2.9
         * @internal    @uses current_theme_supports
         * @internal    @uses the_post_thumbnail
         * @internal    @uses has_post_thumbnail
         */
        global $wp_version;
        $exit_message = 'Featured Category Ad Widget requires WordPress version 2.9 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please Update!</a>';
        if ( version_compare( $wp_version, "2.9", "<" ) ) {
            exit ( $exit_message );
        } /** End if */

        /** Enqueue Scripts and Styles for front-facing views */
        add_action( 'wp_enqueue_scripts', array( $this, 'FCAD_Scripts_and_Styles' ) );

        /** Enqueue Widget Options Panel Scripts and Styles */
        add_action( 'admin_enqueue_scripts', array( $this, 'FCAD_Options_Scripts_and_Styles' ) );

        /** Add shortcode */
        add_shortcode( 'fcad', array( $this, 'fcad_shortcode' ) );

        /** Add widget */
        add_action( 'widgets_init', array( $this, 'load_fcad_widget' ) );

    } /** End function - construct */


    /**
     * Widget
     *
     * @package Featured_Category_Ad_Widget
     *
     * @class   WP_Query
     * @uses    apply_filters
     * @uses    category_description
     * @uses    current_theme_supports
     * @uses    get_category_link
     * @uses    get_option
     * @uses    get_the_author
     * @uses    get_the_category_list
     * @uses    get_the_ID
     * @uses    get_the_time
     * @uses    has_post_thumbnail
     * @uses    have_posts
     * @uses    is_single
     * @uses    post_class
     * @uses    post_password_required
     * @uses    the_permalink
     * @uses    the_post
     * @uses    the_post_thumbnail
     * @uses    wp_get_post_categories
     *
     * @param   array $args
     * @param   array $instance
     */
    function widget( $args, $instance ) {
        extract( $args );

        /** User-selected settings. */
        $show_count     = $instance['show_count'];
        $offset         = $instance['offset'];
        $sort_order     = $instance['sort_order'];
        /** Plugin requires counter variable to be part of its arguments?! */
        $count          = $instance['count'];

        /** @var    $before_widget  string - defined by theme */
        echo $before_widget;

        echo $before_title . '<span class="fcad-cat-class"></span><a href="<?php echo site_url(); ?>/sponsored/" rel="nofollow" title="More sponsored content">Sponsored</a>' . $after_title;

        ?>

        <div class="post type-post status-publish format-standard hentry category-sponsored">
                <div class="fcad-content">
                    <a href="<?php echo site_url(); ?>/sponsored/" rel="nofollow" title="Link to sponsored content" class="fcad-thumb-link">
                        <span class="fcad-thumb" style="background-image:url('<?php echo get_stylesheet_directory_uri() . '/images/sponsored-example.png'; ?>');"></span>
                    </a>
                    <h4>
                        <a href="<?php echo site_url(); ?>/sponsored/" rel="nofollow" title="Link to sponsored content">This is sponsored content down here in the category widgets, too.</a>
                    </h4>
                    <p>This is a little blurb about whatever it is in this here sponsored story. This is "advertorial" content that will complement our coverage of the topic at hand with value for readers but sponsored by an advertiser to help pay the bills.</p>
                    <ul>
                        <li class="post type-post status-publish format-standard hentry category-sponsored">
                            <div class="fcad-content">
                                <h5>
                                    <a href="<?php echo site_url(); ?>/sponsored/" rel="nofollow" title="Permanent Link to sponsored content">This is a second hed of sponsored content</a>
                                </h5>
                            </div> <!-- .fcad-content -->
                        </li> <!-- .post #post-ID -->
                        <li class="post type-post status-publish format-standard hentry category-sponsored">
                            <div class="fcad-content">
                                <h5>
                                    <a href="<?php echo site_url(); ?>/sponsored/" rel="nofollow" title="Permanent Link to sponsored content">This is a third hed of sponsored content</a>
                                </h5>
                            </div> <!-- .fcad-content -->
                        </li> <!-- .post #post-ID -->
                        <li class="post type-post status-publish format-standard hentry category-sponsored">
                            <div class="fcad-content">
                                <h5>
                                    <a href="<?php echo site_url(); ?>/sponsored/" rel="nofollow" title="Permanent Link to sponsored content">This is a fourth hed of sponsored content</a>
                                </h5>
                            </div> <!-- .fcad-content -->
                        </li> <!-- .post #post-ID -->
                    </ul>
                <div class="clear"></div>
            </div>
            </div>

        <?php

        /** @var $after_widget string - defined by theme */
        echo $after_widget;

    } /** End function - widget */


    /**
     * Update
     *
     * @param   array $new_instance
     * @param   array $old_instance
     *
     * @return  array
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /** Strip tags (if needed) and update the widget settings */
        $instance['show_count']     = $new_instance['show_count'];
        $instance['offset']         = $new_instance['offset'];
        $instance['sort_order']     = $new_instance['sort_order'];
        /** Added to reset count for every instance of the plugin */
        $instance['count']          = $new_instance['count'];

        return $instance;

    } /** End function - update */


    /**
     * Extend the `form` function
     *
     * @package Featured_Category_Ad_Widget
     * @since   0.1
     *
     * @param   $instance
     *
     * @uses    checked
     * @uses    current_theme_supports
     * @uses    get_field_id
     * @uses    get_field_name
     * @uses    selected
     * @uses    wp_parse_args
     *
     * @return string|void
     */
    function form( $instance ) {
        /** Set default widget settings */
        $defaults = array(
            'count'             => '0',
            'show_count'        => '3',
            'offset'            => '0',
            'sort_order'        => 'desc'
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>

        <table class="fcad-counts">
            <tr>
                <td>
                    <p>
                        <label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Items to Display:', 'fc-ad' ); ?></label>
                        <input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" style="width:85%;" />
                    </p>
                </td>
                <td>
                    <p>
                        <label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Items Offset:', 'fc-ad' ); ?></label>
                        <input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo $instance['offset']; ?>" style="width:85%;" />
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <label for="<?php echo $this->get_field_id( 'sort_order' ); ?>"><?php _e( 'Sort Order:', 'fc-ad' ); ?></label>
                        <select id="<?php echo $this->get_field_id( 'sort_order' ); ?>" name="<?php echo $this->get_field_name( 'sort_order' ); ?>" class="widefat">
                            <option <?php selected( 'asc', $instance['sort_order'], true ); ?>>asc</option>
                            <option <?php selected( 'desc', $instance['sort_order'], true ); ?>>desc</option>
                            <option <?php selected( 'rand', $instance['sort_order'], true ); ?>>rand</option>
                        </select>
                    </p>
                </td>
            </tr>
        </table><!-- End table -->

    <?php } /** End function - form */


    /**
     * Custom Excerpt
     *
     * Gets the default excerpt as a base line and returns either the excerpt as
     * is if there are less words than the custom value ($length). If there are
     * more words than $length the excess are removed. Otherwise, the amount of
     * words equal to $length are returned. In both cases, the returned text is
     * appended with a permalink to the full post. If there is no excerpt, no
     * additional permalink will be returned.
     *
     * @package Featured_Category_Ad_Widget
     * @since   0.1
     *
     * @param   int $length - user defined amount of words
     * @internal param string $text - the post content
     *
     * @uses    apply_filters
     * @uses    get_permalink
     * @uses    the_title_attribute
     *
     * @return  string
     */
    function custom_excerpt( $length = 55 ) {
        /** @var $text - holds default excerpt */
        $text = get_the_excerpt();
        /** @var $words - holds excerpt of $length words */
        $words = explode( ' ', $text, $length + 1 );
        /** @var $fcad_link - initialize as empty */
        $fcad_link = '';

        /** Create link to full post for end of custom length excerpt output */
        if ( ! empty( $text ) ) {
            $fcad_link = ' <strong>
                <a class="fcad-link" href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'Permalink to: ', 'fc-ad' ), 'after' => '', 'echo' => false ) ) . '">'
                    . apply_filters( 'fcad_link', '&infin;' ) .
                '</a>
            </strong>';
        } /** End if - not empty text */

        /** Check if $length has a value; or, the total words is less than the $length */
        if ( ( ! $length ) || ( count( $words ) < $length ) ) {
            $text .= $fcad_link;
            return $text;
        } else {
            array_pop( $words );
            array_push( $words, '...' );
            $text = implode( ' ', $words );
        } /** End if */

        $text .= $fcad_link;

        return $text;

    } /** End function - custom excerpt */


    /**
     * Enqueue Plugin Scripts and Styles
     *
     * Adds plugin stylesheet and allows for custom stylesheet to be added by end-user.
     *
     * @package Featured_Category_Ad_Widget
     * @since   0.1
     *
     * @uses    get_plugin_data
     * @uses    plugin_dir_path
     * @uses    plugin_dir_url
     * @uses    wp_enqueue_style
     *
     * @internal Used with action: wp_enqueue_scripts
     */
    function FCAD_Scripts_and_Styles() {
        /** Call the wp-admin plugin code */
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        /** @var $fcad_data - holds the plugin header data */
        $fcad_data = get_plugin_data( __FILE__ );

        /** Enqueue Scripts */
        /** Enqueue Style Sheets */
        wp_enqueue_style( 'fcad-Style', plugin_dir_url( __FILE__ ) . 'fcad-style.css', array(), $fcad_data['Version'], 'screen' );
        if ( is_readable( plugin_dir_path( __FILE__ ) . 'fcad-custom-style.css' ) ) {
            wp_enqueue_style( 'fcad-Custom-Style', plugin_dir_url( __FILE__ ) . 'fcad-custom-style.css', array(), $fcad_data['Version'], 'screen' );
        } /** End if - is readable */

    } /** End function - scripts and styles */


    /**
     * Enqueue Options Plugin Scripts and Styles
     *
     * Add plugin options scripts and stylesheet(s) to be used only on the
     * Administration Panels
     *
     * @package Featured_Category_Ad_Widget
     * @since   2.0
     *
     * @uses    plugin_dir_path
     * @uses    plugin_dir_url
     * @uses    wp_enqueue_script
     * @uses    wp_enqueue_style
     *
     * @internal Used with action: admin_enqueue_scripts
     *
     * @version 2.4
     * @date    January 31, 2013
     * Added dynamic version to enqueue parameters
     */
    function FCAD_Options_Scripts_and_Styles() {
        /** Call the wp-admin plugin code */
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        /** @var $fcad_data - holds the plugin header data */
        $fcad_data = get_plugin_data( __FILE__ );

        /** Enqueue Options Scripts; 'jQuery' is enqueued as a dependency */
        wp_enqueue_script( 'fcad-options', plugin_dir_url( __FILE__ ) . 'fcad-options.js', array( 'jquery' ), $fcad_data['Version'] );

        /** Enqueue Options Style Sheets */
        wp_enqueue_style( 'FCAD-Option-Style', plugin_dir_url( __FILE__ ) . 'fcad-option-style.css', array(), $fcad_data['Version'], 'screen' );
        if ( is_readable( plugin_dir_path( __FILE__ ) . 'fcad-options-custom-style.css' ) ) {
            wp_enqueue_style( 'FCAD-Options-Custom-Style', plugin_dir_url( __FILE__ ) . 'fcad-options-custom-style.css', array(), $fcad_data['Version'], 'screen' );
        } /** End if - is readable */

    } /** End function - options scripts and styles */


    /**
     * Load FCAD Widget
     * Register widget to be used in the widget init hook
     *
     * @package Featured_Category_Ad_Widget
     *
     * @uses    register_widget
     */
    function load_fcad_widget() {
        register_widget( 'Featured_Category_Ad_Widget' );
    } /** End function - load fcad widget */


    /**
     * FCAD Shortcode
     *
     * @package Featured_Category_Ad_Widget
     * @since   0.1
     *
     * @param   $atts
     *
     * @uses    shortcode_atts
     * @uses    the_widget
     *
     * @internal Do NOT set 'show_full=true' it will create a recursive loop and crash
     * @internal Note 'content_thumb' although available has no use if 'show_full=false'
     * @internal Used with `add_shortcode`
     *
     * @return  string
     */
    function fcad_shortcode( $atts ) {
        /** Get ready to capture the elusive widget output */
        ob_start();

        the_widget( 'Featured_Category_Ad_Widget',
            $instance = shortcode_atts( array(
                'count'             => '0',
                'show_count'        => '3',
                'offset'            => '0',
                'sort_order'        => 'DESC'
            ), $atts, 'fcad' ),
            $args = array(
                /** clear variables defined by theme for widgets */
                $before_widget  = '',
                $after_widget   = '',
                $before_title   = '',
                $after_title    = '',
            )
        );

        /** Get the_widget output and put into its own container */
        $fcad_content = ob_get_clean();

        return $fcad_content;

    } /** End function - shortcode */


} /** End class extension */


/** @var $fcad - instantiate the class */
$fcad = new Featured_Category_Ad_Widget();


/**
 * FCAD Plugin Meta
 * Adds additional links to plugin meta links
 *
 * @package Featured_Category_Ad_Widget
 * @since   0.1
 *
 * @uses    __
 * @uses    plugin_basename
 *
 * @param   $links
 * @param   $file
 *
 * @return  array $links
 */
function fcad_plugin_meta( $links, $file ) {

    $plugin_file = plugin_basename( __FILE__ );

    if ( $file == $plugin_file ) {

        $links[] = '<a href="https://github.com/Cais/BNS-Featured-Category">' . __( 'Fork on Github', 'fc-ad' ) . '</a>';

    } /** End if - file is the same as plugin */

    return $links;

} /** End function - plugin meta */

/** Add Plugin Row Meta details */
add_filter( 'plugin_row_meta', 'fcad_plugin_meta', 10, 2 );