<?php



class LVCA_Module_11 extends LVCA_Module {

    function render() {

        $module = $this;

        ob_start();
        ?>

        <article
                class="lvca-module-11 <?php echo $module->get_module_classes(); ?> <?php echo join(' ', get_post_class('', $module->post_ID)); ?>">

            <?php if ($thumbnail_exists = has_post_thumbnail($module->post_ID)): ?>

                <div class="lvca-module-image">

                    <div class="lvca-module-thumb">

                        <?php echo $module->get_media(); ?>

                        <?php echo $module->get_lightbox(); ?>

                    </div>

                    <div class="lvca-module-image-info">

                        <div class="lvca-module-entry-info">

                            <?php echo $module->get_media_title(); ?>

                            <?php echo $module->get_media_taxonomy(); ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

            <div class="lvca-module-entry-text">

                <?php echo $module->get_title(); ?>

                <div class="lvca-module-meta">
                    <?php echo $module->get_author(); ?>
                    <?php echo $module->get_date(); ?>
                    <?php echo $module->get_taxonomies_info(); ?>
                </div>

                <div class="lvca-excerpt">
                    <?php echo $module->get_excerpt(); ?>
                </div>

                <?php echo $module->get_read_more_link(); ?>

            </div>

        </article><!-- .hentry -->

        <?php $output = ob_get_clean();

        return apply_filters('lvca_block_module_11', $output, $module);
    }
}