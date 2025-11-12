
<div class="container min-vh-100 d-flex align-items-center py-5">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Вход в кабинет</h3>
                    <form action="/admin/login" method="post">
                        <div class="mb-3">
                            <?php if (isset($errors['login'])): ?>
                                <div class="alert alert-danger p-1">
                                    <?= $errors['login'] ?>
                                </div>
                            <?php endif; ?>
                            <label for="login" class="form-label">Логин</label>
                            <?php if (!empty($oldLoginInput)): ?>
                                <input type="text" name="login" id="login" class="form-control" value="<?= $oldLoginInput ?>">
                            <?php else: ?>
                                <input type="text" name="login" id="login" class="form-control" placeholder="Введите логин">
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <?php if (isset($errors['pass'])): ?>
                                <div class="alert alert-danger p-1">
                                    <?= $errors['pass'] ?>
                                </div>
                            <?php endif; ?>
                            <label for="pass" class="form-label">Пароль</label>
                            <input type="password" name="password" id="pass" class="form-control" placeholder="Введите пароль">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Войти
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


