<?php

/**
 * dt_training_page class for the admin page
 *
 * @class dt_training_page
 * @version	1.0.0
 * @since 1.0.0
 * @package	DRM_Plugin
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class dt_training_page {

    /**
     * dt_training_page The single instance of dt_training_page.
     * @var 	object
     * @access  private
     * @since 	1.0.0
     */
    private static $_instance = null;

    public $p2p_array = array();

    /**
     * dt_training_page Instance
     *
     * Ensures only one instance of dt_training_page is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return dt_training_page instance
     */
    public static function instance () {
        if ( is_null( self::$_instance ) )
            self::$_instance = new self();
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  portal
     * @since   1.0.0
     */
    public function __construct () {

        add_action("admin_menu", array($this, "add_dtsample_data_menu") );

    } // End __construct()

    /**
     * Loads the subnav page
     * @since 0.1
     */
    public function add_dtsample_data_menu () {
        add_submenu_page( 'tools.php', __( 'Training (DT)', 'dt_training' ), __( 'Training (DT)', 'dt_training' ), 'manage_options', 'dt_training', array( $this, 'dt_training_data_page' ) );
    }

    /**
     * Builds the tab bar
     * @since 0.1
     */
    public function dt_training_data_page() {


        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        /**
         * Begin Header & Tab Bar
         */
        if (isset($_GET["tab"])) {$tab = $_GET["tab"];} else {$tab = 'records';}

        $tab_link_pre = '<a href="tools.php?page=dt_training&tab=';
        $tab_link_post = '" class="nav-tab ';

        $html = '<div class="wrap">
            <h2>DISCIPLE TOOLS - TRAINING</h2>
            <h2 class="nav-tab-wrapper">';

        $html .= $tab_link_pre . 'records' . $tab_link_post;
        if ($tab == 'records' || !isset($tab) ) {$html .= 'nav-tab-active';}
        $html .= '">Starter Data</a>';

        $html .= $tab_link_pre . 'report' . $tab_link_post;
        if ($tab == 'report') {$html .= 'nav-tab-active';}
        $html .= '">Add Reports</a>';

        $html .= $tab_link_pre . 'tutorials' . $tab_link_post;
        if ($tab == 'tutorials') {$html .= 'nav-tab-active';}
        $html .= '">Tutorials</a>';


        $html .= '</h2>';

        echo $html;

        $html = '';
        // End Tab Bar

        /**
         * Begin Page Content
         */
        switch ($tab) {

            case "tutorials":
                    $html .= dt_training_plugin()->tutorials->dt_tabs_tutorial_content();
                break;
            case "report":
                $html .= dt_training_plugin()->add_report->add_report_page_form ();
                break;
            default:
                $html .= dt_training_plugin()->add_records->dt_training_add_records_content() ;
        }

        $html .= '</div>'; // end div class wrap

        echo $html;
    }
}