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
class Bubble_chart extends Widget_Base
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
        return 'bubble_chart';
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
        return 'Bubble';
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
        return 'graphina-apex-bubble-chart';
    }

    /***********************************************
     * @param string $type
     * @param $i
     * @param int $count
     * @param int[] $x
     * @param int[] $y
     * @param int[] $z
     * @return array
     */

    /*
     * ----------------  Sample Object Of Array  ------------------
     * [
     *   'iq_type_chart_x_value_3_' => 50,
     *   'iq_type_chart_y_value_3_' => 30,
     *   'iq_type_chart_z_value_3_' => 40,
     * ]
     */

    protected function bubbleDataGenerator($type = '', $i = 0, $count = 20, $x = ["min" => 10, "max" => 1000], $y = ["min" => 10, "max" => 200], $z = ["min" => 10, "max" => 200])
    {
        $result = [];
        for ($j = 0; $j < $count; $j++) {
            $result[] = [
                'iq_' . $type . '_chart_x_value_3_' . $i => rand($x["min"], $x["max"]),
                'iq_' . $type . '_chart_y_value_3_' . $i => rand($y["min"], $y["max"]),
                'iq_' . $type . '_chart_z_value_3_' . $i => rand($z["min"], $z["max"]),
            ];
        }
        return $result;
    }

    public function get_chart_type()
    {
        return 'bubble';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();
        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type);

        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
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

        graphina_common_chart_setting($this, $type, false, true, false, false);

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
            'iq_' . $type . '_chart_fill_opacity',
            [
                'label' => esc_html__('Fill Opacity', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 0,
                'max' => 1,
                'step' => 0.05
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_stroke_width',
            [
                'label' => 'Stroke Width',
                'type' => Controls_Manager::NUMBER,
                'default' => 2,
                'min' => 0,
                'max' => 15
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_stroke_color',
            [
                'label' => 'Stroke Color',
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition' => [
                    'iq_' . $type . '_chart_stroke_width!' => 0
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_3d_show',
            [
                'label' => esc_html__('3D Chart', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => false,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_is_custom_radius',
            [
                'label' => esc_html__('Custom Bubble Radius', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => false,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_min_bubble_radius',
            [
                'label' => esc_html__('Minimum Bubble Radius', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 25,
                'max' => 100,
                'min' => 10,
                'condition' => [
                    'iq_' . $type . '_chart_is_custom_radius' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_max_bubble_radius',
            [
                'label' => esc_html__('Maximum Bubble Radius', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 70,
                'max' => 200,
                'min' => 10,
                'condition' => [
                    'iq_' . $type . '_chart_is_custom_radius' => 'yes',
                ],
            ]
        );

        graphina_animation($this, $type);

        $this->end_controls_section();

        graphina_chart_label_setting($this, $type);

        $this->start_controls_section(
            'iq_' . $type . '_section_5',
            [
                'label' => esc_html__('X-Axis Setting', 'graphina-charts-for-elementor'),
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
            'iq_' . $type . '_chart_xaxis_tooltip_show',
            [
                'label' => esc_html__('Tooltip', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => ''
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_show',
            [
                'label' => esc_html__('Labels', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_position',
            [
                'label' => esc_html__('Position', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'bottom',
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'plugin-domain'),
                        'icon' => 'fa fa-arrow-up',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'plugin-domain'),
                        'icon' => 'fa fa-arrow-down',
                    ]
                ],
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate',
            [
                'label' => esc_html__('Labels Auto Rotate', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('False', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('True', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_rotate',
            [
                'label' => esc_html__('Rotate', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => -45,
                'max' => 360,
                'min' => -360,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_offset_x',
            [
                'label' => esc_html__('Offset-X', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_offset_y',
            [
                'label' => esc_html__('Offset-Y', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_tick_amount',
            [
                'label' => esc_html__('Tick Amount', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'max' => 30,
                'min' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_tick_placement',
            [
                'label' => esc_html__('Tick Placement', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => graphina_position_type('placement', true),
                'options' => graphina_position_type('placement'),
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );


        $this->add_control(
            'iq_' . $type . '_chart_xaxis_title_enable',
            [
                'label' => esc_html__('Enable Title', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_xaxis_title',
            [
                'label' => esc_html__('Xaxis Title', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_title_enable' => 'yes'
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();

        graphina_advance_y_axis_setting($this, $type);

        graphina_series_setting($this, $type, ['color'], false);

        for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

            $this->start_controls_section(
                'iq_' . $type . '_section_3_' . $i,
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
                    'label' => esc_html__('Element Title', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Tile', 'graphina-charts-for-elementor'),
                    'default' => 'Series ' . ($i + 1),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'iq_' . $type . '_chart_x_value_3_' . $i,
                [
                    'label' => 'Chart  X Value',
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => esc_html__('Add X Value', 'graphina-charts-for-elementor'),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater->add_control(
                'iq_' . $type . '_chart_y_value_3_' . $i,
                [
                    'label' => 'Chart Y Value',
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => esc_html__('Add Y Value', 'graphina-charts-for-elementor'),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater->add_control(
                'iq_' . $type . '_chart_z_value_3_' . $i,
                [
                    'label' => 'Chart Z Value',
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => esc_html__('Add Z Value', 'graphina-charts-for-elementor'),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $x = ["min" => 10, "max" => 1000];
            $y = ["min" => 10, "max" => 200];
            $z = ["min" => 10, "max" => 200];

            /** Chart value list. */
            $this->add_control(
                'iq_' . $type . '_value_list_3_' . $i,
                [
                    'label' => esc_html__('Chart value list', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => $this->bubbleDataGenerator('bubble', $i, 20, $x, $y, $z)
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
        $settings = $this->get_settings_for_display();
        $mainId = $this->get_id();
        $type = $this->get_chart_type();
        $color = [];
        $dataLabelPrefix = $dataLabelPostfix = $yLabelPrefix = $yLabelPostfix = '';
        $data = ['series' => [], 'category' => []];
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

        if ($settings['iq_' . $type . '_chart_yaxis_label_show'] === 'yes') {
            $yLabelPrefix = $settings['iq_' . $type . '_chart_yaxis_label_prefix'];
            $yLabelPostfix = $settings['iq_' . $type . '_chart_yaxis_label_postfix'];
        }

        $seriesCount = isset($settings['iq_' . $type . '_chart_data_series_count']) ? $settings['iq_' . $type . '_chart_data_series_count'] : 0;

        if (isGraphinaPro() && $settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
            $new_settings = graphina_setting_sort($settings);
            $callAjax = true;
            $loadingText = esc_html__('Loading...', 'graphina-charts-for-elementor');
            $color = ['#ffffff'];
        } else {
            $new_settings = [];
            for ($i = 0; $i < $seriesCount; $i++) {
                $color[] = strval($settings['iq_' . $type . '_chart_gradient_1_' . $i]);
            }
            for ($i = 0; $i < $seriesCount; $i++) {
                $formatedValue = [];
                $valueList = $settings['iq_' . $type . '_value_list_3_' . $i];
                if (gettype($valueList) === "NULL") {
                    $valueList = [];
                }
                foreach ($valueList as $key => $val) {
                    if ($val['iq_' . $type . '_chart_x_value_3_' . $i] != '' && $val['iq_' . $type . '_chart_y_value_3_' . $i] != '' && $val['iq_' . $type . '_chart_z_value_3_' . $i] != '') {
                        $formatedValue[] = [
                            'x' => (float)graphina_get_dynamic_tag_data($val, 'iq_' . $type . '_chart_x_value_3_' . $i),
                            'y' => (float)graphina_get_dynamic_tag_data($val, 'iq_' . $type . '_chart_y_value_3_' . $i),
                            'z' => (float)graphina_get_dynamic_tag_data($val, 'iq_' . $type . '_chart_z_value_3_' . $i),
                        ];
                    }
                }
                $data['series'][] = [
                    'name' => (string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_title_3_' . $i),
                    'data' => $formatedValue
                ];
            }
            if ($settings['iq_' . $type . '_chart_data_option'] !== 'manual') {
                $data = ['series' => [], 'category' => []];
            }
            $gradient_new = [];
            $desiredLength = count($data['series']);
            while (count($gradient_new) < $desiredLength) {
                $gradient_new = array_merge($gradient_new, $color);
            }
            array_slice($gradient_new, 0, $desiredLength);
        }

        $color = implode('_,_', $color);
        $chartDataJson = json_encode($data['series']);
        $localStringType = graphina_common_setting_get('thousand_seperator');

        require GRAPHINA_ROOT . '/elementor/charts/bubble/render/bubble_chart.php';
        if (isRestrictedAccess('bubble', $this->get_id(), $settings, false) === false) {

            ?>
            <script>
                var myElement = document.querySelector(".bubble-chart-<?php esc_attr_e($mainId); ?>");

                if (typeof isInit === 'undefined') {
                    var isInit = {};
                }
                isInit['<?php esc_attr_e($mainId); ?>'] = false;

                var bubbleOptions = {
                    series: <?php echo $chartDataJson; ?>,
                    chart: {
                        background: '<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height']; ?>'),
                        type: 'bubble',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family'] ?>',
                        locales: [JSON.parse('<?php echo apexChartLocales(); ?>')],
                        defaultLocale: "en",
                        toolbar: {
                            offsetX: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_toolbar_offsetx']) ? $settings['iq_' . $type . '_chart_toolbar_offsetx'] : 0 ;?>') || 0,
                            offsetY: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_toolbar_offsety']) ? $settings['iq_' . $type . '_chart_toolbar_offsety'] : 0 ;?>')|| 0,
                            show: '<?php echo $settings['iq_' . $type . '_can_chart_show_toolbar'] === "yes"; ?>',
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
                            enabled: '<?php echo($settings['iq_' . $type . '_chart_animation'] === "yes"); ?>',
                            speed: '<?php echo $settings['iq_' . $type . '_chart_animation_speed']; ?>',
                            delay: '<?php echo $settings['iq_' . $type . '_chart_animation_delay']; ?>'
                        }
                    },
                    plotOptions: {
                        bubble: {
                            minBubbleRadius: '<?php echo($settings['iq_' . $type . '_chart_is_custom_radius'] == "yes" ? $settings['iq_' . $type . '_chart_min_bubble_radius'] : 10); ?>',
                            maxBubbleRadius: '<?php echo($settings['iq_' . $type . '_chart_is_custom_radius'] == "yes" ? $settings['iq_' . $type . '_chart_max_bubble_radius'] : 50); ?>'
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
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_datalabel_show'] === "yes"; ?>',
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                            fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                            colors: ['<?php echo strval(isset($settings['iq_' . $type . '_chart_datalabel_font_color']) ? $settings['iq_' . $type . '_chart_datalabel_font_color'] : '#ffffff')?>']
                        },
                        formatter: function (val) {
                            if("<?php echo  !empty($settings['iq_' . $type . '_chart_number_format_commas']) &&  esc_html($settings['iq_' . $type . '_chart_number_format_commas'])=== "yes"; ?>" ){
                                val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                            }
                            else if("<?php echo !empty($settings['iq_' . $type . '_chart_yaxis_label_pointer']) && esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer'])=== 'yes'; ?>"
                            &&  typeof graphinaAbbrNum  !== "undefined"){      
                                val = graphinaAbbrNum(val ,  parseInt("<?php echo  esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer_number']); ?>") || 0 );
                            }
                            return '<?php  echo  esc_html($dataLabelPrefix); ?>' + val + '<?php echo   esc_html($dataLabelPostfix); ?>';
                        },
                        offsetY: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_offsety']) ? $settings['iq_' . $type . '_chart_datalabel_offsety'] : 0 ?>'),
                        offsetX: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_datalabel_offsetx']) ? $settings['iq_' . $type . '_chart_datalabel_offsetx'] : 0 ?>'),
                    },
                    colors: '<?php echo $color; ?>'.split('_,_'),
                    fill: {
                        opacity: parseFloat(<?php echo $settings['iq_' . $type . '_chart_fill_opacity']; ?>),
                        type: '<?php echo($settings['iq_' . $type . '_chart_3d_show'] == "yes" ? "gradient" : ""); ?>'
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
                        type: 'category',
                        categories: [],
                        position: '<?php  echo   esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_position']); ?>',
                        tickAmount: parseInt("<?php echo   esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_tick_amount']); ?>"),
                        tickPlacement: "<?php  echo  esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_tick_placement']) ?>",
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_show'] === "yes"; ?>',
                            rotateAlways: '<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_auto_rotate']; ?>',
                            rotate: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_rotate']; ?>') || 0,
                            offsetX: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_offset_x']; ?>')  || 0,
                            offsetY: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_datalabel_offset_y']; ?>')  || 0,
                            trim: true,
                            style: {
                                colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
                                fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                                fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                                fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>'
                            }
                        },
                        tooltip: {
                            enabled: "<?php echo !empty($settings['iq_' . $type . '_chart_xaxis_tooltip_show']) && $settings['iq_' . $type . '_chart_xaxis_tooltip_show'] === 'yes';?>"
                        }
                    },
                    yaxis: {
                        opposite: '<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_position']); ?>',
                        tickAmount: parseInt("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_tick_amount']); ?>"),
                        decimalsInFloat: parseInt("<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float']); ?>"),
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_show'] === "yes"; ?>',
                            rotate: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_rotate']; ?>')  || 0,
                            offsetX: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_offset_x']; ?>')  || 0,
                            offsetY: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_datalabel_offset_y']; ?>')  || 0,
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
                    legend: {
                        showForSingleSeries:true,
                        show: '<?php echo $settings['iq_' . $type . '_chart_legend_show'] === "yes"; ?>',
                        position: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_position']) ? esc_html($settings['iq_' . $type . '_chart_legend_position']) : 'bottom' ; ?>',
                        horizontalAlign: '<?php echo !empty($settings['iq_' . $type . '_chart_legend_horizontal_align']) ? esc_html($settings['iq_' . $type . '_chart_legend_horizontal_align']) : 'center' ; ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                        labels: {
                            colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>'
                        }
                    },
                    tooltip: {
                        theme: '<?php echo $settings['iq_' . $type . '_chart_tooltip_theme']; ?>',
                        enabled: '<?php echo $settings['iq_' . $type . '_chart_tooltip'] === "yes"; ?>',
                        x: {
                            format: "dd/MM/yy"
                        },
                        style: {
                            fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                            fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>'
                        }
                    },
                    markers: {
                        strokeWidth: parseInt('<?php echo $settings['iq_' . $type . '_chart_stroke_width']; ?>'),
                        strokeColors: '<?php echo strval($settings['iq_' . $type . '_chart_stroke_color']); ?>'
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

                if ("<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_label_show'])=== "yes"; ?>" ) {
                    bubbleOptions.yaxis.labels.formatter = function (val) {
                        if("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_format_number']) === "yes"; ?>" ){
                            val = graphinNumberWithCommas(val,'<?php echo $localStringType ?>')
                        }
                        else if("<?php echo   !empty($settings['iq_' . $type . '_chart_yaxis_label_pointer']) && esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer']) === 'yes'; ?>"
                        &&  typeof graphinaAbbrNum  !== "undefined"){     
                            val = graphinaAbbrNum(val ,  parseInt("<?php echo   esc_html($settings['iq_' . $type . '_chart_yaxis_label_pointer_number']); ?>") || 0 );
                        }
                        return '<?php echo   esc_html($yLabelPrefix); ?>' + val + '<?php  echo  esc_html($yLabelPostfix); ?>';
                    }
                }
                if ("<?php  echo  esc_html($settings['iq_' . $type . '_chart_yaxis_0_indicator_show'])=== "yes"; ?>" ) {
                    bubbleOptions['annotations'] = {
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
                    let xaxisYoffset ='<?php echo   esc_html($settings['iq_' . $type . '_chart_xaxis_datalabel_position']); ?>' === 'top' ? -95 : 0;
                    if(typeof axisTitle !== "undefined"){
                        axisTitle(bubbleOptions, 'xaxis' ,title, style,xaxisYoffset );
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
                        axisTitle(bubbleOptions, 'yaxis' ,title, style );
                    }
                }

                if("<?php echo !empty($settings['iq_' . $type . '_chart_opposite_yaxis_title_enable']) && $settings['iq_' . $type . '_chart_opposite_yaxis_title_enable'] == 'yes' ;  ?>"){
                    let style = {
                        color:'<?php echo strval($settings['iq_' . $type . '_card_opposite_yaxis_title_font_color']); ?>',
                        fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size']['size'] . $settings['iq_' . $type . '_chart_font_size']['unit']; ?>',
                        fontFamily: '<?php echo $settings['iq_' . $type . '_chart_font_family']; ?>',
                        fontWeight: '<?php echo $settings['iq_' . $type . '_chart_font_weight']; ?>',
                    }
                    bubbleOptions['yaxis'] = [bubbleOptions.yaxis]
                    bubbleOptions.yaxis.push({
                        opposite: '<?php echo $settings['iq_'.$type.'_chart_yaxis_datalabel_position'] === 'yes' ? false : true ; ?>',
                        labels: {
                            show: '<?php echo $settings['iq_' . $type . '_chart_opposite_yaxis_label_show'] === 'yes'; ?>',
                            formatter: function (val) {
                                if("<?php echo   esc_html($settings['iq_' . $type . '_chart_opposite_yaxis_format_number'])=== "yes"; ?>" ){
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
                    })
                }

                if (typeof initNowGraphina !== "undefined") {
                    initNowGraphina(
                        myElement,
                        {
                            ele: document.querySelector(".bubble-chart-<?php esc_attr_e($mainId); ?>"),
                            options: bubbleOptions,
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

Plugin::instance()->widgets_manager->register(new Bubble_chart());