<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    include_once BASE_PATH . 'templates/header.php';
    include_once BASE_PATH . 'templates/menu.php';
    include_once BASE_PATH . 'classes/DBquery.php';

    include_once BASE_PATH . 'classes/Product.php';
    use classes\Product;
?>
<script>
    function toggle($id) {
        document.getElementById($id).classList.toggle('non');
    }
</script>
<div class="container">
    <div class="col">
        <div class="card mx-auto my-2 my-sm-3 my-lg-4" style="width: 60rem;">
            <button onclick="toggle('toggle');" type="button" class="btn btn-block btn-danger-gradiant text-white" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Создать карточку</button>
            <form action="/handlers/formHandler.php" method="POST" class="non" id="toggle">
                <div class="card-body d-flex justify-content-between">
                    <div class="row g-2">
                        <div class="align-self-center">
                            <input type="file" class="form-control" style="display: none" id="formFile">
                            <button onclick="document.querySelector('#formFile').click()" class="card-link btn btn-block btn-danger-gradiant text-white align-self-center" style="border: 1px solid;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-download" viewBox="0 0 20 20"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/></svg> 
                                Фотография
                            </button>
                        </div>
                    </div>
                    <input name="title" type="text" placeholder="Название">
                    <input name="description" type="text" placeholder="Описание">
                    <input name="price" type="number" placeholder="Цена">
                    <div class="card-link align-self-center">
                        <button type="submit" name="formName" value="insertProduct" class="card-link btn btn-block btn-danger-gradiant text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php 
            $products = Product::findAll(); 
            foreach ($products as $product) {
                $id          = $product->getId();
                $title       = $product->getTitle();
                $description = ($product->getDescription()) ? $product->getDescription() : 'Описание отсутствует';
                $price       = $product->getPrice();
                $photo       = ($product->getPhoto()) ? $product->getPhoto() : '/img/nos.jpg';
        ?>
        <div class="card mx-auto my-2 my-sm-3 my-lg-4 " style="width: 60rem;" >
            <div class="card-body d-flex justify-content-between">
                <img src="<?= $photo ?>" class="card-img-left" alt="img" width="100px">
                <div class="card-text align-self-center w-25"><?= $title ?></div>
                <div class="card-text align-self-center w-25"><?= $description ?></div>
                <div class="card-text align-self-center">Цена: <?= $price ?> руб.</div>
                <div class="card-link align-self-center d-flex">
                    <button onclick="toggle('<?= $id ?>');" class="card-link btn btn-block btn-danger-gradiant text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16"><path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/></svg>
                    </button>
                    <button type="button" onclick="document.querySelector('#deleteId').value = this.value;" value="<?= $id ?>" class="card-link btn btn-block btn-danger-gradiant text-white" data-bs-toggle="modal" data-bs-target="#mwDeletion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                    </button>
                </div>
            </div>
            <form action="/handlers/formHandler.php" method="POST" id="<?= $id ?>" class="non">
                <div class="card-body d-flex justify-content-between">
                    <div class="row g-2">
                        <div class="align-self-center">
                            <input name="photo" type="file" class="form-control" style="display: none" id="formFile">
                            <button onclick="document.querySelector('#formFile').click()" class="card-link btn btn-block btn-danger-gradiant text-white align-self-center" style="border: 1px solid;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-download" viewBox="0 0 20 20"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/></svg> 
                                Фотография
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input name="title" type="text" placeholder="Название">
                    <input name="description" type="text" placeholder="Описание">
                    <input name="price" type="number" placeholder="Цена">
                    <div class="card-link align-self-center d-flex">
                        <button type="submit" name="formName" value="updateProduct" class="card-link btn btn-block btn-danger-gradiant text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="mwDeletion" tabindex="-1" aria-labelledby="mwDeletionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mwDeletionLabel">Удаление товара</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                Подтвердите операцию
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-block btn-danger-gradiant text-white" data-bs-dismiss="modal">Отмена</button>
                <form action="/handlers/formHandler.php" method="POST">
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" name="formName" value="deleteProduct" class="card-link btn btn-block btn-danger-gradiant text-white">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once BASE_PATH . 'templates/footer.php'; ?>
