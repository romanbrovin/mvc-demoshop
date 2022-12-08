<?php
$fact = R::findOne('m_facts', "ORDER BY RAND()");

if (isset($fact['name'])) :?>

    <div class="facts row justify-content-center">
        <div class="d-flex justify-content-center mb-3">
            <h2 class="marker">
                <span class="marker_h2">Факты о товаре</span>
            </h2>
        </div>
        <div class="col-xl-10 col-lg-12">
            <?=htmlspecialchars_decode($fact['name']);?>
        </div>
    </div>

<?php endif; ?>