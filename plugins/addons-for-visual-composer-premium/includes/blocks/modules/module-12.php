<?php



class LVCA_Module_12 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <article
                class="lvca-module-12 <?php echo $module->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $module->post_ID)); ?>">

            <?php if ($thumbnail_exists = has_post_thumbnail($module->post_ID)): ?>

                <div class="lvca-module-image">

                    <div class="lvca-module-thumb">

                        <?php echo $module->get_media(); ?>

                        <?php echo $module->get_lightbox(); ?>

                    </div>

                    <div class="lvca-module-image-info">

                        <div class="lvca-module-entry-info">

                            <?php echo $module->get_title(); ?>

                            <?php echo $module->get_taxonomies_info(); ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </article><!-- .hentry -->

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_12', $output, $module);
    }
}