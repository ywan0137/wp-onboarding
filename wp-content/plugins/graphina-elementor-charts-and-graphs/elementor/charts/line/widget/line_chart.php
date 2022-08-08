<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

/**
 * Elementor Blog widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.5.7
 */
class Line_chart extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @return string Widget name.
     * @since 1.5.7
     * @access public
     *
     */

    public function get_name()
    {
        return 'line_chart';
    }

    /**
     * Get widget Title.
     *
     * Retrieve heading widget Title.
     *
     * @return string Widget Title.
     * @since 1.5.7
     * @access public
     *
     */

    public function get_title()
    {
        return 'Line';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return array Widget categories.
     * @since 1.5.7
     * @access public
     *
     */


    public function get_categories()
    {
        return ['iq-graphina-charts'];
    }


    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @return string Widget icon.
     * @since 1.5.7
     * @access public
     *
     */

    public function get_icon()
    {
        return 'graphina-apex-line-chart';
    }

    public function get_chart_type()
    {
        return 'line';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();
        $this->color = graphina_colors('color');
        $this->gradientColor = graphina_colors('gradientColor');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type, 0, true);

        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),

            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_line_curve',
            [
                'label' => esc_html__('Line Shape', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => graphina_stroke_curve_type(true),
                'options' => graphina_stroke_curve_type(),
            ]
        );

        graphina_common_chart_setting($this, $type, false);

        graphina_tooltip($this, $type);

        //  graphina_fill_style_setting($this,$type,['classic', 'gradient'],false);

        graphina_dropshadow($this, $type, true);

        graphina_animation($this, $type);

        $this->add_control(
            'iq_' . $type . '_chart_hr_category_listing',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_category',
            [
                'label' => esc_html__('Category Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
                'description' => esc_html__('Note: For multiline text seperate Text by comma(,) and Only work if Labels Prefix/Postfix in X-axis is disable ','graphina-charts-for-elementor'),
            ]
        );

        /** Chart value list. */
        $this->add_control(
            'iq_' . $type . '_category_list',
            [
                'label' => esc_html__('Categories', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_category' => 'Jan'],
                    ['iq_' . $type . '_chart_category' => 'Feb'],
                    ['iq_' . $type . '_chart_category' => 'Mar'],
                    ['iq_' . $type . '_chart_category' => 'Apr'],
                    ['iq_' . $type . '_chart_category' => 'May'],
                    ['iq_' . $type . '_chart_category' => 'Jun'],
                ],
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ],
                'title_field' => '{{{ iq_' . $type . '_chart_category }}}',
            ]
        );

        $this->end_controls_section();


        graphina_chart_label_setting($this, $type);

        graphina_advance_x_axis_setting($this, $type);

        graphina_advance_y_axis_setting($this, $type);

        graphina_series_setting($this, $type, ['tooltip', 'color', 'dash', 'width'], true, ['classic', 'gradient'], false, true);

        for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {
            $this->start_controls_section(
                'iq_' . $type . '_section_4_' . $i,
                [
                    'label' => esc_html__('Element ' . ($i + 1), 'graphina-charts-for-elementor'),
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
                        'iq_' . $type . '_chart_data_option' => 'manual'
                    ],
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'relation' => 'and',
                                'terms' => [
                                    [
                                        'name' => 'iq_' . $type . '_chart_is_pro',
                                        'operator' => '==',
                                        'value' => 'false'
                                    ],
                                    [
                                        'name' => 'iq_' . $type . '_chart_data_option',
                                        'operator' => '==',
                                        'value' => 'manual'
                                    ]
                                ]
                            ],
                            [
                                'relation' => 'and',
                                'terms' => [
                                    [
                                        'name' => 'iq_' . $type . '_chart_is_pro',
                                        'operator' => '==',
                                        'value' => 'true'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            );

            $this->add_control(
                'iq_' . $type . '_chart_title_3_' . $i,
                [
                    'label' => 'Title',
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Tile', 'graphina-charts-for-elementor'),
                    'default' => 'Element ' . ($i + 1),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'iq_' . $type . '_chart_value_3_' . $i,
                [
                    'label' => 'Series Value',
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            /** Chart value list. */
            $this->add_control(
                'iq_' . $type . '_value_list_3_1_' . $i,
                [
                    'label' => esc_html__('Values', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(10, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(10, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(10, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(10, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(10, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(10, 200)]
                    ],
                    'condition' => [
                        'iq_' . $type . '_can_chart_negative_values!' => 'yes'
                    ],
                    'title_field' => '{{{ iq_' . $type . '_chart_value_3_' . $i . ' }}}',
                ]
            );

            $this->add_control(
                'iq_' . $type . '_value_list_3_2_' . $i,
                [
                    'label' => esc_html__('Values', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(-200, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(-200, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(-200, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(-200, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(-200, 200)],
                        ['iq_' . $type . '_chart_value_3_' . $i => rand(-200, 200)]
                    ],
                    'condition' => [
                        'iq_' . $type . '_can_chart_negative_values' => 'yes'
                    ],
                    'title_field' => '{{{ iq_' . $type . '_chart_value_3_' . $i . ' }}}',
                ]
            );

            $this->end_controls_section();
        }


        graphina_style_section($this, $type);

        graphina_card_style($this, $type);

        graphina_chart_style($this, $type);

        graphina_chart_filter_style($this,$type);

        if (function_exists('graphina_pro_password_style_section')) {
            graphina_pro_password_style_section($this, $type);
        }

        graphina_dyanmic_chart_style_section($this, $type);
    }

    protected function render()
    {
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();

        $mainId = $this->get_id();
        $second_gradient = [];
        $dropShadowSeries = [];
        $tooltipSeries = [];
        $gradient = [];
        $markerSize = [];
        $markerStrokeColor = [];
        $markerStokeWidth = [];
        $markerShape = [];
        $data = ['series' => [], 'category' => []];
        $stockWidth = [];
        $stockDashArray = [];
        $dataLabelPrefix = $dataLabelPostfix = $yLabelPrefix = $yLabelPostfix = $xLabelPrefix = $xLabelPostfix = '';
        $callAjax = false;
        $loadingText = esc_html__((isset($settings['iq_' . $type . '_chart_no_data_text']) ? $settings['iq_' . $type . '_chart_no_data_text'] : ''), 'graphina-charts-for-elementor');

        $exportFileName = (
            !empty($settings['iq_' . $type . '_can_chart_show_toolbar']) && $settings['iq_' . $type . '_can_chart_show_toolbar'] === 'yes'
            && !empty($settings['iq_' . $type . '_export_filename'])
        ) ? $settings['iq_' . $type . '_export_filename'] : $mainId;

        if ($settings['iq_' . $type . '_chart_datalabel_show'] === 'yes') {
            $dataLabelPrefix = $settings['iq_' . $type . '_chart_datalabel_prefix'];
            $dataLabelPostfix = $settings['iq_' . $type . '_chart_datalabel_postfix'];
        }

        if ($settings['iq_' . $type . '_chart_xaxis_label_show'] === 'yes') {
            $xLabelPrefix = $settings['iq_' . $type . '_chart_xaxis_label_prefix'];
            $xLabelPostfix = $settings['iq_' . $type . '_chart_xaxis_label_postfix'];
        }

        if ($settings['iq_' . $type . '_chart_yaxis_label_show'] === 'yes') {
            $yLabelPrefix = $settings['iq_' . $type . '_chart_yaxis_label_prefix'];
            $yLabelPostfix = $settings['iq_' . $type . '_chart_yaxis_label_postfix'];
        }

        $seriesCount = isset($settings['iq_' . $type . '_chart_data_series_count']) ? $settings['iq_' . $type . '_chart_data_series_count'] : 0;
        for ($i = 0; $i < $seriesCount; $i++) {
            $dropShadowSeries[] = $i;
            if (!empty($settings['iq_' . $type . '_chart_tooltip_enabled_on_1_' . $i]) && $settings['iq_' . $type . '_chart_tooltip_enabled_on_1_' . $i] === "yes") {
                $tooltipSeries[] = $i;
            }
            $gradient[] = strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]);
            $second_gradient[] = strval($settings['iq_' . $type . '_chart_gradient_2_' . $i]) === '' ? strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]) : strval($settings['iq_' . $type . '_chart_gradient_2_' . $i]);
            $stockWidth[] = $settings['iq_' . $type . '_chart_width_3_' . $i] !== '' ? $settings['iq_' . $type . '_chart_width_3_' . $i] : 0;
            $stockDashArray[] = $settings['iq_' . $type . '_chart_dash_3_' . $i] !== '' ? $settings['iq_' . $type . '_chart_dash_3_' . $i] : 0;
            $markerSize[] = (int) $settings['iq_' . $type . '_chart_marker_size_'.$i];
            $markerStrokeColor[] = strval($settings[ 'iq_' . $type . '_chart_marker_stroke_color_'.$i]);
            $markerStokeWidth[] = (int)$settings[ 'iq_' . $type . '_chart_marker_stroke_width_'.$i];
            $markerShape[] = strval($settings['iq_' . $type . '_chart_chart_marker_stroke_shape_'.$i]);
        }

        if (isGraphinaPro() && $settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            $new_settings = graphina_setting_sort($settings);
            $callAjax = true;
            $loadingText = esc_html__('Loading...', 'graphina-charts-for-elementor');
            $gradient = $second_gradient = ['#ffffff'];
        } else {
            $new_settings = [];
            $categoryList = $settings['iq_' . $type . '_category_list'];
            if (gettype($categoryList) === "NULL") {
                $categoryList = [];
            }
            foreach ($categoryList as $v) {
                if(strpos($v['iq_' . $type . '_chart_category'], "," )){
                    $catarray =  explode(',',graphina_get_dynamic_tag_data($v, 'iq_' . $type . '_chart_category'));
                    $data["category"][] =  implode('[,]',$catarray);
                }else{
                    $data["category"][] = (string)graphina_get_dynamic_tag_data($v, 'iq_' . $type . '_chart_category');
                }
            }
            for ($i = 0; $i < $seriesCount; $i++) {
                $valueList = $settings['iq_' . $type . '_value_list_3_' . ($settings['iq_' . $type . '_can_chart_negative_values'] === 'yes' ? 2 : 1) . '_' . $i];
                $value = [];
                if (gettype($valueList) === "NULL") {
                    $valueList = [];
                }
                foreach ($valueList as $v) {
                    $value[] = (float)graphina_get_dynamic_tag_data($v, 'iq_' . $type . '_chart_value_3_' . $i);
                }
                $data['series'][] = [
                    'name' => (string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_title_3_' . $i),
                    'data' => $value,
                ];
            }

            if ($settings['iq_' . $type . '_chart_data_option'] === 'dynamic') {
                $data = ['series' => [], 'category' => []];
            }

            $gradient_new = $second_gradient_new = $stock_width_new = $stock_dash_array_new = [];
            $desiredLength = count($data['series']);
            while (count($gradient_new) < $desiredLength) {
                $gradient_new = array_merge($gradient_new, $gradient);
                $second_gradient_new = array_merge($second_gradient_new, $second_gradient);
                $stock_width_new = array_merge($stock_width_new, $stockWidth);
                $stock_dash_array_new = array_merge($stock_dash_array_new, $stockDashArray);
            }

            $gradient = array_slice($gradient_new, 0, $desiredLength);
            $second_gradient = array_slice($second_gradient_new, 0, $desiredLength);
            $stockWidth = array_slice($stock_width_new, 0, $desiredLength);
            $stockDashArray = array_slice($stock_dash_array_new, 0, $desiredLength);

        }

        $markerSize =  implode('_,_', $markerSize);
        $markerStrokeColor =  implode('_,_', $markerStrokeColor);
        $markerStokeWidth =  implode('_,_', $markerStokeWidth);
        $markerShape =  implode('_,_', $markerShape);
        $gradient = implode('_,_', $gradient);
        $second_gradient = implode('_,_', $second_gradient);
        $stockWidth = implode('_,_', $stockWidth);
        $stockDashArray = implode('_,_', $stockDashArray);
        $category = implode('_,_', $data['category']);
        $chartDataJson = json_encode($data['series']);
        $dropShadowSeries = implode(',', $dropShadowSeries);
        $tooltipSeries = implode(',', $tooltipSeries);
        $localStringType = graphina_common_setting_get('thousand_seperator');
        require GRAPHINA_ROOT . '/elementor/charts/line/render/line_chart.php';
        if (isRestrictedAccess('line', $this->get_id(), $settings, false) === false) {
            ?>
            <script>
                var myElement = document.querySelector(".line-chart-<?php esc_attr_e($mainId); ?>");

                if (typeof isInit === 'undefined') {
                    var isInit = {};
                }
                isInit['<?php esc_attr_e($mainId); ?>'] = false;
                var lineOptions = {
                    series: <?php echo $chartDataJson; ?>,
                    chart: {
                        background: '<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height']; ?>'),
                        type: 'line',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                        locales: [JSON.parse('<?php echo apexChartLocales(); ?>')],
                        defaultLocale: "en",
                        stacked:'<?php echo !empty($settings['iq_' . $type . '_chart_stacked']) && $settings['iq_' . $type . '_chart_stacked'] === 'yes' ; ?>',
                        animations: {
                            enabled: '<?php echo($settings['iq_' . $type . '_chart_animation'] === "yes"); ?>',
                            speed: '<?php echo $settings['iq_' . $type . '_chart_animation_speed']; ?>',
                            delay: '<?php echo $settings['iq_' . $type . '_chart_animation_delay']; ?>',
                            dynamicAnimation: {
                                enabled: true
                            }
                        },
                        toolbar: {
                            offsetX: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_toolbar_offsetx']) ? $settings['iq_' . $type . '_chart_toolbar_offsetx'] : 0 ;?>') || 0,
                            offsetY: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_toolbar_offsety']) ? $settings['iq_' . $type . '_chart_toolbar_offsety'] : 0 ;?>')|| 0,
                            show: '<?php echo $settings['iq_' . $type . '_can_chart_show_toolbar']; ?>',
                            export: {
                                csv: {
                                    filename: "<?php echo $exportFileName; ?>"
                                },
                                svg: {
                                    filename: "<?php echo $exportFileName; ?>"
                                },
                                png: {
                                    filename: "<?php echo $exportFileName; ?>"
                                }
                            }
                        },
                        dropShadow: {
                            enabled: '<?php echo($settings['iq_' . $type . '_is_chart_dropshadow'] === "yes"); ?>',
                            enabledOnSeries: [<?php  echo  esc_html($dropShadowSeries); ?>],
                            top: parseInt('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_top']; ?>'),
                            left: parseInt('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_left']; ?>'),
                            blur: parseInt('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_blur']; ?>'),
                            color: '<?php echo strval(isset($settings['iq_' . $type . '_is_chart_dropshadow_color']) ? $settings['iq_' . $type . '_is_chart_dropshadow_color'] : ''); ?>',
                            opacity: parseFloat('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_opacity']; ?>')
                        }
                    },
                    noData: {
                        text: '<?php echo $loadingText; ?>',
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                            color: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>'
                        }
                    },
                    dataLabels: {
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_datalabel_show'] === 'yes'; ?>',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                            fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                            colors: ['<?php echo $settings['iq_' . $type . '_chart_datalabel_background_show'] === "yes" ? strval($settings['iq_' . $type . '_chart_datalabel_font_color_1']) : strval($settings['iq_' . $type . '_chart_datalabel_font_color']); ?>']
                        },
                        background: {
                            enabled: '<?php echo $settings['iq_' . $type . '_chart_datalabel_background_show'] === "yes"; ?>',
                            borderRadius:parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_border_radius']) ? $settings['iq_' . $type . '_chart_datalabel_border_radius'] : 0 ?>'),
                            foreColor: ['<?php echo strval($settings['iq_' . $type . '_chart_datalabel_background_color']); ?>'],
                            borderWidth: parseInt('<?php echo $settings['iq_' . $type . '_chart_datalabel_border_width']; ?>'),
                            borderColor: '<?php echo strval($settings['iq_' . $type . '_chart_datalabel_border_color']); ?>'
                        },
                        formatter: function (val, opts) {
                            if(isNaN(val)){
                                return '';
                            }
                            if("<?php echo   !empty($settings['iq_' . $type . '_chart_number_format_commas']) &&  esc_html($settings['iq_' . $type . '_chart_number_format_commas']) === "yes"; ?>" ){
                                val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                            }
                            else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_yaxis_label_pointer']) && esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer']) === 'yes'; ?>"
                            &&  typeof graphinaAbbrNum  !== "undefined"){      
                                val = graphinaAbbrNum(val ,  parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer_number']); ?>") || 0 );
                            }
                            return '<?php  echo  esc_html($dataLabelPrefix); ?>' + val + '<?php echo   esc_html($dataLabelPostfix); ?>';
                        },
                         offsetY: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_offsety']) ? $settings['iq_' . $type . '_chart_datalabel_offsety'] : 0 ?>'),
                         offsetX: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_offsetx']) ? $settings['iq_' . $type . '_chart_datalabel_offsetx'] : 0 ?>'),
                    },
                    stroke: {
                        curve: '<?php echo $settings['iq_' . $type . '_chart_line_curve']; ?>',
                        width: '<?php echo $stockWidth; ?>'.split('_,_'),
                        dashArray: '<?php echo $stockDashArray; ?>'.split('_,_')
                    },
                    grid: {
                        borderColor: '<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_line_grid_color'])  ? strval($settings['iq_' . $type . '_chart_yaxis_line_grid_color']) : '#90A4AE'; ?>',
                        yaxis: {
                            lines: {
                                show: '<?php echo $settings['iq_' . $type . '_chart_yaxis_line_show'] === "yes"; ?>'
                            }
                        }
                    },
                    xaxis: {
                        categories: '<?php echo $category; ?>'.split('_,_').map(
                            catData => catData.split('[,]')
                        ),
                        position: '<?php  echo  esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_position']); ?>',
                        tickAmount: parseInt("<?php echo   esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_tick_amount']); ?>"),
                        tickPlacement: "<?php  echo  esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_tick_placement']) ?>",
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_show'] === "yes"; ?>',
                            rotateAlways: '<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_auto_rotate'] === "yes"; ?>',
                            rotate: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_rotate']; ?>') || 0,
                            offsetX: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_offset_x']; ?>') || 0,
                            offsetY: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_offset_y']; ?>') || 0,
                            hideOverlappingLabels: true,
                            trim: true,
                            style: {
                                colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
                                fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                                fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                                fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>'
                            },
                            formatter: function (val) {
                                if('<?php echo !empty( $settings['iq_' . $type . '_chart_xaxis_label_show']) && $settings['iq_' . $type . '_chart_xaxis_label_show'] === 'yes' ?>'){
                                    return '<?php  echo  esc_html($xLabelPrefix) ; ?>' + val + '<?php  echo  esc_html($xLabelPostfix); ?>';
                                }
                                return val
                            }
                        },
                        tooltip: {
                            enabled: "<?php echo !empty($settings['iq_' . $type . '_chart_xaxis_tooltip_show']) && $settings['iq_' . $type . '_chart_xaxis_tooltip_show'] === 'yes';?>"
                        },
                        crosshairs: {
                            show: "<?php echo !empty($settings['iq_' . $type . '_chart_xaxis_crosshairs_show']) && $settings['iq_' . $type . '_chart_xaxis_crosshairs_show'] === 'yes';?>"
                        }
                    },
                    yaxis: {
                        opposite: '<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_position']); ?>',
                        tickAmount: parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount']); ?>"),
                        decimalsInFloat: parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float']); ?>"),
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_show'] === "yes"; ?>',
                            rotate: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_rotate']; ?>') || 0,
                            offsetX: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_offset_x']; ?>') || 0,
                            offsetY: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_offset_y']; ?>') || 0,
                            trim: true,
                            style: {
                                colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
                                fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                                fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                                fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>'
                            }
                        },
                        tooltip: {
                            enabled: "<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_tooltip_show']) && $settings['iq_' . $type . '_chart_yaxis_tooltip_show'] === 'yes';?>"
                        },
                        crosshairs: {
                            show: "<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_crosshairs_show']) && $settings['iq_' . $type . '_chart_yaxis_crosshairs_show'] === 'yes';?>"
                        }
                    },
                    colors: '<?php echo $gradient; ?>'.split('_,_'),
                    fill: {
                        type: '<?php echo $settings['iq_' . $type . '_chart_fill_style_type']; ?>',
                        opacity: 1,
                        colors: '<?php echo $gradient; ?>'.split('_,_'),
                        gradient: {
                            gradientToColors: '<?php echo $second_gradient; ?>'.split('_,_'),
                            type: '<?php echo $settings['iq_' . $type . '_chart_gradient_type']; ?>',
                            inverseColors: '<?php echo $settings['iq_' . $type . '_chart_gradient_inversecolor'] === "yes"; ?>',
                            opacityFrom: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityFrom']; ?>'),
                            opacityTo: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityTo']; ?>')
                        }
                    },
                    legend: {
                        showForSingleSeries:true,
                        show: '<?php echo $settings['iq_' . $type . '_chart_legend_show']; ?>' === 'yes',
                        position: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_position']) ? esc_html($settings['iq_' . $type . '_chart_legend_position']) : 'bottom' ; ?>',
                        horizontalAlign: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_horizontal_align']) ? esc_html($settings['iq_' . $type . '_chart_legend_horizontal_align']) : 'center' ; ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                        labels: {
                            colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>'
                        },
                        tooltipHoverFormatter: function(seriesName, opts) {
                            if('<?php echo !empty($settings['iq_' . $type . '_chart_legend_show_series_value']) && $settings['iq_' . $type . '_chart_legend_show_series_value'] === 'yes' ?>'){
                                return '<div class="legend-info">' + '<span>' + seriesName + '</span>' + ' : '+'<strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>' + '</div>'
                            }
                            return seriesName
                        }
                    },
                    tooltip: {
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_tooltip'] === "yes"; ?>',
                        shared: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_shared']) && $settings['iq_' . $type . '_chart_tooltip_shared'] === "yes"? $settings['iq_' . $type . '_chart_tooltip_shared'] : ''; ?>' ,
                        intersect: !('<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_shared']) && $settings['iq_' . $type . '_chart_tooltip_shared'] === "yes"? $settings['iq_' . $type . '_chart_tooltip_shared'] : ''; ?>' ),
                        theme: '<?php echo $settings['iq_' . $type . '_chart_tooltip_theme']; ?>',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>'
                        }
                    },
                    responsive: [{
                        breakpoint: 1024,
                        options: {
                            chart: {
                                height: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_height_tablet']) ? $settings['iq_' . $type . '_chart_height_tablet'] : $settings['iq_' . $type . '_chart_height'] ; ?>')
                            }
                        }
                    },
                        {
                            breakpoint: 674,
                            options: {
                                chart: {
                                    height: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_height_mobile']) ? $settings['iq_' . $type . '_chart_height_mobile'] : $settings['iq_' . $type . '_chart_height'] ;  ?>')
                                }
                            }
                        }
                    ]
                };

                if ("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_label_show']) === "yes"; ?>" ) {
                    lineOptions.yaxis.labels.formatter = function (val) {
                        let decimal = parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point']) ? $settings['iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point'] : 0; ?>') || 0;
                        if("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_format_number']) === "yes"; ?>" ){
                            val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>',decimal)
                        }
                        else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_yaxis_label_pointer']) && esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer']) === 'yes'; ?>"
                        &&  typeof graphinaAbbrNum  !== "undefined"){      
                            val = graphinaAbbrNum(val ,  parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer_number']); ?>") || 0 );
                        }else{
                            val = parseFloat(val).toFixed(decimal)
                        }
                        return '<?php  echo  esc_html($yLabelPrefix); ?>' +  val  + '<?php  echo  esc_html($yLabelPostfix); ?>';
                    }
                }
                if ("<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_shared']) && $settings['iq_' . $type . '_chart_tooltip_shared'] === "yes"? $settings['iq_' . $type . '_chart_tooltip_shared'] : '';?>" ) {
                    lineOptions.tooltip['enabledOnSeries'] = [<?php echo   esc_html($tooltipSeries); ?>];
                }
                if ("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_0_indicator_show']) === "yes"; ?>" ) {
                    lineOptions['annotations'] = {
                        yaxis: [
                            {
                                y: 0,
                                strokeDashArray: parseInt("<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash']) ? $settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash'] : 0; ?>"),
                                borderColor: '<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_color']) ? strval($settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_color']) : "#000000"; ?>'
                            }
                        ]
                    };
                }
                    lineOptions['markers'] ={
                        size: '<?php echo $markerSize; ?>'.split('_,_'),
                        strokeColors: '<?php echo $markerStrokeColor; ?>'.split('_,_'),
                        strokeWidth: '<?php echo $markerStokeWidth; ?>'.split('_,_'),
                        shape: '<?php echo $markerShape; ?>'.split('_,_'),
                        showNullDataPoints: true,
                        hover: {
                            size: 3,
                            sizeOffset: 1
                        }
                    };

                if("<?php echo $settings['iq_' . $type . '_chart_xaxis_title_enable'] == 'yes' ;?>"){
                    let style ={
                        color:'<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                    }
                    let title = '<?php echo strval($settings['iq_' . $type . '_chart_xaxis_title']); ?>';
                    let xaxisYoffset ='<?php  echo  esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_position']) === 'top'; ?>'  ? -95 : 0;
                    if(typeof axisTitle !== "undefined"){
                        axisTitle(lineOptions, 'xaxis' ,title, style,xaxisYoffset );
                    }
                }

                if("<?php echo $settings['iq_' . $type . '_chart_yaxis_title_enable'] == 'yes' ; ?>"){
                    let style ={
                        color:'<?php echo strval($settings['iq_' . $type . '_card_yaxis_title_font_color']); ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                    }
                    let title = '<?php echo strval($settings['iq_' . $type . '_chart_yaxis_title']); ?>';
                    if(typeof axisTitle !== "undefined"){
                        axisTitle(lineOptions, 'yaxis' ,title, style );
                    }
                }

                if('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_enable_min_max']) && $settings['iq_' . $type . '_chart_yaxis_enable_min_max'] === 'yes' ?>'){
                    lineOptions.yaxis.tickAmount = parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount']); ?>") || 6;
                    lineOptions.yaxis.min = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_min_value']) ? $settings['iq_' . $type . '_chart_yaxis_min_value'] : 0  ?>') || 0;
                    lineOptions.yaxis.max = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_max_value']) ? $settings['iq_' . $type . '_chart_yaxis_max_value'] : 0  ?>') || 200;
                }

                if("<?php echo !empty($settings['iq_' . $type . '_chart_opposite_yaxis_title_enable']) && $settings['iq_' . $type . '_chart_opposite_yaxis_title_enable'] == 'yes' ;  ?>"){
                    let style = {
                        color:'<?php echo strval($settings['iq_' . $type . '_card_opposite_yaxis_title_font_color']); ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                    }
                    lineOptions['yaxis'] = [lineOptions.yaxis]
                    let lineYaxisTemp = {
                        opposite: '<?php echo $settings['iq_'.$type.'_chart_yaxis_datalabel_position'] === 'yes' ? false : true ; ?>',
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_opposite_yaxis_label_show'] === 'yes'; ?>',
                            formatter: function (val) {
                                if("<?php  echo   esc_html($settings['iq_' . $type . '_chart_opposite_yaxis_format_number']) === "yes"; ?>" ){
                                    val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                                }
                                return '<?php echo $settings['iq_' .$type . '_chart_opposite_yaxis_label_prefix'] ;?>'  + val + '<?php echo $settings['iq_' .$type . '_chart_opposite_yaxis_label_postfix'] ;?>'
                            },
                            style
                        },
                        tickAmount: parseInt('<?php echo $settings['iq_' . $type . '_chart_opposite_yaxis_tick_amount']; ?>'),
                        title: {
                            text: '<?php echo $settings['iq_' .$type . '_chart_opposite_yaxis_title'] ;?>',
                            style
                        }
                    }
                    if('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_enable_min_max']) && $settings['iq_' . $type . '_chart_yaxis_enable_min_max'] === 'yes' ?>'){
                        lineYaxisTemp.tickAmount = parseInt('<?php echo $settings['iq_' . $type . '_chart_opposite_yaxis_tick_amount']; ?>') || 6;
                        lineYaxisTemp.min = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_min_value']) ? $settings['iq_' . $type . '_chart_yaxis_min_value'] : 0  ?>') || 0;
                        lineYaxisTemp.max = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_max_value']) ? $settings['iq_' . $type . '_chart_yaxis_max_value'] : 0  ?>') || 200;
                    }

                    lineOptions.yaxis.push(lineYaxisTemp)
                }

                if (typeof initNowGraphina !== "undefined") {
                    initNowGraphina(
                        myElement,
                        {
                            ele: document.querySelector(".line-chart-<?php esc_attr_e($mainId); ?>"),
                            options: lineOptions,
                            series: [{name: '', data: []}],
                            animation: true
                        },
                        '<?php esc_attr_e($mainId); ?>'
                    );
                }
                if (window.ajaxIntervalGraphina_<?php echo $mainId; ?> !== undefined) {
                    clearInterval(window.ajaxIntervalGraphina_<?php echo $mainId; ?>)
                }

            </script>
            <?php
        }
        if ($settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            if($settings['iq_' . $type . '_chart_data_option'] === 'forminator'){
                graphina_ajax_reload(true, $settings, $type, $mainId);
            }else if(isGraphinaPro()){
                graphina_ajax_reload($callAjax, $new_settings, $type, $mainId);
            }
        }
    }

}

Plugin::instance()->widgets_manager->register(new Line_chart());