<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    include_once BASE_PATH . 'templates/header.php';
    include_once BASE_PATH . 'templates/menu.php';
    include_once BASE_PATH . 'classes/DBquery.php';

    use classes\DBquery;
?>

<div class="container">
    <div class="row justify-content-center">
        <?php 
            $DBquery = new DBquery();
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                #$data = filter_input_array(INPUT_GET);
                if (isset($_GET['inbasket']))
                {
                    $DBquery->inBasketProducts($_GET['inbasket']);
                    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/php/catalog.php');
                }
            }
            $rows = $DBquery->getProducts(); 
            $bask = (isset($_SESSION['user']['id'])) ? $DBquery->getBasket() : null;
        ?>
        <?php foreach ($rows as $row) { ?>
            <div class="card mx-3 my-2 my-sm-3 my-lg-4" style="width: 20rem;" id="<?= $row['id'] ?>">
                <div class="card-body">
                    <img src="<?= $row['photo']?$row['photo']: '/img/nos.jpg' ?>" class="card-img-left" alt="..." width="100px">
                    <h5 class="card-title"><?= $row['title'] ?></h5>
                    <p class="card-text"><?= $row['description'] ?></p>
                    <p class="card-text">Цена: <?= $row['price'] ?> руб.</p>

                    <?php if (isset($_SESSION['user']['id'])) { ?>
                        <?php if ($bask != []) { ?>
                            <?php $status = false; ?>
                        
                            <?php foreach ($bask as $value) { ?>
                                <?php if ($row['id'] == $value['pid']) { ?> 
                                    <?php $status = true; ?>
                                <?php } ?>
                            <?php } ?>   
                            <?php if ($status) { ?>
                                <a class="card-link btn btn-block btn-danger-gradiant text-white">Уже в корзине</a>
                            <?php } else { ?>
                                <a href="?inbasket=<?= $row['id'] ?>" class="card-link btn btn-block btn-danger-gradiant text-white">В корзину</a>
                            <?php } ?>
                        <?php } else { ?>
                            <a href="?inbasket=<?= $row['id'] ?>" class="card-link btn btn-block btn-danger-gradiant text-white">В корзину</a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?> 
    </div>
</div>

<?php include_once BASE_PATH . 'templates/footer.php'; ?>
