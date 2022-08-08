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
class Donut_google_chart extends Widget_Base
{


    private $defaultLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan1', 'Feb1', 'Mar1', 'Apr1', 'May', 'Jun1', 'July1', 'Aug1', 'Sep1', 'Oct1', 'Nov1', 'Dec1', 'Jan2', 'Feb2', 'Mar2', 'Apr2', 'May2', 'Jun2', 'July2', 'Aug2', 'Sep2', 'Oct2', 'Nov2', 'Dec2'];
    private $color = ['#449DD1', '#F86624', '#546E7A', '#D4526E', '#775DD0', '#FF4560', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E'];
    private $gradientColor = ['#D56767', '#E02828', '#26A2D6', '#40B293', '#69DFDD', '#F28686', '#7D02EB', '#E02828', '#D56767', '#26A2D6'];

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
        return 'donut_google_chart';
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
        return 'Donut';
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
        return 'graphina-google-donat-chart';
    }

    public function get_chart_type()
    {
        return 'donut_google';
    }

    protected function register_controls()
    {
        $type = $this->get_chart_type();
        $colors = graphina_colors('color');
        $this->color = graphina_colors('color');

        $this->gradientColor = graphina_colors('gradientColor');

        graphina_basic_setting($this, $type);

        graphina_chart_data_option_setting($this, $type, 0, true);
        

        /* Data Option: 'Manual' Start */
        $this->start_controls_section(
            'iq_'.$type.'_datalabel_sections',
            [
                'label' => esc_html__( 'Data Table Options', 'graphina-charts-for-elementor' ),
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ],
            ]
        );

        $this->add_control(
			'iq_'.$type.'_columnone_title',
			[
				'label' => esc_html__( 'Label Title', 'graphina-charts-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Month', 'graphina-charts-for-elementor' ),
                'description' => esc_html__("Data Values Title in DataTable", 'graphina-charts-for-elementor'),
			]
		);

