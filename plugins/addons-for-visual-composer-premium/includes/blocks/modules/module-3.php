<?php



class LVCA_Module_3 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <div class="lvca-module-3 lvca-small-thumb <?php echo $module->get_module_classes(); ?>">

            <?php echo $module->get_thumbnail('medium'); ?>

            <div class="lvca-entry-details">

                <?php echo $module->get_title(); ?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_date(); ?>
                </div>

            </div>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_3', $output, $module);
    }
}