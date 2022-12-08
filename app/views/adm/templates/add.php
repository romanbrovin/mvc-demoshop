<div class="d-flex">
    <h2 class="marker">
        <span class="marker_h2"><?=$meta['h2']?></span>
    </h2>
</div>

<div class="row mt-4">
    <div class="col-xl-8 col-lg-12">

        <form class="row" id="form">
            <?php
            if (isset($meta['block'])) {
                require_once APP . "/views/adm/templates/default/add/{$meta['block']}.php";
            } else {
                require_once APP . "/views/adm/{$meta['route']['controller']}/add.php";
            }
            ?>
        </form>

        <div class="row mt-5 mb-3">
            <div class="col-6">
                <a class="btn btn-secondary btn__back" href="#">Назад</a>
            </div>
            <div class="col-6 text-end">
                <button class="btn btn-success btn__create" type="button">Добавить</button>
            </div>
        </div>

    </div>
</div>
