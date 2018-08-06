<?php if($posts): ?>
<div>
    <ul>
        <?php foreach($posts as $post): ?>
        <li>
            <a href="<?= get_permalink($post->ID)?>">
            <strong><?= $post->post_title ?></strong>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endif; ?>
