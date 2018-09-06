<?php
defined( 'ABSPATH' ) || exit;

/**
 * Classe principal do plugin
 */
class Lemann_Mustache {
	/**
	 * A instância (única) da classe.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * A instância do Mustache
	 *
	 * @var Mustache_Engine
	 */
	protected $m;

	/**
	 * Construtor da classe. Associa os hooks necessários às suas classes.
	 */
	private function __construct() {
		require_once get_theme_file_path( 'vendor/mustache/mustache/src/Mustache/Autoloader.php' );
		\Mustache_Autoloader::register();

		$this->m = new \Mustache_Engine;
	}

	/**
	 * Faz o parse do mustache.
	 *
	 * @param  string $content Conteúdo puro.
	 * @param  array  $vars    Variáveis a resolver.
	 * @return string          Conteúdo "parseado"
	 */
	public function parse( $content, $vars ) {
		return $this->m->render( $content, $vars );
	}

	/**
	 * SINGLETON. Retorna a instância da classe.
	 *
	 * @return object a instância (única) da classe.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
