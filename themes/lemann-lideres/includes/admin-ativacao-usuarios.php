<h1>Ativação de usuários inativos</h1>

<h3><?php echo count($users) ?> usuários inativos</h3>
<form method="POST">
    <p><em>Selecione os usuários para os quais você deseja enviar os e-mails de ativação e clique no botão <strong> enviar e-mail de ativação</strong>. Esta operação pode demorar alguns minutos.</em></p>
    <p><input type="submit" value="enviar e-mail de ativação" class="button-primary" /></p>
    <input type="hidden" name='action' value = 'send-activation-email' />
<table class="wp-list-table widefat fixed striped users">
	<thead>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <th scope="col" id="username" class="manage-column column-username column-primary">Nome de usuário</th>
            <th scope="col" id="name" class="manage-column column-name">Nome</th>
            <th scope="col" id="email" class="manage-column column-email">E-mail</th>
            <th scope="col" id="md_multiple_roles_column" class="manage-column column-md_multiple_roles_column">Roles</th>
            <th scope="col" class="manage-column">Última ativação</th>
        </tr>
	</thead>

	<tbody id="the-list" data-wp-lists="list:user">
		<?php foreach($users as $user): if(false) $user = new WP_User; ?>
            <tr id="user-<?php echo  $user->ID ?>">
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="user_<?php echo  $user->ID ?>">Selecionar <?php echo  $user->user_login ?></label>
                    <input type="checkbox" name="users[]" id="user_<?php echo  $user->ID ?>" value="<?php echo  $user->ID ?>">
                </th>
                <td class="username column-username has-row-actions column-primary" data-colname="Nome de usuário">
                    <label for="user_<?php echo  $user->ID ?>"><strong><?php echo  $user->user_login ?></strong></label>
                </td>
                <td class="name column-name" data-colname="Nome">
                    <label for="user_<?php echo  $user->ID ?>"><?php echo $user->display_name ?></label>
                </td>
                <td class="email column-email" data-colname="E-mail">
                    <a href="mailto:<?php echo $user->user_email ?>"><?php echo $user->user_email ?></a>
                </td>
                <td class="md_multiple_roles_column column-md_multiple_roles_column" data-colname="Roles">
                    <div class="md-multiple-roles">
                        <?php echo implode(', ', $user->roles) ?>
                    </div><!-- .md-multiple-roles -->
                </td>
                <td><?php echo $user->_activation_email_datetime ?: 'nunca'; ?>
            </tr>
        <?php endforeach; ?>
	</tbody>

</table>

<hr>

<h2>log de envio de emails</h2> 
<?php $logs = get_option('_activation_email_logs', []); ?>
<?php 
foreach($logs as $log): 
    $_users = array_map(function($u){
        return "<a title='$u->email ($u->datetime)'>$u->name</a>";
    }, $log->users);
?>
    <div>
        <p><strong><?php echo $log->datetime ?></strong>: <?php echo implode(', ', $_users); ?></p>
    </div>
<?php endforeach ?>
</form>