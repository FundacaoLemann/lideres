<?php



class LVCA_Module_2 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <div class="lvca-module-2 lvca-small-thumb <?php echo $module->get_module_classes(); ?>">

            <div class="lvca-entry-details">

                <?php echo $module->get_title(); ?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_author();?>
                    <?php echo $module->get_date();?>
                    <?php echo $module->get_comments();?>
                </div>

            </div>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_2', $output, $module);
    }
}