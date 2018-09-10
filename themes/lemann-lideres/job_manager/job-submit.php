<?php
/**
 * Content for job submission (`[submit_job_form]`) shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-submit.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $job_manager;
?>

<p>As informações compartilhadas nesse formulário estarão disponíveis para nossa rede de líderes. Caso a vaga que você deseja divulgar seja sigilosa favor não incluir informações sensíveis.</p>

<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-job-form" class="job-manager-form" enctype="multipart/form-data">

<?php
if ( isset( $resume_edit ) && $resume_edit ) {
    printf( '<p><strong>' . esc_html__( "You are editing an existing job. %s", 'wp-job-manager' ) . '</strong></p>', '<a href="?new=1&key=' . esc_attr( $resume_edit ) . '">' . esc_html__( 'Create A New Job', 'wp-job-manager' ) . '</a>' );
}
?>

<?php do_action( 'submit_job_form_start' ); ?>

<?php if ( apply_filters( 'submit_job_form_show_signin', true ) ) : ?>

    <?php get_job_manager_template( 'account-signin.php' ); ?>

<?php endif; ?>

<?php if ( job_manager_user_can_post_job() || job_manager_user_can_edit_job( $job_id ) ) : ?>

    <!-- Job Information Fields -->
    <?php do_action( 'submit_job_form_job_fields_start' ); ?>

    <?php $job_fields = array_merge($job_fields, $company_fields); ?>

    <h2>Detalhes da instituição</h2>
    <?php $job_fields_institution = [
        'job_title',
        'company_name',
        'company_website',
        'company_logo',
    ];
    foreach ( $job_fields_institution as $key ) : ?>
        <?php $field = $job_fields[$key]; ?>
        <fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
            <label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(opcional)', 'wp-job-manager' ) . '</small>', $field ) ); ?></label>
            <div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
                <?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <h2>Identificação</h2>
    <p>As informações de identificação do responsável pela vaga são confidenciais e disponíveis apenas para a Fundação Lemann.</p>
    <?php $job_fields_identification = [
        'responsavel_nome',
        'responsavel_email',
    ];
    foreach ( $job_fields_identification as $key ) : ?>
        <?php $field = $job_fields[$key]; ?>
        <fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
            <label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager' ) . '</small>', $field ) ); ?></label>
            <div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
                <?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <h2>Vaga</h2>
    <?php $job_fields_opportunity = [
        'setor_atuacao',
        'setor_atuacao_outros',
        'area_atuacao',
        'area_atuacao_outros',
        'graduacao',
        'graduacao_outros',
        'experiencia',
        'experiencia_gestao',
        'faixa_salarial',
        'disponibilidade',
        'job_description',
        'anexo',
        'prazo_inscricao',
        'application',
    ];
    foreach ( $job_fields_opportunity as $key ) : ?>
        <?php $field = $job_fields[$key]; ?>
        <fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
            <label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager' ) . '</small>', $field ) ); ?></label>
            <div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
                <?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <h2>Localização da vaga</h2>
    <?php $job_fields_locality = [
        'job_location',
        'localizacao_geo',
    ];
    foreach ( $job_fields_locality as $key ) : ?>
        <?php $field = $job_fields[$key]; ?>
        <fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
            <label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . wp_kses_post( apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager' ) . '</small>', $field ) ); ?></label>
            <div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
                <?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
            </div>
        </fieldset>
    <?php endforeach; ?>

    <?php do_action( 'submit_job_form_job_fields_end' ); ?>
    <?php do_action( 'submit_job_form_company_fields_end' ); ?>
    <?php do_action( 'submit_job_form_end' ); ?>

    <p>
        <input type="hidden" name="job_manager_form" value="<?php echo esc_attr( $form ); ?>" />
        <input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
        <input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
        <input type="submit" name="submit_job" class="button" value="<?php echo esc_attr( $submit_button_text ); ?>" />
        <span class="spinner" style="background-image: url(<?php echo esc_url( includes_url( 'images/spinner.gif' ) ); ?>);"></span>
    </p>

<?php else : ?>

    <?php do_action( 'submit_job_form_disabled' ); ?>

<?php endif; ?>
</form>
<script>
    ['setor_atuacao', 'area_atuacao', 'graduacao'].map(function(seletor) {
        $('.fieldset-' + seletor + '_outros').hide();
        $('#' + seletor).change(function() {
            if ($('#' + seletor + ' option[value="Outros"]')[0].selected === true) {
                $('.fieldset-' + seletor + '_outros').show();
            }
            else {
                $('.fieldset-' + seletor + '_outros').hide();
            }
        });
    });
</script>