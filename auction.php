<?php
require_once("Database_worker.php");
$db = new Database_worker();
@$db->do_sql("SET NAMES utf8");
$res = [];
$error = "";
try {
    $id = $_GET["car"];
    if (empty($id) || !is_numeric($id)) {
        throw new Exception("ID have to be a number and be more then 0", 1);
    }
    $res = $db->do_sql("SELECT * 
                            FROM common_data cd
                            WHERE id = $id
                        ");
    if (empty($res)) {
        throw new Exception("Not found with $id", 2);
    }
    $res = reset($res);
    $photo_list = $db->do_sql("SELECT * FROM photos WHERE car_id=$id");
} catch (Exception $ex) {
    $res = [];
    $error = $ex->getMessage();
}

require_once("header.php"); ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>

<link rel="stylesheet" href="css/prism.css">
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/carousel.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="js/prism.js"></script>
<script type="text/javascript" src="js/simplycarousel.js"></script>
<script type="text/javascript" src="js/script2.js"></script>



<div class="col-lg-8 offset-2">
    <div class="vehicle-card" id="lot_<?= $res->id ?>">
        <div class="row align-items-center mb-3">
            <div class="col-12 col-lg-5">
                <h1 class="mb-0"><?= $res->mark_name." ".$res->modification_name ?></h1>
            </div>
            <div class="col-12 col-md-4 col-lg text-left  my-3 my-lg-0">
                Продавец: <span class="black-font"><?= $res->seller ?><span class="icon header-address-icon-1 mr-1"></span><?= $res->city_name ?></a></span>
            </div>

        </div>


        <div class="row">
            <div class="col-12 col-lg params-block order-1 order-lg-1 mt-0">
                <div class="col-3">
                    <div class="col-12">
                        <div class="price mb-3">
                            <span class="sm-font">Стартовая цена:</span> <span class="black-font" id="bidNum_1404"><?= number_format($res->start_price, 0, ".", " ") ?> р.</span>
                            <span class="min_price_lot xs-font my-1">Минимальная цена не достигнута</span><br/><span class="price_step_lot xs-font mb-1">Шаг аукциона: <strong><?= number_format($res->price_step, 0, ".", " ") ?> р.</strong></span></div>
                    </div>
                </div>                
                <div class="user-id black-font mt-2">
                    iD: <?= $res->id ?> (Открытые торги)<br>
                    <div>Начало торгов: <?= $res->date_start ?></div>
                    <div>Окончание торгов: <?= $res->date_end ?></div>
                </div>               
                <div class="row align-items-center d-flex my-3 ">
                    <div class="col-12">
                        <div id="main_banner" class="demo">
                            <?php foreach ($photo_list as $photo): ?>
                                <div class="carousel-slide" style="background: url(http://rrt-auction.ru<?= $photo->file ?>) no-repeat 50% 50%; background-size: cover;">
                                    <div class="caption"></div>
                                </div>
                            <?php endforeach; ?>
                            <span class="arrow left select-none">&lt;</span>
                            <span class="arrow right select-none">&gt;</span>
                        </div>
                    </div>
                </div>
                <!-- End Icons -->

            </div>

        </div>
        <!--end fblock-->
        <div class="row">
            <div class="col-12 col-lg params-block order-1 order-lg-1 mt-3">
                <!-- Info Table -->
                <div class="info-table">
                    <table class="w-100">
                        <tbody>
                        <tr>
                            <td>VIN</td>
                            <td class="black-font"><a href="http://www.gibdd.ru/check/auto/#Z8NTANZ52GS012556" target="_blank"><?= $res->vin ?></a></td>
                        </tr>
                        <tr>
                            <td>Год выпуска</td>
                            <td class="black-font"><?= $res->year ?></td>
                        </tr>
                        <tr>
                            <td>Пробег</td>
                            <td class="black-font"><?= number_format($res->mileage, 0, ".", " ") ?></td>
                        </tr>
                        <tr>
                            <td>Кузов</td>
                            <td class="black-font"><?= $res->body ?></td>
                        </tr>
                        <tr>
                            <td>Цвет</td>
                            <td class="black-font"><?= $res->color ?></td>
                        </tr>
                        <tr>
                            <td>Двигатель</td>
                            <td class="black-font"><?= $res->engine ?>, <?= $res->engine_vol ?> л, <?= $res->power ?> л.с.</td>
                        </tr>
                        <tr>
                            <td>Коробка</td>
                            <td class="black-font"><?= $res->gearbox ?></td>
                        </tr>
                        <tr>
                            <td>Привод</td>
                            <td class="black-font"><?= $res->drive ?></td>
                        </tr>

                        <!--<tr>
                            <td>Владельцы</td>
                            <td class="black-font"></td>
                        </tr>-->
                        <tr>
                            <td>Ключи</td>
                            <td class="black-font">2 комплекта</td>
                        </tr>
                        <tr>
                            <td>ПТС</td>
                            <td><span class="black-font"><?= $res->pts ?> <?= $res->pts_no ?></span>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Рег. знак</td>
                            <td class="black-font"><?= $res->reg_plate ?></td>
                        </tr>

                        <tr>
                            <td> Кол. владельцев</td>
                            <td class="black-font"><?= $res->owner_count ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-lg-8 order-2 order-lg-2">

                    <div class="mt-4">
                        <h2>Дополнительные данные</h2>
                        <?= str_replace("\n", "<br/>", $res->comments) ?>
                    </div>
                </div>
                <!-- End Carousel -->
            </div>
        </div>


        <?php

        endif; ?>
        <? require_once("footer.php"); ?> 

