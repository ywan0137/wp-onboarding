<?php

namespace Elementor;
if (!defined('ABSPATH')) exit;

/**
 * @method add_control(string $string, array $array)
 */
class Animated_radial extends Widget_Base
{

    private $version;

    public function __construct($data = [], $args = null)
    {
        wp_register_script('graphina-charts-perlin',  GRAPHINA_URL.'/elementor/js/perlin.js', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true);
        wp_register_script('graphina-charts-d3',  GRAPHINA_URL.'/elementor/js/d3.min.js', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true);
        parent::__construct($data, $args);
    }

    public function get_script_depends() {
        return ['graphina-charts-perlin','graphina-charts-d3'];
    }
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
        return 'animated_radial';
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
        return 'Animated Radial (Soft deprecated)';
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
        return 'graphina-apex-animatedradial-chart';
    }

    protected function register_controls()
    {

        graphina_basic_setting($this, 'animated-radial');

        graphina_restriction_content_options($this, 'animated-radial');

        $this->start_controls_section(
            'iq_animated-radial_section_2',
            [
                'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor')
            ]
        );

        $this->add_control(
            'iq_animated-radial_chart_height',
            [
                'label' => esc_html__('Height', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 80,
                'min' => 40
            ]
        );

        $this->add_control(
            'iq_animated-radial_chart_gradient_1',
            [
                'label' => esc_html__('Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#272e3a'
            ]
        );

        $this->add_control(
            'iq_animated-radial_chart_gradient_2',
            [
                'label' => esc_html__('Second Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#d02835'
            ]
        );

        $this->add_control(
            'iq_animated-radial_chart_stroke_color',
            [
                'label' => esc_html__('Stroke Color', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#272e3a'
            ]
        );

        $this->add_control(
            'iq_animated-radial_chart_line_space',
            [
                'label' => esc_html__('Line Space', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4
            ]
        );

        $this->add_control(
            'iq_animated-radial_chart_speed',
            [
                'label' => esc_html__('Animation Speed', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0.005',
                'min' => 0,
                'max' => 1,
                'step' => 0.001
            ]
        );


        $this->end_controls_section();

        graphina_style_section($this, 'animated-radial');

        graphina_card_style($this, 'animated-radial');

        if (function_exists('graphina_pro_password_style_section')) {
            graphina_pro_password_style_section($this, 'animated-radial');
        }
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        require GRAPHINA_ROOT . '/elementor/charts/animated-radial/render/animated-radial.php';
        if (isRestrictedAccess('animated-radial', $this->get_id(), $settings, false) === false) {
            ?>

            <script>
                (function($) {
                    'use strict';
                    if(parent.document.querySelector('.elementor-editor-active') !== null){
                        graphinaAnimatedRadialRender();
                    }
                    document.addEventListener('readystatechange', event => {
                        // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                        if (event.target.readyState === "complete") {
                            graphinaAnimatedRadialRender();
                        }
                    })

                    function graphinaAnimatedRadialRender(){
                        if (typeof animatedRadialChartHeight === "undefined") {
                            var n = [];
                            var svg = [];
                            var g = [];
                            var bars = [];
                            var animeSpeed = [];
                            var interval = [];
                            var animatedRadialChartHeight = [];
                            var radialGradient = [];
                            var animatedRadialChartColor = [];
                            var animatedRadialChartLineSpace = [];
                        }
                        animatedRadialChartColor['<?php esc_attr_e($this->get_id()); ?>'] = {
                            gradient_1: "<?php echo strval($settings['iq_animated-radial_chart_gradient_1']) ?>",
                            gradient_2: "<?php echo strval($settings['iq_animated-radial_chart_gradient_2']) ?>",
                            stroke_color: "<?php echo strval($settings['iq_animated-radial_chart_stroke_color']) ?>"
                        }
                        animatedRadialChartLineSpace['<?php esc_attr_e($this->get_id()); ?>'] = parseFloat('<?php echo $settings['iq_animated-radial_chart_line_space'] ?>');
                        animatedRadialChartHeight['<?php esc_attr_e($this->get_id()); ?>'] = parseFloat('<?php echo $settings['iq_animated-radial_chart_height'] ?>');
                        n['<?php esc_attr_e($this->get_id()); ?>'] = 0;
                        noise.seed(Math.random());
                        animeSpeed['<?php esc_attr_e($this->get_id()); ?>'] = parseFloat('<?php echo $settings['iq_animated-radial_chart_speed'] ?>');

                        if (typeof initAnimatedRadial !== "undefined") {
                            initAnimatedRadial(
                                '<?php esc_attr_e($this->get_id()); ?>',
                                svg,
                                g,
                                bars,
                                radialGradient,
                                animatedRadialChartColor,
                                animatedRadialChartLineSpace,
                                n,
                                interval,
                                animeSpeed,
                                animatedRadialChartHeight
                            );
                        }
                    }
                }).apply(this, [jQuery]);
            </script>

            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register(new \Elementor\Animated_radial());