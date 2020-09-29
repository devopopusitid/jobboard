<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class HMW_Controllers_Widget extends HMW_Classes_FrontController {

    public $riskreport = array();
    public $risktasks;

    public function dashboard() {
        $this->risktasks = HMW_Classes_ObjController::getClass('HMW_Controllers_SecurityCheck')->getRiskTasks();
        $this->riskreport =HMW_Classes_ObjController::getClass('HMW_Controllers_SecurityCheck')->getRiskReport();

	    //Show Hide My WP Offer
	    if ( HMW_Classes_Tools::getOption( 'hmw_mode' ) == 'lite' && date('d') >= 15 && date('d') <= 31) {
		    echo HMW_Classes_Error::showError( sprintf( __( '%sLimited Time Offer%s: Get %s65%% OFF%s today on Hide My WP Ghost 5 Websites License. %sHurry Up!%s', _HMW_PLUGIN_NAME_ ), '<a href="https://wpplugins.tips/buy/5_websites_special" target="_blank" style="font-weight: bold"><strong style="color: red">', '</strong></a>', '<a href="https://wpplugins.tips/buy/5_websites_special" target="_blank" style="font-weight: bold"><strong style="color: red">', '</strong></a>', '<a href="https://wpplugins.tips/buy/5_websites_special" target="_blank" style="font-weight: bold">', '</a>' ) );
	    }

	    echo '<script>var hmwQuery = {"ajaxurl": "' . admin_url( 'admin-ajax.php' ) . '","nonce": "' . wp_create_nonce( _HMW_NONCE_ID_ ) . '"}</script>';
        echo $this->getView('Dashboard');
    }

    public function action() {
        parent::action();

        if (!current_user_can('manage_options')) {
            return;
        }

        switch (HMW_Classes_Tools::getValue('action')) {
            case 'hmw_widget_securitycheck':
                HMW_Classes_ObjController::getClass('HMW_Controllers_SecurityCheck')->doSecurityCheck();

                ob_start();
                $this->dashboard();
                $output = ob_get_clean();

                HMW_Classes_Tools::setHeader('json');
                echo json_encode(array('data' => $output));
                exit;

        }
    }
}
