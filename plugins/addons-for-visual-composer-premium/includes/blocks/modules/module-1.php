<?php



class LVCA_Module_1 extends LVCA_Module {

    function render() {
        
        $module = $this;
        
        ob_start();
        ?>

        <article
                class="lvca-module-1 <?php echo $module->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $module->post_ID)); ?>">

            <div class="lvca-module-image">
                <?php echo $module->get_thumbnail();?>
                <?php echo $module->get_taxonomies_info(); ?>
            </div>

            <?php echo $module->get_title();?>

            <div class="lvca-module-meta">
                <?php echo $module->get_author();?>
                <?php echo $module->get_date();?>
                <?php echo $module->get_comments();?>
            </div>

            <div class="lvca-excerpt">
                <?php echo $module->get_excerpt();?>
            </div>

            <?php echo $module->get_read_more_link(); ?>

        </article>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_1', $output, $module);
    }
}