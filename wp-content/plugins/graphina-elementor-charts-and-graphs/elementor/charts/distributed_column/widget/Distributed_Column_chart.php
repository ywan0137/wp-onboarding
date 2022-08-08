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
class Distributed_Column_chart extends Widget_Base
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
        return 'distributed_column_chart';
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
        return 'Distributed Column';
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
        return 'graphina-apex-distributedcolumn-chart';
    }

    public function get_chart_type()
    {
        return 'distributed_column';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type, 7, true);

        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
            ]
        );

        graphina_common_chart_setting($this, $type, false, true, true);

        graphina_tooltip($this, $type);

        $this->add_control(
            'iq_' . $type . '_is_chart_stroke_width',
            [
                'label' => esc_html__('Column Width', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 50,
                'min' => 1,
                'max' => 100,
                'step' => 10
            ]
        );

        $this->add_responsive_control(
            'iq_' . $type . '_is_chart_horizontal',
            [
                'label' => esc_html__('Horizontal', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'desktop_default' => false,
                'tablet_default' => false,
                'mobile_default' => false,
            ]
        );

        graphina_dropshadow($this, $type);

        graphina_animation($this, $type);

        $this->add_control(
            'iq_' . $type . '_chart_hr_plot_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_plot_setting_title',
            [
                'label' => esc_html__('Plot Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_plot_border_radius',
            [
                'label' => esc_html__('Border Radius', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 0
            ]
        );

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
                    ['iq_' . $type . '_chart_category' => 'July'],
                    ['iq_' . $type . '_chart_category' => 'Aug'],
                ],
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ],
            ]
        );

        $this->end_controls_section();

        graphina_chart_label_setting($this, $type);

        graphina_advance_x_axis_setting($this, $type);

        graphina_advance_y_axis_setting($this, $type);

        graphina_series_setting($this, $type, ['tooltip', 'color'], true, ['classic', 'gradient', 'pattern'], true, true);

        $this->start_controls_section(
            'iq_' . $type . '_section_4_',
            [
                'label' => esc_html__('Element 1', 'graphina-charts-for-elementor'),
                'condition' => [
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
        $repeater = new Repeater();

        $repeater->add_control(
            'iq_' . $type . '_chart_value_4_',
            [
                'label' => esc_html__('Chart Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        /** Chart value list. */
        $this->add_control(
            'iq_' . $type . '_value_list_4_1_',
            [
                'label' => esc_html__('Chart value list', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(100, 200)],
                ],
                'condition' => [
                    'iq_' . $type . '_can_chart_negative_values!' => 'yes'
                ],
                'title_field' => '{{{ iq_' . $type . '_chart_value_4_}}}',
            ]
        );
        /** Chart value list. */

        /** Chart value negative list. */
        $this->add_control(
            'iq_' . $type . '_value_list_4_2_',
            [
                'label' => esc_html__('Chart value list', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                    ['iq_' . $type . '_chart_value_4_' => rand(-200, 200)],
                ],
                'condition' => [
                    'iq_' . $type . '_can_chart_negative_values' => 'yes'
                ],
                'title_field' => '{{{ iq_' . $type . '_chart_value_4_ }}}',
            ]
        );
        /** Chart value negative list. */

        $this->end_controls_section();

        graphina_style_section($this, $type);

        graphina_card_style($this, $type);

        graphina_chart_style($this, $type);

        graphina_chart_filter_style($this,$type);

        if (function_exists('graphina_pro_password_style_section')) {
            graphina_pro_password_style_section($this, $type);
        }

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $mainId = $this->get_id();
        $type = $this->get_chart_type();
        $gradient = [];
        $second_gradient = [];
        $fill_pattern = [];
        $datalables_offset_y = 0;
        $datalables_offset_x = 0;
        $dropshadowSeries = [];
        $tooltipSeries = [];
        $data = ['series' => [], 'category' => []];
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
            if (strval($settings['iq_' . $type . '_chart_gradient_2_' . $i]) === '') {
                $second_gradient[] = strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]);
            } else {
                $second_gradient[] = strval($settings['iq_' . $type . '_chart_gradient_2_' . $i]);
            }
            if ($settings['iq_' . $type . '_chart_bg_pattern_' . $i] !== '') {
                $fill_pattern[] = $settings['iq_' . $type . '_chart_bg_pattern_' . $i];
            } else {
                $fill_pattern[] = 'verticalLines';
            }
        }

        $categoryList = $settings['iq_' . $type . '_category_list'];

        if (isGraphinaPro() && $settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            $new_settings = graphina_setting_sort($settings);
            $callAjax = true;
            $gradient = $second_gradient = ['#ffffff'];
            $loadingText = esc_html__('Loading...', 'graphina-charts-for-elementor');
        } else {
            $new_settings = [];
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
            $valueList = $settings['iq_' . $type . '_value_list_4_1_'];
            $value = [];
            if (gettype($valueList) === "NULL") {
                $valueList = [];
            }
            foreach ($valueList as $v) {
                $value[] = (float)graphina_get_dynamic_tag_data($v, 'iq_' . $type . '_chart_value_4_');
            }
            $data['series'][] = [
                'data' => $value,
            ];
            if ($settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
                $data = ['series' => [], 'category' => []];
            }
            $gradient_new = $second_gradient_new = $fill_pattern_new = [];
        }

        $gradient = implode('_,_', $gradient);
        $second_gradient = implode('_,_', $second_gradient);
        $fill_pattern = implode('_,_', $fill_pattern);
        $dropshadowSeries = implode(',', $dropshadowSeries);
        $tooltipSeries = implode(',', $tooltipSeries);
        $category = implode('_,_', $data['category']);
        $chartDataJson = json_encode($data['series']);
        $localStringType = graphina_common_setting_get('thousand_seperator');

        if ($settings['iq_' . $type . '_chart_datalabel_position_show'] == "top" && $settings['iq_' . $type . '_is_chart_horizontal'] == "yes") {
            $datalables_offset_x = 20;
        } elseif ($settings['iq_' . $type . '_chart_datalabel_position_show'] == "top" && $settings['iq_' . $type . '_is_chart_horizontal'] != "yes") {
            $datalables_offset_y = -20;
        }
        require GRAPHINA_ROOT . '/elementor/charts/distributed_column/render/Distributed_Column_chart.php';
        if (isRestrictedAccess('column', $this->get_id(), $settings, false) === false) {
            ?>
            <script>
                var myElement = document.querySelector(".distributed_column-chart-<?php esc_attr_e($mainId); ?>");

                if (typeof isInit === 'undefined') {
                    var isInit = {};
                }
                isInit['<?php esc_attr_e($mainId); ?>'] = false;

                var columnOptions = {
                    series: <?php echo $chartDataJson ?>,
                    chart: {
                        background: '<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height']; ?>'),
                        type: 'bar',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        locales: [JSON.parse('<?php echo apexChartLocales(); ?>')],
                        defaultLocale: "en",
                        animations: {
                            enabled: '<?php echo($settings['iq_' . $type . '_chart_animation'] === "yes"); ?>',
                            speed: '<?php echo $settings['iq_' . $type . '_chart_animation_speed']; ?>',
                            //delay: '<?php //echo $settings['iq_' . $type . '_chart_animation_delay'] ?>//'
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
                            enabled: '<?php echo($settings['iq_' . $type . '_is_chart_dropshadow'] === "yes") ?>',
                            enabledOnSeries: [<?php  echo   esc_html($dropshadowSeries); ?>],
                            top: parseInt('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_top'] ?>'),
                            left: parseInt('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_left'] ?>'),
                            blur: parseInt('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_blur'] ?>'),
                            color: '<?php echo strval(isset($settings['iq_' . $type . '_is_chart_dropshadow_color']) ? $settings['iq_' . $type . '_is_chart_dropshadow_color'] : ''); ?>',
                            opacity: parseFloat('<?php echo $settings['iq_' . $type . '_is_chart_dropshadow_opacity'] ?>')
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: '<?php echo $settings['iq_' . $type . '_is_chart_horizontal'] ?>',
                            columnWidth: '<?php echo $settings['iq_' . $type . '_is_chart_stroke_width'] ?>% ',
                            borderRadius: parseInt('<?php echo $settings['iq_' . $type . '_chart_plot_border_radius'] ?>') || 0,
                            dataLabels: {
                                position: '<?php echo $settings['iq_' . $type . '_chart_datalabel_position_show'] ?>',
                            },
                            distributed:true
                        },
                    },
                    noData: {
                        text: '<?php echo $loadingText; ?>',
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                            color: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']) ?>'
                        }
                    },
                    dataLabels: {
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_datalabel_show'] === "yes"; ?>',
                        offsetY: parseFloat('<?php echo $datalables_offset_y ?>'),
                        offsetX: parseFloat('<?php echo $datalables_offset_x ?>'),
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
                            borderWidth: parseInt('<?php echo $settings['iq_' . $type . '_chart_datalabel_border_width']; ?>') || 0,
                            borderColor: '<?php echo strval($settings['iq_' . $type . '_chart_datalabel_border_color']); ?>'
                        },
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    grid: {
                        borderColor: '<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_line_grid_color'])  ? strval($settings['iq_' . $type . '_chart_yaxis_line_grid_color']) : '#90A4AE'; ?>',
                        yaxis: {
                            lines: {
                                show: '<?php echo $settings['iq_' . $type . '_chart_yaxis_line_show'] ?>'
                            }
                        }
                    },
                    xaxis: {
                        categories: '<?php echo $category; ?>'.split('_,_').map(
                            catData => catData.split('[,]')
                        ),
                        position: '<?php echo   esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_position']) ?>',
                        tickAmount: parseInt("<?php echo   esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_tick_amount']); ?>"),
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_show'] ?>',
                            rotateAlways: '<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_auto_rotate'] ?>',
                            rotate: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_rotate'] ?>') || 0,
                            offsetX: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_offset_x'] ?>')|| 0,
                            offsetY: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_offset_y'] ?>') || 0,
                            trim: true,
                            style: {
                                colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']) ?>',
                                fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                                fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                                fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight'] ?>'
                            },
                            formatter: function (val) {
                                if('<?php echo !empty( $settings['iq_' . $type . '_chart_xaxis_label_show']) && $settings['iq_' . $type . '_chart_xaxis_label_show'] === 'yes' ?>'){
                                    return '<?php  echo  esc_html($xLabelPrefix) ; ?>' + val + '<?php  echo   esc_html($xLabelPostfix); ?>';
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
                        opposite: '<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_position']) ?>',
                        decimalsInFloat: parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float']); ?>"),
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_show'] ?>',
                            rotate: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_rotate'] ?>') || 0,
                            offsetX: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_offset_x'] ?>') || 0,
                            offsetY: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_offset_y'] ?>') || 0,
                            style: {
                                colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']) ?>',
                                fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                                fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                                fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight'] ?>'
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
                        type: '<?php echo $settings['iq_' . $type . '_chart_fill_style_type'] ?>',
                        opacity: parseFloat('<?php echo $settings['iq_' . $type . '_chart_fill_opacity'] ?>'),
                        colors: '<?php echo $gradient; ?>'.split('_,_'),
                        gradient: {
                            gradientToColors: '<?php echo $second_gradient; ?>'.split('_,_'),
                            type: '<?php echo $settings['iq_' . $type . '_chart_gradient_type'] ?>',
                            inverseColors: '<?php echo $settings['iq_' . $type . '_chart_gradient_inversecolor'] ?>',
                            opacityFrom: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityFrom'] ?>'),
                            opacityTo: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityTo'] ?>')
                        },
                        pattern: {
                            style: '<?php echo $fill_pattern ?>'.split('_,_'),
                            width: 6,
                            height: 6,
                            strokeWidth: 2
                        }
                    },
                    legend: {
                        showForSingleSeries:true,
                        show: '<?php echo $settings['iq_' . $type . '_chart_legend_show'] ?>',
                        position: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_position']) ? esc_html($settings['iq_' . $type . '_chart_legend_position']) : 'bottom' ; ?>',
                        horizontalAlign: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_horizontal_align']) ? esc_html($settings['iq_' . $type . '_chart_legend_horizontal_align']) : 'center' ; ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight'] ?>',
                        labels: {
                            colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']) ?>'
                        }
                    },
                    tooltip: {
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_tooltip'] ?>',
                        theme: '<?php echo $settings['iq_' . $type . '_chart_tooltip_theme'] ?>',
                        shared: '<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_shared']) && $settings['iq_' . $type . '_chart_tooltip_shared'] === "yes" ? $settings['iq_' . $type . '_chart_tooltip_shared'] : ''; ?>' ,
                        intersect:!('<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_shared']) && $settings['iq_' . $type . '_chart_tooltip_shared'] === "yes" ? $settings['iq_' . $type . '_chart_tooltip_shared'] : ''; ?>'),
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>'
                        }
                    },
                    responsive: [{
                        breakpoint: 1024,
                        options: {
                            chart: {
                                height: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_height_tablet']) ? $settings['iq_' . $type . '_chart_height_tablet'] : $settings['iq_' . $type . '_chart_height'] ; ?>')
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: '<?php echo !empty($settings['iq_' . $type . '_is_chart_horizontal_tablet'])  && $settings['iq_' . $type . '_is_chart_horizontal_tablet'] === "yes" ; ?>'
                                }
                            }
                        }
                    },
                        {
                            breakpoint: 674,
                            options: {
                                chart: {
                                    height: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_height_mobile']) ? $settings['iq_' . $type . '_chart_height_mobile'] : $settings['iq_' . $type . '_chart_height'] ;  ?>')
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: '<?php echo !empty($settings['iq_' . $type . '_is_chart_horizontal_mobile'])  && $settings['iq_' . $type . '_is_chart_horizontal_mobile'] === "yes" ; ?>'
                                    }
                                }
                            }
                        }
                    ]
                };

                if ("<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_label_show'])=== "yes"; ?>" ) {
                    columnOptions.yaxis.labels.formatter = function (val) {
                         let decimal = parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point']) ? $settings['iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point'] : 0; ?>') || 0;
                         if("<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_format_number']) === "yes"; ?>"){
                            val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>',decimal)
                        }
                        else if("<?php echo   !empty($settings['iq_' . $type . '_chart_yaxis_label_pointer']) && esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer'])=== 'yes'; ?>"
                        &&  typeof graphinaAbbrNum  !== "undefined"){      
                            val = graphinaAbbrNum(val ,  parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer_number']); ?>") || 0 );
                        }else{
                            val = parseFloat(val).toFixed(decimal)
                        }
                        return '<?php  echo  esc_html($yLabelPrefix); ?>' + val + '<?php  echo  esc_html($yLabelPostfix); ?>';
                    }
                }
                columnOptions.yaxis.tickAmount = parseInt("<?php  echo   esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount']); ?>");
                columnOptions.dataLabels.formatter = function (val) {
                    if(Number.isNaN(val)){
                        return  '';
                    }
                    if("<?php  echo  !empty($settings['iq_' . $type . '_chart_number_format_commas']) &&  esc_html($settings['iq_' . $type . '_chart_number_format_commas'])=== "yes"; ?>" ){
                        val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                    }
                    else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_label_pointer_for_label']) && esc_html($settings['iq_' . $type . '_chart_label_pointer_for_label']) === 'yes'; ?>"
                        &&  typeof graphinaAbbrNum  !== "undefined"){
                        val = graphinaAbbrNum(val ,  parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_label_pointer_number_for_label']); ?>") || 0 );
                    }
                    return '<?php echo   esc_html($dataLabelPrefix) ?>' + val + '<?php echo   esc_html($dataLabelPostfix) ?>';
                };

                if ("<?php echo !empty($settings['iq_' . $type . '_chart_tooltip_shared']) && $settings['iq_' . $type . '_chart_tooltip_shared'] === "yes" ? $settings['iq_' . $type . '_chart_tooltip_shared'] : '';?>" ) {
                    columnOptions.tooltip['enabledOnSeries'] = [<?php  echo  esc_html($tooltipSeries); ?>];
                }
                if ("<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_0_indicator_show']) === "yes"; ?>" ) {
                    columnOptions['annotations'] = {
                        yaxis: [
                            {
                                y: 0,
                                strokeDashArray: parseInt("<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash']) ? $settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash'] : 0; ?>"),
                                borderColor: '<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_color']) ? strval($settings['iq_' . $type . '_chart_yaxis_0_indicator_stroke_color']) : "#000000"; ?>'
                            }
                        ]
                    };
                }

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
                        axisTitle(columnOptions, 'xaxis' ,title, style ,xaxisYoffset);
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
                        axisTitle(columnOptions, 'yaxis' ,title, style );
                    }
                }

                if('<?php echo !empty($settings['iq_' . $type . '_chart_xaxis_enable_min_max']) && $settings['iq_' . $type . '_chart_xaxis_enable_min_max'] === 'yes' ?>'){
                    columnOptions.xaxis.tickAmount = parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_tick_amount']); ?>") || 6;
                    columnOptions.xaxis.min = parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_xaxis_min_value']) ? $settings['iq_' . $type . '_chart_xaxis_min_value'] : 0  ?>') || 0;
                    columnOptions.xaxis.max = parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_xaxis_max_value']) ? $settings['iq_' . $type . '_chart_xaxis_max_value'] : 0  ?>') || 200;
                }

                if('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_enable_min_max']) && $settings['iq_' . $type . '_chart_yaxis_enable_min_max'] === 'yes' ?>'){
                    columnOptions.yaxis.tickAmount = parseInt("<?php  echo   esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount']); ?>") || 6;
                    columnOptions.yaxis.min = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_min_value']) ? $settings['iq_' . $type . '_chart_yaxis_min_value'] : 0  ?>') || 0;
                    columnOptions.yaxis.max = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_max_value']) ? $settings['iq_' . $type . '_chart_yaxis_max_value'] : 0  ?>') || 200;
                }

                if (typeof initNowGraphina !== "undefined") {
                    initNowGraphina(
                        myElement,
                        {
                            ele: document.querySelector(".distributed_column-chart-<?php esc_attr_e($mainId); ?>"),
                            options: columnOptions,
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

Plugin::instance()->widgets_manager->register(new Distributed_Column_chart());