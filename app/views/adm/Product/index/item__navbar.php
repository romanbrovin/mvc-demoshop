<div class="item__navbar row">

    <div class="col-xl-4 col-8">

        <a class="me-1 py-0 btn btn-sm btn-outline-primary"
           href="/adm/product/price?id=<?=$item['id']?>">
            Цены
        </a>

        <?php if ($item['amount'] > 0) : ?>
            <a class="me-1 py-0 btn btn-sm btn-outline-primary"
               href="/adm/storage?s_product_id=<?=$item['id']?>">
                Закупки
            </a>
        <?php endif; ?>

        <a class="me-1 py-0 btn btn-sm btn-outline-primary"
           href="/adm/storage/add?product_id=<?=$item['id']?>">
            Добавить закупку
        </a>

    </div>

    <div class="col-xl-8 col-4 overflow-hidden text-end">

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

        <a class="me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
           data-bs-title="Редактировать" data-bs-toggle="tooltip"
           href="/adm/<?=$uri?>/edit?id=<?=$item['id']?>">
            <i class="fa-regular fa-pen-to-square"></i>
        </a>

        <a class="btn__delete text-danger" data-bs-custom-class="tooltip"
           data-bs-placement="top" data-bs-title="Удалить" data-bs-toggle="tooltip" href="#">
            <i class="fa-regular fa-trash-can"></i>
        </a>

    </div>

</div>
