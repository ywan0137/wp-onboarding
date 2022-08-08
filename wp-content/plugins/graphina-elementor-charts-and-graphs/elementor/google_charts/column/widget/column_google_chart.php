<?php

namespace Elementor;

Use Elementor\Core\Schemes\Typography as Scheme_Typography;

if (!defined('ABSPATH')) exit;

/**
 * Elementor Blog widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.5.7
 */
class Column_google_chart extends Widget_Base
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

    public function __construct($data = [], $args = null)
    {
        wp_register_script('googlecharts-min', GRAPHINA_URL.'/elementor/js/gstatic/loader.js', [], GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true);
        parent::__construct($data, $args);
    }

    public function get_script_depends() {
        return [
            'googlecharts-min'
        ];
    }

    public function get_name()
    {
        return 'column_google_chart';
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
        return 'Column';
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
        return ['iq-graphina-google-charts'];
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
        return 'graphina-google-column-chart';
    }

    public function get_chart_type()
    {
        return 'column_google';
    }

    protected function register_controls()
    { $type = $this->get_chart_type();
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
            'iq_' . $type . '_google_chart_title_heading',
            [
                'label' => esc_html__('Chart Title Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_title_show',
            [
                'label' => esc_html__('Chart Title Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_title',
            [
                'label' => esc_html__('Chart Title', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                'default' => esc_html__('Chart Title', 'graphina-charts-for-elementor'),
                'condition' => [
                    'iq_' . $type . '_google_chart_title_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_title_position',
            [
                'label' => esc_html__('Position', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'in' => esc_html__('In', 'graphina-charts-for-elementor'),
                    'out' => esc_html__('Out', 'graphina-charts-for-elementor')
                ],
                'default' => 'out',
                'condition' => [
                    'iq_' . $type . '_google_chart_title_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_google_chart_title_color',
            [
                'label' => esc_html__('Title Font Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'iq_' . $type . '_google_chart_title_show' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'iq_' . $type . '_google_chart_title_font_size',
            [
                'label' => esc_html__('Title Font Size', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => [
                    'iq_' . $type . '_google_chart_title_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_title_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        graphina_common_chart_setting($this, $type, false);

        graphina_tooltip($this, $type);

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
                'description' => esc_html__('Note: For multiline text seperate Text by comma(,) ','graphina-charts-for-elementor')
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

        graphina_advance_legend_setting($this, $type);

        graphina_advance_h_axis_setting($this, $type);

        graphina_advance_v_axis_setting($this, $type);

        graphina_column_chart_google_series_setting($this, $type, ['tooltip', 'color']);

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
                    'label' => 'Element Value',
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

        $this->start_controls_section(
            'iq_' . $type . '_style_section',
            [
                'label' => esc_html__('Style Section', 'graphina-charts-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'iq_' . $type . '_chart_card_show' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'iq_' . $type . '_title_options',
            [
                'label' => esc_html__('Title', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['iq_' . $type . '_is_card_heading_show' => 'yes'],
            ]
        );
        /** Header typography. */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'iq_' . $type . '_card_title_typography',
                'label' => esc_html__('Typography', 'graphina-charts-for-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .graphina-chart-heading',
                'condition' => ['iq_' . $type . '_is_card_heading_show' => 'yes']
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_title_align',
            [
                'label' => esc_html__('Alignment', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'graphina-charts-for-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'graphina-charts-for-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'graphina-charts-for-elementor'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'condition' => [
                    'iq_' . $type . '_is_card_heading_show' => 'yes'
                ]
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_title_font_color',
            [
                'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_title_margin',
            [
                'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'iq_' . $type . '_is_card_heading_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .graphina-chart-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_title_padding',
            [
                'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'iq_' . $type . '_is_card_heading_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .graphina-chart-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_subtitle_options',
            [
                'label' => esc_html__('Description', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['iq_' . $type . '_is_card_desc_show' => 'yes']
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'iq_' . $type . '_subtitle_typography',
                'label' => esc_html__('Typography', 'graphina-charts-for-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .graphina-chart-sub-heading',
                'condition' => ['iq_' . $type . '_is_card_desc_show' => 'yes']
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_subtitle_align',
            [
                'label' => esc_html__('Alignment', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'graphina-charts-for-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'graphina-charts-for-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'graphina-charts-for-elementor'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'condition' => [
                    'iq_' . $type . '_is_card_heading_show' => 'yes'
                ]
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_subtitle_font_color',
            [
                'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'iq_' . $type . '_is_card_heading_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .graphina-chart-sub-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_subtitle_padding',
            [
                'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'iq_' . $type . '_is_card_heading_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .graphina-chart-sub-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'iq_' . $type . '_card_style_section',
            [
                'label' => esc_html__('Card Style', 'graphina-charts-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'iq_' . $type . '_chart_card_show' => 'yes'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'iq_' . $type . '_card_background',
                'label' => esc_html__('Background', 'graphina-charts-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .chart-card',
                'condition' => [
                    'iq_' . $type . '_chart_card_show' => 'yes'
                ]
            ]
        );
    
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'iq_' . $type . '_card_box_shadow',
                'label' => esc_html__('Box Shadow', 'graphina-charts-for-elementor'),
                'selector' => '{{WRAPPER}} .chart-card',
                'condition' => ['iq_' . $type . '_chart_card_show' => 'yes']
            ]
        );
    
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'iq_' . $type . '_card_border',
                'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
                'selector' => '{{WRAPPER}} .chart-card',
                'condition' => ['iq_' . $type . '_chart_card_show' => 'yes']
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'graphina-charts-for-elementor'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'iq_' . $type . '_chart_card_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .chart-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'iq_' . $type . '_chart_style_section',
            [
                'label' => esc_html__('Chart Style', 'graphina-charts-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_chart_border_show',
            [
                'label' => esc_html__('Chart Box', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        );
    
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'iq_' . $type . '_chart_background',
                'label' => esc_html__('Background', 'graphina-charts-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .chart-box',
                'condition' => [
                    'iq_' . $type . '_chart_border_show' => 'yes'
                ]
            ]
        );
    
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'iq_' . $type . '_chart_box_shadow',
                'label' => esc_html__('Box Shadow', 'graphina-charts-for-elementor'),
                'selector' => '{{WRAPPER}} .chart-box',
                'condition' => ['iq_' . $type . '_chart_border_show' => 'yes']
            ]
        );
    
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'iq_' . $type . '_chart_border',
                'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
                'selector' => '{{WRAPPER}} .chart-box',
                'condition' => ['iq_' . $type . '_chart_border_show' => 'yes']
            ]
        );
    
        $this->add_control(
            'iq_' . $type . '_chart_border_radius',
            [
                'label' => esc_html__('Border Radius', 'graphina-charts-for-elementor'),
                'size_units' => ['px', '%', 'em'],
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'iq_' . $type . '_chart_border_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .chart-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
                ],
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_label_setting',
            [
                'label' => esc_html__('X-Axis Label Setting', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_haxis_label_font_color',
            [
                'label' => esc_html__('Label Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000'
            ]
        );
         $this->add_control(
            'iq_' . $type . '_chart_haxis_label_font_size',
            [
                'label' => esc_html__(' Label Fontsize', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 25,
                'default' => 12,
              
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_haxis_label_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_Label_Setting',
            [
                'label' => esc_html__('Y-Axis Label Setting', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_vaxis_label_font_color',
            [
                'label' => esc_html__('Label Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000'
            ]
        );
         $this->add_control(
            'iq_' . $type . '_chart_vaxis_label_font_size',
            [
                'label' => esc_html__(' Label Fontsize', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 3,
                'max' => 18,
                'default' => 12,
              
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_vaxis_Label_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
//        require GRAPHINA_ROOT . '/elementor/google_charts/column/render/column_google_chart.php';

        $mainId = $this->get_id();
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();
        $seriesListCount = $settings['iq_' . $type . '_chart_data_series_count'];
        $columnData = $valueList = $element_colors = $seriesStyleArray = $elementTitleArray = [];
        $legendPosition = $settings['iq_' . $type . '_google_chart_legend_position'];
        $targetAxisIndex = ($legendPosition == 'left') ? 1 : 0;
        $animatioShow = $settings['iq_' . $type . '_chart_animation_show'];
        $animatioShowValue = $animatioShow == 'yes' ? 'true' : 'false';
        $directionShow = $settings['iq_' . $type . '_chart_haxis_direction'];
        $directionShowValue = $directionShow == 'yes' ? -1 : 1;
        $vAxisDirectionShow = $settings['iq_' . $type . '_chart_vaxis_direction'];
        $vAxisDirectionShowValue = $vAxisDirectionShow == 'yes' ? -1 : 1;
        $annotationShow = $settings['iq_' . $type . '_chart_annotation_show'];
        $chartstackedShow = $settings['iq_' . $type . '_chart_stacked'];
        $chartstackedShowValue = $chartstackedShow == 'yes' ? 'true' : 'false';

        if( ($settings['iq_' . $type . '_google_chart_title_show']) === 'yes' ){
            $chartTitlePositoin = $settings['iq_' . $type . '_google_chart_title_position'];
        }else{
            $chartTitlePositoin = 'none';
        }
         //label show
         if( ($settings['iq_' . $type . '_chart_haxis_label_position_show']) === 'yes' ){
            $chartLabelPositoin = $settings['iq_' . $type . '_chart_haxis_label_position'];
        }else{
            $chartLabelPositoin = 'none';
        }

        if( ($settings['iq_' . $type . '_chart_vaxis_label_position_show']) === 'yes' ){
            $chartyaxisLabelPositoin = $settings['iq_' . $type . '_chart_vaxis_label_position'];
        }else{
            $chartyaxisLabelPositoin = 'none';
        }

        if( ($settings['iq_' . $type . '_chart_tooltip_show']) === 'yes' ){
            $toolTipTrigger = $settings['iq_' . $type . '_chart_tooltip_trigger'];
        }else{
            $toolTipTrigger = 'none';
        }

        if( ($settings['iq_' . $type . '_google_chart_legend_show']) === 'yes' ){
            $legendPosition = $settings['iq_' . $type . '_google_chart_legend_position'];
        }else{
            $legendPosition = 'none';
        }
        $targetAxisIndex = ($legendPosition == 'left') ? 1 : 0;

        $rotateshow = $settings['iq_' . $type . '_chart_xaxis_rotate'];
        $rotateshowvalue = $rotateshow == 'yes' ? 'true' : 'false';

        
        // category list
        if($settings['iq_' . $type . '_chart_data_option'] === 'manual'){
            // category list
            $categoryList = $settings['iq_' . $type . '_category_list'];

            $categoryListCount = count($categoryList);

            foreach ($categoryList as $key => $value) {
                $temp = [];
                array_push($temp, $value['iq_' . $type . '_chart_category']);
                array_push($columnData, $temp);
            }
        }
        
        $columnDataElementCount = $settings['iq_' . $type . '_chart_data_series_count'];

        for ($j = 0; $j < $columnDataElementCount; $j++) {
            $valueList = $settings['iq_' . $type . '_value_list_3_' . ($settings['iq_' . $type . '_can_chart_negative_values'] === 'yes' ? 2 : 1) . '_' . $j];
            $valueListCount = !empty($valueList) ? count($valueList) : 0;

            

            $element_color = $settings['iq_' . $type . '_chart_element_color_' . $j];
            array_push( $element_colors, $element_color );

            $elementTitle = $settings['iq_' . $type . '_chart_title_3_' . $j];
            array_push( $elementTitleArray, $elementTitle );
            
            // ---- Min - Max values ----
            $val_array = [];
            if(!empty($valueList) && count($valueList) > 0){
                foreach ($valueList as $key => $value) {
                    array_push($val_array, $value['iq_'.$type.'_chart_value_3_'. $j] );
                }
            }
            $min_value = !empty($val_array) ? min($val_array) : 0;
            $max_value = !empty($val_array) ? max($val_array) : 0;

            // ---- Inconsistent data length fix ----
            $label_count = count($columnData);
            if($label_count < $valueListCount){
                array_push($columnData, ['Label']);
            }else if($label_count > $valueListCount){
                $random_value = randomValueGenerator($min_value, $max_value);
                array_push($valueList, ['iq_'.$type.'_chart_value_3_'. $j => $random_value ]);
            }

            // ---- Old Code ----
            // if($valueListCount < $categoryListCount){
            //     $diff = $categoryListCount - $valueListCount;
                
            //     for ($k = 0; $k < $diff; $k++) {
            //         $random_array = [];
            //         array_push( $valueList, $random_array );
            //     }
            // }
            if(!empty($valueList) && count($valueList) > 0){
                foreach ($valueList as $key => $value) {
                    array_push( $columnData[$key], $value['iq_'.$type.'_chart_value_3_'. $j]);
                    $val = strval( $value['iq_'.$type.'_chart_value_3_'. $j] );
                    if($annotationShow === 'yes'){
                        if( !empty($settings['iq_' . $type . '_chart_annotation_prefix_postfix']) ){
                            $annotationPrefix = $settings['iq_' . $type . '_chart_annotation_prefix'];
                            $annotationPostfix = $settings['iq_' . $type . '_chart_annotation_postfix'];
                            array_push( $columnData[$key], $annotationPrefix.$val.$annotationPostfix );
                        }else{
                            array_push( $columnData[$key], $val );
                        }
                    }
                }
            }

            $serire_array = ['targetAxisIndex' => $targetAxisIndex];
            array_push( $seriesStyleArray, $serire_array );
        }
            

            

        if(!empty($settings['iq_' . $type . '_chart_haxis_label_prefix_postfix'])){
            $xPrefix = $settings['iq_' . $type . '_chart_haxis_label_prefix'];
            $xPostfix = $settings['iq_' . $type . '_chart_haxis_label_postfix'];
            $columnDataLength = count($columnData);
            for ($x = 0; $x < $columnDataLength; $x++) {
                $columnData[$x][0] = $xPrefix.$columnData[$x][0].$xPostfix;
            }
        }
        $data = ['series' => [], 'category' => []];
        $dataTypeOption = $settings['iq_' . $type . '_chart_data_option'] === 'manual' ? 'manual' : $settings['iq_' . $type . '_chart_dynamic_data_option'];
        if($settings['iq_' . $type . '_chart_data_option'] !== 'manual'){
            $data = graphinaGoogleChartDynamicData($this, $data);
            if (isset($data['fail']) && $data['fail'] === 'permission') {
                switch ($dataTypeOption) {
                    case "google-sheet" :
                        echo "<pre><b>" . esc_html__('Please check file sharing permission and "Publish As" type is CSV or not. ',  'graphina-pro-charts-for-elementor') . "</b><small><a target='_blank' href='https://youtu.be/Dv8s4QxZlDk'>" . esc_html__('Click for reference.',  'graphina-pro-charts-for-elementor') . "</a></small></pre>";
                        return;
                        break;
                    case "remote-csv" :
                    default:
                        echo "<pre><b>" . (isset($data['errorMessage']) ? $data['errorMessage'] :  esc_html__('Please check file sharing permission.',  'graphina-pro-charts-for-elementor')). "</b></pre>";
                        return;
                        break;
                }
            }
            if(!empty($data['series']) && count($data['series']) > 0 &&
                !empty($data['category']) && count($data['category']) > 0){
                $seriesListCount = count($data['series']);
                $seriesName = [];
                foreach ($data['category'] as $key => $value){
                    $datas = $seriesName= [];
                    $datas[] = strval($value);
                    foreach ($data['series'] as $key3 => $value3){
                        $seriesName[] = $value3['name'];
                        $datas[] = (float)$value3['data'][$key];
                        if( $annotationShow === 'yes' ){
                            if( !empty($settings['iq_' . $type . '_chart_annotation_prefix_postfix']) ){
                                $datas[] = $settings['iq_' . $type . '_chart_annotation_prefix'].(float)$value3['data'][$key].$settings['iq_' . $type . '_chart_annotation_postfix'];
                            }else{
                                $datas[] =strval($value3['data'][$key]);
                            }
                        }
                    }
                    $columnData[]=$datas;
                }
                $elementTitleArray = $seriesName;
            }
        }
        $seriesStyleArray = json_encode($seriesStyleArray);
        $elementTitleArray =  json_encode($elementTitleArray);
        $element_colors = json_encode($element_colors);
        $columnData = json_encode($columnData);
        require GRAPHINA_ROOT . '/elementor/google_charts/column/render/column_google_chart.php';
        if( isRestrictedAccess($type,$this->get_id(),$settings,false) === false)
        {

    ?>

        <script type="text/javascript">
            (function($) {
                'use strict';
                if(parent.document.querySelector('.elementor-editor-active') !== null){
                    if (typeof isInit === 'undefined') {
                        var isInit = {};
                    }
                    isInit['<?php esc_attr_e($mainId); ?>'] = false;
                    google.charts.load("current", {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                }
                document.addEventListener('readystatechange', event => {
                    // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                    if (event.target.readyState === "complete") {
                        if (typeof isInit === 'undefined') {
                            var isInit = {};
                        }
                        isInit['<?php esc_attr_e($mainId); ?>'] = false;
                        google.charts.load("current", {packages:['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                    }
                })

                function drawChart() {

                    var areaseriesListCount = parseInt('<?= $seriesListCount?>');
                    var colorArray = <?php print_r($element_colors); ?>;
                    var seriesStyleArray = <?php print_r($seriesStyleArray); ?>;
                    var elementTitleArray = <?php print_r($elementTitleArray); ?>;
                    var animatioShowValue = '<?php echo $animatioShowValue  ?>';
                    var animatioShow = (animatioShowValue === 'true');
                    var directionShowValue = '<?php echo $directionShowValue  ?>';
                    var vAxisDirectionShowValue = '<?php echo $vAxisDirectionShowValue  ?>';
                    var annotationShow = '<?php echo $annotationShow; ?>';
                    var legendPosition = '<?php echo strval($legendPosition); ?>';

                    var chartstackedShowValue = '<?php echo $chartstackedShowValue  ?>';
                    var chartstackedShow = (chartstackedShowValue === 'true');

                    if( legendPosition === 'left' ){
                        var chartArea = { left: '25%', right: '10%' }
                    }else if( legendPosition === 'right' ){
                        var chartArea = { left: '10%', right: '25%' }
                    }else{
                        var chartArea = { left: '10%', right: '5%' }
                    }

                    var rotateshowvalue= '<?php echo $rotateshowvalue ?>';

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '<?php echo strval($settings['iq_' . $type . '_chart_haxis_title']); ?>');

                    for (let i = 0; i < areaseriesListCount; i++) {
                        data.addColumn('number', elementTitleArray[i]);
                        if(annotationShow === 'yes'){
                            data.addColumn( { role: 'annotation' });
                        }
                    }
                    data.addRows(<?php print_r($columnData); ?>);

                    var options = {
                        title: '<?php echo strval($settings['iq_' . $type . '_google_chart_title']); ?>',
                        titlePosition: '<?php echo $chartTitlePositoin ?>', // in, out, none
                        titleTextStyle: {
                            color: '<?php echo strval($settings['iq_' . $type . '_google_chart_title_color']); ?>',
                            fontSize: '<?php echo strval($settings['iq_' . $type . '_google_chart_title_font_size']); ?>',
                        },

                        chartArea: chartArea,
                        bar: {
                            groupWidth:parseInt('<?php echo $settings['iq_' . $type . '_chart_element_width']; ?>'),

                        },
                        isStacked:'<?php echo strval($settings['iq_' . $type . '_chart_stack_type']); ?>',
                        colors: colorArray,
                        backgroundColor:'<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        series: seriesStyleArray,
                        annotations: {
                            stemColor: '<?php echo strval($settings['iq_' . $type . '_chart_annotation_stemcolor']); ?>',
                            textStyle: {
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_chart_annotation_fontsize']; ?>'),
                                color: '<?php echo strval($settings['iq_' . $type . '_chart_annotation_color']); ?>',
                                auraColor: '<?php echo strval($settings['iq_' . $type . '_chart_annotation_color2']); ?>',
                                opacity: parseFloat('<?php echo $settings['iq_' . $type . '_chart_annotation_opacity']; ?>'),
                            }
                        },
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height']; ?>'),
                        hAxis: {
                            slantedText:rotateshowvalue,
                            slantedTextAngle:parseFloat('<?php echo $settings['iq_' . $type . '_chart_xaxis_rotate_value']; ?>'),
                            direction:directionShowValue,
                            title: '<?php echo strval($settings['iq_' . $type . '_chart_haxis_title']); ?>',
                            titleTextStyle: {
                                color: '<?php echo strval($settings['iq_' . $type . '_chart_haxis_title_font_color']); ?>',
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_chart_haxis_title_font_size']; ?>'),
                            },
                            textStyle: {
                                color: '<?php echo strval($settings['iq_' . $type . '_chart_xaxis_label_font_color']); ?>',
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_chart_xaxis_label_font_size']; ?>'),


                            },
                            textPosition: '<?php echo $chartLabelPositoin ?>', // in, out, none
                        },
                        vAxis: {
                            viewWindowMode:'explicit',
                            viewWindow:{
                                max:parseInt('<?php echo $settings['iq_' . $type . '_chart_vaxis_maxvalue']; ?>'),
                                min: parseInt('<?php echo $settings['iq_' . $type . '_chart_vaxis_minvalue']; ?>'),
                            },
                            direction:vAxisDirectionShowValue,
                            title: '<?php echo strval($settings['iq_' . $type . '_chart_vaxis_title']); ?>',
                            logScale:'<?php echo strval($settings['iq_' . $type . '_chart_logscale_show']); ?>',
                            minValue: 0,
                            scaleType:'<?php echo strval($settings['iq_' . $type . '_chart_vaxis_scaletype']); ?>',
                            titleTextStyle: {
                                color: '<?php echo strval($settings['iq_' . $type . '_chart_vaxis_title_font_color']); ?>',
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_chart_vaxis_title_font_size']; ?>'),
                            },
                            textStyle: {
                                color: '<?php echo strval($settings['iq_' . $type . '_chart_yaxis_label_font_color']); ?>',
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_chart_yaxis_label_font_size']; ?>'),
                            },
                            textPosition: '<?php echo $chartyaxisLabelPositoin ?>', // in, out, none
                            format:'<?php echo $settings['iq_' . $type . '_chart_vaxis_format'] == '\#' ? ($settings['iq_' . $type . '_chart_vaxis_format_currency_prefix'].$settings['iq_' . $type . '_chart_vaxis_format']) : $settings['iq_' . $type . '_chart_vaxis_format'] ; ?>',
                            baselineColor:'<?php echo $settings['iq_' . $type . '_chart_baseline_Color']; ?>',
                            gridlines:{
                                color:'<?php echo $settings['iq_' . $type . '_chart_gridline_color']; ?>',
                                count: parseInt('<?php echo $settings['iq_' . $type . '_chart_gridline_count']; ?>'),
                            },
                        },
                        tooltip: {
                            showColorCode: true,
                            textStyle: {color:'<?php echo $settings['iq_' . $type . '_chart_tooltip_color']; ?>',},
                            trigger:'<?php echo $toolTipTrigger; ?>',
                        },
                        animation:{
                            startup: animatioShow,
                            duration: parseInt('<?php echo $settings['iq_' . $type . '_chart_animation_speed']; ?>'),
                            easing:'<?php echo $settings['iq_' . $type . '_chart_animation_easing']; ?>',
                        },
                        legend:{
                            position: legendPosition, // Position others options:-  bottom,labeled,left,right,top,none
                            textStyle: {
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_legend_fontsize']; ?>'),
                                color: '<?php echo strval($settings['iq_' . $type . '_google_chart_legend_color']); ?>',
                            },
                            alignment: '<?php echo strval($settings['iq_' . $type . '_google_chart_legend_horizontal_align']); ?>', // start,center,end
                        }
                    };
                    if (typeof graphinaGoogleChartInit !== "undefined") {
                        graphinaGoogleChartInit(
                            document.getElementById('column_google_chart<?php esc_attr_e($this->get_id()); ?>'),
                            {
                                ele:document.getElementById('column_google_chart<?php esc_attr_e($this->get_id()); ?>'),
                                options: options,
                                series: data,
                                animation: true,
                                renderType:'ColumnChart'
                            },
                            '<?php esc_attr_e($mainId); ?>',
                            '<?php echo $this->get_chart_type(); ?>',
                        );
                    }
                }

            }).apply(this, [jQuery]);

        </script>
         
        <?php
        }
    }
}
Plugin::instance()->widgets_manager->register(new Column_google_chart());
