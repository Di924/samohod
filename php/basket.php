<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    include_once BASE_PATH . 'templates/header.php';
    include_once BASE_PATH . 'templates/menu.php';
    include_once BASE_PATH . 'classes/DBquery.php';

    use classes\DBquery;
?>

<div class="container">
    <div class="col">
        <?php 
            $DBquery = new DBquery();
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                #$data = filter_input_array(INPUT_GET);
                if (isset($_GET['plus']))
                {
                    $DBquery->countBasket($_GET['plus'], $_GET['id']);
                }
                if (isset($_GET['minus']))
                {
                    $DBquery->countBasket($_GET['minus'], $_GET['id']);
                }
                if (isset($_GET['delete'])) {
                    #var_dump($_GET['delete']);
                    $DBquery->deleteBasket($_GET['delete']);
                }
                if (isset($_GET['inorder'])) {
                    #var_dump($_GET['delete']);
                    $DBquery->newOrder();
                    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/php/orders.php');
                    #http://samohod:86/php/basket.php
                }
            }
        ?>
        <div class="card mx-auto my-2 my-sm-3 my-lg-4" style="width: 60rem;" >
            <a href="?inorder=1" class="card-link btn btn-block btn-danger-gradiant text-white">Оформить заказ</a>
        </div>
        <?php foreach ($DBquery->getBasket() as $row): ?>
        <div class="card mx-auto my-2 my-sm-3 my-lg-4" style="width: 60rem;" >
            <img src="<?= $row['photo']?$row['photo']: '/img/nos.jpg' ?>" class="card-img-left" alt="..." width="100px">
            <div class="card-body">
                <h5 class="card-title"><?= $row['title'] ?></h5>
                <p class="card-text"><?= $row['description'] ?></p><div style="display: inline;">Цена: <?= $row['price']*$row['count'] ?> руб</div>
                <a href="?plus=<?= $row['count'] + 1 ?>&id=<?= $row['id'] ?>" class="card-link btn btn-block btn-danger-gradiant text-white">+</a>
                <div style="display: inline;"><?= $row['count'] ?></div>
                <a href="?minus=<?= ($row['count'] === 1) ? $row['count'] : --$row['count'] ?>&id=<?= $row['id'] ?>" class="card-link btn btn-block btn-danger-gradiant text-white">-</a>
                <a href="?delete=<?= $row['id'] ?>" class="card-link btn btn-block btn-danger-gradiant text-white">Удалить</a>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>

<?php include_once BASE_PATH . 'templates/footer.php'; ?>
