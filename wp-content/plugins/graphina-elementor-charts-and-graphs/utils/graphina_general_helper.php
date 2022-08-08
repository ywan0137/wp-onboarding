<?php
function getGraphinaProFileUrl($file)
{
    return GRAPHINA_PRO_ROOT . '/elementor/' . $file;
}

function isGraphinaPro()
{
    return get_option('graphina_is_activate') === "1";
}

function isGraphinaProInstall()
{
    return get_option('graphina_pro_is_install') === "1";
}

function graphinaForminatorAddonActive(){

    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $basename = '';
    $plugins = get_plugins();

    foreach ($plugins as $key => $data) {
        if ($data['TextDomain'] === "graphina-forminator-addon") {
            $basename = $key;
        }
    }

    return is_plugin_active($basename);
}

function graphinaForminatorInstall(){

    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $basename = '';
    $plugins = get_plugins();

    foreach ($plugins as $key => $data) {
        if ($data['TextDomain'] === "forminator") {
            $basename = $key;
        }
    }

    return is_plugin_active($basename);
}

function graphina_plugin_activation($is_deactivate = false)
{
    $pluginName = "Graphina";
    $arg = 'plugin=' . $pluginName . '&domain=' . get_bloginfo('wpurl') . '&site_name=' . get_bloginfo('name');
    if ($is_deactivate) {
        $arg .= '&is_deactivated=true';
    }
    wp_remote_get('https://innoquad.in/plugin-server/active-server.php?' . $arg);
}

function graphina_if_failed_load(){
    $latest_pro_version = '1.1.3';

    if (!current_user_can('activate_plugins')) {
        return;
    }

    // Get Graphina animation lite version basename
    $basename = '';
    $plugins = get_plugins();

    foreach ($plugins as $key => $data) {
        if ($data['TextDomain'] === "graphina-pro-charts-for-elementor") {
            $basename = $key;
        }
    }

    if (is_graphina_plugin_installed($basename) && is_plugin_active($basename) && version_compare(graphina_get_pro_plugin_version($basename), $latest_pro_version, '<')) {
        $message = sprintf(__('Required <strong>Version '.$latest_pro_version.' </strong>of<strong> Graphina – Elementor Dynamic Charts & Datatable</strong> plugin. Please update to continue.', 'graphina-charts-for-elementor'), '<strong>', '</strong>');
        $url = "https://themeforest.net/downloads";
        $button_text = __('Download Version '.$latest_pro_version, 'graphina-charts-for-elementor');
        $button = '<p><a target="_blank" href="' . $url . '" class="button-primary">' . $button_text . '</a></p>';
        printf('<div class="error"><p>%1$s</p>%2$s</div>', __($message), $button);
    }

}

function is_graphina_plugin_installed($basename)
{
    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    return isset($plugins[$basename]);
}

function graphina_get_pro_plugin_version($basename)
{
    if (!function_exists('get_plugins')) {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    return $plugins[$basename]['Version'];
}

function graphina_is_preview_mode()
{
    if (isset($_REQUEST['elementor-preview'])) {
        return false;
    }

    if (isset($_REQUEST['ver'])) {
        return false;
    }

    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'elementor') {
        return false;
    }

    $url_params = !empty($_SERVER['HTTP_REFERER']) ?  parse_url(sanitize_url($_SERVER['HTTP_REFERER']),PHP_URL_QUERY) : parse_url(sanitize_url($_SERVER['REQUEST_URI']),PHP_URL_QUERY);
    parse_str($url_params,$params);
    if(!empty($params['action']) && $params['action'] == 'elementor'){
        return false;
    }

    if(!empty($params['preview']) && $params['preview'] == 'true'){
        return false;
    }

    if(!empty($params['elementor-preview'])){
        return false;
    }

    return true;
}

function graphina_ajax_reload($callAjax,$new_settings,$type,$mainId){
     ?><script>
            if(typeof getDataForChartsAjax !== "undefined" && '<?php echo $callAjax; ?>' === "1") {
                if( !['mixed'].includes('<?php echo $type; ?>' )){
                    getDataForChartsAjax(<?php echo json_encode($new_settings); ?>, '<?php echo $type; ?>', '<?php echo $mainId; ?>');
                }
              <?php if (isset($new_settings['iq_' . $type . '_can_chart_reload_ajax']) ? $new_settings['iq_' . $type . '_can_chart_reload_ajax'] : 'no' ==='yes') { ?>
                    let ajaxIntervalTime = parseInt('<?php echo $new_settings['iq_' . $type . '_interval_data_refresh']?>') * 1000;

                    window.ajaxIntervalGraphina_<?php echo $mainId; ?> = setInterval(function () {
                       getDataForChartsAjax(<?php echo json_encode($new_settings); ?>, '<?php echo $type; ?>', '<?php echo $mainId; ?>');
                   }, ajaxIntervalTime);
              <?php  } ?>

            }
        </script>
 <?php
}

