<?php

/*
* BP Profile Search - form template 'bps-form-sample-2'
*
* See http://dontdream.it/bps/form-templates/ if you wish to modify this template or develop a new one.
*
*/

$F = bps_escaped_form_data ();

$toggle_id = 'bps_toggle' . $F->id;
$form_id = 'bps_' . $F->location . $F->id;

?>

<?php if ( $F->location == 'directory' ) { ?><div class="gp-bps-wrapper"><?php } ?>

	<?php if ( $F->location == 'directory' ) { ?>

		<?php if ( $F->header OR $F->toggle ) { ?>
	
			<div class="gp-bps-header">
		
				<div class="gp-bps-title"><?php echo wp_kses_post( $F->header ); ?></div>

				<?php if ( $F->toggle ) { ?>
			
					<input class="gp-bps-toggle-button" id="<?php echo esc_attr( $toggle_id ); ?>" type="submit" value="<?php echo wp_kses_post( $F->toggle_text ); ?>">
			
					<script>
						jQuery( document ).ready( function( $ ) {
							$( '#<?php echo esc_attr( $form_id ); ?>' ).hide();
							$(' #<?php echo esc_attr( $toggle_id ); ?>' ).click( function() {
								$( '#<?php echo esc_attr( $form_id ); ?>' ).toggle();
							});
						});
					</script>
			
				<?php } ?>
	
			</div>
			
			<div class="gp-clear"></div>
		
		<?php } ?>
		
	<?php } ?>

	<form action="<?php echo esc_attr( $F->action ); ?>" method="<?php echo esc_attr( $F->method ); ?>" id="<?php echo esc_attr( $form_id ); ?>" class="gp-bps-form<?php if ( $F->toggle ) { ?> bps-toggle-form<?php } ?>">

		<?php foreach ( $F->fields as $f ) {
	
			if ( $f->display == 'hidden' ) {
				echo "<input type='hidden' name='$f->code' value='$f->value'>\n";
				continue;
			}

			echo "<div class='gp-bps-field'>\n";

			switch ( $f->display ) {

				case 'range':
					echo "<label for='$f->code'>$f->label</label>\n";
					echo "<input style='width: 15%; display: inline;' type='text' name='{$f->code}_min' id='$f->code' value='$f->min'>";
					echo '&nbsp;-&nbsp;';
					echo "<input style='width: 15%; display: inline;' type='text' name='{$f->code}_max' value='$f->max'>\n";
					break;

				case 'textbox':
				case 'textarea':
					echo "<label for='$f->code'>$f->label</label>\n";
					echo "<input type='text' name='$f->code' id='$f->code' value='$f->value'>\n";
					break;

				case 'number':
					echo "<label for='$f->code'>$f->label</label>\n";
					echo "<input type='number' name='$f->code' id='$f->code' value='$f->value'>\n";
					break;

				case 'url':
					echo "<label for='$f->code'>$f->label</label>\n";
					echo "<input type='text' inputmode='url' name='$f->code' id='$f->code' value='$f->value'>\n";
					break;

				case 'selectbox':
				case 'multiselectbox':
				case 'radio':
				case 'checkbox':
					echo "<label for='$f->code'>$f->label</label>\n";
					echo "<select name='$f->code' id='$f->code'>\n";

					$no_selection = apply_filters( 'bps_field_selectbox_no_selection', esc_html__( 'Select', 'aardvark' ), $f );
					if (is_string ($no_selection))
						echo "<option value=''>$no_selection</option>\n";


					foreach ($f->options as $key => $label)
					{
						$selected = in_array ($key, $f->values)? "selected='selected'": "";
						echo "<option $selected value='$key'>$label</option>\n";
					}
					echo "</select>\n";
					break;

				default:
					echo "<p>BP Profile Search: don't know how to display the <div class='gp-bps-desc'>$f->display</div> field type.</p>\n";
					break;
				
			}

				if ($f->description != '' && $f->description != '-')
					echo "<div class='gp-bps-desc'>$f->description</div>\n";

				echo "</div>\n";

		}

		echo "<input class='button gp-bps-button' type='submit' value='". esc_html__( 'Search', 'aardvark' ). "'>\n"; ?>

	</form>
	
<?php if ( $F->location == 'directory' ) { ?></div><?php } ?>