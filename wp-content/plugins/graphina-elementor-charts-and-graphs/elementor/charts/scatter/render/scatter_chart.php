<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit;

$settings = $this->get_settings_for_display();
$title = (string)graphina_get_dynamic_tag_data($settings,'iq_scatter_chart_heading');
$description = (string)graphina_get_dynamic_tag_data($settings,'iq_scatter_chart_content');

if(isRestrictedAccess('scatter',$this->get_id(),$settings, true)) {
    if($settings['iq_scatter_restriction_content_type'] ==='password'){
        return true;
    }
    echo html_entity_decode($settings['iq_scatter_restriction_content_template']);
    return true;
}
?>

<div class="<?php echo $settings['iq_scatter_chart_card_show'] === 'yes' ? 'chart-card' : ''; ?>">
    <div class="">
        <?php if ($settings['iq_scatter_is_card_heading_show'] && $settings['iq_scatter_chart_card_show']) { ?>
            <h4 class="heading graphina-chart-heading" style="text-align: <?php echo $settings['iq_scatter_card_title_align'];?>; color: <?php echo strval($settings['iq_scatter_card_title_font_color']);?>;"><?php echo html_entity_decode($title); ?></h4>
        <?php }
        if ($settings['iq_scatter_is_card_desc_show'] && $settings['iq_scatter_chart_card_show']) { ?>
            <p class="sub-heading graphina-chart-sub-heading" style="text-align: <?php echo $settings['iq_scatter_card_subtitle_align'];?>; color: <?php echo strval($settings['iq_scatter_card_subtitle_font_color']);?>;"><?php echo html_entity_decode($description); ?></p>
        <?php } ?>
    </div>
    <?php if (!empty($settings['iq_scatter_dynamic_change_chart_type']) && $settings['iq_scatter_dynamic_change_chart_type'] == 'yes') { ?>
        <div class="graphina_dynamic_change_type">
            <select id="graphina-select-chart-type"
                    onchange="updateChartType('scatter',this,'<?php esc_attr_e($this->get_id()); ?>');">
                <option selected disabled><?php echo esc_html__('Choose Chart Type','graphina-charts-for-elementor')?></option>
                <option value="scatter">Scatter</option>
                <option value="area">Area</option>
                <option value="bar">Column</option>
                <option value="line">Line</option>
            </select>
        </div>
    <?php }
    graphina_filter_common($this,$settings,$this->get_chart_type());
    ?>
    <div class="<?php echo $settings['iq_scatter_chart_border_show'] === 'yes' ? 'chart-box' : ''; ?>">
        <div class="chart-texture scatter-chart-<?php esc_attr_e($this->get_id()); ?>"></div>
        <div style="display: none;height: <?php echo $settings['iq_' . $this->get_chart_type() . '_chart_height'];?>" class="chart-texture scatter-chart-<?php esc_attr_e($this->get_id()); ?>-loader" >
            <img class="graphina-loader" src="<?php echo graphinaGetloader(); ?>">
            <p class="graphina-filter-notext" style="text-align: center;display: none;">
                <?php echo esc_html__('No Data Found' ,'graphina-charts-for-elementor');?>
            </p>
        </div>
    </div>
</div>