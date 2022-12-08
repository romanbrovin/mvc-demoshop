<?php if (in_array('navbar', $meta['item']['blocks'])) : ?>

    <div class="item__navbar row">
        <div class="col-3">

            <?php if (in_array('hidden', $meta['item']['btn'])) : ?>
                <a class="btn__hidden me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                   data-bs-title="<?=($item['is_hidden'] == 1) ? 'Вкл.' : 'Выкл.';?>"
                   data-bs-toggle="tooltip" href="#">
                    <?php if ($item['is_hidden'] == 1) : ?>
                        <i class="fa-solid fa-toggle-off text-danger"></i>
                    <?php else : ?>
                        <i class="fa-solid fa-toggle-on"></i>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <?php if (in_array('split', $meta['item']['btn'])) : ?>
                <?php if ($item['amount'] > 1) : ?>
                    <a class="btn__split me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                       data-bs-title="Разделить" data-bs-toggle="tooltip" href="#">
                        <i class="fa-regular fa-copy"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (in_array('sort', $meta['item']['btn'])) : ?>
                <a class="btn__sort me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                   data-bs-title="Порядок сортировки" data-bs-toggle="tooltip" href="#">
                    <i class="fa-solid fa-sort"></i>
                    <?=$item['sort_order']?>
                </a>
            <?php endif; ?>

        </div>

        <div class="col-9 overflow-hidden text-end">

            <?php if (in_array('comment', $meta['item']['btn'])) : ?>
                <?php if ($item['comment_admin']) : ?>
                    <a class="btn__comment me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                       data-bs-title="Изменить заметку" data-bs-toggle="tooltip" href="#">
                        <span class="badge badge-comment">
                            <?=$item['comment_admin']?>
                        </span>
                    </a>
                <?php else : ?>
                    <a class="btn__comment me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
                       data-bs-title="Добавить заметку" data-bs-toggle="tooltip" href="#">
                        <i class="fa-regular fa-comment-dots"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (in_array('edit', $meta['item']['btn'])) : ?>
                <a class="me-2" data-bs-custom-class="tooltip" data-bs-placement="top"
                   data-bs-title="Редактировать" data-bs-toggle="tooltip"
                   href="/adm/<?=$uri?>/edit?id=<?=$item['id']?>">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            <?php endif; ?>

            <?php if (in_array('delete', $meta['item']['btn'])) : ?>
                <a class="btn__delete text-danger" data-bs-custom-class="tooltip"
                   data-bs-placement="top" data-bs-title="Удалить" data-bs-toggle="tooltip" href="#">
                    <i class="fa-regular fa-trash-can"></i>
                </a>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>