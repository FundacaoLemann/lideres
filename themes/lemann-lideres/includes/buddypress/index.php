<?php
defined( 'ABSPATH' ) || exit;

// Verifica se o usuário preencheu os campos obrigatórios e exibe msg.
require 'required-fields.php';

// Grupo Timeline.
require 'timeline-group.php';

// Tipos de campo personalizados do BuddyPress.
require 'custom-fields/index.php';
