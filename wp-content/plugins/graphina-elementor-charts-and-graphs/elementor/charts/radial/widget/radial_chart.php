<?php

namespace Elementor;
if (!defined('ABSPATH')) exit;

class Radial_chart extends Widget_Base
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
        return 'radial_chart';
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
        return 'Radial';
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
        return 'graphina-apex-radial-chart';
    }

    public function get_chart_type()
    {
        return 'radial';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();
        $defaultLabel = graphina_default_setting('categories');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type);

        $this->start_controls_section(
            'iq_' . $type . '_chart_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
            ]
        );

        graphina_common_chart_setting($this, $type, true, true, false, false);

        graphina_tooltip($this, $type, true, false);

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
            'iq_' . $type . '_chart_is_stroke_rounded',
            [
                'label' => esc_html__('Linecap Stroke Rounded', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => false,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_line_width',
            [
                'label' => esc_html__('Line width (%)', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 20,
                'max' => 70,
                'step' => 5,
                'default' => 30
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_track_width',
            [
                'label' => 'Track Width',
                'type' => Controls_Manager::NUMBER,
                'default' => 97,
                'min' => 0,
                'max' => 100
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_track_color_enable',
            [
                'label' => esc_html__('Chart Track Background Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => false,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_track_color',
            [
                'label' => 'Track Color',
                'type' => Controls_Manager::COLOR,
                'default' => "#808080",
                'condition' =>[
                    'iq_' . $type . '_chart_track_color_enable' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_track_opacity',
            [
                'label' => 'Track Opacity',
                'type' => Controls_Manager::NUMBER,
                'default' => 0.2,
                'min' => 0,
                'max' => 0.5,
                'step' => 0.01
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_angle',
            [
                'label' => esc_html__('Radial Shape', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__('Circle', 'graphina-charts-for-elementor'),
                    'semi_circle' => esc_html__('Semi Circle', 'graphina-charts-for-elementor'),
                    'custom' => esc_html__('Custom', 'graphina-charts-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_start_angle',
            [
                'label' => esc_html__('Start Angle', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 315,
                'step' => 5,
                'default' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_angle' => 'custom',
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_end_angle',
            [
                'label' => esc_html__('End Angle', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 45,
                'max' => 360,
                'step' => 5,
                'default' => 270,
                'condition' => [
                    'iq_' . $type . '_chart_angle' => 'custom',
                ]
            ]
        );

        graphina_animation($this, $type);

        $this->end_controls_section();

        graphina_chart_label_setting($this, $type);

        graphina_series_setting($this, $type, ['color'], true, ['classic', 'gradient', 'pattern'], false, true);

        for ($i = 0; $i <= graphina_default_setting('max_series_value'); $i++) {

            $this->start_controls_section(
                'iq_' . $type . '_section_series' . $i,
                [
                    'label' => esc_html__('Element ' . ($i + 1), 'graphina-charts-for-elementor'),
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range($i + 1, graphina_default_setting('max_series_value')),
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
                'iq_' . $type . '_chart_label' . $i,
                [
                    'label' => 'Label',
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Label', 'graphina-charts-for-elementor'),
                    'default' => $defaultLabel[$i],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $this->add_control(
                'iq_' . $type . '_chart_value' . $i,
                [
                    'label' => 'Value',
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                    'default' => rand(50, 95),
                    'dynamic' => [
                        'active' => true,
                    ],
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

    }

    protected function render()
    {
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();
        $mainId = $this->get_id();
        $valueList = $settings['iq_' . $type . '_chart_data_series_count'];
        $gradient = [];
        $second_gradient = [];
        $fill_pattern = [];
        $dataLabelPrefix = $dataLabelPostfix = '';
        $data = ['category' => [], 'series' => [], 'total' => 0];
        $callAjax = false;
        $loadingText = esc_html__((isset($settings['iq_' . $type . '_chart_no_data_text']) ? $settings['iq_' . $type . '_chart_no_data_text'] : ''), 'graphina-charts-for-elementor');

        $exportFileName = (
            !empty($settings['iq_' . $type . '_can_chart_show_toolbar']) && $settings['iq_' . $type . '_can_chart_show_toolbar'] === 'yes'
            && !empty($settings['iq_' . $type . '_export_filename'])
        ) ? $settings['iq_' . $type . '_export_filename'] : $mainId;

        if (gettype($valueList) === "NULL") {
            $valueList = 0;
        }
        if ($settings['iq_' . $type . '_chart_datalabel_show'] === 'yes') {
            $dataLabelPrefix = $settings['iq_' . $type . '_chart_datalabel_prefix'];
            $dataLabelPostfix = $settings['iq_' . $type . '_chart_datalabel_postfix'];
        }

        if ($settings['iq_' . $type . '_chart_angle'] == 'circle') {
            $start_angle = 0;
            $end_angle = 360;
        } elseif ($settings['iq_' . $type . '_chart_angle'] == 'semi_circle') {
            $start_angle = -90;
            $end_angle = 90;
        } else {
            $start_angle = $settings['iq_' . $type . '_chart_start_angle'];
            $end_angle = $settings['iq_' . $type . '_chart_end_angle'];
        }

        for ($i = 0; $i < $valueList; $i++) {
            $gradient[] = strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]);
            $second_gradient[] = !isset($settings['iq_' . $type . '_chart_gradient_2_' . $i]) ? strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]) : strval($settings['iq_' . $type . '_chart_gradient_2_' . $i]);
            $fill_pattern[] = isset($settings['iq_' . $type . '_chart_bg_pattern_' . $i]) ? $settings['iq_' . $type . '_chart_bg_pattern_' . $i] : 'verticalLines';
        }

        if (isGraphinaPro() && $settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            $new_settings = graphina_setting_sort($settings);
            $callAjax = true;
            $gradient = $second_gradient = ['#ffffff'];
            $loadingText = esc_html__('Loading...', 'graphina-charts-for-elementor');
        } else {
            for ($i = 0; $i < $valueList; $i++) {
                $data["category"][] = (string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_label' . $i);
                $val = (float)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_value' . $i);
                $data["series"][] = $val;
                $data['total'] += $val;
            }
            $gradient_new = $second_gradient_new = $fill_pattern_new = [];
            $desiredLength = count($data['series']);
            while (count($gradient_new) < $desiredLength) {
                $gradient_new = array_merge($gradient_new, $gradient);
                $second_gradient_new = array_merge($second_gradient_new, $second_gradient);
                $fill_pattern_new = array_merge($fill_pattern_new, $fill_pattern);
            }

            $gradient = array_slice($gradient_new, 0, $desiredLength);
            $second_gradient = array_slice($second_gradient_new, 0, $desiredLength);
            $fill_pattern = array_slice($fill_pattern_new, 0, $desiredLength);
        }

        $gradient = implode('_,_', $gradient);
        $second_gradient = implode('_,_', $second_gradient);
        $fill_pattern = implode('_,_', $fill_pattern);
        $label = implode('_,_', $data['category']);
        $value = implode(',', $data['series']);
        $localStringType = graphina_common_setting_get('thousand_seperator');

        require GRAPHINA_ROOT . '/elementor/charts/radial/render/radial_chart.php';
        if (isRestrictedAccess('radial', $this->get_id(), $settings, false) === false) {
            ?>
            <script>

                var myElement = document.querySelector(".radial-chart-<?php esc_attr_e($this->get_id()); ?>");
                if (typeof isInit === 'undefined') {
                    var isInit = {};
                }
                isInit['<?php esc_attr_e($this->get_id()); ?>'] = false;

                var radialOptions = {
                    series: [<?php echo   esc_html($value); ?>],
                    chart: {
                        background: '<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height'] ?>'),
                        type: 'radialBar',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                        locales: [JSON.parse('<?php echo apexChartLocales(); ?>')],
                        defaultLocale: "en",
                        toolbar: {
                            offsetX: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_toolbar_offsetx']) ? $settings['iq_' . $type . '_chart_toolbar_offsetx'] : 0 ;?>') || 0,
                            offsetY: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_toolbar_offsety']) ? $settings['iq_' . $type . '_chart_toolbar_offsety'] : 0 ;?>')|| 0,
                            show: '<?php echo $settings['iq_' . $type . '_can_chart_show_toolbar'] ?>',
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
                        animations: {
                            enabled: '<?php echo($settings['iq_' . $type . '_chart_animation'] === "yes") ?>',
                            speed: '<?php echo $settings['iq_' . $type . '_chart_animation_speed'] ?>',
                            delay: '<?php echo $settings['iq_' . $type . '_chart_animation_delay'] ?>'
                        }
                    },
                    labels: '<?php echo $label; ?>'.split('_,_'),
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
                    colors: '<?php echo $gradient; ?>'.split('_,_'),
                    plotOptions: {
                        radialBar: {
                            startAngle: parseInt('<?php esc_attr_e($start_angle) ?>'),
                            endAngle: parseInt('<?php esc_attr_e($end_angle) ?>'),
                            hollow: {
                                size: '<?php echo strval(70 - $settings['iq_' . $type . '_chart_line_width']) ?>'
                            },
                            dataLabels: {
                                show: <?php  echo($settings['iq_' . $type . '_chart_datalabel_show'] === 'yes' ? 'true' : 'false') ?>,
                                name: {
                                    fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                                    fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight'] ?>',
                                    fontSize: '<?php echo ((int)$settings['iq_' . $type . '_chart_font_size']['size'] + 2) . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                                },
                                value: {
                                    formatter: function (val) {
                                        if("<?php echo   !empty($settings['iq_' . $type . '_chart_number_format_commas']) &&  esc_html($settings['iq_' . $type . '_chart_number_format_commas']) === "yes"; ?>" ){
                                            val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                                        }
                                        else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_label_pointer_for_label']) && esc_html($settings['iq_' . $type . '_chart_label_pointer_for_label']) === 'yes'; ?>"
                                        &&  typeof graphinaAbbrNum  !== "undefined"){      
                                            val = graphinaAbbrNum(val ,  parseInt("<?php echo    esc_html($settings['iq_' . $type . '_chart_label_pointer_number_for_label']); ?>") || 0 );
                                        }
                                        return '<?php  echo  esc_html($dataLabelPrefix) ?>' + val + '<?php  echo   esc_html($dataLabelPostfix) ?>';
                                    },
                                    fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                                    fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight'] ?>',
                                    color: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']) ?>',
                                    fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                                },
                                total: {
                                    fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                                    fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight'] ?>',
                                    color: '<?php echo strval($settings['iq_' . $type . '_chart_datalabel_font_color']) ?>',
                                    fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                                    show: <?php echo($settings['iq_' . $type . '_chart_datalabel_show'] === 'yes' ? 'true' : 'false') ?>,
                                    label: '<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_total_title']) ? $settings['iq_' . $type . '_chart_datalabel_total_title'] : 'Total' ?>',
                                    formatter: function (w) {
                                        let total =   w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b
                                        }, 0) ;
                                        if("<?php  echo  !empty($settings['iq_' . $type . '_chart_number_format_commas']) &&  esc_html($settings['iq_' . $type . '_chart_number_format_commas']) === "yes"; ?>" ){
                                            total = total.toLocaleString('<?php echo $localStringType ?>')
                                        }else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_label_pointer_for_label']) && esc_html($settings['iq_' . $type . '_chart_label_pointer_for_label']) === 'yes'; ?>"
                                        &&  typeof graphinaAbbrNum  !== "undefined"){      
                                            total = graphinaAbbrNum(total ,  parseInt("<?php echo   esc_html($settings['iq_' . $type . '_chart_label_pointer_number_for_label']); ?>") || 0 );
                                        }

                                        return '<?php  echo  esc_html($dataLabelPrefix) ?>' + total + '<?php echo   esc_html($dataLabelPostfix) ?>';
                                    }
                                },
                                offsetY: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_offsety']) ? $settings['iq_' . $type . '_chart_datalabel_offsety'] : 0 ?>'),
                                offsetX: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_offsetx']) ? $settings['iq_' . $type . '_chart_datalabel_offsetx'] : 0 ?>'),
                            },
                            track: {
                                show: true,
                                background: '<?php echo $gradient; ?>'.split('_,_'),
                                strokeWidth: parseFloat('<?php echo $settings['iq_' . $type . '_chart_track_width'] ?>') + '%',
                                opacity: parseFloat('<?php echo $settings['iq_' . $type . '_chart_track_opacity'] ?>')
                            }
                        }
                    },
                    stroke: {
                        lineCap: '<?php echo($settings['iq_' . $type . '_chart_is_stroke_rounded'] === "yes" ? "round" : "") ?>'
                    },
                    fill: {
                        type: '<?php echo($settings['iq_' . $type . '_chart_fill_style_type']) ?>',
                        opacity: 1,
                        colors: '<?php echo $gradient; ?>'.split('_,_'),
                        gradient: {
                            gradientToColors: '<?php echo $second_gradient; ?>'.split('_,_'),
                            type: '<?php echo $settings['iq_' . $type . '_chart_gradient_type'] ?>',
                            inverseColors: '<?php echo $settings['iq_' . $type . '_chart_gradient_inversecolor'] ?>',
                            opacityFrom: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityFrom'] ?>'),
                            opacityTo: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityTo'] ?>')
                        },
                        pattern: {
                            style: '<?php echo $fill_pattern; ?>'.split('_,_'),
                            width: 6,
                            height: 6,
                            strokeWidth: 2
                        }
                    },
                    legend: {
                        showForSingleSeries:true,
                        show: '<?php echo $settings['iq_' . $type . '_chart_legend_show'] === "yes" && $label != '' && $value != ''; ?>',
                        position: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_position']) ? esc_html($settings['iq_' . $type . '_chart_legend_position']) : 'bottom' ; ?>',
                        horizontalAlign: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_horizontal_align']) ? esc_html($settings['iq_' . $type . '_chart_legend_horizontal_align']) : 'center' ; ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                        labels: {
                            colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>'
                        },
                        formatter: function(seriesName, opts) {
                            if('<?php echo !empty($settings['iq_' . $type . '_chart_legend_show_series_value']) && $settings['iq_' . $type . '_chart_legend_show_series_value'] === 'yes' ?>'){
                                return '<div class="legend-info">' + '<span>' + seriesName + '</span>' + ' : '+'<strong>' + opts.w.globals.series[opts.seriesIndex] + '</strong>' + '</div>'
                            }
                            return seriesName
                        }
                    },
                    tooltip: {
                        theme: '<?php echo $settings['iq_' . $type . '_chart_tooltip_theme'] ?>',
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_tooltip'] ?>',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit'] ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>'
                        },
                        y: {
                            formatter: function(val) {
                                if('<?php  echo !empty($settings[ 'iq_' . $type . '_chart_number_format_commas' ]) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ?>'){
                                    val= graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                                }else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_label_pointer_for_label']) && esc_html($settings['iq_' . $type . '_chart_label_pointer_for_label']) === 'yes'; ?>"
                                    &&  typeof graphinaAbbrNum  !== "undefined"){
                                    val = graphinaAbbrNum(val ,  parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_label_pointer_number_for_label']); ?>") || 0 );
                                }
                                return '<?php  echo  esc_html($dataLabelPrefix) ?>' + val + '<?php echo   esc_html($dataLabelPostfix) ?>'
                            }
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

                if('<?php echo !empty($settings['iq_' . $type . '_chart_track_color_enable']) && $settings['iq_' . $type . '_chart_track_color_enable'] ?>'){
                    radialOptions.plotOptions.radialBar.track.background = '<?php echo !empty($settings['iq_' . $type . '_chart_track_color']) ? strval($settings['iq_' . $type . '_chart_track_color']) : strval('#808080') ; ?>'
                }

                if (typeof initNowGraphina !== "undefined") {
                    initNowGraphina(
                        myElement,
                        {
                            ele: document.querySelector(".radial-chart-<?php esc_attr_e($this->get_id()); ?>"),
                            options: radialOptions,
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

Plugin::instance()->widgets_manager->register(new \Elementor\Radial_chart());