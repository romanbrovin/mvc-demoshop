<div class="item__content row">
    <div class="col-12">

        <div class="d-inline-block me-2 align-top">
            <div class="font-10 text-gray-500">
                Ост.
            </div>
            <div class="font-14">
                <?=$item['amount']?>
            </div>
        </div>

        <div class="d-inline-block align-top">
            <div class="font-10 text-gray-500">
                Цена
            </div>
            <div class="font-14">
                <?=rank($item['price'])?> ₽
            </div>
        </div>

        <div class="d-inline-block mx-2 align-top">
            <div class="font-10 text-gray-500">
                Адрес склада
            </div>
            <div class="font-14">
                <?php $warehouse = R::load('m_warehouse', $item['warehouse_id']); ?>
                <?php if ($warehouse['name']) : ?>
                    <?=$warehouse['name']?>
                <?php else : ?>
                    <span data-bs-custom-class="tooltip" data-bs-placement="top"
                          data-bs-title="Адрес склада отсутствует" data-bs-toggle="tooltip">
                        <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                    </span>
                <?php endif; ?>

            </div>
        </div>

        <div class="d-inline-block mx-2 align-top">
            <div class="font-10 text-gray-500">
                Стел.
            </div>
            <div class="font-14">
                <?=($item['rack']) ?: '&nbsp;';?>
            </div>
        </div>

        <div class="d-inline-block mx-2 align-top">
            <div class="font-10 text-gray-500">
                Пал.
            </div>
            <div class="font-14">
                <?=($item['pallet']) ?: '&nbsp;';?>
            </div>
        </div>

        <div class="d-inline-block mx-2 align-top">
            <div class="font-10 text-gray-500">
                Кор.
            </div>
            <div class="font-14">
                <?=($item['box']) ?: '&nbsp;';?>
            </div>
        </div>

        <div class="d-inline-block mx-2 align-top">
            <div class="font-10 text-gray-500">
                Поставщик
            </div>
            <div class="font-14">
                <?php $supplier = R::load('m_supplier', $item['supplier_id']); ?>
                <?php if ($supplier['name']) : ?>
                    <?=$supplier['name']?>
                <?php else : ?>
                    <span data-bs-custom-class="tooltip" data-bs-placement="top"
                          data-bs-title="Поставщик отсутствует" data-bs-toggle="tooltip">
                        <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                    </span>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>