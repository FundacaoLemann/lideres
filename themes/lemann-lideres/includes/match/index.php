<?php
defined( 'ABSPATH' ) || exit;

/**
 * Índice: ID do campo no WP Job Manager,
 * Valor: ID do campo no BuddyPress.
 */
define( 'LEMANN_VAGAS_DE_PARA', [
	'setor_atuacao'      => 1502,
	'area_atuacao'       => 1513,
	'disponibilidade'    => 1526,
	'graduacao'          => 1497,
	'experiencia'        => 1531,
	'experiencia_gestao' => 1536,
	'faixa_salarial'     => 1542,
	'localizacao_geo'    => 1548,
] );

define( 'LEMANN_MATCHES_META_KEY', 'job_listings_matches' );

/**
 * Define a porcentagem de correspondência entre uma vaga e um usuário.
 *
 * @param int $post_id ID da vaga.
 * @param int $user_id ID do usuário.
 */
function lemann_match( $post_id, $user_id ) {
	$possible_matches = 0;
	$real_matches     = 0;

	foreach ( LEMANN_VAGAS_DE_PARA as $wpjm_id => $bp_id ) {
		$job_listing_data = get_post_meta( $post_id, "_{$wpjm_id}", true );
		if ( 'graduacao' == $wpjm_id ) {
			$user_data = BP_XProfile_ProfileData::get_value_byid( $bp_id, $user_id );
			$user_data = Lemann_Field_Graduacao::unserialize( $user_data );
		} else {
			$user_data = xprofile_get_field_data( $bp_id, $user_id );
		}

		switch ( $wpjm_id ) {
			// Campos de vaga multivalorados.
			case 'setor_atuacao':
			case 'area_atuacao':
			case 'localizacao_geo':
				foreach ( (array) $job_listing_data as $possible_value ) {
					$possible_matches++;
					if ( in_array( $possible_value, (array) $user_data ) ) {
						$real_matches++;
					}
				}
				break;

			case 'graduacao':
				$possible_matches++;
				if ( is_array( $user_data ) ) {
					foreach ( $user_data as $graduacao ) {
						if ( $graduacao['nivel'] == $job_listing_data ) {
							$real_matches++;
							break;
						}
					}
				}
				break;

			default:
				$possible_matches++;
				if ( $job_listing_data == $user_data ) {
					$real_matches++;
				}
				break;
		}
	}

	$match = ( $real_matches / $possible_matches ) * 100;

	$matches = (array) get_user_meta( $user_id, LEMANN_MATCHES_META_KEY, true );
	$matches[ $post_id ] = [
		'match' => $match,
		'date'  => date_i18n( 'c' ),
	];
	update_user_meta( $user_id, LEMANN_MATCHES_META_KEY, $matches );
}

/**
 * Ao salvar uma vaga, se ela estiver publicada
 * faz a correspondência com todos os usuários líderes.
 */
add_action( 'save_post_job_listing', function( $post_id ) {
	if ( 'publish' == get_post_status( $post_id ) ) {
		$users = get_users( [
			'role'   => 'lider',
			'fields' => 'ID',
		] );
		foreach ( $users as $user_id ) {
			lemann_match( $post_id, $user_id );
		}
	}
} );

/**
 * Ao atualizar o perfil, faz a correspondência com todas as vagas.
 */
add_action( 'xprofile_updated_profile', function( $user_id ) {
	$job_listings = get_posts( [
		'post_type'   => 'job_listing',
		'numberposts' => -1,
	] );
	foreach ( $job_listings as $job_listing ) {
		lemann_match( $job_listing->ID, $user_id );
	}
} );
