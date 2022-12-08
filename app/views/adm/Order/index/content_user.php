<div class="content_user mb-1">

    <?php $user = R::findOne('m_user', "uid = '{$item['uid']}'"); ?>
    <?php if (isset($user) && $user['role'] == 'user') : ?>
        <div class="mb-11">
            <?php if ($user['role'] == 'user'): ?>

                <div>
                    <a href="/adm/user?s_user_id=<?=$user['id']?>">
                        <?=$user['name']?> <?=$user['surname']?>
                    </a>
                </div>

                <div class="small">
                    <?php if ($user['phone']): ?>
                        <div>
                            <a href="tel:+<?=$user['phone']?>">
                                +<?=$user['phone']?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($user['email']): ?>
                        <?php if (strpos($user['email'], '@fake.ru') === false) : ?>
                            <div>
                                <a href="mailto:<?=$user['email']?>">
                                    <?=$user['email']?>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($user['comment_admin']): ?>
                        <div class="text-secondary">
                            <i class="fa-regular fa-comment-dots"></i>
                            <?=$user['comment_admin']?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>
        </div>
    <?php elseif (isset($user) && $user['role'] == 'admin') : ?>
    <?php else : ?>
        <div class="text-secondary">
            Клиент не найден
        </div>
    <?php endif; ?>

</div>
