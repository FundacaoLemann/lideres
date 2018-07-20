<?php
/**
 * Widget peronalizado para exibir eventos do Events Manager em abas.
 */

class Lemann_Em_Widget extends WP_Widget {
	/**
	 * Construtor da classe.
	 */
	public function __construct() {
		parent::__construct(
			'lemann-event-manager',
			'Lemann Líderes: Eventos',
			array(
				'classname'   => 'widget-lemann-event-manager',
				'description' => 'Eventos do site exibidos em abas',
			)
		);
	}

	/**
	 * Renderiza o widget.
	 *
	 * @param array $args     Argumentos da área de widgets.
	 * @param array $instance Dados da instância do widget.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( $instance['title'] ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		$eventos = $this->get_eventos();
		if ( ! empty( $eventos['abas_nomes'] ) ) {
			?>
			<div class="item-options">
				<?php
				foreach ( $eventos['abas_nomes'] as $i => $aba ) {
					?>
					<a href="#data-<?php echo $aba; ?>">
						<?php
						$time = strtotime( $aba );
						printf(
							'%s<br>%s',
							date_i18n( 'l', $time ),
							date_i18n( 'd/m', $time )
						);
						?>
					</a>
					<?php
					if ( count( $eventos['abas_nomes'] ) != ( $i + 1 ) ) {
						?>
						<span class="bp-separator" role="separator">|</span>
						<?php
					}
				}
				?>
			</div>
			<ul>
				<?php foreach ( $eventos['abas_conteudos'] as $data => $eventos ) { ?>
					<li id="data-<?php echo $data; ?>">
						<ul>
							<?php foreach ( $eventos as $evento ) { ?>
								<li><?php echo $evento->post_title; ?></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
			</ul>
			<?php
		}

		echo $args['after_widget'];
	}

	/**
	 * Formulário exibido no painel de administração de widgets.
	 *
	 * @param array $instance Dados anteriores da instância.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$cat   = isset( $instance['cat'] ) ? absint( $instance['cat'] ) : 0;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Título:</label>
			<input
				type="text"
				class="widefat"
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				value="<?php echo $title; ?>">
		</p>
		<?php
	}

	/**
	 * Atualiza a instância do widget (com os dados informados em `form()`)
	 *
	 * @param array $new_instance Dados informados.
	 * @param array $old_instance Dados guardados anteriormente.
	 * @return array              Dados que devem ser guardados
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

	/**
	 * Pega os eventos no Events Manager para exibir.
	 *
	 * @return array
	 */
	private function get_eventos() {
		$eventos = [
			'abas_nomes'     => [],
			'abas_conteudos' => [],
		];

		/**
		 * Busca os eventos no plugin para exibir no widget.
		 *
		 * @see http://wp-events-plugin.com/documentation/event-search-attributes/
		 */
		$eventos = EM_Events::get( [] );
		$dia     = null;
		foreach ( $eventos as $evento ) {
			if ( $evento->start_date != $dia ) {
				$dia = $evento->start_date;

				$eventos['abas_nomes'][]           = $dia;
				$eventos['abas_conteudos'][ $dia ] = [];
			}

			// Se o dia já tem 4 eventos vamos testar o próximo evento.
			if ( 4 == count( $eventos['abas_conteudos'][ $dia ] ) ) {
				continue;
			}

			$eventos['abas_conteudos'][ $dia ][] = $evento;

			// Se já tem 4 dias pode parar.
			if ( 4 == count( $eventos['abas_nomes'] ) ) {
				break;
			}
		}

		return $eventos;
	}
}

add_action( 'widgets_init', function() {
	return register_widget( 'Lemann_Em_Widget' );
});
