<?php if($result): ?>
<div>
    <h4>Usuários contrados: </h4>
    <ul>
        <?php foreach($result as $user): ?>
        <li>
            <a href="<?= get_bloginfo('url') ?>/conheca-a-rede/<?= $user->user_nicename ?>">
            <?= get_avatar($user->ID) ?>
            <strong><?= $user->display_name ?></strong>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php else: ?>
<div> nenhum usuário encontrado </div>
<?php endif; ?>
