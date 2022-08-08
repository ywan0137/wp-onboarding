<?php

use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

/****************
 * @param $key
 * @param string $dataType
 * @return int|mixed|string
 */
function graphina_default_setting($key, $dataType = "int")
{
    $list = [
        "max_series_value" => 30,
        "categories" => [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
            'Jan1', 'Feb1', 'Mar1', 'Apr1', 'May1', 'Jun1', 'July1', 'Aug1', 'Sep1', 'Oct1', 'Nov1', 'Dec1',
            'Jan2', 'Feb2', 'Mar2', 'Apr2', 'May2', 'Jun2', 'July2', 'Aug2',
        ]
    ];
    return in_array($key, array_keys($list)) ? $list[$key] : (in_array($dataType, ['int', 'float']) ? 0 : '');
}

/***************
 * @param bool $first
 * @return array|mixed|string
 */
function graphina_stroke_curve_type($first = false)
{
    $options = [
        "smooth" => esc_html__('Smooth', 'graphina-charts-for-elementor'),
        "straight" => esc_html__('Straight', 'graphina-charts-for-elementor'),
        "stepline" => esc_html__('Stepline', 'graphina-charts-for-elementor')
    ];
    $keys = array_keys($options);
    return $first ? (count($keys) > 0 ? $keys[0] : '') : $options;
}

/****************
 * @param string $type
 * @param bool $first
 * @return array|mixed|string
 */
