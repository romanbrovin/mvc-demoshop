<div class="item__footer row">

    <div class="col-md-6 col-12">
        <?php \app\models\App::renderBlock('adm/info', ['position' => 'horizontal', 'var' => $item]); ?>
        <span class="me-1" data-bs-custom-class="tooltip" data-bs-placement="top"
              data-bs-title="Счетчик просмотров" data-bs-toggle="tooltip">
            <i class="far fa-eye"></i>
            <?=$item['counter']?>
        </span>
    </div>
    <div class="col-md-6 col-12 text-end">
        <?php if ($item['amount'] == 0) : ?>
            <a class="btn__soon me-1" href="#">
                <?php if ($item['is_soon'] == 1) : ?>
                    <i class="fa-regular fa-square-check"></i>
                <?php else : ?>
                    <i class="fa-regular fa-square"></i>
                <?php endif; ?>
                Скоро в продаже
            </a>
        <?php endif; ?>
    </div>

</div>
