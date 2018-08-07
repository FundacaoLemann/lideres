<?php if($members): ?>
<div>
    <ul>
        <?php foreach($members as $user): ?>
        <li>
            <a href="<?= $member->permalink ?>">
            <?= get_avatar($user->ID, 35) ?>
            <strong><?= $user->display_name ?></strong>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php else: ?>
<div> nenhum usuário encontrado </div>
<?php endif; ?>
