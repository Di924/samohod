<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    include_once BASE_PATH . 'templates/header.php';
    include_once BASE_PATH . 'templates/menu.php';
    include_once BASE_PATH . 'classes/DBquery.php';

    use classes\DBquery;
?>

<?php 
    $DBquery = new DBquery();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        #$data = filter_input_array(INPUT_GET);
        if (isset($_GET['inbasket']))
        {
            $DBquery->inBasketProducts($_GET['inbasket']);
        }
    }
    ?>

<div class="container">

<?php 
    $rows = $DBquery->getOrders(); 
    foreach ($rows as $row):
        echo '
    <div class="row order"> 
        <h2>Заказ №'.$row.'</h2> ';  
        $list = $DBquery->getOrderList($row); 
        foreach ($list as $l):
        echo '
        <div class="card mx-3 my-2 my-sm-3 my-lg-4" style="width: 20rem;" >
            <div class="card-body">
                <h5 class="card-title">' . $l["title"] . '</h5>
                <p class="card-text">' . $l["description"] . '</p>
                <a href="#" class="card-link btn btn-block btn-danger-gradiant text-white">Посмотреть</a>
            </div>
        </div>';
        endforeach;
        echo '
    </div>';

 endforeach;?>
</div>

<?php include_once BASE_PATH . 'templates/footer.php'; ?>
