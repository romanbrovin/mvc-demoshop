<div class="item__content row">

    <div class="col-2">
        <?php $pathToAvatar = "/uploads/goods/{$item['url']}/thumb-{$item['photo']}"; ?>
        <?php $item['avatar'] = isImageExist($pathToAvatar); ?>

        <?php if ($item['photo']) : ?>
            <div class="d-flex justify-content-end">
                <div class="btn-round btn-round_small btn-round_delete btn-delete btn__delete-photo"
                     data-bs-custom-class="tooltip" data-bs-placement="top" data-bs-title="Удалить фотографию"
                     data-bs-toggle="tooltip"></div>
            </div>
        <?php endif; ?>

        <label class="btn-photo" data-bs-custom-class="tooltip" data-bs-placement="top"
               data-bs-title="Загрузить фотографию" data-bs-toggle="tooltip">
            <input accept="image/jpeg,image/png" class="btn__upload-photo" id="files_<?=$item['id']?>" type="file">
            <img alt="" class="img-fluid" loading="lazy" src="<?=$item['avatar']?>">
        </label>

    </div>

    <div class="col-10">
        <div>
            Себестоимость:
            <?php if ($item['cost_all'] == 0) : ?>
                0 ₽
            <?php elseif ($item['cost_active'] == $item['cost_all']) : ?>
                <span class="dotted fw-bold" data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Всех товаров" data-bs-toggle="tooltip">
                    <?=rank($item['cost_all'])?> ₽
                </span>
            <?php else : ?>
                <span class="fw-bold dotted" data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Активных товаров" data-bs-toggle="tooltip">
                    <?=rank($item['cost_active'])?> ₽
                </span> /
                <span class="dotted text-secondary" data-bs-custom-class="tooltip"
                      data-bs-placement="top" data-bs-title="Всех товаров" data-bs-toggle="tooltip">
                    <?=rank($item['cost_all'])?> ₽
                </span>
            <?php endif; ?>
        </div>

        <div>
            В продаже на:
            <?php if ($item['amount_all'] == 0) : ?>
                0 ₽
            <?php else : ?>
                <span class="fw-bold dotted" data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Суммарная стоимость реализации всех активных товаров"
                      data-bs-toggle="tooltip">
                    <?=rank($item['selling_active'])?> ₽
                </span>
            <?php endif; ?>
        </div>

        <div>
            Кол-во:
            <?php if ($item['amount_all'] == 0) : ?>
                0 шт.
            <?php elseif ($item['amount_active'] == $item['amount_all']) : ?>
                <span class="dotted fw-bold" data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Всех товаров" data-bs-toggle="tooltip">
                    <?=rank($item['amount_all'])?> шт.
                </span>
            <?php else : ?>
                <span class="fw-bold dotted" data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Активных товаров" data-bs-toggle="tooltip">
                    <?=rank($item['amount_active'])?> шт.
                </span> /
                <span class="dotted text-secondary" data-bs-custom-class="tooltip"
                      data-bs-placement="top" data-bs-title="Всех товаров" data-bs-toggle="tooltip">
                    <?=rank($item['amount_all'])?> шт.
                </span>
            <?php endif; ?>
        </div>

        <div class="small mt-2">
            <a href="/adm/product/add?category_id=<?=$item['id']?>">
                <i class="fa-regular fa-square-plus"></i>
                Новый товар
            </a>

        </div>

    </div>

</div>