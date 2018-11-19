<section class="dawn_charts">
    <canvas class="dawn_final_result_doughnut_chart"></canvas>
    <canvas class="dawn_final_result_polar_area_chart"></canvas>
    <canvas class="dawn_final_result_radar_chart"></canvas>
    <canvas class="dawn_final_result_bar_chart"></canvas>
    <div class="dawn_charts_all_principles_averages">
    <?php 
        foreach ( $analysis['principles'] as $key => $principle ) : ?>
        <div class="dawn_charts_all_principles_averages__single_principle">
            <h3 class="dawn_charts_all_principles_averages_single_principle__title"><?php echo $principle['principle']; ?></h3>
            <canvas class="<?php echo ('dawn_principle' . $key . '_doughnut_chart');?>"></canvas>
        </div> <?php
        endforeach;
    ?>
    </div>
</section>