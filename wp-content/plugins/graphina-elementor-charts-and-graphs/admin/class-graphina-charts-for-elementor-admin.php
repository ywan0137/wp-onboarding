<?php
class Graphina_Charts_For_Elementor_Admin{



    private $version;

    public function __construct($version){
        $this->version = $version;

        add_action('admin_enqueue_scripts', array($this,'enqueue_scripts'));
        add_action('admin_menu',  array($this,'admin_menu'));
        //setting page ajax
        add_action('wp_ajax_graphina_setting_data',array($this,'graphina_save_setting'));
        //database page ajax
        add_action('wp_ajax_graphina_external_database',array($this,'graphina_save_external_database_setting'));
        
        add_action( 'admin_head',function() {
            ?>
            <script type="text/javascript">
                jQuery(document).ready( function($) {
                    jQuery(document).find('ul.wp-submenu a[href="https://wordpress.iqonic.design/docs/product/graphina-elementor-charts-and-graphs"]').attr( 'target', '_blank' );
                    jQuery(document).find('ul.wp-submenu a[href="https://iqonic.design/feature-request/?for_product=graphina"]').attr( 'target', '_blank' );
                    jQuery(document).find('ul.wp-submenu a[href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061"]').attr( 'target', '_blank' );
                });
            </script>
            <?php
        });
    }

    public function enqueue_scripts(){
        global $pagenow;
        $current_page = ( isset( $_GET['page'] ) ) ? sanitize_text_field(wp_unslash($_GET['page'] )) : 'graphina-chart';
        if ($pagenow === 'admin.php' && !empty($current_page) && $current_page == 'graphina-chart') {
            wp_enqueue_media();
            wp_enqueue_style('sweetalert2', plugin_dir_url(__FILE__) . 'assets/css/sweetalert2.min.css', array(), $this->version, false);
            wp_enqueue_style('graphina-custom-admin', plugin_dir_url(__FILE__) . 'assets/css/graphina-custom-admin.css', array(), $this->version, false);
            wp_enqueue_script('sweetalert2', plugin_dir_url(__FILE__) . 'assets/js/sweetalert2.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script('graphina-admin-custom', plugin_dir_url(__FILE__) . 'assets/js/graphina-custom-admin.js', array('jquery'), $this->version, false);
            wp_localize_script('graphina-admin-custom', 'localize', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce'),
            ));

            wp_localize_script('graphina-admin-custom', 'localize_admin', array(
                'adminurl' => admin_url(),
                'swal_are_you_sure_text' => esc_html__('Are you sure?' ,'graphina-charts-for-elementor'),
                'swal_revert_this_text' => esc_html__('You won\'t be able to revert this!' ,'graphina-charts-for-elementor'),
                'swal_delete_text' => esc_html__('Yes, delete it!' ,'graphina-charts-for-elementor'),
                'nonce' => wp_create_nonce('ajax-nonce'),
            ));
        }  
    }

    public function admin_menu()
    {
        if (current_user_can('manage_options')) {
            add_menu_page(
                __('Graphina Charts', 'graphina-charts-for-elementor'),
                __('Graphina Charts', 'graphina-charts-for-elementor'),
                "manage_options",
                "graphina-chart",
                [$this, 'options_page'],
                plugin_dir_url(__FILE__) . 'assets/images/graphina.svg',
                100
            );
            add_submenu_page(
                "graphina-chart",
                __('Graphina Charts Setting', 'graphina-charts-for-elementor'),
                __('Settings', 'graphina-charts-for-elementor'),
                'manage_options',
                'graphina-chart'
            );
            add_submenu_page(
                "graphina-chart",
                __('Graphina Charts Documentation', 'graphina-charts-for-elementor'),
                __('Documentation', 'graphina-charts-for-elementor'),
                'manage_options',
                'https://wordpress.iqonic.design/docs/product/graphina-elementor-charts-and-graphs/'
            );
            add_submenu_page(
                "graphina-chart",
                __('Graphina Charts Request Feature', 'graphina-charts-for-elementor'),
                __('Request a Feature', 'graphina-charts-for-elementor'),
                'manage_options',
                'https://iqonic.design/feature-request/?for_product=graphina'
            );
            if(!isGraphinaPro()){
                add_submenu_page(
                    "graphina-chart",
                    __('Graphina Charts Pro', 'graphina-charts-for-elementor'),
                    '<span class="dashicons dashicons-star-filled" style="font-size: 17px; color:#0073aa"></span>'.__('Go Pro','graphina-charts-for-elementor'),
                    'manage_options',
                    'https://graphina.iqonic.design/'
                );
            }
        }
    }

