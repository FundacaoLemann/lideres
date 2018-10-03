<?php



class LVCA_Module_10 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <div class="lvca-module-10 lvca-small-thumb <?php echo $module->get_module_classes(); ?>">

            <div class="lvca-entry-details">

                <?php echo $module->get_taxonomies_info(); ?>

                <?php echo $module->get_title(); ?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_author(); ?>
                    <?php echo $module->get_date(); ?>
                    <?php echo $module->get_comments(); ?>
                    <?php echo $module->get_taxonomies_info(); ?>
                </div>

            </div>

            <?php echo $module->get_thumbnail(); ?>

            <div class="lvca-excerpt">
                <?php echo $module->get_excerpt(); ?>
            </div>

            <?php echo $module->get_read_more_link(); ?>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_10', $output, $module);
    }
}