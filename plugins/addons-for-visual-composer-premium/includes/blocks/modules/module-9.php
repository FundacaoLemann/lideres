<?php



class LVCA_Module_9 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <article
                class="lvca-module-9 lvca-module-trans1 <?php echo $module->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $module->post_ID)); ?>">

            <?php echo $module->get_thumbnail(); ?>

            <div class="lvca-entry-details">

                <?php echo $module->get_title();?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_author(); ?>
                    <?php echo $module->get_date(); ?>
                    <?php echo $module->get_comments(); ?>
                    <?php echo $module->get_taxonomies_info(); ?>
                </div>

            </div>

        </article>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_9', $output, $module);
    }
}