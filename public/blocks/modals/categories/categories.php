<?php use app\models\App; ?>
<?php $categories = App::getCategories(); ?>

<div class="modal fade categories" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title h5">Серии товаров</div>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <?php foreach ($categories as $category): ?>
                        <div class="mb-3 col-3 col-md-2" data-bs-custom-class="tooltip" data-bs-placement="top"
                             data-bs-title="<?=$category['name']?>" data-bs-toggle="tooltip">
                            <a href="/catalog/<?=$category['url']?>">
                                <img alt="<?=$category['name']?>" class="img-fluid" loading="lazy"
                                     src="<?=isImageExist("/uploads/goods/$category[url]/thumb-$category[photo]")?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
            </div>

        </div>
    </div>
</div>