function apexChartLocales(){
    $data = [
        'name' => 'en',
        'options' => [
            'toolbar'=> [
                'download'=> esc_html__('Download SVG', 'graphina-charts-for-elementor'),
                'selection'=> esc_html__('Selection', 'graphina-charts-for-elementor'),
                'selectionZoom'=> esc_html__('Selection Zoom', 'graphina-charts-for-elementor' ),
                'zoomIn'=> esc_html__('Zoom In', 'graphina-charts-for-elementor'),
                'zoomOut'=> esc_html__('Zoom Out', 'graphina-charts-for-elementor'),
                'pan'=> esc_html__('Panning', 'graphina-charts-for-elementor'),
                'reset'=> esc_html__('Reset Zoom', 'graphina-charts-for-elementor'),
                'menu' => esc_html__('Menu', 'graphina-charts-for-elementor'),
                "exportToSVG"=>esc_html__('Download SVG', 'graphina-charts-for-elementor'),
                "exportToPNG"=>esc_html__('Download PNG', 'graphina-charts-for-elementor'),
                "exportToCSV"=>esc_html__('Download CSV', 'graphina-charts-for-elementor'),
            ]
        ]
    
    ];

    return json_encode($data);
}

function graphina_filter_common($this_ele,$settings,$type){
    if (!empty($settings['iq_'.$type.'_chart_filter_enable']) && $settings['iq_'.$type.'_chart_filter_enable'] == 'yes') {
        ?>
        <div class="graphina_chart_filter" style="display: flex; flex-wrap: wrap; align-items: end;">
            <?php
            if(!empty($settings['iq_'.$type.'_chart_filter_list'])){
                foreach ($settings['iq_'.$type.'_chart_filter_list'] as $key => $value) {
                    if(!empty($value['iq_' . $type . '_chart_filter_type']) && $value['iq_' . $type . '_chart_filter_type'] === 'date'){
                        ?>
                        <div class="graphina-filter-div">
                            <div>
                                <label> <?php echo !empty($value['iq_' . $type . '_chart_filter_value_label']) ? $value['iq_' . $type . '_chart_filter_value_label'] : '';?> </label>
                            </div>
                            <?php if(!empty($value['iq_' . $type . '_chart_filter_date_type']) && $value['iq_' . $type . '_chart_filter_date_type'] === 'date'){
                                $defaultdate = !empty($value['iq_' . $type . '_chart_filter_date_default']) ? $value['iq_' . $type . '_chart_filter_date_default'] : current_time('Y-m-d h:i:s');
                                ?>
                                <div>
                                    <input  type="date" style="font-size:<?php echo $settings['iq_' . $type . '_chart_filter_date_font_size']['size'].$settings['iq_' . $type . '_chart_filter_date_font_size']['unit'];?>" id="start-date_<?php echo $key?>" class="graphina-chart-filter-date-time graphina_datepicker_<?php echo $this_ele->get_id() ?> graphina_filter_select<?php echo $this_ele->get_id() ?>" value="<?php echo date('Y-m-d', strtotime($defaultdate)); ?>" >
                                </div>
                                <?php
                            }else{
                                $defaultdate = !empty($value['iq_' . $type . '_chart_filter_datetime_default']) ? $value['iq_' . $type . '_chart_filter_datetime_default'] : current_time('Y-m-d h:i:s');
                                ?>
                                <div>
                                    <input  type="datetime-local" style="font-size:<?php echo $settings['iq_' . $type . '_chart_filter_date_font_size']['size'].$settings['iq_' . $type . '_chart_filter_date_font_size']['unit'];?>" id="start-date_<?php echo $key?>" class="graphina-chart-filter-date-time graphina_datepicker_<?php echo $this_ele->get_id() ?>" step="1" value="<?php echo date('Y-m-d\TH:i', strtotime($defaultdate)); ?>" >
                                </div>
                                <?php
                            }?>
                        </div>
                        <?php
                    }else{
                        if (!empty($value['iq_'.$type.'_chart_filter_value']) && !empty($value['iq_'.$type.'_chart_filter_option'])) {
                            $data = explode(',', $value['iq_'.$type.'_chart_filter_value']);
                            $dataOption =  explode(',', $value['iq_'.$type.'_chart_filter_option']);
                            if (!empty($data) && is_array($data) && !empty($dataOption) && is_array($dataOption)) {
                                ?>
                                <div  class="graphina-filter-div">
                                    <div>
                                        <label style="font-size:<?php echo $settings['iq_' . $type . '_chart_filter_label_font_size']['size'].$settings['iq_' . $type . '_chart_filter_label_font_size']['unit']?>"> <?php echo !empty($value['iq_' . $type . '_chart_filter_value_label']) ? $value['iq_' . $type . '_chart_filter_value_label'] : '';?> </label>
                                    </div>
                                    <div>
                                        <select style="font-size:<?php echo $settings['iq_' . $type . '_chart_filter_font_size']['size'].$settings['iq_' . $type . '_chart_filter_font_size']['unit']?>" class="graphina_filter_select<?php echo $this_ele->get_id() ?>"
                                                id="graphina-select-chart-type_<?php echo $key ?>">
                                            <?php foreach ($data as $key1 => $value1) {
                                                ?>
                                                <option value="<?php echo $value1 ; ?>" <?php echo $key1 == 0 ? 'selected' : '' ?>><?php echo isset($dataOption[$key1]) ? $dataOption[$key1] : '' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <div  class="graphina-filter-div" >
                    <input class="graphina-filter-div-button" type="button" value="Apply Filter" style="font-size:<?php echo $settings['iq_' . $type . '_chart_filter_button_font_size']['size'].$settings['iq_' . $type . '_chart_filter_button_font_size']['unit']?>" id="grapina_apply_filter_<?php echo $this_ele->get_id(); ?>" onclick='graphinaChartFilter(<?php echo json_encode($settings); ?>,"<?php echo $type; ?>",this,"<?php esc_attr_e($this_ele->get_id()); ?>");' />
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

function graphina_check_external_database($type){
    $data = get_option('graphina_mysql_database_setting',true);
    return $type === 'status' ? gettype($data) != 'boolean' && is_array($data) && count($data) > 0 : $data;
}

function graphina_common_setting_get($type){
    $data = get_option('graphina_common_setting',true);
    $value = '';
    switch ($type){
        case 'thousand_seperator':
            $value = !empty($data['thousand_seperator_new']) ? $data['thousand_seperator_new'] : ",";
            break;
        case 'view_port':
            $value = !empty($data['view_port']) ? $data['view_port'] : 'off';
            break;
        case 'csv_seperator':
            $value = !empty($data['csv_seperator']) ? $data['csv_seperator'] == 'semicolon' ? ';' : ',' : ',';
            break;
        case 'graphina_loader':
            $value = !empty($data['graphina_loader']) ? $data['graphina_loader']  : GRAPHINA_URL . '/admin/assets/images/graphina.gif';
            break;
    }

    return $value;
}

function graphinaGetloader(){
    return !empty(graphina_common_setting_get('graphina_loader')) ? graphina_common_setting_get('graphina_loader') : GRAPHINA_URL . '/admin/assets/images/graphina.gif';
}

function randomValueGenerator($min, $max){
    return rand( (int)$min, (int)$max );
}

function graphinaRecursiveSanitizeTextField($array)
{
    $filterParameters = [];
    foreach ($array as $key => $value) {

        if ($value === '') {
            $filterParameters[$key] = null;
        } else {
            if (is_array($value)) {
                $filterParameters[$key] = graphinaRecursiveSanitizeTextField($value);
            } else {
                if(is_object($value)){
                    $filterParameters[$key] = $value;
                }
                else if (preg_match("/<[^<]+>/", $value, $m) !== 0) {
                    $filterParameters[$key] = $value;
                }
                elseif($key === 'graphina_loader' ){
                    $filterParameters[$key] = sanitize_url($value);
                }
                elseif($key  === 'nonce'){
                    $filterParameters[$key] = sanitize_key($value);
                }
                else {
                    $filterParameters[$key] = sanitize_text_field($value);
                }
            }
        }

    }

    return $filterParameters;
}

function graphina_change_google_chart_type($this_ele){
    $type = $this_ele->get_chart_type();
    $settings = $this_ele->get_settings_for_display();
    if (!empty($settings['iq_'.$type.'_dynamic_change_chart_type']) && $settings['iq_'.$type.'_dynamic_change_chart_type'] == 'yes') { ?>
        <div class="graphina_dynamic_change_type">
            <select id="graphina-select-chart-type"
                    onchange="updateGoogleChartType('<?php echo esc_js($type); ?>',this,'<?php echo esc_js($this_ele->get_id()); ?>');">
                <option selected
                        disabled><?php echo esc_html__('Choose Chart Type', 'graphina-charts-for-elementor') ?></option>
                <?php if (in_array($type, ['pie_google', 'donut_google'])) {
                    ?>
                    <option value="PieChart">Pie</option>
                    <option value="DonutChart">Donut</option>
                    <?php
                } else { ?>
                    <option value="AreaChart">Area</option>
                    <option value="LineChart">Line</option>
                    <option value="BarChart">Bar</option>
                    <option value="ColumnChart">Column</option>
                <?php } ?>
            </select>
        </div>
    <?php }
}