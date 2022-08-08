<?php

namespace Elementor;
if (!defined('ABSPATH')) exit;

class Polar_chart extends Widget_Base
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
        return 'polar_chart';
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
        return 'Polar';
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
        return 'graphina-apex-polar-chart';
    }

    public function get_chart_type()
    {
        return 'polar';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();
        $defaultLabel = graphina_default_setting('categories', 'string');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type);

        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
            ]
        );

        graphina_common_chart_setting($this, $type, false, false, false, false);

        graphina_tooltip($this, $type, true, false);

        graphina_animation($this, $type);

        $this->end_controls_section();

        graphina_chart_label_setting($this, $type);

        $this->start_controls_section(
            'iq_' . $type . '_section_6',
            [
                'label' => esc_html__('Advance Y-Axis Setting', 'graphina-charts-for-elementor'),
            ]
        );

        graphina_yaxis_min_max_setting($this,$type);

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_datalabel_show',
            [
                'label' => esc_html__('Labels', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_datalabel_tick_amount',
            [
                'label' => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'max' => 30,
                'min' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_datalabel_format',
            [
                'label' => esc_html__('Format', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no',
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_yaxis_chart_number_format_commas',
            [
                'label' => esc_html__('Format Number(Commas)', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no',
                'condition'=>[
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_format'=> 'yes',
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_format_prefix',
            [
                'label' => esc_html__('Label Prefix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition'=>[
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_format'=> 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_format_postfix',
            [
                'label' => esc_html__('Label Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition'=>[
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_format'=> 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point',
            [
                'label' => esc_html__('Decimals In Float', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' =>0,
                'max' => 6,
                'min' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_label_pointer!' =>'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_label_pointer',
            [
                'label' => esc_html__('Format Number to String', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_format'=> 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                ],
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false,
                'description' => esc_html__('Note: Convert 1,000  => 1k and 1,000,000 => 1m', 'graphina-charts-for-elementor'),
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_yaxis_label_pointer_number',
            [
                'label' => esc_html__('Number of Decimal Want', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_label_pointer' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_format'=> 'yes',
                ]
            ]
        );


        $this->end_controls_section();

        graphina_series_setting($this, $type, ['color'], true, ['classic', 'gradient', 'pattern'], true, false);

        for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

            $this->start_controls_section(
                'iq_' . $type . '_section_series' . $i,
                [
                    'label' => esc_html__('Element ' . ($i + 1), 'graphina-charts-for-elementor'),
                    'default' => rand(50, 200),
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
                    'default' => rand(25, 200),
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

        graphina_dyanmic_chart_style_section($this, $type);
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
        $data = ['category' => [], 'series' => []];
        $callAjax = false;
        $loadingText = esc_html__((isset($settings['iq_' . $type . '_chart_no_data_text']) ? $settings['iq_' . $type . '_chart_no_data_text'] : ''), 'graphina-charts-for-elementor');

        $exportFileName = (
            !empty($settings['iq_' . $type . '_can_chart_show_toolbar']) && $settings['iq_' . $type . '_can_chart_show_toolbar'] === 'yes'
            && !empty($settings['iq_' . $type . '_export_filename'])
        ) ? $settings['iq_' . $type . '_export_filename'] : $mainId;

        if (gettype($valueList) === "NULL") {
            $valueList = 0;
        }
        for ($i = 0; $i < $valueList; $i++) {
            $gradient[] = strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]);
            $second_gradient[] = isset($settings['iq_' . $type . '_chart_gradient_2_' . $i]) ? strval($settings['iq_' . $type . '_chart_gradient_2_' . $i]) : strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]);
            $fill_pattern[] = $settings['iq_' . $type . '_chart_bg_pattern_' . $i] !== '' ? $settings['iq_' . $type . '_chart_bg_pattern_' . $i] : 'verticalLines';
        }
        if (isGraphinaPro() && $settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            $new_settings = graphina_setting_sort($settings);
            $callAjax = true;
            $gradient = $second_gradient = ['#ffffff'];
            $loadingText = esc_html__('Loading...', 'graphina-charts-for-elementor');
        } else {
            $new_settings = [];
            for ($i = 0; $i < $valueList; $i++) {
                $data["category"][] = (string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_label' . $i);
                $data["series"][] = (float)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_value' . $i);
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

        require GRAPHINA_ROOT . '/elementor/charts/polar/render/polar_chart.php';
        if (isRestrictedAccess('polar', $this->get_id(), $settings, false) === false) {
            ?>
            <script>
                var myElement = document.querySelector(".polar-chart-<?php esc_attr_e($this->get_id()); ?>");
                if (typeof isInit === 'undefined') {
                    var isInit = {};
                }
                isInit['<?php esc_attr_e($this->get_id()); ?>'] = false;

                var polarOptions = {
                    series: [<?php echo   esc_html($value); ?>],
                    chart: {
                        background: '<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height']; ?>'),
                        type: 'polarArea',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                        locales: [JSON.parse('<?php echo apexChartLocales(); ?>')],
                        defaultLocale: "en",
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
                        animations: {
                            enabled: '<?php echo($settings['iq_' . $type . '_chart_animation'] === "yes") ?>',
                            speed: '<?php echo $settings['iq_' . $type . '_chart_animation_speed']; ?>',
                            delay: '<?php echo $settings['iq_' . $type . '_chart_animation_delay']; ?>',
                            dynamicAnimation: {
                                enabled: true
                            }
                        },
                    },
                    labels: '<?php echo $label; ?>'.split('_,_'),
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
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_datalabel_show'] === "yes"; ?>',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                            fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                            colors: ['<?php echo isset($settings['iq_' . $type . '_chart_datalabel_font_color']) ? strval($settings['iq_' . $type . '_chart_datalabel_font_color']) : '#ffffff'; ?>'],
                        },
                        background:{
                            enabled: false
                        },
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    yaxis: {
                        show: '<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_show'] === "yes"; ?>',
                        tickamount:parseInt("<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount']) ? $settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount'] : 6 ; ?>") || 6,
                        labels: {
                            style: {
                                colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
                                fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                                fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                                fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>'
                            },
                            formatter: function(val) {
                                if('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_datalabel_format']) && $settings['iq_' . $type . '_chart_yaxis_datalabel_format'] === 'yes' ?>'){
                                    let decimal = parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point']) ? $settings['iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point'] : 0; ?>') || 0;
                                    if("<?php echo   esc_html($settings['iq_' . $type . '_yaxis_chart_number_format_commas']); ?>" === "yes"){
                                        val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>',decimal)
                                    }
                                    else if("<?php  echo  !empty($settings['iq_' . $type . '_chart_yaxis_label_pointer']) && esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer']) === 'yes'; ?>"
                                        &&  typeof graphinaAbbrNum  !== "undefined"){
                                        val = graphinaAbbrNum(val ,  parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer_number']); ?>") || 0 );
                                    }else{
                                        val = parseFloat(val).toFixed(decimal)
                                    }
                                    return '<?php  echo   !empty($settings[ 'iq_' . $type . '_chart_yaxis_format_prefix']) ?
                                            esc_html($settings[ 'iq_' . $type . '_chart_yaxis_format_prefix']): '' ; ?>'
                                        + val + '<?php echo   !empty($settings[ 'iq_' . $type . '_chart_yaxis_format_postfix']) ?
                                            esc_html($settings[ 'iq_' . $type . '_chart_yaxis_format_postfix']): ''; ?>';
                                }else{
                                    return val;
                                }
                            }
                        }
                    },
                    colors: '<?php echo $gradient; ?>'.split('_,_'),
                    fill: {
                        type: '<?php echo $settings['iq_' . $type . '_chart_fill_style_type']; ?>',
                        opacity: parseFloat('<?php echo $settings['iq_' . $type . '_chart_fill_opacity']; ?>') || 0.4,
                        colors: '<?php echo $gradient; ?>'.split('_,_'),
                        gradient: {
                            gradientToColors: '<?php echo $second_gradient; ?>'.split('_,_'),
                            inverseColors: '<?php echo $settings['iq_' . $type . '_chart_gradient_inversecolor']; ?>',
                            opacityFrom: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityFrom']; ?>'),
                            opacityTo: parseFloat('<?php echo $settings['iq_' . $type . '_chart_gradient_opacityTo']; ?>')
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
                        show: '<?php echo $settings['iq_' . $type . '_chart_legend_show'] == "yes" && $label != '' && $value != ''; ?>',
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
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_tooltip'] === "yes"; ?>',
                        theme: '<?php echo $settings['iq_' . $type . '_chart_tooltip_theme']; ?>',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>'
                        },
                        y: {
                            formatter: function(val) {
                                let valueInStringShow =  '<?php echo !empty($settings[ 'iq_' . $type . '_chart_label_pointer']) ? $settings[ 'iq_' . $type . '_chart_label_pointer'] : 'no' ?>'
                                let valueInString =  '<?php echo !empty($settings[ 'iq_' . $type . '_chart_label_pointer_number']) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number'] : 0 ?>'
                                let prefix = '<?php echo !empty($settings[ 'iq_' . $type . '_chart_datalabel_format_prefix']) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix'] : '' ?>'
                                let postfix = '<?php echo !empty($settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ]) ? $settings['iq_' . $type . '_chart_datalabel_format_postfix'] : '' ?>'
                                if('<?php  echo !empty($settings[ 'iq_' . $type . '_chart_number_format_commas' ]) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ?>'){
                                    val= graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                                }else{
                                    val = valueInStringShow == 'no' ? val : graphinaAbbrNum(val , valueInString);
                                }
                                return prefix + val + postfix
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

                if("<?php echo $settings['iq_' . $type . '_chart_datalabels_format'] === 'yes'?>"){
                    let valueInStringShow =  '<?php echo !empty($settings[ 'iq_' . $type . '_chart_label_pointer']) ? $settings[ 'iq_' . $type . '_chart_label_pointer'] : 'no' ?>'
                    let valueInStringValue =  '<?php echo !empty($settings[ 'iq_' . $type . '_chart_label_pointer_number']) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number'] : 0 ?>'
                    let showlabel = '<?php echo !empty($settings[ 'iq_' . $type . '_chart_datalabels_format_showlabel']) ? $settings[ 'iq_' . $type . '_chart_datalabels_format_showlabel'] : 'no' ?>'
                    let showValue = '<?php echo !empty($settings[  'iq_' . $type . '_chart_datalabels_format_showValue']) ? $settings[  'iq_' . $type . '_chart_datalabels_format_showValue'] : 'no' ?>'
                    let prefix = '<?php echo !empty($settings[ 'iq_' . $type . '_chart_datalabel_format_prefix']) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix'] : '' ?>'
                    let postfix = '<?php echo !empty($settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ]) ? $settings['iq_' . $type . '_chart_datalabel_format_postfix'] : '' ?>'
                    let numberformat = '<?php echo !empty($settings[ 'iq_' . $type . '_chart_number_format_commas' ]) ? $settings['iq_' . $type . '_chart_number_format_commas'] : 'no' ?>'
                    if(typeof chartDatalabelsFormat !== "undefined"){
                        chartDatalabelsFormat(polarOptions, showlabel, showValue, numberformat, prefix, postfix,valueInStringShow, valueInStringValue);
                    }
                }

                if('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_enable_min_max']) && $settings['iq_' . $type . '_chart_yaxis_enable_min_max'] === 'yes' ?>'){
                    polarOptions.yaxis.min = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_min_value']) ? $settings['iq_' . $type . '_chart_yaxis_min_value'] : 0  ?>') || 0;
                    polarOptions.yaxis.max = parseFloat('<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_max_value']) ? $settings['iq_' . $type . '_chart_yaxis_max_value'] : 0  ?>') || 200;
                }

                if (typeof initNowGraphina !== "undefined") {
                    initNowGraphina(
                        myElement,
                        {
                            ele: document.querySelector(".polar-chart-<?php esc_attr_e($mainId); ?>"),
                            options: polarOptions,
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
        if (isGraphinaPro() && $settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            graphina_ajax_reload($callAjax, $new_settings, $type, $mainId);
        }
    }

}

Plugin::instance()->widgets_manager->register(new \Elementor\Polar_chart());