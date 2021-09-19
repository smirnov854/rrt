<?php
require_once("Database_worker.php");
$db = new Database_worker();
@$db->do_sql("SET NAMES utf8");
$res = $db->do_sql("SELECT *, (SELECT file FROM photos WHERE car_id= cd.id ORDER BY ID LIMIT 1)  as main_photo
                        FROM common_data cd
                        ");
?>
<?php require_once("header.php"); ?>
<?php foreach ($res as $key=>$row): ?>
    <div class="col-12 col-md-6 col-lg-4 col-xl-4 model-item-block p-2 float-left" id="lot_<?= $row->id ?>">
        <div class="model-item row mx-0" style="flex-direction: column;">
            <div class="gs-12 model-item-desc-container col-8 col-12">
                <div class="row">
                    <div class="gs-12 col-12 model-title-icons">
                        <div class="row">                            
                            <img src="http://rrt-auction.ru<?=$row->main_photo?>" class="img-fluid">                            
                            <div class="col-10 pr-0 mb-3">
                                <span style="color:#28a745;">Лот № <?= $row->id ?> (Открытые торги)</span><br/>
                                <a target="_blank" href="/auction.php?car=<?= $row->id ?>" class="model-name"><?= $row->mark_name ?> <?= $row->model_name ?><br><?= $row->modification_name ?></a>
                            </div>                            
                            <div class="col-12 pr-0 mb-3">
                                <div class="mb-3 model-params">
                                    <ul>
                                        <li>VIN:<?= $row->vin ?></a></li>
                                        <li><?= $row->engine_vol ?> л., <?= $row->year ?> г.</li>
                                        <li>Мощность <?= $row->power ?> л.с.</li>
                                        <li><?= $row->drive ?> привод</li>
                                        <li><?= number_format($row->mileage, 0, ".", " ") ?> км</li>
                                    </ul>
                                </div>
                                <a target="_blank" href="/auctions/cars-legkovye-1/lot-1404/" class="location al-line">• <?= $row->seller ?></a>
                                <a href="#">• Город: <?= $row->city_name ?></a>
                                <div class="al-line">• Начало торгов: <?= $row->date_start ?></div>
                                <div class="al-line">• Окончание торгов: <?= $row->date_end ?></div>
                                <div class="al-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="gs-12 col-12 model-price mb-3">
                        <div class="mb-2 mib">
                        <span class="curst"> Стартовая цена: <span class="sum-b" id="bidNum_1404"><?=number_format($row->start_price, 0, ".", " ") ?> р.</span> </span>
                            <span class="min_price"></span>
                            <div class="row h-18">
                                <div class="col-12 col-md-6 stc">
                                    <span class="price_step"></span></div>
                                <div class="col-12 col-md-6 stc" id="setBidStatusInfo_1404">
                                </div>
                            </div>
                            <div class="row mt-2 bids">
                                <div class="col-12">
                                    <a href="#" data-toggle="modal" data-target="#login_modal" class="a-modal btn btn-success btn-xs btn-outline">Авторизация</a></div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                    <div class="col-12 btm-block">
                        <div class="row">
                            <div class="gs-12 col-12 model-params">
                                <a target="_blank" href="/auction.php?car=<?= $row->id ?>" class="btn btn-gray w-100">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(($key+1)%3 == 0 && $key>0):?>    
    <div class="clearfix"></div>
    <?php endif;?>
<?php endforeach; ?>
<?php require_once("footer.php"); ?>