function graphina_position_type($type = "vertical", $first = false)
{
    $result = [];
    switch ($type) {
        case "vertical" :
            $result = [
                'top' => esc_html__('Top', 'graphina-charts-for-elementor'),
                'center' => esc_html__('Center', 'graphina-charts-for-elementor'),
                'bottom' => esc_html__('Bottom', 'graphina-charts-for-elementor')
            ];
            break;
        case "horizontal_boolean" :
            $result = [
                '' => [
                    'title' => esc_html__('Left', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-left',
                ],
                'yes' => [
                    'title' => esc_html__('Right', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-right',
                ]
            ];
            break;
        
        case "placement":
            $result = [
                'on' => esc_html__('On', 'graphina-charts-for-elementor'),
                'between' => esc_html__('Between', 'graphina-charts-for-elementor')
            ];
            break;
        case "in_out" :
                $result = [
                    'in' => esc_html__('In', 'graphina-charts-for-elementor'),
                    'out' => esc_html__('Out', 'graphina-charts-for-elementor')
                ];
                break;
        case "google_chart_legend_position" :
            $result = [
                'top' => esc_html__('Top', 'graphina-charts-for-elementor'),
                'bottom' => esc_html__('Bottom', 'graphina-charts-for-elementor'),
                'left' => esc_html__('Left', 'graphina-charts-for-elementor'),
                'right' => esc_html__('Right', 'graphina-charts-for-elementor'),
                'in' => esc_html__('Inside', 'graphina-charts-for-elementor'),
            ];
            break;
        case "google_piechart_legend_position" :
                $result = [
                    'top' => esc_html__('Top', 'graphina-charts-for-elementor'),
                    'bottom' => esc_html__('Bottom', 'graphina-charts-for-elementor'),
                    'left' => esc_html__('Left', 'graphina-charts-for-elementor'),
                    'right' => esc_html__('Right', 'graphina-charts-for-elementor'),
                    'labeled' => esc_html__('Labeled', 'graphina-charts-for-elementor'),
                ];
                break;
    }
    if ($first) {
        $keys = array_keys($result);
        return count($keys) > 0 ? $keys[0] : '';
    }
    return $result;
}

/****************
 * @param bool $first
 * @return array|mixed
 */
function graphina_get_fill_patterns($first = false)
{
    $patterns = [
        'verticalLines' => esc_html__('VerticalLines', 'graphina-charts-for-elementor'),
        'squares' => esc_html__('Squares', 'graphina-charts-for-elementor'),
        'horizontalLines' => esc_html__('HorizontalLines', 'graphina-charts-for-elementor'),
        'circles' => esc_html__('Circles', 'graphina-charts-for-elementor'),
        'slantedLines' => esc_html__('SlantedLines', 'graphina-charts-for-elementor'),
    ];
    if ($first) {
        $keys = array_keys($patterns);
        $patterns = $keys[rand(0, count($keys) - 1)];
    }
    return $patterns;
}

/****************
 * @param string $type
 * @param bool $first
 * @return array|mixed
 */
function graphina_chart_data_enter_options($type = '', $chartType = '', $first = false)
{
    $options = [];
    $type = !empty($type) ? $type : 'base';
    switch ($type) {
        case 'base':
            $options = [
                'manual' => esc_html__('Manual', 'graphina-charts-for-elementor'),
                'dynamic' => esc_html__('Dynamic', 'graphina-charts-for-elementor')
            ];

            if (get_option('graphina_firebase_addons') === '1') {
                $options['firebase'] = esc_html__('Firebase', 'graphina-charts-for-elementor');
            }
            if(graphinaForminatorAddonActive()){
                if(in_array($chartType,['line', 'column', 'area', 'pie', 'donut', 'radial', 'radar', 'polar','data_table_lite','distributed_column','scatter','mixed','brush', 'pie_google','donut_google','line_google','area_google',
                    'column_google','bar_google','gauge_google','geo_google','org_google'])){
                    $options['forminator'] = esc_html__('Forminator Addon', 'graphina-charts-for-elementor');
                }
            }
            break;
        case 'dynamic':
            $options = [
                'csv' => esc_html__('CSV', 'graphina-charts-for-elementor'),
                'remote-csv' => esc_html__('Remote CSV', 'graphina-charts-for-elementor'),
                'google-sheet' => esc_html__('Google Sheet', 'graphina-charts-for-elementor'),
                'api' => esc_html__('API', 'graphina-charts-for-elementor'),
            ];
            $sql_builder_for = ['line', 'column', 'area', 'pie', 'donut', 'radial', 'radar', 'polar','data_table_lite','distributed_column','scatter','mixed','brush', 'pie_google','donut_google','line_google','area_google','column_google','bar_google','gauge_google','geo_google','org_google','gantt_google'];
            if (in_array($chartType, $sql_builder_for)) {
                $options['sql-builder'] = esc_html__('SQL Builder', 'graphina-charts-for-elementor');
            }
            if(isGraphinaPro()){
                $options['filter'] = esc_html__('Data From Filter', 'graphina-charts-for-elementor');
            }
            break;
    }
    if ($first) {
        return (count($options) > 0) ? array_keys($options)[0] : [];
    }
    return $options;
}

/****************
 * @param $types
 * @param bool $first
 * @return array|mixed
 */
function graphina_fill_style_type($types, $first = false)
{
    $options = [];

    if (in_array('classic', $types)) {
        $options['classic'] = [
            'title' => esc_html__('Classic', 'graphina-charts-for-elementor'),
            'icon' => 'fa fa-paint-brush',
        ];
    }
    if (in_array('gradient', $types)) {
        $options['gradient'] = [
            'title' => esc_html__('Gradient', 'graphina-charts-for-elementor'),
            'icon' => 'fa fa-barcode',
        ];
    }
    if (in_array('pattern', $types)) {
        $options['pattern'] = [
            'title' => esc_html__('Pattern', 'graphina-charts-for-elementor'),
            'icon' => 'fa fa-bars',
        ];
    }
    if ($first) {
        $keys = array_keys($options);
        return count($keys) > 0 ? $keys[0] : '';
    }
    return $options;
}

/****************
 * @param object $this_ele
 * @param string $type
 */
function graphina_basic_setting($this_ele, $type = 'chart_id')
{

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_1',
        [
            'label' => esc_html__('Basic Setting', 'graphina-charts-for-elementor')
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_card_show',
        [
            'label' => esc_html__('Card', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_is_card_heading_show',
        [
            'label' => esc_html__('Heading', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'default' => 'yes',
            'condition' => [
                'iq_' . $type . '_chart_card_show' => 'yes',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_heading',
        [
            'label' => esc_html__('Card Heading', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => 'My Example Heading',
            'condition' => [
                'iq_' . $type . '_is_card_heading_show' => 'yes',
                'iq_' . $type . '_chart_card_show' => 'yes',
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_is_card_desc_show',
        [
            'label' => esc_html__('Description', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'default' => 'yes',
            'condition' => [
                'iq_' . $type . '_chart_card_show' => 'yes',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_content',
        [
            'label' => 'Card Description',
            'type' => Controls_Manager::TEXTAREA,
            'default' => 'My Other Example Heading',
            'condition' => [
                'iq_' . $type . '_is_card_desc_show' => 'yes',
                'iq_' . $type . '_chart_card_show' => 'yes',
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this_ele->end_controls_section();
}

/****************
 * @param object $this_ele
 * @param string $type `
 * @param int $defaultCount
 * @param boolean $showNegative
 */
function graphina_chart_data_option_setting($this_ele, $type = 'chart_id', $defaultCount = 0, $showNegative = false)
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_5_2',
        [
            'label' => esc_html__('Chart Data Options', 'graphina-charts-for-elementor')
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_is_pro',
        [
            'label' => esc_html__('Is Pro', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HIDDEN,
            'default' => isGraphinaPro() === true ? 'true' : 'false',
        ]
    );
    
    if(in_array($type, [ 'demo'])) {
        $this_ele->add_control(
			'iq_' . $type . '_chart_data_option',
			[
				'label' => esc_html__( 'Type', 'plugin-name' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'manual',
			]
		);
    }else{
        $this_ele->add_control(
            'iq_' . $type . '_chart_data_option',
            [
                'label' => esc_html__('Type', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => graphina_chart_data_enter_options('base', $type, true),
                'options' => graphina_chart_data_enter_options('base', $type)
            ]
        );
    }
    $seriesTest = 'Elements';
if(!in_array($type, ['geo_google'])){
    $this_ele->add_control(
        'iq_' . $type . '_chart_data_series_count',
        [
            'label' => esc_html__('Data ' . $seriesTest, 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => $defaultCount !== 0 ? $defaultCount : (in_array($type, ['pie', 'polar', 'donut', 'radial', 'bubble','pie_google','donut_google','org_google']) ? 5 : 1),
            'min' => 1,
            'max' => $type === 'gantt_google' ? 1 : graphina_default_setting('max_series_value'),
        ]
    );
}

    if ($showNegative && (!in_array($type, ['pie_google','donut_google','gauge_google','geo_google','org_google','gantt_google']))) {
        $this_ele->add_control(
            'iq_' . $type . '_can_chart_negative_values',
            [
                'label' => esc_html__('Default Negative Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'description' => esc_html__("Show default chart with some negative values", 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_data_option' => 'manual'
                ]
            ]
        );
    }

    if (!in_array($type, ['nested_column','brush','area_google', 'pie_google','line_google', 'bar_google','column_google','donut_google','gauge_google','geo_google','org_google','gantt_google'])) {
        $this_ele->add_control(
            'iq_' . $type . '_can_chart_reload_ajax',
            [
                'label' => esc_html__('Reload Ajax', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('True', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('False', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_data_option!' => ['manual'],
                ]
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_interval_data_refresh',
        [
            'label' => __('Set Interval(sec)', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'min' => 5,
            'step' => 5,
            'default' => 15,
            'condition' => [
                'iq_' . $type . '_can_chart_reload_ajax' => 'yes',
                'iq_' . $type . '_chart_data_option!' => ['manual'],
            ]
        ]
    );

    $this_ele->end_controls_section();

    if(in_array($type,['line', 'column', 'area', 'pie', 'donut', 'radial', 'radar', 'polar','data_table_lite','distributed_column','scatter','mixed','brush', 'pie_google','donut_google','line_google','area_google',
        'column_google','bar_google','gauge_google','geo_google','org_google','gantt_google'])){
        do_action('graphina_forminator_addon_control_section', $this_ele, $type);
    }

    do_action('graphina_addons_control_section', $this_ele, $type);

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_5_2_1',
        [
            'label' => esc_html__('Dynamic Data Options', 'graphina-charts-for-elementor'),
            'condition' => [
                'iq_' . $type . '_chart_data_option' => ['dynamic']
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_dynamic_data_option',
        [
            'label' => esc_html__('Type', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => graphina_chart_data_enter_options('dynamic', $type, true),
            'options' => graphina_chart_data_enter_options('dynamic', $type)
        ]
    );

    if (isGraphinaPro()) {
        graphina_pro_get_dynamic_options($this_ele, $type);
    }

    if (!isGraphinaPro()) {

        $this_ele->add_control(
            'iq_' . $type . 'get_pro',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => graphina_get_teaser_template([
                    'title' => esc_html__('Get New Exciting Features', 'graphina-charts-for-elementor'),
                    'messages' => ['Get Graphina Pro for above exciting features and more.'],
                    'link' => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061'
                ]),
            ]
        );
    }
 
    $this_ele->end_controls_section();

    if(!in_array($type,['mixed','brush','nested_column','area_google', 'pie_google','line_google', 'bar_google','column_google','donut_google','gauge_google','geo_google','org_google'])){
        graphina_charts_filter_settings($this_ele,$type);
    }
    if (isGraphinaPro()) {
        graphina_restriction_content_options($this_ele, $type);
    }

}

function graphina_get_teaser_template($texts)
{
    ob_start();
    ?>
    <div class="elementor-nerd-box">
        <!--        <img class="elementor-nerd-box-icon" src="-->
        <?php //echo ELEMENTOR_ASSETS_URL . 'images/go-pro.svg';
        ?><!--" />-->
        <div class="elementor-nerd-box-title"><?php echo $texts['title']; ?></div>
        <?php foreach ($texts['messages'] as $message) { ?>
            <div class="elementor-nerd-box-message"><?php echo $message; ?></div>
        <?php }

        if ($texts['link']) { ?>
            <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro"
               href="<?php echo Utils::get_pro_link($texts['link']); ?>" target="_blank">
                <?php echo esc_html__('Get Pro', 'graphina-charts-for-elementor'); ?>
            </a>
        <?php } else { ?>
            <div style="font-style: italic;">Coming Soon...</div>
        <?php } ?>
    </div>
    <?php

    return ob_get_clean();
}

/****************
 * @param object $this_ele
 * @param string $type
 * @param boolean $showDataLabel
 * @param boolean $labelAddFixed
 * @param boolean $labelPosition
 * @param boolean $showLabelBackground
 * @param boolean $showLabelColor
 */
function graphina_common_chart_setting($this_ele, $type = 'chart_id', $showDataLabel = false, $labelAddFixed = true, $labelPosition = false, $showLabelBackground = true, $showLabelColor = true)
{

    $this_ele->add_control(
        'iq_' . $type . '_chart_background_color1',
        [
            'label' => esc_html__('Chart Background Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
//            'default' => '#fff'
        ]
    );

    $responsive = "add_responsive_control";

    $this_ele->$responsive(
        'iq_' . $type . '_chart_height',
        [
            'label' => esc_html__('Height (px)', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => $type === 'brush' ? 175 : 350,
            'step' => 5,
            'min' => 10,
            'desktop_default' => $type === 'brush' ? 175 : 350,
            'tablet_default' => $type === 'brush' ? 175 : 350,
            'mobile_default' => $type === 'brush' ? 175 : 350,
        ]
    );

    if(in_array($type,['line','area','column','pie','polar','donut','scatter','line_google','area_google','bar_google','column_google'])){
        $this_ele->add_control(
            'iq_' . $type . '_dynamic_change_chart_type',
            [
                'label' => esc_html__('Change Chart Type ', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false
            ]
        );
    }
    
    if($type != 'brush'){

        if(!in_array($type,['line_google','area_google','bar_google','column_google','pie_google','donut_google','geo_google','gauge_google','org_google'])){
            $this_ele->add_control(
                'iq_' . $type . '_can_chart_show_toolbar',
                [
                    'label' => esc_html__('Toolbar', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => false
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_toolbar_offsety', [

                    'label' => esc_html__('Offset-Y', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'condition' => [
                        'iq_' . $type . '_can_chart_show_toolbar' => 'yes'
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_toolbar_offsetx', [

                    'label' => esc_html__('Offset-X', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'condition' => [
                        'iq_' . $type . '_can_chart_show_toolbar' => 'yes'
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_export_filename',
                [
                    'label' => esc_html__('Export Filename', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'iq_' . $type . '_can_chart_show_toolbar' => 'yes',
                    ],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
        }
    }

    if(!in_array($type,['line_google','area_google','bar_google','column_google','pie_google','donut_google','gauge_google','org_google'])){
        $this_ele->add_control(
            'iq_' . $type . '_chart_no_data_text',
            [
                'label' => esc_html__('No Data Text', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Loading...', 'graphina-charts-for-elementor'),
                'default' => 'No Data Available',
                'description' => esc_html__("When chart is empty, this text appears", 'graphina-charts-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
    }

    // ------ Datalabel Setting Start ------
    if(in_array($type,['area','line'])){
        $this_ele->add_control(
            'iq_' . $type . '_chart_stacked',
            [
                'label' => esc_html__('Stacked '.ucfirst($type), 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => false,
            ]
        );
    }

    if(!in_array($type,['line_google','area_google','column_google','bar_google','pie_google','donut_google','org_google'])){

        $this_ele->add_control(
            'iq_' . $type . '_chart_hr_datalabel_setting',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_datalabel_setting_title',
            [
                'label' => esc_html__('Label Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_datalabel_show',
            [
                'label' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => $showDataLabel === true ? "yes" : false,
            ]
        );

        if(in_array($type,['timeline'])){
            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_hide_show_text',
                [
                    'label' => esc_html__('Show Text', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => 'yes',
                ]
            );
        }

        if(in_array($type ,['radial','pie','donut'])){

            $condition_title = [
                'iq_' . $type . '_chart_datalabel_show' => 'yes',
            ];

            if(in_array($type ,['pie','donut'])){
                $this_ele->add_control(
                    'iq_' . $type . '_chart_center_datalabel_show',
                    [
                        'label' => esc_html__('Show Center Lable', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                        'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                        'default' => $showDataLabel === true ? "yes" : false,
                        'condition'=>[
                            'iq_' . $type . '_chart_datalabel_show' => 'yes',
                        ]
                    ]
                );
            }

            if($type != 'radial'){

                $condition_title = [
                    'iq_' . $type . '_chart_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_datalabel_total_title_show' => 'yes'
                ];

                $this_ele->add_control(
                    'iq_' . $type . '_chart_datalabel_total_title_show',
                    [
                        'label' => esc_html__('Show Total Value', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                        'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                        'condition'=>[
                            'iq_' . $type . '_chart_datalabel_show' => 'yes',
                            'iq_' . $type . '_chart_center_datalabel_show' => 'yes',
                        ]
                    ]
                );
                
                $condition_title = [
                    'iq_' . $type . '_chart_datalabel_show' => 'yes',
                ];

                if($type != 'radial'){
                    $condition_title = [
                        'iq_' . $type . '_chart_datalabel_show' => 'yes',
                        'iq_' . $type . '_chart_center_datalabel_show' => 'yes',
                        'iq_' . $type . '_chart_datalabel_total_title_show' => 'yes',
                    ];
                    $this_ele->add_control(
                        'iq_' . $type . '_chart_datalabel_total_title_always',
                        [
                            'label' => esc_html__('Show Always Total', 'graphina-charts-for-elementor'),
                            'type' => Controls_Manager::SWITCHER,
                            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                            'condition'=>$condition_title,
                            'description' => esc_html__('Note: Always show the total label and do not remove it even when  clicks/hovers over the slices.','graphina-charts-for-elementor')
                        ]
                    );
                }

                $this_ele->add_control(
                    'iq_' . $type . '_chart_datalabel_total_title',
                    [
                        'label' => esc_html__('Total Text', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Total', 'graphina-charts-for-elementor'),
                        'condition'=>$condition_title
                    ]
                );
            }
        }

        if(!in_array($type,['timeline'])){
            $this_ele->add_control(
                'iq_' . $type . '_chart_number_format_commas',
                [
                    'label' => esc_html__('Format Number(Commas)', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => 'no',
                    'condition'=>[
                        'iq_' . $type . '_chart_datalabel_show' => 'yes',
                    ]
                ]
            );
        }

        if( in_array($type,['radar','heatmap','radial','brush','distributed_column'])){
            $this_ele->add_control(
                'iq_' . $type . '_chart_label_pointer_for_label',
                [
                    'label' => esc_html__('Format Number to String', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'condition'=>[
                        'iq_' . $type . '_chart_datalabel_show' => 'yes',
                    ],
                    'default' => false,
                    'description' => esc_html__('Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor'),
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_label_pointer_number_for_label',
                [
                    'label' => esc_html__('Number of Decimal Want', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_datalabel_show' => 'yes',
                        'iq_' . $type . '_chart_label_pointer_for_label' => 'yes'
                    ]
                ]
            );
        }

        if( !in_array($type,['pie','donut', 'polar','nested_column','radial','column'])){

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_offsety', [

                    'label' => esc_html__('Offset-Y', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_datalabel_show' => 'yes'
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_offsetx', [

                    'label' => esc_html__('Offset-X', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_datalabel_show' => 'yes'
                    ]
                ]
            );
        }

        if(in_array($type,['pie','donut', 'polar'])){

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabels_format',
                [
                    'label' => esc_html__('Format(tooltip/label)', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => 'no',
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabels_format_showlabel',
                [
                    'label' => esc_html__('Show label', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => 'no',
                    'condition'=>[
                        'iq_' . $type . '_chart_datalabels_format' => 'yes'
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabels_format_showValue',
                [
                    'label' => esc_html__('Show Value', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => 'yes',
                    'condition'=>[
                        'iq_' . $type . '_chart_datalabels_format' => 'yes'
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_label_pointer',
                [
                    'label' => esc_html__('Format Number to String', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [
                        'iq_' . $type . '_chart_datalabels_format' => 'yes',
                        'iq_' . $type . '_chart_datalabels_format_showValue' => 'yes'
                    ],
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => false,
                    'description' => esc_html__('Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor'),
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_label_pointer_number',
                [
                    'label' => esc_html__('Number of Decimal Want', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_datalabels_format' => 'yes',
                        'iq_' . $type . '_chart_datalabels_format_showValue' => 'yes',
                        'iq_' . $type . '_chart_label_pointer' => 'yes',
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_format_prefix',
                [
                    'label' => esc_html__('Label Prefix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'condition'=>[
                        'iq_' . $type . '_chart_datalabels_format' => 'yes'
                    ],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_format_postfix',
                [
                    'label' => esc_html__('Label Postfix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'condition'=>[
                        'iq_' . $type . '_chart_datalabels_format' => 'yes'
                    ],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
        }

        /// Need to create condition for responsive controller

        $dataLabelFontColorCondition = [
            'relation' => 'and',
            'terms' => [
                [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'iq_' . $type . '_chart_datalabel_show',
                            'operator' => '==',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        ];
    
        if ($labelPosition) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_position_show',
                [
                    'label' => esc_html__('Position', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => graphina_position_type("vertical", true),
                    'options' => graphina_position_type("vertical"),
                    'conditions' => $dataLabelFontColorCondition,
                ]
            );
        }

        if ($showLabelColor) {
            $dataLabelFontSetting = $dataLabelFontColorCondition;
            $dataLabelBackground = $dataLabelFontColorCondition;
            if ($showLabelBackground) {
                $dataLabelFontSetting['terms'][] = [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'iq_' . $type . '_chart_datalabel_background_show',
                            'operator' => '!=',
                            'value' => 'yes'
                        ]
                    ]
                ];
            }

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_font_color',
                [
                    'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#000000',
                    'conditions' => $dataLabelFontSetting
                ]
            );

        }

        if ($showLabelBackground) {

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_background_show',
                [
                    'label' => esc_html__('Show Background', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                    'default' => false,
                    'conditions' => $dataLabelFontColorCondition
                ]
            );

            $dataLabelBackground['terms'][] = [
                'relation' => 'and',
                'terms' => [
                    [
                        'name' => 'iq_' . $type . '_chart_datalabel_background_show',
                        'operator' => '==',
                        'value' => 'yes'
                    ]
                ]
            ];

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_background_color',
                [
                    'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#FFFFFF',
                    'conditions' => $dataLabelBackground
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_font_color_1',
                [
                    'label' => esc_html__('Background Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#000000',
                    'conditions' => $dataLabelBackground
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_border_width',
                [
                    'label' => esc_html__('Border Width', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 1,
                    'min' => 0,
                    'max' => 20,
                    'conditions' => $dataLabelBackground
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_border_radius',
                [
                    'label' => esc_html__('Border radius', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'conditions' => $dataLabelBackground
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_border_color',
                [
                    'label' => esc_html__('Border Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#FFFFFF',
                    'conditions' => $dataLabelBackground
                ]
            );
        }

        if ($labelAddFixed) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_prefix',
                [
                    'label' => esc_html__('Label Prefix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'conditions' => $dataLabelFontColorCondition,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_datalabel_postfix',
                [
                    'label' => esc_html__('Label Postfix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'conditions' => $dataLabelFontColorCondition,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
        }
    }

    // ------ Datalabe Setting End ------
}

/*****************
 * @param object $this_ele
 * @param string $type
 * @param array $fill_styles like ['classic', 'gradient', 'pattern']
 * @param bool $showOpacity
 * @param int $i
 * @param array $condition
 * @param boolean $showNoteFillStyle
 */
function graphina_fill_style_setting($this_ele, $type = 'chart_id', $fill_styles = ['classic', 'gradient', 'pattern'], $showOpacity = false, $i = -1, $condition = [], $showNoteFillStyle = false)
{

    $this_ele->add_control(
        'iq_' . $type . '_chart_fill_setting_title' . ($i > -1 ? '_' . $i : ''),
        [
            'label' => esc_html__('Fill Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' => array_merge([], ($i > -1 ? $condition : []))
        ]
    );

    $description = "Pattern will not eligible for the line chart. So if you select it, it will consider as Classic";

    $this_ele->add_control(
        'iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : ''),
        [
            'label' => esc_html__('Style', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => graphina_fill_style_type($fill_styles, true),
            'options' => graphina_fill_style_type($fill_styles),
            'description' => $showNoteFillStyle ? esc_html__($description, 'graphina-charts-for-elementor') : '',
            'condition' => array_merge([], ($i > -1 ? $condition : []))
        ]
    );

    if ($showOpacity) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_fill_opacity' . ($i > -1 ? '_' . $i : ''),
            [
                'label' => esc_html__('Opacity', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => in_array($type, ['column', 'timeline','scatter']) ? 1 : 0.4,
                'min' => 0.00,
                'max' => 1,
                'step' => 0.05,
                'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'classic'], ($i > -1 ? $condition : []))
            ]
        );
    }
}

/*****************
 * @param $this_ele
 * @param string $type
 * @param bool $show_type
 * @param bool $usedAsSubPart
 * @param int $i
 * @param array $condition
 */
function graphina_gradient_setting($this_ele, $type = 'chart_id', $show_type = true, $usedAsSubPart = false, $i = -1, $condition = [])
{
    if (!$usedAsSubPart) {
        $this_ele->start_controls_section(
            'iq_' . $type . '_chart_section_3' . ($i > -1 ? '_' . $i : ''),
            [
                'label' => esc_html__('Gradient Setting', 'graphina-charts-for-elementor'),
                'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
            ]
        );
    } else {
        $this_ele->add_control(
            'iq_' . $type . '_chart_hr_gradient_setting' . ($i > -1 ? '_' . $i : ''),
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_gradient_setting_title' . ($i > -1 ? '_' . $i : ''),
            [
                'label' => esc_html__('Gradient Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
            ]
        );
    }

    if ($show_type) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_gradient_type' . ($i > -1 ? '_' . $i : ''),
            [
                'label' => esc_html__('Type', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => esc_html__('Vertical', 'graphina-charts-for-elementor'),
                    'horizontal' => esc_html__('Horizontal', 'graphina-charts-for-elementor')
                ],
                'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
            ]
        );
    }

    $from_opacity = (in_array($type, ['radar', 'area','brush'])) ? 0.6 : 1.0;
    $to_opacity = (in_array($type, ['radar', 'area','brush'])) ? 0.6 : 1.0;

    $this_ele->add_control(
        'iq_' . $type . '_chart_gradient_opacityFrom' . ($i > -1 ? '_' . $i : ''),
        [
            'label' => esc_html__('From Opacity', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'step' => 0.1,
            'default' => $from_opacity,
            'min' => 0,
            'max' => 1,
            'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_gradient_opacityTo' . ($i > -1 ? '_' . $i : ''),
        [
            'label' => esc_html__('To Opacity', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'step' => 0.1,
            'default' => $to_opacity,
            'min' => 0,
            'max' => 1,
            'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_gradient_inversecolor' . ($i > -1 ? '_' . $i : ''),
        [
            'label' => esc_html__('Inverse Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'default' => false,
            'condition' => array_merge(['iq_' . $type . '_chart_fill_style_type' . ($i > -1 ? '_' . $i : '') => 'gradient'], ($i > -1 ? $condition : []))
        ]
    );

    if (!$usedAsSubPart) {
        $this_ele->end_controls_section();
    }
}

/*****************
 * @param object $this_ele
 * @param string $type
 */
function graphina_chart_label_setting($this_ele, $type = 'chart_id')
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_7',
        [
            'label' => esc_html__('Legend Setting', 'graphina-charts-for-elementor'),

        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_legend_show',
        [
            'label' => esc_html__('Legend', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_legend_position',
        [
            'label' => esc_html__('Position', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'bottom',
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-up',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-right',
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-down',
                ],
                'left' => [
                    'title' => esc_html__('Left', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-left',
                ]
            ],
            'condition' => [
                'iq_' . $type . '_chart_legend_show' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_legend_horizontal_align',
        [
            'label' => esc_html__('Horizontal Align', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
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
                'iq_' . $type . '_chart_legend_position' => ['top', 'bottom'],
                'iq_' . $type . '_chart_legend_show' => 'yes'
            ]
        ]
    );

    $des = esc_html__('','graphina-charts-for-elementor');
    if(!in_array($type,['pie','donut','polar','donut'])){
        $des = esc_html__('Note: Only work if tooltip enable' ,'graphina-charts-for-elementor');
    }

    if(!in_array($type,['bubble','candle','distributed_column','radar','timeline','nested_column','scatter'])){
        $this_ele->add_control(
            'iq_' . $type . '_chart_legend_show_series_value',
            [
                'label' => esc_html__('Show Series Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'description' => $des,
                'condition' => [
                    'iq_' . $type . '_chart_legend_show' => 'yes'
                ]
            ]
        );
    }

    $this_ele->end_controls_section();
}

/******************
 * @param object $this_ele
 * @param string $type
 * @param boolean $showFixed
 * @param bool $showTooltip
 */
function graphina_advance_x_axis_setting($this_ele, $type = 'chart_id', $showFixed = true, $showTooltip = true)
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_5',
        [
            'label' => esc_html__('X-Axis Setting', 'graphina-charts-for-elementor'),
        ]
    );

    if(in_array($type,['column','distributed_column'])){
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_enable_min_max',
            [
                'label' => esc_html__('Enable Min/Max', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_is_chart_horizontal' => 'yes',
                    'iq_' . $type . '_chart_stack_type' => 'normal'
                ],
                'description' => esc_html__('Note: If chart having multi series, Enable Min/Max value will be applicable to all series and xaxis Tickamount must be according to min - max value' ,'graphina-charts-for-elementor')
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_min_value',
            [
                'label' => esc_html__('Min Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_enable_min_max' => 'yes',
                    'iq_' . $type . '_is_chart_horizontal' => 'yes',
                    'iq_' . $type . '_chart_stack_type' => 'normal'
                ],
                'description' => esc_html__('Note: Lowest number to be set for the x-axis. The graph drawing beyond this number will be clipped off','graphina-charts-for-elementor')
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_max_value',
            [
                'label' => esc_html__('Max Value', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 250,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_enable_min_max' => 'yes',
                    'iq_' . $type . '_is_chart_horizontal' => 'yes',
                    'iq_' . $type . '_chart_stack_type' => 'normal'
                ],
                'description' => esc_html__('Note: Highest number to be set for the x-axis. The graph drawing beyond this number will be clipped off.','graphina-charts-for-elementor')
            ]
        );
    }

    if ($showTooltip) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_tooltip_show',
            [
                'label' => esc_html__('Tooltip', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => ''
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_crosshairs_show',
            [
                'label' => esc_html__('Pointer Line', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => '',
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_tooltip_show' => 'yes'
                ]
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_xaxis_datalabel_show',
        [
            'label' => esc_html__('Labels', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_xaxis_datalabel_position',
        [
            'label' => esc_html__('Position', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'bottom',
            'options' => [
                'top' => [
                    'title' => esc_html__('Top', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-up',
                ],
                'bottom' => [
                    'title' => esc_html__('Bottom', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-arrow-down',
                ]
            ],
            'condition' => [
                'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
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

    $this_ele->add_control(
        'iq_' . $type . '_chart_xaxis_datalabel_rotate',
        [
            'label' => esc_html__('Rotate', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => -45,
            'max' => 360,
            'min' => -360,
            'condition' => [
                'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' => 'yes',
                'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
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

    $this_ele->add_control(
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

    if($type == 'brush'){
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_datalabel_tick_amount_dataPoints',
            [
                'label' => esc_html__('Tick Amount(dataPoints)', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('False', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('True', 'graphina-charts-for-elementor'),
                'default' => 'yes',
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );
    }

    if (!in_array($type, ['brush', 'candle', 'timeline'])) {
        $this_ele->add_control(
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
    }
    if (!in_array($type, ['brush', 'candle', 'timeline'])) {
        $this_ele->add_control(
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

    }

    if(in_array($type , ['timeline','candle'])){
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_show_time',
            [
                'label' => esc_html__('Show Time In xaxis', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'yes',
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_show_date',
            [
                'label' => esc_html__('Show Date In xaxis', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ]
            ]
        );
    }

    if ($showFixed) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_label_show',
            [
                'label' => esc_html__('Labels Prefix/Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ],
                'description' => esc_html__('Note: If categories data are in array form it won\'t work','graphina-charts-for-elementor'),
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_label_prefix',
            [
                'label' => esc_html__('Labels Prefix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_label_postfix',
            [
                'label' => esc_html__('Labels Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
                    'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes'
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_xaxis_title_enable',
        [
            'label' => esc_html__('Enable Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'no'
        ]
    );

    $this_ele->add_control(
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
    $this_ele->end_controls_section();
}

/******************
 * @param object $this_ele
 * @param string $type
 * @param boolean $showFixed
 * @param bool $showTooltip
 */
function graphina_advance_y_axis_setting($this_ele, $type = 'chart_id', $showFixed = true, $showTooltip = true)
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_6',
        [
            'label' => esc_html__('Y-Axis Setting', 'graphina-charts-for-elementor'),
        ]
    );

    if(in_array($type,['line','area','column','mixed','distributed_column'])){
        graphina_yaxis_min_max_setting($this_ele,$type);
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_line_show',
        [
            'label' => esc_html__('Line', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_line_grid_color',
        [
            'label' => esc_html__('Grid Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#90A4AE',
            'condition' => [
                'iq_' . $type . '_chart_yaxis_line_show' => 'yes'
            ]
        ]
    );

    if (in_array($type, ['line', 'area', 'column', 'bubble', 'candle','distributed_column','scatter'])) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_0_indicator_show',
            [
                'label' => esc_html__('Zero Indicator', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash',
            [
                'label' => esc_html__('Stroke Dash', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min'=>0,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_0_indicator_show' => 'yes'
                ]
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_0_indicator_stroke_color',
            [
                'label' => esc_html__('Stroke Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_0_indicator_show' => 'yes'
                ]
            ]
        );
    }

    if ($showTooltip) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_tooltip_show',
            [
                'label' => esc_html__('Tooltip', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => ''
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_crosshairs_show',
            [
                'label' => esc_html__('Pointer Line', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => '',
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_tooltip_show' => 'yes'
                ]
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_show',
        [
            'label' => esc_html__('Labels', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_position',
        [
            'label' => esc_html__('Position', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => graphina_position_type('horizontal_boolean', true),
            'options' => graphina_position_type('horizontal_boolean'),
            'condition' => [
                'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_offset_x',
        [
            'label' => esc_html__('Offset-X', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_offset_y',
        [
            'label' => esc_html__('Offset-Y', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_rotate',
        [
            'label' => esc_html__('Rotate', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'max' => 360,
            'min' => -360,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    $titleBrushChart = $type == 'brush' ? 'Chart-1' : '';

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_tick_amount',
        [
            'label' => esc_html__( $titleBrushChart.' Tick Amount', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'max' => 30,
            'min' => 0,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
            ]
        ]
    );

    if($type == 'brush'){

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_datalabel_tick_amount_2',
            [
                'label' => esc_html__('Chart-2 Tick Amount', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'max' => 30,
                'min' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
                ]
            ]
        );
    }

    $condition = ['iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'];
    $note = '';
    if ($showFixed) {
        $condition = [
            'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
            'iq_' . $type . '_chart_yaxis_label_show!' => 'yes'
        ];
        $note = esc_html__('If you enabled "Labels Prefix/Postfix", this won’t have any effect.', 'graphina-charts-for-elementor');
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float',
        [
            'label' => esc_html__('Decimals In Float', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 2,
            'max' => 6,
            'min' => 0,
            'condition' => $condition,
            'description' => $note
        ]
    );

    if ($showFixed) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_label_show',
            [
                'label' => esc_html__('Labels Prefix/Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
                ]
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_label_prefix',
            [
                'label' => esc_html__('Labels Prefix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_label_postfix',
            [
                'label' => esc_html__('Labels Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        if(in_array($type,['line','area','column','distributed_column','scatter'])){
            $this_ele->add_control(
                'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point',
                [
                    'label' => esc_html__('Decimals In Float', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'max' => 6,
                    'min' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
                        'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                        'iq_' . $type . '_chart_yaxis_label_pointer!' =>'yes'
                    ]
                ]
            );
        }

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_label_pointer',
            [
                'label' => esc_html__('Format Number to String', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
                ],
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => false,
                'description' => esc_html__('Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor'),
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_label_pointer_number',
            [
                'label' => esc_html__('Number of Decimal Want', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 0,
                'condition' => [
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
                    'iq_' . $type . '_chart_yaxis_label_pointer' => 'yes',
                    'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
                ]
            ]
        );

    }

    if(in_array($type,['area','column','bubble','line','brush','distributed_column','scatter'])){
        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_format_number',
            [
                'label' => esc_html__('Format Number', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no',
                'condition' =>[
                    'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes'
                ],
                'description' => esc_html__( 'Enabled Labels Prefix/Postfix ', 'graphina-charts-for-elementor')
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_title_enable',
        [
            'label' => esc_html__('Enable Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'no'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_title',
        [
            'label' => esc_html__('Y-axis Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_title_enable' => 'yes'
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_card_yaxis_title_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
            'condition' => [
                'iq_' . $type . '_chart_yaxis_title_enable' => 'yes'
            ]
        ]
    );

    if(in_array($type,['line','area','column','candle','heatmap','bubble','brush','scatter'])){

        graphinaYaxisOpposite($this_ele, $type);

    }

    $this_ele->end_controls_section();
}

/*******************
 * @param object $this_ele
 * @param string $type
 */
function graphina_style_section($this_ele, $type = 'chart_id')
{
    $this_ele->start_controls_section('iq_' . $type . '_style_section',
        [
            'label' => esc_html__('Style Section', 'graphina-charts-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'iq_' . $type . '_chart_card_show' => 'yes'
            ]
        ]
    );
    /** Header settings. */
    $this_ele->add_control(
        'iq_' . $type . '_title_options',
        [
            'label' => esc_html__('Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' => ['iq_' . $type . '_is_card_heading_show' => 'yes'],
        ]
    );
    /** Header typography. */
    $this_ele->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => 'iq_' . $type . '_card_title_typography',
            'label' => esc_html__('Typography', 'graphina-charts-for-elementor'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .graphina-chart-heading',
            'condition' => ['iq_' . $type . '_is_card_heading_show' => 'yes']
        ]
    );

    $this_ele->add_control(
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

    $this_ele->add_control(
        'iq_' . $type . '_card_title_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
        ]
    );

    $this_ele->add_control(
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

    $this_ele->add_control(
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

    $this_ele->add_control(
        'iq_' . $type . '_subtitle_options',
        [
            'label' => esc_html__('Description', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' => ['iq_' . $type . '_is_card_desc_show' => 'yes']
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => 'iq_' . $type . '_subtitle_typography',
            'label' => esc_html__('Typography', 'graphina-charts-for-elementor'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_2,
            'selector' => '{{WRAPPER}} .graphina-chart-sub-heading',
            'condition' => ['iq_' . $type . '_is_card_desc_show' => 'yes']
        ]
    );

    $this_ele->add_control(
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

    $this_ele->add_control(
        'iq_' . $type . '_card_subtitle_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
        ]
    );

    $this_ele->add_control(
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

    $this_ele->add_control(
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
    $this_ele->end_controls_section();

}

/*******************
 * @param object $this_ele
 * @param string $type
 */
function graphina_card_style($this_ele, $type = 'chart_id')
{
    $this_ele->start_controls_section('iq_' . $type . '_card_style_section',
        [
            'label' => esc_html__('Card Style', 'graphina-charts-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'iq_' . $type . '_chart_card_show' => 'yes'
            ],
        ]
    );

    $this_ele->add_group_control(
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

    $this_ele->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'iq_' . $type . '_card_box_shadow',
            'label' => esc_html__('Box Shadow', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .chart-card',
            'condition' => ['iq_' . $type . '_chart_card_show' => 'yes']
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name' => 'iq_' . $type . '_card_border',
            'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .chart-card',
            'condition' => ['iq_' . $type . '_chart_card_show' => 'yes']
        ]
    );

    $this_ele->add_control(
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

    $this_ele->end_controls_section();
}

/*******************
 * @param object $this_ele
 * @param string $type
 */
function graphina_chart_style($this_ele, $type = 'chart_id')
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_chart_style_section',
        [
            'label' => esc_html__('Chart Style', 'graphina-charts-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_font_family',
        [
            'label' => esc_html__('Font Family', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::FONT,
            'description' => esc_html__("Notice:If possible use same font as Chart Title & Description, Otherwise it may not show the actual font you selected.", 'graphina-charts-for-elementor'),
            'default' => "Poppins"
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_font_size',
        [
            'label' => esc_html__('Font Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', 'vw'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'vw' => [
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 12,
            ]
        ]
    );

    $typo_weight_options = [
        '' => esc_html__('Default', 'graphina-charts-for-elementor'),
    ];

    foreach (array_merge(['normal', 'bold'], range(100, 900, 100)) as $weight) {
        $typo_weight_options[$weight] = ucfirst($weight);
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_font_weight',
        [
            'label' => esc_html__('Font Weight', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => $typo_weight_options,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_border_show',
        [
            'label' => esc_html__('Chart Box', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes'
        ]
    );

    $this_ele->add_group_control(
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

    $this_ele->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_box_shadow',
            'label' => esc_html__('Box Shadow', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .chart-box',
            'condition' => ['iq_' . $type . '_chart_border_show' => 'yes']
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_border',
            'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .chart-box',
            'condition' => ['iq_' . $type . '_chart_border_show' => 'yes']
        ]
    );

    $this_ele->add_control(
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
    $this_ele->end_controls_section();
}

function graphina_chart_filter_style($this_ele, $type = 'chart_id')
{
    
    $this_ele->start_controls_section(
        'iq_' . $type . '_chart_filter_style',
        [
            'label'=>esc_html__('Chart Filter Style','graphina-charts-for-elementor'),
            'tab'=>Controls_Manager::TAB_STYLE,
            'condition'=>[
                'iq_' . $type . '_chart_filter_enable'=>'yes',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_align_heading',
        [
            'label'=>esc_html__('Chart Filter','graphina-charts-for-elementor'),
            'type'=>Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_align',
        [
            'label' => esc_html__('Alignment', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
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
            'selectors' => [
                '{{WRAPPER}} .graphina_chart_filter' => 'justify-content: {{VALUE}}',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_hr_label',
        [
            'type'=>Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_label_heading',
        [
            'label'=>esc_html__('Label','graphina-charts-for-elementor'),
            'type'=>Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_label_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .graphina-filter-div label'=>'color:{{VALUE}}',],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_label_font_size',
        [
            'label' => esc_html__('Font Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', 'vw'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'vw' => [
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ]
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_label_margin',
        [
            'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_label_padding',
        [
            'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_hr_select',
        [
            'type'=>Controls_Manager::DIVIDER,
        ]
    );
        
    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_select_heading',
        [
            'label'=>esc_html__('DropDown','graphina-charts-for-elementor'),
            'type'=>Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_filter_select_background',
            'label' => esc_html__('Background Type', 'graphina-charts-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .graphina-filter-div select',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_select_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .graphina-filter-div select'=>'color:{{VALUE}}',],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_select_font_size',
        [
            'label' => esc_html__('Font Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', 'vw'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'vw' => [
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ]
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_select_margin',
        [
            'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_select_padding',
        [
            'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_filter_select_border',
            'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .graphina-filter-div select',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_select_border_radius',
        [
            'label' => esc_html__('Border Radius', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_hr_button',
        [
            'type'=>Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_button_heading',
        [
            'label'=>esc_html__('Apply Filter Button','graphina-charts-for-elementor'),
            'type'=>Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_filter_button_background',
            'label' => esc_html__('Background Type', 'graphina-charts-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .graphina-filter-div input[type=button]',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_button_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .graphina-filter-div input[type=button]'=>'color:{{VALUE}}',],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_button_font_size',
        [
            'label' => esc_html__('Font Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', 'vw'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'vw' => [
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ]
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_button_margin',
        [
            'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div input[type=button]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_button_padding',
        [
            'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div input[type=button]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_filter_button_border',
            'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .graphina-filter-div input[type=button]',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_button_border_radius',
        [
            'label' => esc_html__('Border Radius', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div input[type=button]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_date_picker',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_date_picker_header',
        [
            'label'=>esc_html__('Date Picker','graphina-charts-for-elementor'),
            'type'=>Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_filter_date_background',
            'label' => esc_html__('Background Type', 'graphina-charts-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_date_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time'=>'color:{{VALUE}}',],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_date_font_size',
        [
            'label' => esc_html__('Font Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', 'vw'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'vw' => [
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_date_margin',
        [
            'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_date_padding',
        [
            'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name' => 'iq_' . $type . '_chart_filter_date_border',
            'label' => esc_html__('Border', 'graphina-charts-for-elementor'),
            'selector' => '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_date_border_radius',
        [
            'label' => esc_html__('Border Radius', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
            ]
        ]
    );

    $this_ele->end_controls_section();
}


/*******************
 * @param object $this_ele
 * @param string $type
 */
function graphina_stroke($this_ele, $type = 'chart_id')
{
    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_stroke_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_stroke_setting_title',
        [
            'label' => esc_html__('Stroke Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_stroke_show',
        [
            'label' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'default' => false
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_stroke_width',
        [
            'label' => 'Stroke Width',
            'type' => Controls_Manager::NUMBER,
            'default' => 2,
            'min' => 0,
            'max' => 10,
            'condition' => [
                'iq_' . $type . '_chart_stroke_show' => 'yes'
            ]
        ]
    );
}

/*******************
 * @param object $this_ele
 * @param string $type
 */
function graphina_animation($this_ele, $type = 'chart_id')
{
    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_animation_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_animation_setting_title',
        [
            'label' => esc_html__('Animation Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    // ------ Animation Setting For Google Chart ------
    if (in_array($type, ['area_google', 'line_google', 'bar_google', 'column_google', 'gauge_google'])) {

        $this_ele->add_control(
            'iq_' . $type . '_chart_animation_show',
            [
                'label' => esc_html__('Show Animation', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'yes' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'no' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_animation_speed',
            [
                'label' => esc_html__('Speed', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 800,
                'condition' => [
                    'iq_' . $type . '_chart_animation_show' => 'yes'
                ]
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_animation_easing',
            [
                'label' => esc_html__('Easing', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'linear',
                'options' => [
                    "linear" => esc_html__('Linear', 'graphina-charts-for-elementor'),
                    "in" => esc_html__('In', 'graphina-charts-for-elementor'),
                    "out" => esc_html__('Out', 'graphina-charts-for-elementor'),
                    "inAndout" => esc_html__('In And Out', 'graphina-charts-for-elementor')
                ],
                'condition' => [
                    'iq_' . $type . '_chart_animation_show' => 'yes'
                ]
            ]
        );
    }
    
    // ------ Animation Setting For Apex Chart ------
    else{

        $this_ele->add_control(
            'iq_' . $type . '_chart_animation',
            [
                'label' => esc_html__('Custom', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'yes',
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_animation_speed',
            [
                'label' => esc_html__('Speed', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 800,
                'condition' => [
                    'iq_' . $type . '_chart_animation' => 'yes'
                ]
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_animation_delay',
            [
                'label' => esc_html__('Delay', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 150,
                'condition' => [
                    'iq_' . $type . '_chart_animation' => 'yes'
                ]
            ]
        );
    }
}

/********************
 * @param object $this_ele
 * @param string $type
 */
function graphina_plot_setting($this_ele, $type = 'chart_id')
{
    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_plot_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_plot_setting_title',
        [
            'label' => esc_html__('Plot Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_plot_options',
        [
            'label' => esc_html__('Show Options', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_plot_size',
        [
            'label' => esc_html__('Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 140,
            'condition' => [
                'iq_' . $type . '_chart_plot_options' => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_plot_stroke_color',
        [
            'label' => 'Stroke Color',
            'type' => Controls_Manager::COLOR,
            'default' => '#e9e9e9'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_plot_color',
        [
            'label' => 'Color',
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_stroke_size',
        [
            'label' => esc_html__('Stroke Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 1,
            'min' => 0
        ]
    );
}

/********************
 * @param object $this_ele
 * @param string $type
 */
function graphina_marker_setting($this_ele, $type = 'chart_id', $i=0)
{

    if($type == 'mixed'){
        $condition = [
            'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
            'iq_' . $type . '_chart_type_3_' . $i.'!' => 'bar'
        ];
    }
    else{
        $condition = [
            'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
        ];
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_marker_setting_title_'.$i,
        [
            'label' => esc_html__('Marker Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' =>  $condition
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_marker_size_'.$i,
        [
            'label' => esc_html__('Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => in_array($type, ['radar','mixed','brush']) ? 3 : 0,
            'min'=> 0,
            'condition' => $condition,
            'description' => $type == 'brush'? 'Note : Marker are only show in Chart 1 ' : ''
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_marker_stroke_color_'.$i,
        [
            'label' => esc_html__('Stroke Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'condition' => $condition
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_marker_stroke_width_'.$i,
        [
            'label' => esc_html__('Stroke Width', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => in_array($type, ['mixed','brush'])? 1 :0,
            'min' => 0,
            'condition' =>  $condition
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_chart_marker_stroke_shape_'.$i,
        [
            'label' => esc_html__('Shape', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'circle',
            'options' => [
                'circle' => esc_html__('Circle', 'graphina-charts-for-elementor'),
                'square' => esc_html__('Square', 'graphina-charts-for-elementor'),
            ],
            'condition' =>  $condition,
            'description' => esc_html__('Note: Hover will Not work in Square', 'graphina-charts-for-elementor'),

        ]
    );

}

function graphina_marker_setting_google($this_ele, $type = 'chart_id', $i=0)
{
    $condition = [
        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
    ];

    $this_ele->add_control(
        'iq_' . $type . '_chart_marker_setting_title_'.$i,
        [
            'label' => esc_html__('Marker Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' => $condition
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_point_show'.$i,
        [
            'label' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'true' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'false' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => false,
            'condition' => $condition
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_line_point'.$i,
        [
            'label' => esc_html__('Point', 'graphina-charts-for-elementor'),  
            'type' => Controls_Manager::SELECT,
            'default' => 'circle',
            'options' => [
                'circle' => esc_html__('Circle', 'graphina-charts-for-elementor'),
                'triangle' => esc_html__('Triangle', 'graphina-charts-for-elementor'),
                'square' => esc_html__('Square', 'graphina-charts-for-elementor'),
                'diamond' => esc_html__('Diamond', 'graphina-charts-for-elementor'),
                'star' => esc_html__('Star', 'graphina-charts-for-elementor'),
                'polygon' => esc_html__('Polygon', 'graphina-charts-for-elementor')
            ],
            'condition' => [
                'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
                'iq_' . $type . '_chart_point_show'.$i => 'yes'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_line_point_size'.$i,
        [
            'label' => esc_html__(' Size', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5,
            'max' => 100,
            'min' => 1,
            'condition' => [
                'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
                'iq_' . $type . '_chart_point_show'.$i => 'yes'
            ]
        ]
    );

}

/********************
 * @param object $this_ele
 * @param string $type
 * @param bool $showTheme
 * @param bool $shared
 */
function graphina_element_label($this_ele, $type = 'chart_id', $showTheme = true, $shared = true)
{
    // Label Setting
    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_label_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_label_setting_title',
        [
            'label' => esc_html__('Label Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    
    if (in_array($type, ['pie_google','donut_google']))
    {
        $this_ele->add_control(
            'iq_' . $type . '_chart_pieSliceText_show',
            [
                'label' => esc_html__('Label Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('no', 'graphina-charts-for-elementor'),
                'default' => 'no',
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_pieSliceText',
            [
                'label' => esc_html__('Label Text', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'label',
                'options' => [
                   
                    'label' => esc_html__('Label', 'graphina-charts-for-elementor'),
                    'value' => esc_html__('Value', 'graphina-charts-for-elementor'),
                    'percentage' => esc_html__('Percentage', 'graphina-charts-for-elementor'),
                    'value-and-percentage' => esc_html__('Value And Percentage', 'graphina-charts-for-elementor'),
                ],
                'condition' => [
                    'iq_' . $type . '_chart_pieSliceText_show' => 'yes'
                    
                ],
                
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_label_prefix_postfix',
            [
                'label' => esc_html__('Label Prefix/Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => '',
                'condition' => [
                    'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
                    
                ],
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_label_prefix',
            [
                'label' => esc_html__('Prefix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
                    'iq_' . $type . '_chart_label_prefix_postfix' => 'yes'
                ],
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_label_postfix',
            [
                'label' => esc_html__('Postfix', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
                    'iq_' . $type . '_chart_label_prefix_postfix' => 'yes'
                ],
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_pieSliceText_color',
            [
                'label' => esc_html__('Label Text Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => 'black',
                'condition' => [
                    'iq_' . $type . '_chart_pieSliceText_show' => 'yes'
                ],
                
            ]
            
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_pieSliceText_fontsize',
            [
                'label' => esc_html__('Label Text Fontsize', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min'=>5,
                'max' => 20,
                'default' => '12',
                'condition' => [
                    'iq_' . $type . '_chart_pieSliceText_show' => 'yes'
                ],
                
            ]
        );
    }
    $this_ele->add_control(
        'iq_' . $type . '_chart_label_reversecategory',
        [
            'label' => esc_html__('Reverse Categories', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'false' => esc_html__('no', 'graphina-charts-for-elementor'),
            'default' => 'false',
        ]
    );
    $this_ele->add_control(
        'iq_' . $type . '_chart_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );
    if (in_array($type, ['pie_google'])) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_isthreed',
            [
                'label' => esc_html__('3D ', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('no', 'graphina-charts-for-elementor'),
                'default' => 'false',
            ]
        );
    }
    if (in_array($type, ['pie_google','donut_google'])) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_pieslice_bordercolor',
                [
                    'label' => esc_html__('Pieslice Border', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#ffffff',
                ]
            );
    }
    if (in_array($type, ['donut_google'])) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_piehole',
            [
                'label' => esc_html__('pieHole', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.01,
                'default' => 0.65,
            ]
        );
    }
}
function graphina_common_area_stacked_option($this_ele, $type = 'chart_id', $showTheme = true, $shared = true)
{
    $this_ele->add_control(
        'iq_' . $type . '_chart_stacked_show',
        [
            'label' => esc_html__('Stacked Show ', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'default' => false,
        ]
    );
}
function graphina_tooltip($this_ele, $type = 'chart_id', $showTheme = true, $shared = true)
{
    // Tooltip Setting
    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_tooltip_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_tooltip_setting_title',
        [
            'label' => esc_html__('Tooltip Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );
    
    // ------ Tooltip Setting For Google Chart ------
    if (in_array($type, ['area_google', 'line_google','bar_google','column_google','pie_google','donut_google', 'geo_google'])) {
        
        $this_ele->add_control(
            'iq_' . $type . '_chart_tooltip_show',
            [
                'label' => esc_html__('Show Tooltip', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_tooltip_trigger',
            [
                'label' => esc_html__(' Trigger', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    "focus" => esc_html__('On Hover', 'graphina-charts-for-elementor'),
                    "selection" => esc_html__('On Selection', 'graphina-charts-for-elementor')
                ],
                'default' => 'focus',
                'condition' => [
                    'iq_' . $type . '_chart_tooltip_show' => 'yes'
                ]
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_tooltip_color',
            [
                'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => 'black',
                'condition' => [
                    'iq_' . $type . '_chart_tooltip_show' => 'yes'
                ]
            ]
        );

        if(in_array($type,['geo_google']))
        {
            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_font_size',
                [
                    'label' => esc_html__('Font Size','graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip_show' => 'yes'
                    ]
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_bold',
                [
                    'label' => esc_html__('Bold','graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip_show' => 'yes'
                    ]
                ]
            );
        
            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_italic',
                [
                    'label' => esc_html__('Italic','graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip_show' => 'yes'
                    ]
                ]
            );

        }

       if(in_array($type, ['pie_google','donut_google'])) 
           {
            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_text',
                [
                    'label' => esc_html__('Text', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'value',
                    'options' => [
                        "both" => esc_html__('Value And Percentage', 'graphina-charts-for-elementor'),
                        "value" => esc_html__('Value', 'graphina-charts-for-elementor'),
                        "percentage" => esc_html__('Percentage', 'graphina-charts-for-elementor')
                    ],
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip_show' => 'yes'
                    ]
                    
                ]
            );
       }
 
        if (in_array($type, ['column_google','bar_google'])) {
        
            $this_ele->add_control(
                'iq_' . $type . '_chart_element_column_setting',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );
        
            $this_ele->add_control(
                'iq_' . $type . '_chart_element_column_setting_title',
                [
                    'label' => esc_html__('Column Settings', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_element_width',
                [
                    'label' => esc_html__('Column Width', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 20,
                ]
            );
        
            $this_ele->add_control(
                'iq_' . $type . '_chart_stacked',
                [
                    'label' => esc_html__('Stacked Show', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => false,
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_stack_type',
                [
                    'label' => esc_html__('Stack Type', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'absolute',
                    'options' => [
                        "absolute" => esc_html__('Absolute', 'graphina-charts-for-elementor'),
                        "relative" => esc_html__('Relative', 'graphina-charts-for-elementor'),
                        "percent" => esc_html__('percent', 'graphina-charts-for-elementor')
                    ],
                    'condition' => [
                        'iq_' . $type . '_chart_stacked' => 'yes',
                       
                    ]
                ]
            );
            
        }
        if (in_array($type, ['column_google','bar_google','line_google','area_google'])) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_setting_start',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );
        
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_setting_title',
                [
                    'label' => esc_html__('Annotation Settings', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                ]
            );

            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_show',
                [
                    'label' => esc_html__('Show Annotation', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => false
                ]
            );
            
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_color',
                [
                    'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#000000',
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_color2',
                [
                    'label' => esc_html__('Second Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_stemcolor',
                [
                    'label' => esc_html__('Stem Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#000000',
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_fontsize',
                [
                    'label' => esc_html__(' Fontsize', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 12,
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_opacity',
                [
                    'label' => esc_html__('Opacity', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0.5,
                    'step' => 0.01,
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_prefix_postfix',
                [
                    'label' => esc_html__('Annotation Prefix/Postfix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => '',
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes'
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_prefix',
                [
                    'label' => esc_html__('Prefix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                        'iq_' . $type . '_chart_annotation_prefix_postfix' => 'yes'
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_annotation_postfix',
                [
                    'label' => esc_html__('Postfix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'condition' => [
                        'iq_' . $type . '_chart_annotation_show' => 'yes',
                        'iq_' . $type . '_chart_annotation_prefix_postfix' => 'yes'
                    ],
                ]
            );
        }
        
    }
    // ------ Tooltip Setting For Apex Chart ------
    else{
        $notice = '';
        if ($type === 'radar') {
            $notice = esc_html__('Warning: This will may not work if markers are not shown.', 'graphina-charts-for-elementor');
        }
        $this_ele->add_control(
            'iq_' . $type . '_chart_tooltip',
            [
                'label' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'yes',
                'description' => $notice
            ]
        );

        if ($shared && $type != 'candle') {
            $notice = '';
            if ($type === 'column') {
                $notice = esc_html__('Warning: This will may not work for horizontal column chart.', 'graphina-charts-for-elementor');
            }
            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_shared',
                [
                    'label' => esc_html__('Shared', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'description' => $notice,
                    'default' => 'yes',
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip' => 'yes',
                    ]
                ]
            );
        }
        if ($showTheme) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_theme',
                [
                    'label' => esc_html__('Theme', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => 'light',
                    'options' => [
                        'light' => [
                            'title' => esc_html__('Light', 'graphina-charts-for-elementor'),
                            'icon' => 'fas fa-sun',
                        ],
                        'dark' => [
                            'title' => esc_html__('Dark', 'graphina-charts-for-elementor'),
                            'icon' => 'fas fa-moon',
                        ]
                    ],
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip' => 'yes'
                    ]
                ]
            );
        }
    }
}

/********************
 * @param object $this_ele
 * @param string $type
 * @param bool $condition
 */
function graphina_dropshadow($this_ele, $type = 'chart_id', $condition = true)
{

    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_plot_drop_shadow_setting',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_plot_drop_shadow_setting_title',
        [
            'label' => esc_html__('Drop Shadow Settings', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_is_chart_dropshadow',
        [
            'label' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'default' => false,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_is_chart_dropshadow_top',
        [
            'label' => esc_html__('Drop Shadow Top Position', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'iq_' . $type . '_is_chart_dropshadow' => 'yes',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_is_chart_dropshadow_left',
        [
            'label' => esc_html__('Drop Shadow Left Position', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'iq_' . $type . '_is_chart_dropshadow' => 'yes',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_is_chart_dropshadow_blur',
        [
            'label' => esc_html__('Drop Shadow Blur', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'condition' => [
                'iq_' . $type . '_is_chart_dropshadow' => 'yes',
            ],
        ]
    );

    if ($condition) {
        $this_ele->add_control(
            'iq_' . $type . '_is_chart_dropshadow_color',
            [
                'label' => esc_html__('Drop Shadow Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'condition' => [
                    'iq_' . $type . '_is_chart_dropshadow' => 'yes',
                ],
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_is_chart_dropshadow_opacity',
        [
            'label' => esc_html__('Drop Shadow Opacity', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0.35,
            'max' => 1,
            'min' => 0,
            'step' => 0.05,
            'condition' => [
                'iq_' . $type . '_is_chart_dropshadow' => 'yes',
            ],
        ]
    );
}

/********************
 * @param string $type color,gradientColor
 * @return string[]
 */
function graphina_colors($type = 'color'): array
{
    if ($type === 'gradientColor') {
        return ['#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6'];
    }
    return ['#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E','#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#e23cfd','#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E'];
}

/********************
 * @param $start
 * @param $format
 * @param array $add
 * @param array $minus
 * @return false|string
 */
function graphina_getRandomDate($start, $format, $add = [], $minus = [])
{
    $date = '';
    foreach ($add as $i => $a) {
        $date .= ' + ' . $a . ' ' . $i;
    }
    foreach ($minus as $j => $b) {
        $date .= ' - ' . $b . ' ' . $j;
    }
    return date($format, strtotime($date, strtotime($start)));
}

/**********************
 * @param object $this_ele
 * @param string $type
 * @param array $ele_array show elements like ["color"]
 * @param boolean $showFillStyle
 * @param array $fillOptions like ['classic', 'gradient', 'pattern']
 * @param boolean $showFillOpacity
 * @param boolean $showGradientType
 */
function graphina_series_setting($this_ele, $type = 'chart_id', $ele_array = ['color'], $showFillStyle = true, $fillOptions = [], $showFillOpacity = false, $showGradientType = false)
{
    $colors = graphina_colors('color');
    $gradientColor = graphina_colors('gradientColor');
    $seriesTest = 'Element';

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_11',
        [
            'label' => esc_html__('Elements Setting', 'graphina-charts-for-elementor'),
        ]
    );

    if ($showFillStyle) {
        graphina_fill_style_setting($this_ele, $type, $fillOptions, $showFillOpacity);
    }

    if ($showFillStyle && in_array('gradient', $fillOptions)) {
        graphina_gradient_setting($this_ele, $type, $showGradientType, true);
    }

    if($type == 'scatter'){
        $this_ele->add_control(
            'iq_' . $type . '_chart_scatter_width',
            [
                'label' => esc_html__('Width', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'step' => 1,
                'min' => 1,
            ]
        );
    }

    for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

        if ($i !== 0 || $showFillStyle) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_hr_series_count_' . $i,
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        $this_ele->add_control(
            'iq_' . $type . '_chart_series_title_' . $i,
            [
                'label' => esc_html__($seriesTest . ' ' . ($i + 1), 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                ]
            ]
        );

        if (in_array('tooltip', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_tooltip_enabled_on_1_' . $i,
                [
                    'label' => esc_html__('Tooltip Enabled', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'yes',
                    'condition' => [
                        'iq_' . $type . '_chart_tooltip' => 'yes',
                        'iq_' . $type . '_chart_tooltip_shared' => 'yes',
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        if (in_array('color', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_gradient_1_' . $i,
                [
                    'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => $colors[$i],
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_gradient_2_' . $i,
                [
                    'label' => esc_html__('Second Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => $gradientColor[$i],
                    'condition' => [
                        'iq_' . $type . '_chart_fill_style_type' => 'gradient',
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_bg_pattern_' . $i,
                [
                    'label' => esc_html__('Fill Pattern', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => graphina_get_fill_patterns(true),
                    'options' => graphina_get_fill_patterns(),
                    'condition' => [
                        'iq_' . $type . '_chart_fill_style_type' => 'pattern',
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        if (in_array('dash', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_dash_3_' . $i,
                [
                    'label' => 'Dash',
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'min' => 0,
                    'max' => 100,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        if (in_array('width', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_width_3_' . $i,
                [
                    'label' => 'Stroke Width',
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5,
                    'min' => 1,
                    'max' => 20,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        $chart_type = ['radar','line', 'area'];

        if(in_array($type,$chart_type)){

            graphina_marker_setting($this_ele, $type, $i);

        }

    }
    $this_ele->end_controls_section();
}


function graphina_setting_sort($settings)
{
    //    $typeArr = ['string' => 0,'boolean'=>1,'integer' => 2,'double' => 3,'NULL' => 9,'array' => 10,'lg_array' => 11];
    //    uasort($settings,function($a, $b) use($typeArr){
    //        $a_type = gettype($a);
    //        $b_type = gettype($b);
    //
    //        $a_type= ($a_type === 'array' && count((array)$a_type)>10) ? 'lg_array' : $a_type;
    //        $b_type= ($b_type === 'array' && count((array)$b_type)>10) ? 'lg_array' : $b_type;
    //
    //        $a_index = in_array($a_type,array_keys($typeArr)) ? $typeArr[$a_type] : 8;
    //        $b_index = in_array($b_type,array_keys($typeArr)) ? $typeArr[$b_type] : 8;
    //        return ($a_index > $b_index);
    //    });
    
    return array_filter($settings, function ($val, $key) {
        return strpos($key, '_value_list_') === false;
    }, ARRAY_FILTER_USE_BOTH);
}

function graphina_get_dynamic_tag_data($eleSettingVals, $mainKey)
{
    return str_replace("'", "\'", $eleSettingVals[$mainKey]);   
}


if (!function_exists('get_editable_roles')) {
    require_once(ABSPATH . '/wp-admin/includes/user.php');
}

function graphina_fetch_roles_options()
{
    $roles = get_editable_roles();
    $tempneer = array();
    foreach ($roles as $rol => $rolname) {
        $tempneer[$rol] = $rolname['name'];
    }
    return $tempneer;
}

function graphina_fetch_user_name_options()
{
    $all_users = get_users();
    $tempneer = array();
    foreach ($all_users as $user) {
        $first_name = get_user_meta( $user->ID, 'first_name', true );
        $last_name = get_user_meta( $user->ID, 'last_name', true );
        $tempneer[$user->user_login] =  $first_name. ' '.$last_name.'('. $user->display_name.')';
    }
    return $tempneer;
}

function graphina_fetch_user_name()
{
    $user = wp_get_current_user();
    return $user->user_login;
}

function graphina_fetch_user_roles($userId, $singleRole = true)
{
    $userRole = [];
    $currentUserRoles = get_user_meta(get_current_user_id(), 'wp_capabilities');

    foreach ($currentUserRoles[0] as $currentUserRole => $currentUserRoleAccess) {
        if ($currentUserRoleAccess) {
            $userRole[] = $currentUserRole;
        }
    }

    if ($singleRole) {
        return !empty($userRole[0]) ? $userRole[0] : '';
    }

    return $userRole;
}

function graphina_restriction_content_options($this_ele, $type = 'chart_id')
{

    $this_ele->start_controls_section(
        'iq_' . $type . '_restriction_content_control',
        [
            'label' => esc_html__('Restriction content access', 'graphina-charts-for-elementor')
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_restriction_content_type',
        [
            'label' => esc_html__('Restriction Based On', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => __('No Restriction Access', 'graphina-charts-for-elementor'),
                'login' => __('Logged In User', 'graphina-charts-for-elementor'),
                'password' => __('Password Protected', 'graphina-charts-for-elementor'),
                'role' => __('Role Based Access', 'graphina-charts-for-elementor'),
                'userName' => __('UserName Based Access', 'graphina-charts-for-elementor')
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_restriction_content_password',
        [
            'label' => __('Set Password', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'password',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_password_content_headline',
        [
            'label' => __('Headline', 'graphina-charts-for-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Protected Area', 'graphina-charts-for-elementor'),
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'password',
            ],
            'dynamic' => [
                'active' => true,
            ],
    ]);

    $this_ele->add_control(
        'iq_' . $type . '_password_button_label',
        [
            'label' => __('Button Label', 'graphina-charts-for-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Submit', 'graphina-charts-for-elementor'),
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'password',
        ]
    ]);

    $this_ele->add_control(
        'iq_' . $type . '_password_error_message_show',
        [
            'label' => esc_html__('Error', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
            'description' => esc_html__("Notice:Error message when incorrect password enter", 'graphina-charts-for-elementor'),
            'default' => 'yes',
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'password',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_password_error_message',
        [
            'label' => __('Error message', 'graphina-charts-for-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Password is invalid', 'graphina-charts-for-elementor'),
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'password',
                'iq_' . $type . '_password_error_message_show' => 'yes',
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]);
    $this_ele->add_control(
        'iq_' . $type . '_password_instructions_text', [
        'label' => __('Instructions Text', 'graphina-charts-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'default' => __('This content is password-protected. Please verify with a password to unlock the content.', 'graphina-charts-for-elementor'),
        'condition' => [
            'iq_' . $type . '_restriction_content_type' => 'password',
        ],
        'dynamic' => [
            'active' => true,
        ],
    ]);

    $this_ele->add_control(
        'iq_' . $type . '_restriction_content_role_type',
        [
            'label' => __('Select Roles', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'role',
            ],
            'options' => graphina_fetch_roles_options(),
            'label_block' => true
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_restriction_content_user_name_based',
        [
            'label' => __('Select User', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'condition' => [
                'iq_' . $type . '_restriction_content_type' => 'userName',
            ],
            'options' => graphina_fetch_user_name_options(),
            'label_block' => true
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_restriction_content_template',
        [
            'label' => __('Restricted Template View (shortcode)', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::WYSIWYG,
            'default' => esc_html__('<div style="padding: 30px; text-align: center;">' .
                '<h5>You don\'t have permission to see this content.</h5>' .
                '<a class="button" href="/wp-login.php">Unlock Access</a></div>', 'graphina-charts-for-elementor'),
            'condition' => [
                'iq_' . $type . '_restriction_content_type!' => ['', 'password'],
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this_ele->end_controls_section();
}

function isRestrictedAccess($type, $chartId, $settings, $flag = false)
{
    $restrictedTemplate = false;
    if (!empty($settings['iq_' . $type . '_restriction_content_type'])
        && $settings['iq_' . $type . '_restriction_content_type'] != '') {
        $restrictedTemplate = true;
        if (is_user_logged_in()) {
            $restrictedTemplate = false;
            if ($settings['iq_' . $type . '_restriction_content_type'] == 'role') {
                $currentUserRole = graphina_fetch_user_roles(get_current_user_id(), true);
                if (!is_array($settings['iq_' . $type . '_restriction_content_role_type'])
                    || !in_array($currentUserRole, $settings['iq_' . $type . '_restriction_content_role_type'])) {
                    $restrictedTemplate = true;
                }
            }
            if($settings['iq_' . $type . '_restriction_content_type'] == 'userName'){
                $currentUserName = graphina_fetch_user_name();
                if (!is_array($settings['iq_' . $type . '_restriction_content_user_name_based'])
                    || !in_array($currentUserName, $settings['iq_' . $type . '_restriction_content_user_name_based'])) {
                    $restrictedTemplate = true;
                }
            }
        }
        if ($settings['iq_' . $type . '_restriction_content_type'] === 'password'
            && (empty($_COOKIE['graphina_' . $type . '_' . $chartId]) || !$_COOKIE['graphina_' . $type . '_' . $chartId])) {
            if ($flag) {
                ?>
                <div class="graphina-restricted-content <?php echo $type === 'counter' ? 'graphina-card counter' : 'chart-card' ?>"
                     style="padding: 20px">
                    <form class="graphina-password-restricted-form" method="post" autocomplete="off" target="_top"
                          onsubmit="return graphinaRestrictedPasswordAjax(this,event)">
                        <h4 class="graphina-password-heading"><?php echo $settings['iq_' . $type . '_password_content_headline']; ?></h4>
                        <p class="graphina-password-message"><?php echo $settings['iq_' . $type . '_password_instructions_text']; ?></p>
                        <div class="graphina-input-wrapper">
                            <input type="hidden" name="chart_password"
                                   value="<?php echo wp_hash_password($settings['iq_' . $type . '_restriction_content_password']); ?>">
                            <input type="hidden" name="chart_type" value="<?php echo $type; ?>">
                            <input type="hidden" name="chart_id" value="<?php echo $chartId; ?>">
                            <input type="hidden" name="action" value="graphina_restrict_password_ajax">
                            <input class="form-control graphina-input " type="password" name="graphina_password"
                                   autocomplete="off" placeholder="Enter Password" style="outline: none">
                        </div>
                        <div class="button-box">
                            <button class="graphina-button" name="submit" type="submit"
                                    style="outline: none"><?php echo $settings['iq_' . $type . '_password_button_label']; ?></button>
                        </div>
                        <div class="graphina-error-div">
                            <?php
                            if (!graphina_is_preview_mode()) {
                                ?>
                                <div class=" elementor-alert-danger graphina-error "
                                     style="display: <?php echo $settings['iq_' . $type . '_password_error_message_show'] === 'yes' ? 'flex' : 'none'; ?>;align-items:center; ">
                                    <span><?php echo $settings['iq_' . $type . '_password_error_message']; ?></span>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class=" elementor-alert-danger graphina-error "
                                     style="display: none; align-items:center;">
                                    <span><?php echo $settings['iq_' . $type . '_password_error_message']; ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <?php
            }
            $restrictedTemplate = true;

        } elseif ($settings['iq_' . $type . '_restriction_content_type'] === 'password') {
            $restrictedTemplate = false;
        }
    }

    return $restrictedTemplate;
}

//  opposite yaxis section
function graphinaYaxisOpposite($this_ele, $type)
{

    $this_ele->add_control(
        'iq_' . $type . '_chart_hr_opposite_yaxis',
        [
            'type' => Controls_Manager::DIVIDER,
            'condition' => [
                'iq_' . $type . '_chart_data_series_count!' => 1
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_opposite_yaxis_title_enable',
        [
            'label' => esc_html__('Enable Opposite Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'no',
            'condition' => [
                'iq_' . $type . '_chart_data_series_count!' => 1
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_opposite_yaxis_tick_amount',
        [
            'label' => esc_html__('Tick Amount', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'max' => 30,
            'min' => 0,
            'condition' => [
                'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
                'iq_' . $type . '_chart_data_series_count!' => 1
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_opposite_yaxis_label_show',
        [
            'label' => esc_html__('Show Label', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => false,
            'condition' => [
                'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
                'iq_' . $type . '_chart_data_series_count!' => 1
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_opposite_yaxis_label_prefix',
        [
            'label' => esc_html__('Labels Prefix', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'iq_' . $type . '_chart_opposite_yaxis_label_show' => 'yes',
                'iq_' . $type . '_chart_data_series_count!' => 1
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_opposite_yaxis_label_postfix',
        [
            'label' => esc_html__('Labels Postfix', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'iq_' . $type . '_chart_opposite_yaxis_label_show' => 'yes',
                'iq_' . $type . '_chart_data_series_count!' => 1
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    if (in_array($type, ['area', 'column', 'bubble', 'line','mixed','scatter'])) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_opposite_yaxis_format_number',
            [
                'label' => esc_html__('Format Number', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
                'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'default' => 'no',
                'condition' => [
                    'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
                    'iq_' . $type . '_chart_opposite_yaxis_label_show' => 'yes',
                    'iq_' . $type . '_chart_data_series_count!' => 1
                ]
            ]
        );
    }

    $this_ele->add_control(
        'iq_' . $type . '_chart_opposite_yaxis_title',
        [
            'label' => esc_html__('Opposite Y-axis Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
                 'iq_' . $type . '_chart_data_series_count!' => 1
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_card_opposite_yaxis_title_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
            'condition' => [
                'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
                'iq_' . $type . '_chart_data_series_count!' => 1
            ]
        ]
    );
}

function graphina_selection_setting( $this_ele, $type){

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_selection',
        [
            'label' => esc_html__('Selection Setting', 'graphina-charts-for-elementor')
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_xaxis',
        [
            'label' => esc_html__('Xaxis', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Enable', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Disable', 'graphina-charts-for-elementor'),
            'default' => 'yes',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_xaxis_min',
        [
            'label' => __('Min', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 1,
            'default' => 1,
            'condition' => [
                'iq_' . $type . '_chart_selection_xaxis' => 'yes',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_xaxis_max',
        [
            'label' => __('Max', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'min' => 2,
            'step' => 1,
            'default' => 6,
            'condition' => [
                'iq_' . $type . '_chart_selection_xaxis' => 'yes',
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_fill',
        [
            'label' => __('Fill', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_fill_color',
        [
            'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_fill_opacity',
        [
            'label' => esc_html__('Opacity', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0.4,
            'min' => 0.00,
            'max' => 1,
            'step' => 0.05,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_stroke',
        [
            'label' => __('Stroke', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_stroke_width',
        [
            'label' => esc_html__('Width', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 1,
            'min' => 1,
            'step' => 1
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_stroke_dasharray',
        [
            'label' => esc_html__('Dash', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'step' => 1
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_stroke_color',
        [
            'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#24292e',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_selection_stroke_opacity',
        [
            'label' => esc_html__('Opacity', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0.4,
            'min' => 0.00,
            'max' => 1,
            'step' => 0.05,
        ]
    );

    $this_ele->end_controls_section();
}

function graphina_series_2_setting($this_ele, $type = 'chart_id', $ele_array = ['color'], $showFillStyle = true, $fillOptions = [], $showFillOpacity = false, $showGradientType = false)
{
    $colors = graphina_colors('color');
    $gradientColor = graphina_colors('gradientColor');
    $seriesTest = 'Element';

    $title = in_array('brush-1',$ele_array) ? 'chart-1 ' : 'Chart-2 ';

    $type1='brush';

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_11',
        [
            'label' => esc_html__($title.'Elements Setting', 'graphina-charts-for-elementor'),
        ]
    );

    if ($showFillStyle) {
        graphina_fill_style_setting($this_ele, $type, $fillOptions, $showFillOpacity);
    }

    if ($showFillStyle && in_array('gradient', $fillOptions)) {
        graphina_gradient_setting($this_ele, $type, $showGradientType, true);
    }

    for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

        if ($i !== 0 || $showFillStyle) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_hr_series_count_' . $i,
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' => [
                        'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        $this_ele->add_control(
            'iq_' . $type . '_chart_series_title_' . $i,
            [
                'label' => esc_html__($seriesTest . ' ' . ($i + 1), 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                ]
            ]
        );

        if (in_array('color', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_gradient_1_' . $i,
                [
                    'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => $colors[$i],
                    'condition' => [
                        'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_gradient_2_' . $i,
                [
                    'label' => esc_html__('Second Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => $gradientColor[$i],
                    'condition' => [
                        'iq_' . $type . '_chart_fill_style_type' => 'gradient',
                        'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_bg_pattern_' . $i,
                [
                    'label' => esc_html__('Fill Pattern', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => graphina_get_fill_patterns(true),
                    'options' => graphina_get_fill_patterns(),
                    'condition' => [
                        'iq_' . $type . '_chart_fill_style_type' => 'pattern',
                        'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        if (in_array('dash', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_dash_3_' . $i,
                [
                    'label' => 'Dash',
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'min' => 0,
                    'max' => 100,
                    'condition' => [
                        'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
                    ],
                    'description' => esc_html__("Notice:This will not work in column chart", 'graphina-charts-for-elementor'),
                ]
            );
        }

        if (in_array('width', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_width_3_' . $i,
                [
                    'label' => 'Stroke Width',
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3,
                    'min' => 1,
                    'max' => 20,
                    'condition' => [
                        'iq_' . $type1 . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ],
                    'description' => esc_html__("Notice:This will not work in column chart", 'graphina-charts-for-elementor'),
                ]
            );
        }

        $chart_type = ['radar','line', 'area','brush'];

        if(in_array($type,$chart_type)){

            graphina_marker_setting($this_ele, $type, $i);

        }
    }
    $this_ele->end_controls_section();
}

function graphina_yaxis_min_max_setting($this_ele,$type){
    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_enable_min_max',
        [
            'label' => esc_html__('Enable Min/Max', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => false,
            'description' => esc_html__('Note: If chart having multi series, Enable Min/Max value will be applicable to all series and Yaxis Tickamount must be according to min - max value','graphina-charts-for-elementor')
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_min_value',
        [
            'label' => esc_html__('Min Value', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_enable_min_max' => 'yes'
            ],
            'description' => esc_html__('Note: Lowest number to be set for the y-axis. The graph drawing beyond this number will be clipped off','graphina-charts-for-elementor')
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_yaxis_max_value',
        [
            'label' => esc_html__('Max Value', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 250,
            'condition' => [
                'iq_' . $type . '_chart_yaxis_enable_min_max' => 'yes'
            ],
            'description' => esc_html__('Note: Highest number to be set for the y-axis. The graph drawing beyond this number will be clipped off.','graphina-charts-for-elementor')
        ]
    );
}

function graphina_datatable_lite_element_data_option_setting($this_ele, $type = 'element_id')
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_data_options',
        [
            'label' => esc_html__('Data Options',  'graphina-charts-for-elementor'),
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_is_pro',
        [
            'label' => esc_html__('Is Pro', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HIDDEN,
            'default' => isGraphinaPro() === true ? 'true' : 'false',
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_data_option',
        [
            'label' => esc_html__('Type',  'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => graphina_chart_data_enter_options('base', $type, true),
            'options' => graphina_chart_data_enter_options('base', $type)
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_element_rows',
        [
            'label' => esc_html__('No of Rows',  'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'condition'=>[
                'iq_' . $type . '_chart_data_option' => 'manual'
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_element_columns',
        [
            'label' => esc_html__('No of Columns',  'graphina-pro-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 3,
            'min' => 1,
            'condition'=>[
                'iq_' . $type . '_chart_data_option' => 'manual'
            ]
        ]
    );

    $this_ele->end_controls_section();

    do_action('graphina_addons_control_section', $this_ele, $type);

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_5_2_1',
        [
            'label' => esc_html__('Dynamic Data Options', 'graphina-charts-for-elementor'),
            'condition' => [
                'iq_' . $type . '_chart_data_option' => ['dynamic']
            ]
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_dynamic_data_option',
        [
            'label' => esc_html__('Type', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => graphina_chart_data_enter_options('dynamic', $type, true),
            'options' => graphina_chart_data_enter_options('dynamic', $type)
        ]
    );

    if (isGraphinaPro()) {
        graphina_pro_get_dynamic_options($this_ele, $type);
    }else{
        $this_ele->add_control(
            'iq_' . $type . 'get_pro',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => graphina_get_teaser_template([
                    'title' => esc_html__('Get New Exciting Features', 'graphina-charts-for-elementor'),
                    'messages' => ['Get Graphina Pro for above exciting features and more.'],
                    'link' => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061'
                ]),
            ]
        );
    }

    $this_ele->end_controls_section();

    if (isGraphinaPro() && (!in_array($type, ['line_google']))) {
        graphina_restriction_content_options($this_ele, $type);
    }
}

/*******************
 * @param object $this_ele
 * @param string $type
 */
function graphina_dyanmic_chart_style_section($this_ele, $type = 'chart_id')
{
    $this_ele->start_controls_section('iq_' . $type . 'dynamic_change_type_style_section',
        [
            'label' => esc_html__('Change Chart Type Style', 'graphina-charts-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'iq_' . $type . '_dynamic_change_chart_type' => 'yes'
            ],
        ]
    );

    $this_ele->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => 'iq_' . $type . '_dynamic_change_type_select_text_typography',
            'label' => esc_html__('Select Text Typography', 'graphina-charts-for-elementor'),
            'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            'selector' => '{{WRAPPER}} #graphina-select-chart-type'
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_dynamic_change_type_align',
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
            'selectors' => [
                '{{WRAPPER}} .graphina_dynamic_change_type' => 'text-align: {{VALUE}}',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_dynamic_change_type_font_color',
        [
            'label' => esc_html__('Font Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} #graphina-select-chart-type' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_dynamic_change_type_background_color',
        [
            'label' => esc_html__('Select Background Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} #graphina-select-chart-type' => 'background: {{VALUE}}',
            ],
        ]
    );
    $this_ele->add_responsive_control(
        'iq_' . $type . '_dynamic_change_type_height',
        [
            'label' => __( 'Height', 'graphina-charts-for-elementor' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => '%',
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'size_units' => [ '%', 'px', 'vw' ],
            'range' => [
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #graphina-select-chart-type' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this_ele->add_responsive_control(
        'iq_' . $type . '__dynamic_change_type_width',
        [
            'label' => __( 'Width', 'graphina-charts-for-elementor' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => '%',
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'size_units' => [ '%', 'px', 'vw' ],
            'range' => [
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #graphina-select-chart-type' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '__dynamic_change_type_select_radius',
        [
            'label' => esc_html__('Select Border Radius',  'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} #graphina-select-chart-type '=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
                ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_dynamic_change_type_margin',
        [
            'label' => esc_html__('Margin', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .graphina_dynamic_change_type' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_dynamic_change_type_padding',
        [
            'label' => esc_html__('Padding', 'graphina-charts-for-elementor'),
            'size_units' => ['px', '%', 'em'],
            'type' => Controls_Manager::DIMENSIONS,
            'condition' => [
                'iq_' . $type . '_is_card_heading_show' => 'yes'
            ],
            'selectors' => [
                '{{WRAPPER}} .graphina_dynamic_change_type' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this_ele->end_controls_section();

}

function graphina_charts_filter_settings($this_ele,$type){
    $condition = [
        'iq_' . $type . '_chart_data_option' => 'dynamic',
        'iq_' . $type . '_chart_dynamic_data_option' =>['sql-builder','api']
    ];
    if(in_array($type,['counter','advance-datatable'])){
        $condition = [
            'iq_' . $type . '_element_data_option' => 'dynamic',
            'iq_' . $type . '_element_dynamic_data_option' =>['database','api']
        ];
    }
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_chart_filter',
        [
            'label' => esc_html__('Chart Filter', 'graphina-charts-for-elementor'),
            'condition' => $condition
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_enable',
        [
            'label' => esc_html__('Enable Filter', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => false,
        ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_value_label',
        [
            'label' => esc_html__('Label', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default'=> esc_html__('Choose Option','graphina-charts-for-elementor'),
            'description' => esc_html__("Note: This key is use where you want to use selected option value", 'graphina-charts-for-elementor'),
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_value_key',
        [
            'label' => esc_html__('Add Filter Keys', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'placeholder' =>esc_html__('{{key_1}}', 'graphina-charts-for-elementor'),
            'description' => esc_html__("Note: This key is use where you want to use selected option value", 'graphina-charts-for-elementor'),
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_type',
        [
            'label' => esc_html__('Filter Type', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default'=> 'select',
            'block'=>true,
            'options' => [
                'select' => esc_html__('Select Dropdown','graphina-charts-for-elementor'),
                'date' => esc_html__('Datepicker','graphina-charts-for-elementor'),
            ],
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_date_type',
        [
            'label' => esc_html__('Date Type', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default'=> 'date',
            'block'=>true,
            'options' => [
                'datetime' => esc_html__('DateTime','graphina-charts-for-elementor'),
                'date' => esc_html__('Date','graphina-charts-for-elementor'),
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'iq_' . $type . '_chart_filter_type',
                        'value' => 'date',
                    ],
                ],
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_datetime_default',
        [
            'label' => esc_html__('Default Date', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::DATE_TIME,
            'default'=> current_time('Y-m-d h:i:s'),
            'label_block' => true,
            'dynamic' => [
                'active' => true,
            ],
            'conditions' => [
                'relation' => 'and',
                'terms' => [
                    [
                        'name' => 'iq_' . $type . '_chart_filter_type',
                        'value' => 'date',
                    ],
                    [
                        'name' => 'iq_' . $type . '_chart_filter_date_type',
                        'value' => 'datetime',
                    ],
                ],
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_date_default',
        [
            'label' => esc_html__('Default Date', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::DATE_TIME,
            'default'=> current_time('Y-m-d'),
            'label_block' => true,
            'dynamic' => [
                'active' => true,
            ],
            'picker_options' => [
                'enableTime' => false,
            ],
            'conditions' => [
                'relation' => 'and',
                'terms' => [
                    [
                        'name' => 'iq_' . $type . '_chart_filter_type',
                        'value' => 'date',
                    ],
                    [
                        'name' => 'iq_' . $type . '_chart_filter_date_type',
                        'value' => 'date',
                    ],
                ],
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_value',
        [
            'label' => esc_html__('Add Select Dropdown Filter Value', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'placeholder' =>esc_html__('Value,Value1', 'graphina-charts-for-elementor'),
            'description' => __("<strong>Note: Value are seperator by comma, value is use as option <u>(".htmlspecialchars('<option value="value1" selected> Name1 </option> <option value="value2" > Name2 </option>')."</u> And first option will be default selected value </strong>", 'graphina-charts-for-elementor'),
            'label_block' => true,
            'dynamic' => [
                'active' => true,
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'iq_' . $type . '_chart_filter_type',
                        'value' => 'select',
                    ],
                ],
            ],
        ]
    );

    $repeater->add_control(
        'iq_' . $type . '_chart_filter_option',
        [
            'label' => esc_html__('Add Select Dropdown Filter Name', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'placeholder' =>esc_html__('Name1,Name2', 'graphina-charts-for-elementor'),
            'description' => __("<strong> Note: Name are seperator by comma ,Name is use as option <u>(".htmlspecialchars('<option value="value1" selected> Name1 </option> <option value="value2" > Name2 </option>')."</u>  And first option will be default selected value </strong>    ", 'graphina-charts-for-elementor'),
            'label_block' => true,
            'dynamic' => [
                'active' => true,
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'iq_' . $type . '_chart_filter_type',
                        'value' => 'select',
                    ],
                ],
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_filter_list',
        [
            'label' => esc_html__('Filter Tab', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'condition' => [
                'iq_' . $type . '_chart_filter_enable' =>'yes'
            ]
        ]
    );

    $this_ele->end_controls_section();
}

function graphina_advance_h_axis_setting($this_ele, $type = 'chart_id', $showFixed = true, $showTooltip = true)
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_8',
        [
            'label' => esc_html__('X-Axis Setting', 'graphina-charts-for-elementor'),
        ]
    );
    if (in_array($type, [ 'column_google','line_google','area_google', 'bar_google'])) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_label_settings',
            [
                'label' => esc_html__('Label Setting', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_haxis_label_position_show',
            [
                'label' => esc_html__('Label Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        ); 
        $this_ele->add_control(
            'iq_' . $type . '_chart_haxis_label_position',
            [
                'label' => esc_html__('Label Position', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'out',
                'options' => graphina_position_type("in_out"),
                'condition' => [
                    'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                ],
            ]
        );
        if (in_array($type, [ 'column_google','line_google','area_google'])) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_haxis_label_prefix_postfix',
                [
                    'label' => esc_html__('Label Prefix/Postfix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => '',
                    'condition' => [
                        'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_haxis_label_prefix',
                [
                    'label' => esc_html__('Prefix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'condition' => [
                        'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
                        'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes'
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_haxis_label_postfix',
                [
                    'label' => esc_html__('Postfix', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'condition' => [
                        'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
                        'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes'
                    ],
                ]
            );
        }
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_label_font_color',
            [
                'label' => esc_html__('Label Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                ]
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_label_font_size',
            [
                'label' => esc_html__(' Label Fontsize', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 25,
                'default' => 11,
                'condition' => [
                    'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                ]              
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_rotate',
            [
                'label' => esc_html__('Label Rotate', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => false,
                'condition' => [
                    'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                ]
            ]
        );  
        $this_ele->add_control(
            'iq_' . $type . '_chart_xaxis_rotate_value',
            [
                'label' => esc_html__('Label Rotate Angle', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 11,
                'max' => 349,
                'default' => 50,
                'condition' => [
                    'iq_' . $type . '_chart_xaxis_rotate' => 'yes'
                ],
            ]
        );
    }
    if (in_array($type, [ 'column_google','line_google','area_google', 'geo_google'])) {
        $this_ele->add_control(
            'iq_' . $type . '_chart_haxis_direction',
            [
                'label' => esc_html__('Reverse Category', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'false',
                'condition' => [
                    'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                ]
            ]
        );
    }
    
    $this_ele->add_control(
        'iq_' . $type . '_chart_xaxis_title_devider',
        [
            'type' => Controls_Manager::DIVIDER,
        ]
    );
    $this_ele->add_control(
        'iq_' . $type . '_chart_axis_Title_heading',
        [
            'label' => esc_html__('Title Setting', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]
    );  
    $this_ele->add_control(
            'iq_' . $type . '_chart_haxis_title_show',
            [
                'label' => esc_html__('Title Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'false'
            ]
    );  
    $this_ele->add_control(
        'iq_' . $type . '_chart_haxis_title',
        [
            'label' => esc_html__('Title', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Title',
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                'iq_' . $type . '_chart_haxis_title_show' => 'yes'
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_haxis_title_font_color',
        [
            'label' => esc_html__('Title Color', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#000000',
            'condition' => [
                'iq_' . $type . '_chart_haxis_title_show' => 'yes'
            ],
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_chart_haxis_title_font_size',
        [
            'label' => esc_html__(' Title Fontsize', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 25,
            'default' => 12,
            'condition' => [
                'iq_' . $type . '_chart_haxis_title_show' => 'yes'
            ],
        ]
    );

    
    
    $this_ele->end_controls_section();

}

function graphina_advance_v_axis_setting($this_ele, $type = 'chart_id', $showFixed = true, $showTooltip = true)
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_9',
        [
            'label' => esc_html__('Y-Axis Setting', 'graphina-charts-for-elementor'),
        ]
    );
    if (in_array($type, [ 'column_google','bar_google','line_google','area_google'])) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_enable_minmax',
                [
                    'label' => esc_html__('Enable Min/Max', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'false'
                ]
            );  
            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_minvalue',
                [
                    'label' => esc_html__('Yaxis Min Value', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 0,
                    'condition' => [
                        'iq_' . $type . '_chart_vaxis_enable_minmax' => 'yes'
                    ],
                ]
            );  
            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_maxvalue',
                [
                    'label' => esc_html__('Yaxis Max Value', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,     
                    'default' => 250,
                    'condition' => [
                        'iq_' . $type . '_chart_vaxis_enable_minmax' => 'yes'
                    ],
                ]
            ); 
            $this_ele->add_control(
                'iq_' . $type . '__chart_vaxis_enable_minmax_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_Label_Settings',
                [
                    'label' => esc_html__('Label Setting', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::HEADING,
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_label_position_show',
                [
                    'label' => esc_html__('Label Show', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'yes'
                ]
            ); 
           
            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_label_position',
                [
                    'label' => esc_html__('Label Position', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'out',
                    'options' => graphina_position_type("in_out"),
                    'condition' => [
                        'iq_' . $type . '_chart_vaxis_label_position_show' => 'yes'
                    ],
                ]
            );
            if (in_array($type, [ 'bar_google'])) {
                $this_ele->add_control(
                    'iq_' . $type . '_chart_haxis_label_prefix_postfix',
                    [
                        'label' => esc_html__('Label Prefix/Postfix', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::SWITCHER,
                        'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                        'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                        'default' => '',
                        'condition' => [
                            'iq_' . $type . '_chart_haxis_label_position_show' => 'yes'
                        ],
                    ]
                );
                $this_ele->add_control(
                    'iq_' . $type . '_chart_haxis_label_prefix',
                    [
                        'label' => esc_html__('Prefix', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'condition' => [
                            'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
                            'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes'
                        ],
                    ]
                );
                $this_ele->add_control(
                    'iq_' . $type . '_chart_haxis_label_postfix',
                    [
                        'label' => esc_html__('Postfix', 'graphina-charts-for-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '',
                        'condition' => [
                            'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
                            'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes'
                        ],
                    ]
                );
            }
       
            $this_ele->add_control(
                'iq_' . $type . '_chart_yaxis_label_font_color',
                [
                    'label' => esc_html__('Label Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#000000',
                    'condition' => [
                        'iq_' . $type . '_chart_vaxis_label_position_show' => 'yes'
                    ],
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_yaxis_label_font_size',
                [
                    'label' => esc_html__(' Label Fontsize', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 3,
                    'max' => 18,
                    'default' => 11,
                    'condition' => [
                        'iq_' . $type . '_chart_vaxis_label_position_show' => 'yes'
                    ],
                ]
            );
            
    }
     if (in_array($type, [ 'column_google','line_google','area_google'])) {

            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_direction',
                [
                    'label' => esc_html__('Reverse Direction', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'false'
                ]
            );  
        }
        if (in_array($type, [ 'bar_google'])) {
  
            $this_ele->add_control(
                'iq_' . $type . '_chart_haxis_direction',
                [
                    'label' => esc_html__('Reverse Direction', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'false'
                ]
            );
            

         }
         if (in_array($type, [ 'bar_google'])) {

            $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_direction',
                [
                    'label' => esc_html__('Reverse Category', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'false'
                ]
            );  
        }
         $this_ele->add_control(
            'iq_' . $type . '_chart_vaxis_format',
            [
                'label' => esc_html__('Number Format', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'decimal',
                'options' => [
                    "decimal" => esc_html__('Decimal', 'graphina-charts-for-elementor'),
                    "scientific" => esc_html__('Scientific', 'graphina-charts-for-elementor'),
                    "\#" => esc_html__('Currency', 'graphina-charts-for-elementor'),
                    "#\'%\'" => esc_html__('Percent', 'graphina-charts-for-elementor'),
                    "short" => esc_html__('Short', 'graphina-charts-for-elementor'),
                    "long" => esc_html__('Long', 'graphina-charts-for-elementor'),
                    
                ]
            ]
        );

    $this_ele->add_control(
        'iq_' . $type . '_chart_vaxis_format_currency_prefix',
        [
            'label' => esc_html__('Currency Prefix', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '$',
            'condition'=>[
                'iq_' . $type . '_chart_vaxis_format' => '\#'
            ]
        ]
    );

        $this_ele->add_control(
            'iq_' . $type . '__chart_vaxis_label_divider',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_yaxis_Title_heading',
            [
                'label' => esc_html__('Title Setting', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this_ele->add_control(
                'iq_' . $type . '_chart_vaxis_title_show',
                [
                    'label' => esc_html__('Title Show', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                    'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                    'default' => 'false'
                ]
        );  
        $this_ele->add_control(
            'iq_' . $type . '_chart_vaxis_title',
            [
                'label' => esc_html__('Title', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Title',
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'iq_' . $type . '_chart_vaxis_title_show' => 'yes'
                ],
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_vaxis_title_font_color',
            [
                'label' => esc_html__('Title Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'iq_' . $type . '_chart_vaxis_title_show' => 'yes'
                ],
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_vaxis_title_font_size',
            [
                'label' => esc_html__(' Title Fontsize', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 25,
                'default' => 12,
                'condition' => [
                    'iq_' . $type . '_chart_vaxis_title_show' => 'yes'
                ],
            ]
        );
        
        $this_ele->add_control(
            'iq_' . $type . '_chart_gridline',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_gridline_setting',
            [
                'label' => esc_html__('Gridline Setting', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_gridline_count_show',
            [
                'label' => esc_html__('Line Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'yes'
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_gridline_count',
            [
                'label' => esc_html__('Gridline Count', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'condition' => [
                    'iq_' . $type . '_chart_gridline_count_show' => 'yes'
                ],
                
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_gridline_color',
            [
                'label' => esc_html__('Gridline color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#cccccc',
                'condition' => [
                    'iq_' . $type . '_chart_gridline_count_show' => 'yes'
                ],
            ]
        );
    
        $this_ele->add_control(
            'iq_' . $type . '_chart_baseline_Color',
            [
                'label' => esc_html__('Zero Indicator', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#cccccc',
            
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_logscale_setting_title',
            [
                'label' => esc_html__('Log Scale Settings', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'iq_' . $type . '_chart_gridline_count_show' => 'yes'
                ]
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_chart_logscale_show',
            [
                'label' => esc_html__('Show', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'true' => esc_html__('Yes', 'graphina-charts-for-elementor'),
                'false' => esc_html__('No', 'graphina-charts-for-elementor'),
                'default' => 'fasle',
                'condition' => [
                    'iq_' . $type . '_chart_gridline_count_show' => 'yes'
                ]
            ]
        );

        $this_ele->add_control(
            'iq_' . $type . '_chart_vaxis_scaletype',
            [
                'label' => esc_html__('Scale Type', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'log',
                'options' => [
                    "log" => esc_html__('Log', 'graphina-charts-for-elementor'),
                    "mirrorLog" => esc_html__('MirrorLog', 'graphina-charts-for-elementor')
                
                ],
                'condition' => [
                    'iq_' . $type . '_chart_logscale_show' => 'yes',
                    'iq_' . $type . '_chart_gridline_count_show' => 'yes'
                ]
            ]
        );
        
        $this_ele->end_controls_section();

}

function graphina_advance_legend_setting($this_ele, $type = 'chart_id', $showFixed = true, $showTooltip = true)
{
    $this_ele->start_controls_section(
        'iq_' . $type . '_section_10',
        [
            'label' => esc_html__('Legend Setting', 'graphina-charts-for-elementor'),
        ]
    );

    $this_ele->add_control(
        'iq_' . $type . '_google_chart_legend_show',
        [
            'label' => esc_html__('Show Legend', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Hide', 'graphina-charts-for-elementor'),
            'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
            'default' => 'yes'
        ]
    );
    
    if (in_array($type, [ 'column_google','line_google','area_google','bar_google'])) {
                    $this_ele->add_control(
                        'iq_' . $type . '_google_chart_legend_position',
                        [
                            'label' => esc_html__('Legend Position', 'graphina-charts-for-elementor'),
                            'type' => Controls_Manager::SELECT,
                            'default' => 'bottom',
                            'options' => graphina_position_type("google_chart_legend_position"),
                            'condition' => [
                                'iq_' . $type . '_google_chart_legend_show' => 'yes'
                            ]
                        ]
                    );
                   
                    $this_ele->add_control(
                        'iq_' . $type . '_google_chart_legend_color',
                        [
                            'label' => esc_html__('Legend Text Color', 'graphina-charts-for-elementor'),
                            'type' => Controls_Manager::COLOR,
                            'default' => 'black',
                            'options' => graphina_position_type("google_chart_legend_position"),
                            'condition' => [
                                'iq_' . $type . '_google_chart_legend_show' => 'yes'
                            ]
                        ]
                    );
                    $this_ele->add_control(
                        'iq_' . $type . '_google_chart_legend_fontsize',
                        [
                            'label' => esc_html__('Legend Text Fontsize', 'graphina-charts-for-elementor'),
                            'type' => Controls_Manager::NUMBER,
                            'default' => 10,
                            'min' => 1,
                            'max' => 15,
                            'options' => graphina_position_type("google_chart_legend_position"),
                            'condition' => [
                                'iq_' . $type . '_google_chart_legend_show' => 'yes'
                            ]
                        ]
                    );
                    
    }
    if (in_array($type, [ 'column_google','line_google','area_google','bar_google','pie_google','donut_google'])) 
    {
    $this_ele->add_control(
        'iq_' . $type . '_google_chart_legend_horizontal_align',
        [
            'label' => esc_html__('Horizontal Align', 'graphina-charts-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
            'options' => [
                'start' => [
                    'title' => esc_html__('Start', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'end' => [
                    'title' => esc_html__('End', 'graphina-charts-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ]
            ],
            'condition' => [
                'iq_' . $type . '_google_chart_legend_show' => 'yes',
            ]
        ]
    );
}
    if (in_array($type, [ 'pie_google','donut_google'])) {
        $this_ele->add_control(
            'iq_' . $type . '_google_piechart_legend_position',
            [
                'label' => esc_html__('Legend Position', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => graphina_position_type("google_piechart_legend_position"),
                'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_google_chart_legend_labeld_value',
            [
                'label' => esc_html__('Labeled Value Text', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'Value',
                'options' => [
                    "both" => esc_html__('Value And Percentage', 'graphina-charts-for-elementor')],
                    "value" => esc_html__('Value', 'graphina-charts-for-elementor'),
                    "percentages" => esc_html__('Percentages', 'graphina-charts-for-elementor'),
                'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes',
                    'iq_' . $type . '_google_piechart_legend_position' => 'labeled'
                ]
            ]
        );
      
        $this_ele->add_control(
            'iq_' . $type . '_google_chart_legend_color',
            [
                'label' => esc_html__('Legend Text Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => 'black',
                'options' => graphina_position_type("google_piechart_legend_position"),
                'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
            ]
        );
        $this_ele->add_control(
            'iq_' . $type . '_google_chart_legend_fontsize',
            [
                'label' => esc_html__('Legend Text Fontsize', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 15,
                'default' => 10,
                'options' => graphina_position_type("google_piechart_legend_position"),
                'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
            ]
        );
    }

    if(in_array($type,['geo_google']))
    {
        $this_ele->add_control(
            'iq_' . $type . '_google_legend_color',
            [
                'label' => esc_html__('Legend Color','graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
            ]
        );
     
        $this_ele->add_control(
             'iq_' . $type . '_google_legend_size',
             [
                 'label' => esc_html__('Legend Size','graphina-charts-for-elementor'),
                 'type' => Controls_Manager::NUMBER,
                 'min' => 0,
                 'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
             ]
         );
     
         $this_ele->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'iq_' . $type . '_legend_typography',
                 'label' => esc_html__('Typography', 'graphina-charts-for-elementor'),
                 'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                 'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
             ]
         );
     
         $this_ele->add_control(
             'iq_' . $type . '_google_legend_format',
             [
                 'label' => esc_html__('Number Format','graphina-charts-for-elementor'),
                 'type' => Controls_Manager::SWITCHER,
                 'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
             ]
         );
     
         $this_ele->add_control(
             'iq_' . $type . '_google_legend_bold',
             [
                 'label' => esc_html__('Bold','graphina-charts-for-elementor'),
                 'type' => Controls_Manager::SWITCHER,
                 'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
             ]
         );
     
         $this_ele->add_control(
             'iq_' . $type . '_google_legend_italic',
             [
                 'label' => esc_html__('Italic','graphina-charts-for-elementor'),
                 'type' => Controls_Manager::SWITCHER,
                 'condition' => [
                    'iq_' . $type . '_google_chart_legend_show' => 'yes'
                ]
             ]
         );
    }
    


    $this_ele->end_controls_section();
}

// google chart element setting funtion
function graphina_google_series_setting($this_ele, $type = 'chart_id', $ele_array = ['color'], $showFillStyle = true, $fillOptions = [], $showFillOpacity = false, $showGradientType = false)
{
    $colors = graphina_colors('color');
    $gradientColor = graphina_colors('gradientColor');
    $seriesTest = 'Element';

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_12',
        [
            'label' => esc_html__('Elements Setting', 'graphina-charts-for-elementor'),
        ]
    );
    for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

        if ($i !== 0) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_hr_series_count_' . $i,
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        $this_ele->add_control(
            'iq_' . $type . '_chart_series_title_' . $i,
            [
                'label' => esc_html__($seriesTest . ' ' . ($i + 1), 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                ]
            ]
        );

        if (in_array('color', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_element_color_' . $i,
                [
                    'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => $colors[$i],
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        if(in_array($type, ['line_google', 'area_google'])){
            $this_ele->add_control(
                'iq_' . $type . '_chart_element_linewidth' . $i,
                [
                    'label' => esc_html__(' LineWidth', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 2,
                    'min' => 1,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
            $this_ele->add_control(
                'iq_' . $type . '_chart_element_lineDash' . $i,
                [
                    'label' => esc_html__(' Line Dash Style', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default' => esc_html__('Default', 'graphina-charts-for-elementor'),
                        'style_1' => esc_html__('Style 1', 'graphina-charts-for-elementor'),
                        'style_2' => esc_html__('Style 2', 'graphina-charts-for-elementor'),
                        'style_3' => esc_html__('Style 3', 'graphina-charts-for-elementor'),
                        'style_4' => esc_html__('Style 4', 'graphina-charts-for-elementor'),
                        'style_5' => esc_html__('Style 5', 'graphina-charts-for-elementor'),
                        'style_6' => esc_html__('Style 6', 'graphina-charts-for-elementor'),
                        'style_7' => esc_html__('Style 7', 'graphina-charts-for-elementor'),
                        'style_8' => esc_html__('Style 8', 'graphina-charts-for-elementor'),
                        'style_9' => esc_html__('Style 9', 'graphina-charts-for-elementor'),
                    ],
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                        ]
                ]
            );
        }                            

        if (in_array('width', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_width_3_' . $i,
                [
                    'label' => 'Stroke Width',
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5,
                    'min' => 1,
                    'max' => 20,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        $chart_type = ['line_google', 'area_google','column_google'];

        if(in_array($type,$chart_type)){

            // graphina_marker_setting($this_ele, $type, $i);
            graphina_marker_setting_google($this_ele, $type, $i);

        }

    }
    $this_ele->end_controls_section();
}

//column element setting
function graphina_column_chart_google_series_setting($this_ele, $type = 'chart_id', $ele_array = ['color'], $showFillStyle = true, $fillOptions = [], $showFillOpacity = false, $showGradientType = false)
{
    $colors = graphina_colors('color');
    $gradientColor = graphina_colors('gradientColor');
    $seriesTest = 'Element';

    $this_ele->start_controls_section(
        'iq_' . $type . '_section_13',
        [
            'label' => esc_html__('Elements Setting', 'graphina-charts-for-elementor'),
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
    for ($i = 0; $i < graphina_default_setting('max_series_value'); $i++) {

        if ($i !== 0) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_hr_series_count_' . $i,
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }

        $this_ele->add_control(
            'iq_' . $type . '_chart_series_title_' . $i,
            [
                'label' => esc_html__($seriesTest . ' ' . ($i + 1), 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                ]
            ]
        );

        if (in_array('color', $ele_array)) {
            $this_ele->add_control(
                'iq_' . $type . '_chart_element_color_' . $i,
                [
                    'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                    'type' => Controls_Manager::COLOR,
                    'default' => $colors[$i],
                    'condition' => [
                        'iq_' . $type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value'))
                    ]
                ]
            );
        }
      
    }
    $this_ele->end_controls_section();
}
