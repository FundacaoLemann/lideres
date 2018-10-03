<?php



class LVCA_Module_5 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <article
                class="lvca-module-5 <?php echo $module->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $module->post_ID)); ?>">

            <div class="lvca-entry-details">

                <?php echo $module->get_title(); ?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_author(); ?>
                    <?php echo $module->get_date(); ?>
                    <?php echo $module->get_comments(); ?>
                    <?php echo $module->get_taxonomies_info(); ?>
                </div>

                <div class="lvca-excerpt">
                    <?php echo $module->get_excerpt(); ?>
                </div>

                <?php echo $module->get_read_more_link(); ?>

            </div>

        </article>

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_5', $output, $module);
    }
}