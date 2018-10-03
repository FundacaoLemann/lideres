<?php



class LVCA_Module_8 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <div class="lvca-module-8 lvca-small-thumb <?php echo $module->get_module_classes(); ?>">

            <?php echo $module->get_thumbnail(); ?>

            <div class="lvca-entry-details">

                <?php echo $module->get_title();?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_author();?>
                    <?php echo $module->get_date();?>
                    <?php echo $module->get_comments();?>
                </div>

                <div class="lvca-excerpt">
                    <?php echo $module->get_excerpt();?>
                </div>

                <?php echo $module->get_read_more_button(); ?>

            </div>

        </div>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_8', $output, $module);
    }
}