        $this->add_control(
			'iq_'.$type.'_columntwo_title',
			[
				'label' => esc_html__( 'Value Title', 'graphina-charts-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Sales', 'graphina-charts-for-elementor' ),
                'description' => esc_html__("Data Values Title in DataTable", 'graphina-charts-for-elementor'),
			]
		);
        
        
        $this->end_controls_section();
        $this->start_controls_section(
            'iq_' . $type . '_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
            ]
        );
        $this->add_control(
            'iq_' . $type . '_chart_title_heading',
            [
                'label' => esc_html__('Chart Title Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_title_show',
            [
                'label' => esc_html__('Chart Title Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no'
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_title',
            [
                'label' => esc_html__('Chart Title', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Add Value', 'graphina-charts-for-elementor'),
                'default' => esc_html__('Chart Title', 'graphina-charts-for-elementor'),
                'condition' => [
                    'iq_' . $type . '_chart_title_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iq_' . $type . '_chart_title_color',
            [
                'label' => esc_html__('Title Font Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'iq_' . $type . '_chart_title_show' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'iq_' . $type . '_chart_title_font_size',
            [
                'label' => esc_html__('Title Font Size', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => [
                    'iq_' . $type . '_chart_title_show' => 'yes'
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

        graphina_element_label($this, $type);
        
        graphina_tooltip($this, $type);
    
        $this->end_controls_section();

        graphina_advance_legend_setting($this, $type);
       
         /* Manual Data options start */
         for ($i = 0; $i <= graphina_default_setting('max_series_value'); $i++) {

            $this->start_controls_section(
                'iq_' . $type . '_section_series' . $i,
                [
                    'label' => esc_html__('Element ' . ($i + 1), 'graphina-charts-for-elementor'),
                    'default' => rand(50, 200),
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range($i + 1, graphina_default_setting('max_series_value')),
//                        'iq_' . $type . '_chart_data_option' => 'manual'
                    ]
                ]
            );

            $this->add_control(
                'iq_' . $type . '_chart_label' . $i,
                [
                    'label' => 'Label',
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => esc_html__('Add Label', 'graphina-charts-for-elementor'),
                    'default' => $this->defaultLabel[$i],
                    'dynamic' => [
                        'active' => true,
                    ],
                    'condition'=>[
                        'iq_' . $type . '_chart_data_option' => 'manual'
                    ]
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
                    'condition'=>[
                        'iq_' . $type . '_chart_data_option' => 'manual'
                    ]
                ]
            );
         
          
        
                $this->add_control(
                    'iq_' . $type . '_chart_element_color_' . $i,
                    [
                        'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::COLOR,
                        'default' => $colors[$i],
        
                    ]
                );
            
        

            $this->end_controls_section();
        }
        /* Manual Data options End */

       
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
                'tab' => Controls_Manager::TAB_STYLE,
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
      
        $this->end_controls_section();
    }

    protected function render()
    {  
//         require GRAPHINA_ROOT . '/elementor/google_charts/donut/render/donut_google_chart.php';
       
        global $wpdb;

        $mainId = $this->get_id();
        $type = $this->get_chart_type();
        $donutData = [];
        $type = $this->get_chart_type();
        $settings = $this->get_settings_for_display();
        $valueList = $settings['iq_' . $type . '_chart_data_series_count'];
        $dataOption = $settings['iq_' . $type . '_chart_data_option'];
        $chartDynamic = $settings['iq_' . $type . '_chart_dynamic_data_option'];
        if(isGraphinaPro()){
            $chartDynamicDataOption = $settings['iq_' . $type . '_element_import_from_database'];
        }
        
        if($settings['iq_' . $type . '_chart_label_reversecategory'] == 'yes'){
            $reversecategory = true;
        }else{
            $reversecategory = false;
        }

       
        $legendPosition = $settings['iq_' . $type . '_google_piechart_legend_position'];
        if( ($settings['iq_' . $type . '_google_chart_legend_show']) === 'yes' ){
            $legendPosition = $settings['iq_' . $type . '_google_piechart_legend_position'];
        }else{
            $legendPosition = 'none';
        }

        //tooltip
        if( ($settings['iq_' . $type . '_chart_tooltip_show']) === 'yes' ){
            $toolTipTrigger = $settings['iq_' . $type . '_chart_tooltip_trigger'];
        }else{
            $toolTipTrigger = 'none';
        }
        
        for ($j = 0; $j < $valueList; $j++) {
            $colors[] =(string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_element_color_' . $j);
        }
        $data = ['series' => [], 'category' => []];
        $dataTypeOption = $settings['iq_' . $type . '_chart_data_option'] === 'manual' ? 'manual' : $settings['iq_' . $type . '_chart_dynamic_data_option'];
        if($settings['iq_' . $type . '_chart_data_option'] === 'manual'){
            for ($i = 0; $i < $valueList; $i++) {
                $data["category"][] = (string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_label' . $i);
                $data["series"][] = (float)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_value' . $i);

                $colors[] =(string)graphina_get_dynamic_tag_data($settings, 'iq_' . $type . '_chart_element_color_' . $i);

                $new_list = [
                    $data['category'][$i],
                    $data['series'][$i],
                ];

                array_push( $donutData, $new_list);
            }
        }else{
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
            foreach ($data['category'] as $key => $va){
                $new_list = [
                    $va,
                    $data['series'][$key],
                ];
                array_push( $donutData, $new_list);
            }
        }


            $donutData = json_encode($donutData);

            $ele_colors = json_encode($colors);
        require GRAPHINA_ROOT . '/elementor/google_charts/donut/render/donut_google_chart.php';
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
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                }
                document.addEventListener('readystatechange', event => {
                    // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                    if (event.target.readyState === "complete") {
                        if (typeof isInit === 'undefined') {
                            var isInit = {};
                        }
                        isInit['<?php esc_attr_e($mainId); ?>'] = false;
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                    }
                })

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '<?php echo $settings['iq_'.$type.'_columnone_title']; ?>');
                    data.addColumn('number', '<?php echo $settings['iq_'.$type.'_columntwo_title']; ?>');
                    data.addRows(<?php print_r($donutData); ?>);

                    var dataOption = '<?php echo $dataOption; ?>';
                    var dynamicData = '<?php echo $chartDynamic; ?>';
                    var chartDynamicDataOption = '';
                    var elementColors = <?php echo $ele_colors; ?>;
                    var legendPosition = '<?php echo strval($legendPosition); ?>';

                    if( legendPosition === 'top' ){
                        var chartArea = { top: '15%', width: '100%', height: '80%'}
                    }else{
                        var chartArea = { width: '100%', height: '80%' }
                    }

                    if('<?php echo !empty($settings['iq_' . $type . '_chart_label_prefix_postfix']) && $settings['iq_' . $type . '_chart_label_prefix_postfix'] === 'yes' ?>'){
                        var formatter = new google.visualization.NumberFormat({
                            prefix: '<?php echo $settings['iq_' . $type . '_chart_label_prefix']?>',
                            suffix: '<?php echo $settings['iq_' . $type . '_chart_label_postfix']?>',
                            fractionDigits:0
                        });
                        formatter.format(data, 1);
                    }
                    /* Graph Options */
                    var optionsData = {
                        title: '<?php echo strval($settings['iq_' . $type . '_chart_title']); ?>',
                        titleTextStyle: {
                            color: '<?php echo strval($settings['iq_' . $type . '_chart_title_color']); ?>',
                            fontSize: '<?php echo strval($settings['iq_' . $type . '_chart_title_font_size']); ?>',
                        },
                        chartArea: chartArea,
                        height: parseInt('<?php echo $settings['iq_' . $type . '_chart_height']; ?>'),
                        backgroundColor:'<?php echo strval($settings['iq_' . $type . '_chart_background_color1']); ?>',
                        colors:elementColors,
                        tooltip: {
                            showColorCode: true,
                            textStyle: {color:'<?php echo $settings['iq_' . $type . '_chart_tooltip_color']; ?>',},
                            trigger: '<?php echo $toolTipTrigger; ?>',
                            text:'<?php echo $settings['iq_' . $type . '_chart_tooltip_text']; ?>',
                        },
                        legend:{
                            position: legendPosition,
                            labeledValueText: '<?php echo strval($settings['iq_' . $type . '_google_chart_legend_labeld_value']); ?>',
                            textStyle: {
                                fontSize: parseInt('<?php echo $settings['iq_' . $type . '_google_chart_legend_fontsize']; ?>'),
                                color: '<?php echo strval($settings['iq_' . $type . '_google_chart_legend_color']); ?>',
                            },
                            alignment: '<?php echo strval($settings['iq_' . $type . '_google_chart_legend_horizontal_align']); ?>', // start,center,end
                        },

                        reverseCategories:'<?php echo $reversecategory; ?>',
                        showLables: 'false',
                        pieSliceText:'<?php echo $settings['iq_' . $type . '_chart_pieSliceText']; ?>', //percentage,value,label,none
                        pieSliceBorderColor :  '<?php echo strval($settings['iq_' . $type . '_chart_pieslice_bordercolor']); ?>',
                        pieSliceTextStyle: {
                            color: '<?php echo strval($settings['iq_' . $type . '_chart_pieSliceText_color']); ?>',
                            fontSize:'<?php echo strval($settings['iq_' . $type . '_chart_pieSliceText_fontsize']); ?>',
                        },
                        pieHole:parseFloat('<?php echo $settings['iq_' . $type . '_chart_piehole']; ?>'),
                    };

                    if (typeof graphinaGoogleChartInit !== "undefined") {
                        graphinaGoogleChartInit(
                            document.getElementById('donut_google_chart<?php esc_attr_e($this->get_id()); ?>'),
                            {
                                ele:document.getElementById('donut_google_chart<?php esc_attr_e($this->get_id()); ?>'),
                                options: optionsData,
                                series: data,
                                animation: true,
                                renderType:'PieChart'
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

Plugin::instance()->widgets_manager->register(new Donut_google_chart());
