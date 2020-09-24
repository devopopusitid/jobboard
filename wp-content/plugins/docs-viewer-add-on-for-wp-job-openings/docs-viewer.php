<?php
/*
Plugin Name: Docs Viewer Add-On for WP Job Openings
Plugin URI: https://wordpress.org/plugins/docs-viewer-add-on-for-wp-job-openings/
Description: Docs Viewer is an add-on for WP Job Openings plugin. This plugin allows you to view the applicant resume from admin panel.
Author: AWSM Innovations
Author URI: https://awsm.in/
Version: 1.0
Licence :GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text domain : docs-viewer-add-on-for-wp-job-openings
Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! defined( 'AWSM_JOBS_MAIN_PLUGIN' ) ) {
    define( 'AWSM_JOBS_MAIN_PLUGIN', 'wp-job-openings/wp-job-openings.php' );
}

class AWSM_Job_Openings_Docs_Viewer {
    private static $_instance = null;

    public static function init() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
        add_action( 'admin_init', array( $this, 'handle_plugin_activation' ) );
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'docs-viewer-add-on-for-wp-job-openings', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    public function register_meta_boxes() {
        add_meta_box( 'awsm-jobs-resume-viewer', esc_html__( 'Resume Preview', 'docs-viewer-add-on-for-wp-job-openings' ), array( $this, 'docs_viewer_handle' ), 'awsm_job_application', 'advanced', 'low' );
    }

    public function docs_viewer_handle(){
        $awsm_application_id = get_post_meta( get_the_ID(), 'awsm_attachment_id', true );
        $attachment_url = wp_get_attachment_url( intval( $awsm_application_id ) );
        if ( $attachment_url ) :
        ?>
            <iframe src="<?php echo esc_url( 'https://docs.google.com/viewer?embedded=true&url=' . $attachment_url ); ?>" style="width: 100%; height: 400px; border: none;">
            </iframe>
         <?php
        else :
         ?>
            <div class="awsm-resume-none">
                <h2><strong><?php esc_html_e( 'No resume to preview. File not found!', 'docs-viewer-add-on-for-wp-job-openings' ); ?></strong></h2>
            </div>
        <?php
        endif;
    }

    public function get_main_plugin_activation_link() {
        $content = $link_action = $action_url = $link_class = '';
        $plugin_arr = explode( '/', esc_html( AWSM_JOBS_MAIN_PLUGIN ) );
        $plugin_slug = $plugin_arr[0];
        $installed_plugin = get_plugins( '/' . $plugin_slug );
        if ( empty( $installed_plugin ) ) {
            if ( get_filesystem_method( array(), WP_PLUGIN_DIR ) === 'direct' ) {
                $link_action = esc_html__( 'Install', 'docs-viewer-add-on-for-wp-job-openings' );
                $action_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin_slug ), 'install-plugin_' . $plugin_slug );
                $link_class = ' install-now';
            }
        } else {
            if( is_plugin_inactive( AWSM_JOBS_MAIN_PLUGIN ) ) {
                $link_action = esc_html__( 'Activate', 'docs-viewer-add-on-for-wp-job-openings' );
                $action_url = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=' . AWSM_JOBS_MAIN_PLUGIN ), 'activate-plugin_' . AWSM_JOBS_MAIN_PLUGIN );
                $link_class = ' activate-now';
            }
        }
        if( ! empty( $link_action ) ) {
            $content = sprintf( '<a href="%2$s" class="button button-small%3$s">%1$s</a>', $link_action, esc_url( $action_url ), esc_attr( $link_class ) );
        }
        return $content;
    }

    public function handle_plugin_activation(){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( is_plugin_inactive( AWSM_JOBS_MAIN_PLUGIN ) || ! class_exists( 'AWSM_Job_Openings' ) ) {
                if( isset( $_GET['action'] ) ) {
                    if( $_GET['action'] == 'install-plugin' ) {
                        return;
                    }
                }
                if( ! current_user_can( 'install_plugins' ) ) {
                    return;
                }
                add_action( 'admin_notices', function() {
        ?>
            <div class="updated error">
                <p>
                    <?php
                        printf( esc_html__( 'The plugin %2$s needs the plugin %1$s active. %4$s Please %3$s %1$s', 'docs-viewer-add-on-for-wp-job-openings' ), '<strong>"WP Job Openings"</strong>', '<strong>"Docs Viewer Add-On for WP Job Openings"</strong>', $this->get_main_plugin_activation_link(), '<br />' );
                    ?>
                </p>
            </div>
        <?php
            });
        }
    }
}
add_action( 'plugins_loaded', 'AWSM_Job_Openings_Docs_Viewer::init' );