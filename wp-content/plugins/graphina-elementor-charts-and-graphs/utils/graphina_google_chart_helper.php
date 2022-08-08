<?php

function graphinaGoogleChartDynamicData($this_ele, $data){

    $mainId = $this_ele->get_id();
    $type = $this_ele->get_chart_type();
    $settings = $this_ele->get_settings_for_display();

    if ($settings['iq_' . $type . '_chart_data_option'] === 'firebase') {
        return apply_filters('graphina_addons_render_section', $data, $type, $settings);
    }

    if($settings['iq_' . $type . '_chart_data_option'] === 'forminator' && graphinaForminatorAddonActive()){
        $data = apply_filters('graphina_forminator_addon_data', $data,$type,$settings);
        ?>
        <script>
            if (jQuery('body').hasClass("elementor-editor-active")) {
                setFieldsFromForminator(<?php echo json_encode($settings);?>, <?php echo json_encode($data);?>, '<?php echo $type;?>');
            };
        </script>
        <?php
        return $data;
    }

    if (!isGraphinaPro()) {
        return $data;
    }
    $dataFormatType = 'area';

    switch ($type){
        case 'pie_google':
        case 'donut_google':
        case 'geo_google':
        case 'gauge_google':
            $dataFormatType = 'circle';
            break;
        case 'org_google':
            $dataFormatType = 'org_google';
            break;
        case 'gantt_google':
            $dataFormatType = 'gantt_google';
            break;
    }

    if($settings['iq_' . $type . '_chart_data_option'] === 'dynamic'){

        $dataTypeOption = $settings['iq_' . $type . '_chart_dynamic_data_option'];

        switch ($dataTypeOption) {
            case "csv":
                if (!empty($settings['iq_' . $type . '_chart_csv_column_wise_enable']) && $settings['iq_' . $type . '_chart_csv_column_wise_enable'] === 'yes') {
                    $url = $settings['iq_' . $type . '_chart_upload_csv']['url'];
                    $data = graphina_pro_parse_csv_column_wise($url, $dataFormatType, $settings, $type);
                    ?>
                    <script>
                        if (jQuery('body').hasClass("elementor-editor-active")) {
                            setFieldsForCSV(<?php echo json_encode($settings);?>, <?php echo json_encode($data);?>, '<?php echo $type;?>');
                        };
                    </script>
                    <?php
                } else {
                    $data = graphina_pro_parse_csv($settings, $type, $dataFormatType);
                }
                break;
            case "remote-csv" :
            case "google-sheet" :
                if (!empty($settings['iq_' . $type . '_chart_csv_column_wise_enable']) && $settings['iq_' . $type . '_chart_csv_column_wise_enable'] === 'yes') {
                    $url = $dataTypeOption === 'remote-csv' ? $settings['iq_' . $type . '_chart_import_from_url'] : $settings['iq_' . $type . '_chart_import_from_google_sheet'];
                    $data = graphina_pro_parse_csv_column_wise($url, $dataFormatType, $settings, $type);
                    ?>
                    <script>
                        if (jQuery('body').hasClass("elementor-editor-active")) {
                            setFieldsForCSV(<?php echo json_encode($settings);?>, <?php echo json_encode($data);?>, '<?php echo $type;?>');
                        };
                    </script>
                    <?php
                } else {
                    $data = graphina_pro_get_data_from_url($type, $settings, $dataTypeOption, $mainId, $dataFormatType);
                }
                break;
            case "api":
                $data = graphina_pro_chart_get_data_from_api($type, $settings, $dataFormatType, []);
                break;
            case "sql-builder":
                $data = graphina_pro_chart_get_data_from_sql_builder($settings, $type, []);
                ?>
                <script>
                    if (jQuery('body').hasClass("elementor-editor-active")) {
                        setFieldsFromSQLStateMent(<?php echo json_encode($settings);?>, <?php echo json_encode($data);?>, '<?php echo $type;?>');
                    };
                </script>
                <?php
                break;
            case 'filter':
                update_post_meta(get_the_ID(), $mainId, $settings['iq_' . $type . '_element_filter_widget_id']);
                $data = apply_filters('graphina_extra_data_option', $data, $type, $settings, $settings['iq_' . $type . '_element_filter_widget_id']);
                break;
        }
    }

    return $data;
}