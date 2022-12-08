<div class="content_storage d-inline-block mt-1">

    <?php $storageCount = R::count('m_storage', 'product_id = ?', [$item['id']]); ?>
    <?php if ($storageCount > 0) : ?>
        <div class="font-10 text-gray-500">
            <div class="d-inline-block w-45">
                Ост.
            </div>

            <div class="d-inline-block w-65">
                Цена
            </div>

            <div class="d-inline-block">
                Адрес склада / Поставщик
            </div>
        </div>

        <?php $storageList = R::findAll('m_storage', 'product_id = ?', [$item['id']]); ?>
        <?php foreach ($storageList as $storage) : ?>

            <?php $warehouse = R::load('m_warehouse', $storage['warehouse_id']); ?>
            <?php $supplier = R::load('m_supplier', $storage['supplier_id']); ?>

            <div class="font-12">
                <div class="d-inline-block w-45">
                    <?=$storage['amount']?>

                    <?php
                    if ($storage['is_hidden'] == 1) {
                        $class = "bg-danger";
                        $tooltip = "Неактивный товар";
                    } else {
                        $class = "bg-success";
                        $tooltip = "Активный товар";
                    }
                    ?>
                    <span class="point <?=$class?>" data-bs-custom-class="tooltip"
                          data-bs-placement="top" data-bs-title="<?=$tooltip?>"
                          data-bs-toggle="tooltip"></span>
                </div>

                <div class="d-inline-block w-65">
                    <?=rank($storage['price'])?> ₽
                </div>

                <div class="d-inline-block">
                    <?php if ($warehouse['name']) : ?>
                        <?=$warehouse['name']?>
                        <?=($storage['rack']) ? ' &bull; с' . $storage['rack'] : null;?>
                        <?=($storage['pallet']) ? ' &bull; п' . $storage['pallet'] : null;?>
                        <?=($storage['box']) ? ' &bull; к' . $storage['box'] : null;?>
                    <?php else : ?>
                        <span data-bs-custom-class="tooltip" data-bs-placement="top"
                              data-bs-title="Адрес склада отсутствует" data-bs-toggle="tooltip">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </span>
                    <?php endif; ?>
                    /
                    <?php if ($supplier['name']) : ?>
                        <?=$supplier['name']?>
                    <?php else : ?>
                        <span data-bs-custom-class="tooltip" data-bs-placement="top"
                              data-bs-title="Поставщик отсутствует" data-bs-toggle="tooltip">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </span>
                    <?php endif; ?>

                    <?php if ($storage['comment_admin']) : ?>
                        <span class="badge badge-comment">
                            <?=$storage['comment_admin']?>
                        </span>
                    <?php endif; ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    <div class="font-12 mt-2">
        <?php if ($item['amount'] != $item['amount_active']) : ?>
            <?php if ($item['amount'] > 1) : ?>
                <div>
                    Активных товаров: <strong><?=$item['amount_active']?> шт.</strong>
                </div>
            <?php endif; ?>

            <div>
                Всего товаров: <strong><?=$item['amount']?> шт.</strong>
            </div>
        <?php endif; ?>

        <?php if ($item['price_avg'] > 0 && $storageCount > 1) : ?>
            <div>
                <span data-bs-custom-class="tooltip" data-bs-placement="top"
                      data-bs-title="Только для активных товаров" data-bs-toggle="tooltip">
                    Средняя цена закупки:
                </span>
                <?=rank($item['price_avg'])?> ₽
            </div>
        <?php endif; ?>
    </div>

</div>