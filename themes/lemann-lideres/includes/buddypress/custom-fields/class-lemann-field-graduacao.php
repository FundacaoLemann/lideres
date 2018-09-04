<?php
defined( 'ABSPATH' ) || exit;

class Lemann_Field_Graduacao extends BP_XProfile_Field_Type {

	public function __construct() {
		parent::__construct();

		$this->category = _x( 'Lemann', 'xprofile field type category', 'lemann-lideres' );
		$this->name     = _x( 'Graduação', 'xprofile field type', 'lemann-lideres' );

		$this->accepts_null_value = true;
		$this->supports_options   = false;

		add_action( 'xprofile_fields_saved_field', array( $this, 'save_meta' ) );
	}

	public function edit_field_html( array $raw_properties = array() ) {
		global $field;

		$values = bp_get_the_profile_field_edit_value();
		if ( ! empty( $values ) ) {
			$values = self::unserialize( $values );
		} else {
			$values = [
				[
					'curso'        => '',
					'nivel'        => '',
					'nivel_outros' => '',
					'inicio'       => '',
					'fim'          => '',
					'descricao'    => '',
					'area'         => [],
				],
			];
		}

		$field_basename = bp_get_the_profile_field_input_name();

		?>
		<legend id="<?php bp_the_profile_field_input_name(); ?>-1">
			<?php bp_the_profile_field_name(); ?>
		</legend>

		<?php
		// Errors.
		do_action( bp_get_the_profile_field_errors_action() );
		?>

		<div class="lemann-campos-graduacao-wrapper">
			<?php
			foreach ( $values as $key => $value ) {
				$field_name = "{$field_basename}[{$key}]";
				?>
				<div class="lemann-campos-graduacao">
					<div class="lemann-campos-graduacao-campo">
						<label for="<?php echo $field_name . '_curso'; ?>"><?php _e( 'Curso', 'lemann-lideres' ); ?></label>
						<input <?php echo $this->get_edit_field_html_elements( array_merge(
							array(
								'type'  => 'text',
								'name'  => $field_name . '[curso]',
								'id'    => $field_name . '_curso',
								'value' => $value['curso'],
							),
							$raw_properties
						) ); ?> />
					</div>
					<div class="lemann-campos-graduacao-campo">
						<label for="<?php echo $field_name . '_nivel'; ?>"><?php _e( 'Nível', 'lemann-lideres' ); ?></label>
						<select <?php echo $this->get_edit_field_html_elements( array_merge(
							array(
								'name'  => $field_name . '[nivel]',
								'id'    => $field_name . '_nivel',
							),
							$raw_properties
						) ); ?>>
							<option value="">Selecione</option>
							<?php
							$options = [
								'Graduação',
								'Pós-graduação',
								'Mestrado',
								'Doutorado',
								'Pós-Doutorado',
								'Outros',
							];
							foreach ( $options as $option ) {
								?>
								<option
									value="<?php echo esc_attr( $option ); ?>"
									<?php selected( $option, $value['nivel'] ); ?>><?php echo $option; ?></option>
								<?php
							}
							?>
						</select>
						<input <?php echo $this->get_edit_field_html_elements( array_merge(
							array(
								'type'  => 'text',
								'name'  => $field_name . '[nivel_outros]',
								'id'    => $field_name . '_nivel_outros',
								'value' => $value['nivel_outros'],
							),
							$raw_properties
						) ); ?> />
					</div>
					<div class="lemann-campos-graduacao-campo">
						<label for="<?php echo $field_name . '_inicio'; ?>"><?php _e( 'Início', 'lemann-lideres' ); ?></label>
						<input <?php echo $this->get_edit_field_html_elements( array_merge(
							array(
								'type'  => 'text',
								'name'  => $field_name . '[inicio]',
								'id'    => $field_name . '_inicio',
								'value' => $value['inicio'],
							),
							$raw_properties
						) ); ?> />
					</div>
					<div class="lemann-campos-graduacao-campo">
						<label for="<?php echo $field_name . '_fim'; ?>"><?php _e( 'Término', 'lemann-lideres' ); ?></label>
						<input <?php echo $this->get_edit_field_html_elements( array_merge(
							array(
								'type'  => 'text',
								'name'  => $field_name . '[fim]',
								'id'    => $field_name . '_fim',
								'value' => $value['fim'],
							),
							$raw_properties
						) ); ?> />
					</div>
					<div class="lemann-campos-graduacao-campo">
						<label for="<?php echo $field_name . '_descricao'; ?>"><?php _e( 'Descrição', 'lemann-lideres' ); ?></label>
						<textarea <?php echo $this->get_edit_field_html_elements( array_merge(
							array(
								'name'  => $field_name . '[descricao]',
								'id'    => $field_name . '_descricao',
							),
							$raw_properties
						) ); ?>><?php echo esc_textarea( $value['descricao'] ); ?></textarea>
					</div>
					<div class="lemann-campos-graduacao-campo">
						<div class="label"><?php _e( 'Área de formação', 'lemann-lideres' ); ?></div>
						<?php
						$name    = $field_name . '[area][]';
						$options = [
							'Políticas Públicas',
							'Economia',
							'Administração',
							'Engenharia',
							'Educação / Pedagogia / Licenciatura',
							'Direito',
							'Relações Internacionais / Ciências Políticas',
							'Medicina / Saúde',
							'Comunicação / Jornalismo',
							'Arquitetura / Planejamento Urbano',
							'Outros',
						];
						foreach ( $options as $option ) {
							?>
							<label>
								<input
									type="checkbox"
									name="<?php echo $name; ?>"
									<?php checked( in_array( $option, (array) $value['area'] ) ); ?>
									value="<?php echo esc_attr( $option ); ?>">
								<?php echo $option; ?>
							</label>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
			?>
			<input type="button" class="lemann-campos-graduacao-add" value="Adicionar">
		</div>

		<?php
		if ( bp_get_the_profile_field_description() ) {
			?>
			<p class="description" id="<?php bp_the_profile_field_input_name(); ?>-3"><?php bp_the_profile_field_description(); ?></p>
			<?php
		}

		wp_enqueue_script( 'lemann-field-graduacao', get_stylesheet_directory_uri() . '/assets/js/lemann-field-graduacao.js', [ 'jquery' ], null, true );
	}

	public function admin_field_html( array $raw_properties = array() ) {

	}

	public function is_valid( $values ) {
		return true;
	}

	public static function display_filter( $field_value, $field_id = '' ) {
		$values = BP_XProfile_ProfileData::get_value_byid( $field_id, bp_displayed_user_id() );
		$values = self::unserialize( $values );
		foreach ( $values as $graduacao ) {
			$output .=
				'<p>' .
					'<strong>' . $graduacao['curso'] . '</strong> ' .
					$graduacao['nivel'] . ' - ' .
					$graduacao['nivel_outros'] . ' - ' .
					$graduacao['inicio'] . ' - ' .
					$graduacao['fim'] . ' - ' .
					$graduacao['descricao'] . ' - ' .
					implode( ', ', $graduacao['area'] ) .
				'</p>';
		}

		return $output;
	}

	public static function unserialize( $string ) {
		if ( ! empty( $string ) ) {
			$string = html_entity_decode( $string );
			$string = html_entity_decode( $string );
			$string = maybe_unserialize( $string );
		}
		return (array) $string;
	}
}