    public function options_page(){
        if(current_user_can( 'manage_options' )){
            $activeTab='setting';
            if(isset($_GET['activetab'])){
                $activeTab = sanitize_text_field(wp_unslash($_GET['activetab']));
            }
            $proActive = isGraphinaPro();
            ?>
            <div id="graphina-settings" name="graphina-settings">
                <div class="graphina-main">
                    <div class="graphina-tabs">
                        <ul>
                            <li class="<?php echo esc_html($activeTab =='setting' ? 'active-tab' : '') ?>"><a class="tab " href="<?php echo esc_url(admin_url().'admin.php?page=graphina-chart&activetab=setting'); ?>"><?php  echo __("Settings", "graphina-charts-for-elementor"); ?></a></li>
                            <li class=" <?php echo esc_html($activeTab =='database' ? 'active-tab' : '') ?>" style="position: relative ">
                                <span class="graphina-badge" <?php echo esc_html($proActive ? 'hidden' : '') ;?> ><?php  echo __("Pro", "graphina-charts-for-elementor"); ?></span>
                                <a class="tab" href="<?php echo esc_url(admin_url().'admin.php?page=graphina-chart&activetab=database'); ?>">
                                    <?php  echo __("External Database", "graphina-charts-for-elementor"); ?>
                                </a>
                            </li>
                        </ul>
                        <div class="graphina-tab">
                            <?php
                            switch ($activeTab){
                                case "general":
                                    ?>
                                    <div id="general" class="graphina-tab-detail">
                                        <div class="row">
                                            <div class="col">
                                                <div class="graphina_card">
                                                    <div class="graphina_card_body">
                                                        <h3 class="graphina_card_title"><?php  echo __("Documentation", "graphina-charts-for-elementor") ?></h3>
                                                        <p class="graphina_card_text"><?php  echo __("Get started by spending some time with the documentation to get familiar with Graphina Charts.", "graphina-charts-for-elementor") ?></p>
                                                        <a href="https://wordpress.iqonic.design/docs/product/graphina-elementor-charts-and-graphs/" class="graphina_document_button" target="_blank" ><?php  echo __("Documentation", "graphina-charts-for-elementor") ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="graphina_card">
                                                    <div class="graphina_card_body">
                                                        <h3 class="graphina_card_title"><?php  echo __("Need Help?", "graphina-charts-for-elementor") ?></h3>
                                                        <p class="graphina_card_text">
                                                            <?php  echo __("We are constantly working to make your experience better. Still faced a problem? Need assistance ?", "graphina-charts-for-elementor") ?></p>
                                                        <a href="mailto:hello@iqonic.com" class="graphina_document_button"><?php  echo __("Contact Us", "graphina-charts-for-elementor") ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case "charts":
                                    ?>
                                    <div id="chart" class="graphina-tab-detail" >
                                    </div>
                                    <?php
                                    break;
                                case "setting":
                                    ?>
                                    <div id="setting" class="graphina-tab-detail">

                                        <?php
                                            $data = !empty(get_option('graphina_common_setting',true)) ? get_option('graphina_common_setting',true) : [];
                                            $selected_js_array = !empty($data['graphina_select_chart_js']) ? $data['graphina_select_chart_js'] : [];
                                            $selected_apex = ( in_array("apex_chart_js", $selected_js_array)) ? 'checked' : '';
                                            $selected_google = ( in_array("google_chart_js", $selected_js_array)) ? 'checked' : '';
                                        ?>

                                        <form id="graphina_settings_tab"><br>

                                            <div class="graphina-admin-charts-setting">
                                                <span class="select-chart-title"><?php echo esc_html__("Select Chart Js :  ",'graphina-charts-for-elementor');?></span>
                                                <input type="checkbox" id="graphina_select_chart_js" name="graphina_select_chart_js[]" value='apex_chart_js' <?php echo esc_html($selected_apex); ?> >
                                                <span class="check-value"><?php echo esc_html__("Apex Chart Js",'graphina-charts-for-elementor');?></span>
                                                <input type="checkbox" id="graphina_select_chart_js" name="graphina_select_chart_js[]" value='google_chart_js' <?php echo esc_html($selected_google); ?> >
                                                <span class="check-value"><?php echo esc_html__("Google Chart Js",'graphina-charts-for-elementor');?></span>
                                            </div>

                                            <div class="graphina-admin-charts-setting">
                                                <span class="select-chart-title"><?php echo esc_html__("Thousand Seperator: ",'graphina-charts-for-elementor');?></span>
                                                <input id="graphina_setting_text" type="text" name="thousand_seperator_new" value="<?php echo esc_html(!empty($data['thousand_seperator_new']) ? $data['thousand_seperator_new']: ",") ?>">
                                            </div>

                                            <div class="graphina-admin-charts-setting">                                                
                                                <span class="select-chart-title"><?php echo esc_html__("CSV Seperator :",'graphina-charts-for-elementor');?>
                                                    <span <?php echo esc_html($proActive ? 'hidden' : '') ;?> class="graphina-badge"><?php echo __('Pro','graphina-charts-for-elementor') ?></span>
                                                </span>
                                                <select <?php echo esc_html($proActive ? '' : 'disabled') ;?> id="graphina_setting_select" name="csv_seperator">
                                                    <option name="comma" value="comma" <?php echo esc_html( !empty($data['csv_seperator']) && $data['csv_seperator']=='comma' ? "selected": '');?> ><?php echo esc_html__("Comma",'graphina-charts-for-elementor');?></option>
                                                    <option name="semicolon" value="semicolon" <?php echo esc_html(!empty($data['csv_seperator']) && $data['csv_seperator']=='semicolon' ? "selected": '');?> ><?php echo esc_html__("Semicolon",'graphina-charts-for-elementor');?></option>
                                                </select>
                                            </div>

                                            <div class="graphina-admin-charts-setting">
                                                <span class="select-chart-title"><?php echo esc_html__("View Port : ",'graphina-charts-for-elementor');?></span>
                                                <input  type="checkbox" id="switch" name="view_port" <?php echo esc_html( !empty($data['view_port']) && $data['view_port'] =='on' ? "checked": '');?> >
                                                <span class="check-value"><?php echo esc_html__("Disable",'graphina-charts-for-elementor');?></span>
                                                <p class="graphina-chart-note"> <?php echo esc_html__('Note : Disable  chart and counter render when it come in viewport ,render chart and counter when page load (default chart and counter are render when it in viewport)','graphina-charts-for-elementor')?></p>
                                            </div>

                                            <div class="graphina-admin-charts-setting">
                                                <span class="select-chart-title"> <?php echo esc_html__("Chart Filter loader: ",'graphina-charts-for-elementor');?>
                                                    <span <?php echo esc_html($proActive ? 'hidden' : '') ;?> class="graphina-badge"><?php echo __('Pro','graphina-charts-for-elementor') ?></span>
                                                </span>                                                
                                                <input <?php echo esc_html($proActive ? '' : 'disabled') ;?> type="checkbox" id="enable_chart_filter" name="enable_chart_filter" <?php echo esc_html(!empty($data['enable_chart_filter']) && $data['enable_chart_filter']=='on' ? "checked=checked": '');?> >
                                                <span class="check-value"><?php echo __("Enable ",'graphina-charts-for-elementor');?></span>
                                                <span class="check-value">
                                                    <!-- <i class="dashicons dashicons-editor-help"></i> -->
                                                    <!-- <a href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061" target="_blank">
                                                        <u><?php echo __("-Available In Pro Version",'graphina-charts-for-elementor');?></u>
                                                    </a> -->
                                                </span>
                                            </div>

                                            <div id="chart_filter_div" class="<?php echo esc_html( !empty($data['enable_chart_filter']) && $data['enable_chart_filter']? '' : 'graphina-d-none') ?>">
                                                <input style="margin-left: unset; background:#2a4cc9;" class="graphina_upload_loader graphina_test_btn" type="button" value="<?php echo esc_html__('Upload Filter Loader', 'graphina-charts-for-elementor'); ?>"/>
                                                <input size="36"
                                                       id="graphina_loader_hidden"
                                                       name="graphina_loader" type="hidden" value="<?php echo esc_url(!empty($data['graphina_loader']) ?  $data['graphina_loader'] : GRAPHINA_URL . '/admin/assets/images/graphina.gif'); ?>">
                                                <img <?php echo $proActive ? '' : 'hidden' ;?> name="image_src"
                                                     class="graphina_upload_image_preview" id="graphina_upload_image_preview"
                                                     src="<?php echo esc_url(!empty($data['graphina_loader']) ?  $data['graphina_loader'] : GRAPHINA_URL . '/admin/assets/images/graphina.gif'); ?>"
                                                />
                                                <p style="display: <?php echo esc_html($proActive ? 'none' : 'block') ;?>"> <strong><?php echo __('Chart Filter working only in Graphina pro','graphina-charts-for-elementor')?></strong></p>
                                            </div>
                                            <div>
                                                <input type="hidden" name="action" value="graphina_setting_data">
                                                <input type="hidden" name="nonce" value="<?php echo  esc_html(wp_create_nonce('ajax-nonce'));?>">
                                                <button type="submit" name="save_data" data-url='<?php echo esc_url(admin_url()); ?>' id="graphina_setting_save_button" class="graphina_test_btn"><?php echo esc_html__("Save Setting",'graphina-charts-for-elementor');?></button>
                                            </div>

                                        </form>
                                    </div>
                                    <?php
                                    break;
                                case "database":
                                    ?>
                                    <div id="database" class="container">
                                        <?php
                                        $option_value = [];
                                        if(isset($_GET['data']) && $_GET['data']!= ""){
                                            $editData = sanitize_text_field(wp_unslash($_GET['data']));
                                            $option = get_option('graphina_mysql_database_setting',true);
                                            if(gettype($option) != 'boolean' && !empty($option) && is_array($option)){
                                                if(array_key_exists($editData,$option)){
                                                    $option_value = $option[$editData];
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="form-header">
                                            <h3 class="head-border"><?php echo esc_html__("Connection Detail",'graphina-charts-for-elementor');?>
                                                <strong style="display: <?php echo esc_html(!$proActive ? '' : 'none') ?>">
                                                    <!-- <i class="dashicons dashicons-editor-help"></i>
                                                    <a href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061" target="_blank">
                                                        <?php echo __('(This features is available in Graphina pro plugin Buy Now )','graphina-charts-for-elementor') ;?>
                                                    </a> -->
                                                </strong>
                                            </h3>
                                        </div>

                                        <form id="graphina-settings-db-tab">
                                            <div class="row">
                                                <div class="col-25">
                                                    <label class="form-label" for="fname"><?php echo esc_html__("Connection Name : ",'graphina-charts-for-elementor');?></label>
                                                    <input type="text" name="con_name" value="<?php echo esc_html(isset($option_value['con_name']) &&  !empty($option_value['con_name']) ? $option_value['con_name'] : '') ; ?>" <?php echo esc_html((isset($editData) && $editData!= "") || (!$proActive) ? 'readonly' : '') ?>>
                                                </div>
                                                <div class="col-75">
                                                    <label class="form-label" for="fname"><?php echo esc_html__("Vendor : ",'graphina-charts-for-elementor');?></label>
                                                    <select id="input1" name="vendor" <?php echo esc_html($proActive ? '' :'disabled');?> style="padding: 11px;">
                                                        <option value="mysql"><?php echo esc_html__("MySQL",'graphina-charts-for-elementor');?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-25">
                                                    <label class="form-label" for="lname"><?php echo esc_html__("Database Name : ",'graphina-charts-for-elementor');?></label>
                                                    <input type="text" id="lname" name="db_name" value="<?php echo esc_html(isset($option_value['db_name']) &&  !empty($option_value['db_name']) ? $option_value['db_name'] : '') ; ?>" <?php echo esc_html($proActive ? '' :'readonly')?> />
                                                </div>
                                                <div class="col-75">
                                                    <label class="form-label" for="fname"><?php echo esc_html__("Host : ",'graphina-charts-for-elementor');?></label>
                                                    <input type="text" name="host" id="fname" value="<?php echo esc_html(isset($option_value['host']) &&  !empty($option_value['host']) ? $option_value['host'] : '') ; ?>" <?php echo esc_html($proActive ? '' :'readonly')?> />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-25">
                                                    <label class="form-label" for="lname"><?php echo esc_html__("Username : ",'graphina-charts-for-elementor');?></label>
                                                    <input type="text" name="user_name" value="<?php echo esc_html(isset($option_value['user_name']) &&  !empty($option_value['user_name']) ? $option_value['user_name'] : '') ; ?>" <?php echo esc_html($proActive ? '' :'readonly')?>>
                                                </div>
                                                <div class="col-75">
                                                    <label class="form-label" for="fname"><?php echo esc_html__("Password : ",'graphina-charts-for-elementor');?></label>
                                                    <input type="password" id="fname" name="pass" value="<?php echo esc_html(isset($option_value['pass']) &&  !empty($option_value['pass']) ? $option_value['pass'] : '') ; ?>" <?php echo esc_html($proActive ? '' :'readonly')?> />
                                                </div>
                                            </div>

                                            <input type="hidden" name="type" value="<?php echo esc_html(isset($editData) && $editData != "" ? 'edit' : 'save') ?>" id="graphina_external_database_action_type">
                                            <input type="hidden" name="action" value="graphina_external_database">
                                            <input type="hidden" name="nonce" value="<?php echo esc_html(wp_create_nonce('ajax-nonce'));?>">
                                            <div class="row" style="padding: 14px 0;">
                                                <button type="submit" name="save" id="graphina_database_save_button" class="graphina_test_btn btn-submit" data-url="<?php echo esc_url(admin_url())?>" <?php echo esc_html($proActive ? '' :'disabled')?>><?php echo esc_html__("Save Setting",'graphina-charts-for-elementor');?></button>
                                                <button type="button" name="graphina_con_test" class="graphina_test_db_btn graphina_test_btn btn-submit" <?php echo esc_html($proActive ? '' :'disabled')?>><?php echo esc_html__("Test DB Setting",'graphina-charts-for-elementor');?></button>
                                                <a href="<?php echo esc_url(admin_url() . 'admin.php?page=graphina-chart&activetab=database')?>">
                                                    <button type="button" name="btn-submit" class="graphina_reset_db_btn graphina_test_btn">
                                                        <?php echo esc_html__("Reset",'graphina-charts-for-elementor');?>
                                                    </button>
                                                </a>
                                            </div>
                                            
                                        </form>
                                        <div class="graphina_form_body">
                                            <?php
                                            if(graphina_check_external_database('status')){
                                                ?>
                                                <table>
                                                    <tr>
                                                        <td class="w-36"><?php echo esc_html__("Connection Name", 'graphina-charts-for-elementor') ?></td>
                                                        <td class="w-10" style="padding: 13px;"><?php echo esc_html__("Action", 'graphina-charts-for-elementor') ?></td>
                                                        <td style="padding: 13px;"><?php echo  esc_html__("Action", 'graphina-charts-for-elementor') ?></td>
                                                    </tr>
                                                    <?php
                                                    foreach (graphina_check_external_database('data') as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td ><?php echo esc_html($value['con_name']); ?></td>
                                                            <td>
                                                                <a href="<?php echo esc_url(admin_url() . 'admin.php?page=graphina-chart&activetab=database&data=' . $value['con_name']); ?>">
                                                                    <button class="graphina_test_btn"
                                                                            id="graphina_database_edit">
                                                                        <?php echo esc_html__("Edit", 'graphina-charts-for-elementor'); ?>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <button data-selected="<?php echo esc_html($value['con_name']); ?>"
                                                                        class="graphina_test_btn graphina-database-delete"
                                                                        name="delete">
                                                                    <?php echo esc_html__("Delete", 'graphina-charts-for-elementor'); ?>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    } ?>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case 'addon':
                                    ?>
                                    <div id="general" class="graphina-tab-detail graphina-tab-detail-addon">
                                        <div class="row">
                                            <div class="col">
                                                <div class="graphina_card">
                                                    <div class="graphina_card_body">
                                                        <h3 class="graphina_card_title"><?php echo __("Graphina Pro", "graphina-charts-for-elementor") ?></h3>
                                                        <p class="graphina_card_text">
                                                            <?php echo __("Graphina Pro has a powerful set of options, with Dynamic data and new counters, data table, mixed chart, and nested column chart; it has a wide range of charts and adaptability. Dynamic Data for all widgets (Google Sheet, CSV,Database and API)", "graphina-charts-for-elementor") ?></p>
                                                        <a href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061" class="graphina_document_button" target="_blank" ><?php echo  __("Buy Now", "graphina-charts-for-elementor") ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="graphina_card">
                                                    <div class="graphina_card_body">
                                                        <h3 class="graphina_card_title"><?php echo __("Graphina Firebase", "graphina-charts-for-elementor") ?></h3>
                                                        <p class="graphina_card_text">
                                                            <?php echo __("Graphina Firebase Helps in getting data dynamically from Firebase real-time database. This helps you make your website show real-time data from this latest tech out there.", "graphina-charts-for-elementor") ?></p>
                                                        <a href="https://codecanyon.net/item/graphina-firebase-addon/31762235" class="graphina_document_button" target="_blank"><?php echo __("Buy Now", "graphina-charts-for-elementor") ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function graphina_save_setting(){
        $postData = graphinaRecursiveSanitizeTextField($_POST);
        $status = false;
        $message = esc_html__("Action Not found", 'graphina-charts-for-elementor');
        $subMessage = '';
        if ( ! wp_verify_nonce( $postData['nonce'], 'ajax-nonce' ) ) {
            wp_send_json([
                'status' => false,
                'message' => esc_html__("Invalid nonce", 'graphina-charts-for-elementor'),
            ]);
            die;
        }
        if (isset($postData['action']) && $postData['action'] == 'graphina_setting_data'){
            unset($postData['action']);
            unset($postData['nonce']);
            if (!empty($postData)) {
                update_option('graphina_common_setting', $postData);
                $status = true;
                $message = esc_html__("Setting saved", 'graphina-charts-for-elementor');
                $subMessage = esc_html__('Your setting has been saved!','graphina-charts-for-elementor');
            } else {
                $message = esc_html__("Setting Not saved", 'graphina-charts-for-elementor');
            }
        }

         wp_send_json([
            'status' => $status,
            'message' => $message,
             'subMessage' => $subMessage
        ]);
        die;
    }
    public function graphina_save_external_database_setting(){
        $status = false;
        $postData = graphinaRecursiveSanitizeTextField($_POST);

        $message = esc_html__('not saved','graphina-charts-for-elementor');
        if ( ! wp_verify_nonce( $postData['nonce'], 'ajax-nonce' ) ) {
            wp_send_json([
                'status' => false,
                'message' => esc_html__("Invalid nonce", 'graphina-charts-for-elementor'),
            ]);
            die;
        }
        if(isset($postData['action']) && $postData['action'] === 'graphina_external_database'){
            unset($postData['action']);
            unset($postData['nonce']);
            $data = get_option('graphina_mysql_database_setting',true);
            $data_exists = gettype($data) != 'boolean' && !empty($data) && is_array($data);
            $actionType = !empty($postData['type']) ? $postData['type'] : 'no_action';
            unset($postData['type']);

            if(in_array($actionType,['save','edit','con_test'])){

                $connectionDetail = $this->graphinaCheckDataBaseConnection($postData);
                $status = $connectionDetail['status'];
                $message = $connectionDetail['message'];

                if(!$connectionDetail['status']){
                     wp_send_json([
                        'data' => '',
                        'status' => $status,
                        'message' =>$message
                    ]);
                    die;
                }

                if($actionType == 'con_test'){
                    wp_send_json([
                        'data' => '',
                        'status' => $status,
                        'message' =>$message
                    ]);
                    die;
                }
            }

            switch ($actionType){
                case 'delete':
                    // delete exists database setting from options
                    if($data_exists){
                        if(array_key_exists($postData['value'],$data)){
                            unset($data[$postData['value']]);
                            update_option('graphina_mysql_database_setting',$data);
                            $status = true;
                            $message = esc_html__('Connection name delete','graphina-charts-for-elementor');
                        }else{
                            $message = esc_html__('Connection Name not found','graphina-charts-for-elementor');
                        }
                    }
                    break;
                case 'edit':
                    // edit exists database connection details
                    if($data_exists){
                        if(array_key_exists($postData['con_name'],$data)){
                            $data[$_POST['con_name']] = $postData;
                            update_option('graphina_mysql_database_setting',$data);
                            $status = true;
                            $message = esc_html__('Connection detail Updated','graphina-charts-for-elementor');
                        }
                    }
                    break;
                case 'save':
                    if($data_exists){
                        //check if same connection name exists while save new connection detail
                        if(!array_key_exists($postData['con_name'],$data)){
                            // save database connection detail
                            update_option('graphina_mysql_database_setting',array_merge($data,[$postData['con_name'] =>$postData]));
                            $status = true;
                            $message = esc_html__('Connection Details Saved','graphina-charts-for-elementor');
                        }
                    }else{
                        // save database connection detail
                        update_option('graphina_mysql_database_setting',[$postData['con_name'] =>$postData]);
                        $status = true;
                        $message = esc_html__('Connection Details Saved','graphina-charts-for-elementor');
                    }
                    break;
            }
        }

        wp_send_json([
            'data' => '',
            'status' => $status,
            'message' =>$message,
            'subMessage' => esc_html__('Your setting has been saved!','graphina-charts-for-elementor')
        ]);
        die;

    }

    public function graphinaCheckDataBaseConnection($data){

        $status = false;
        $message = esc_html__('Connection Detail Not Found','graphina-charts-for-elementor');
        if(!empty($data['host']) && !empty($data['user_name']) && isset($data['pass']) && !empty($data['db_name']) && !empty($data['con_name'])){
            try {
                $dc_con = mysqli_connect($data['host'],$data['user_name'],$data['pass'],$data['db_name']);
                if(!$dc_con){
                    $status = false;
                    $message = esc_html__(mysqli_connect_error(),'graphina-charts-for-elementor');
                }else{
                    $status = true;
                    $message = esc_html__('Sucessfully connected','graphina-charts-for-elementor');
                }
                return [ 'data' =>'', 'status' => $status , 'message' => $message];
            }
            catch(Exception $e) {
                return [ 'data' =>'', 'status' => false , 'message' => $e->getMessage()];
            }
        }
        return [ 'data' =>'', 'status' => $status , 'message' => $message];
    }
}