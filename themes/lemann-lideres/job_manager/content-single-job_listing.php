<?php
/**
 * Single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.28.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
?>
<div class="single_job_listing">
	<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
		<div class="job-manager-info"><?php _e( 'This listing has expired.', 'wp-job-manager' ); ?></div>
	<?php else : ?>
		<?php
			/**
			 * single_job_listing_start hook
			 *
			 * @hooked job_listing_meta_display - 20
			 * @hooked job_listing_company_display - 30
			 */
			do_action( 'single_job_listing_start' );
		?>

		<div class="job_info">
            <style>
                .match-list li { margin-left:50px; line-height: 2em; padding:10px; }
                .match-list li img { position:absolute; margin-left:-40px;}
                .match-list--percent { color:red; font-weight: bold; }

                .match-list .match-list--empty { padding:25px 50px; font-size: 1.5em; }
            </style>
            <?php if(current_user_can('administrator')): ?>
                <div class="job_info_box match-list" id="matches-vaga">
                    <h3 class="job_info_box--title" style="background-color:burlywood">
                        Matches da Vaga
                    </h3>
                    <div class="job_info_box--content">
                        <?php 
                        $matches = get_matches_users(get_the_ID());
                        if($matches):
                        ?>
                        <ul>
                            <?php foreach($matches as $match): $u = $match['user']; ?>
                                <li > 
                                    <a href="/conheca-a-rede/<?php echo $u->user_nicename ?>">
                                        <?php echo get_avatar($u->ID, 32) ?>
                                        <?php echo $u->display_name ?> <span class="match-list--percent"><?php echo number_format($match['match'],1) ?>%</span> 
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                        <div class="match-list--empty">Não há matches para esta vaga</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
		<?php $fields = lemann_wjm_custom_fields(); ?>

			<div class="job_info_box" id="informacoes-basicas">
				<h3 class="job_info_box--title">
					Informações básicas
				</h3>
				<div class="job_info_box--content">
					<ul>
					<?php $basic_fields_1 = ['setor_atuacao', 'area_atuacao'];
					foreach ($basic_fields_1 as $key):
						$meta_value = get_post_meta( get_the_ID(), "_{$key}", true);
						$outros = get_post_meta( get_the_ID(), "_{$key}_outros", true);
						if ( ! empty( $meta_value ) ):
							if (! empty ($outros)):
								$meta_value = str_replace('Outros', $outros, $meta_value);
							endif; ?>
							<li>
								<strong><?php echo $fields[$key]['label']; ?></strong>
								<span><?php echo implode( ', ', $meta_value ); ?></span>
							</li>
						<?php endif;
					endforeach;

					$basic_fields_2 = ['localizacao_geo', 'localizacao_pais', 'localizacao_estado', 'localizacao_cidade'];
					foreach ($basic_fields_2 as $key):
						$meta_value = get_post_meta( get_the_ID(), "_{$key}", true);
						if (! empty( $meta_value ) ): ?>
							<li>
								<strong><?php echo $fields[$key]['label']; ?></strong>
								<span><?php echo is_array( $meta_value) ? implode( ', ', $meta_value ) : $meta_value; ?></span>
							</li>
						<?php endif;
					endforeach;

					$link_anexo = get_post_meta( get_the_ID(), "_anexo", true);
					if (! empty ( $link_anexo ) ): ?>
						<li>
							<strong>Anexo</strong>
							<span><a href="<?php echo $link_anexo; ?>">Link pro anexo</a></span>
						</li>
					<?php endif; ?>
					</ul>
				</div>
			</div>

			<div class="job_info_box" id="pre-requisitos">
				<h3 class="job_info_box--title">
					Pré-requisitos para a vaga
				</h3>
				<div class="job_info_box--content">
					<ul>
					<?php $graduacao = get_post_meta( get_the_ID(), "_graduacao", true);
					$graduacao_outros = get_post_meta( get_the_ID(), "_graduacao_outros", true);
					if (! empty ($graduacao) ): ?>
						<li>
							<strong>Nível de graduação</strong>
							<span><?php echo (! empty ($graduacao_outros) ) ? $graduacao_outros : $graduacao; ?></span>
						</li>
					<?php endif; ?>

					<?php $requisites_fields = ['experiencia', 'experiencia_gestao', 'faixa_salarial', 'disponibilidade', 'prazo_inscricao'];
					foreach ($requisites_fields as $key):
						$meta_value = get_post_meta( get_the_ID(), "_{$key}", true);
						if (! empty( $meta_value ) ): ?>
							<li>
								<strong><?php echo $fields[$key]['label']; ?></strong>
								<span><?php echo is_array( $meta_value) ? implode( ', ', $meta_value ) : $meta_value; ?></span>
							</li>
						<?php endif;
					endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="job_info_box" id="sobre-a-vaga">
				<h3 class="job_info_box--title">
					Sobre a vaga
				</h3>
				<div class="job_info_box--content">
					<ul>
						<?php $job_description = wpjm_get_the_job_description(); ?>
						<?php if (! empty ($job_description) ): ?>
							<li>
								<strong>Descrição</strong>
								<span><?php echo $job_description; ?></span>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

			<?php if ( candidates_can_apply() ) : ?>
				<?php get_job_manager_template( 'job-application.php' ); ?>
			<?php endif; ?>
		</div>

		<?php
			/**
			 * single_job_listing_end hook
			 */
			do_action( 'single_job_listing_end' );
		?>
	<?php endif; ?>
</div>
