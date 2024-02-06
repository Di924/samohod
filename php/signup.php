<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    include_once BASE_PATH . 'templates/header.php';
    include_once BASE_PATH . 'templates/menu.php';
?>

<div class="container">
    <form action="/handlers/formHandler.php" method="POST" class="col-lg-6 offset-lg-3 d-flex flex-column row-gap-3">
        <h2 class="font-weight-light mt-2">Регистрация</h2>

        <div class="form-floating">
            <input type="text" name="lname" class="form-control" id="floatingInputLname" placeholder="" required>
            <label for="floatingInputLname">Фамилия</label>
        </div>

        <div class="form-floating">
            <input type="text" name="fname" class="form-control" id="floatingInputFname" placeholder="" required>
            <label for="floatingInputFname">Имя</label>
        </div>

        <div class="form-floating">
            <input type="text" name="mname" class="form-control" id="floatingInputMname" placeholder="">
            <label for="floatingInputMname">Отчество</label>
        </div>

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInputEmail" placeholder="" required>
            <label for="floatingInputEmail">Почта</label>
        </div>

        <div class="d-flex gap-2">
            <div class="form-floating col">
                <input type="password" name="password" class="form-control" id="floatingInputPassword" placeholder="" required pattern="^.{8,}">
                <label for="floatingInputPassword">Пароль</label>
            </div>
            <div class="form-floating col">
                <input type="password" name="repeat-password" class="form-control" id="floatingInputRepeatPassword" placeholder="" required pattern="^.{8,}">
                <label for="floatingInputRepeatPassword">Повторите пароль</label>
            </div>
        </div>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
                <strong>Ошибка!</strong>
                <span>Пользователь с такой почтой уже существует!</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <button type="submit" name="formName" value="signup" class="btn btn-md btn-block btn-danger-gradiant text-white border-0">Создать аккаунт</button>
    </form>

    <div class="text-center mt-4">
        Уже зарегистрированы? <a href="/php/signin.php" class="text-danger">Войти</a>
    </div>
</div>

<?php include_once BASE_PATH . 'templates/footer.php'; ?>
