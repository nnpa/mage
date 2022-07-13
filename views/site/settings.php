<h3>Настройки</h3>
<div >
    <?php foreach ($errors as $error):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error;?>
        </div>
    <?php endforeach;?>
    <h4>Смена проля</h4>
    <form method="POST" action="/site/settings">
        <div class="form-group">
            <label for="exampleInputEmail1">Пароль</label>

            <input class="form-control" type="text" name="password">

        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Пароль повторно</label>

            <input class="form-control" type="text" name="password2">

        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>

    </form>
    <h4>Информация о персонаже</h4>
    <form method="POST" action="/site/settings">
        <div class="form-group">

            <textarea class="form-control" type="text" name="text"><?php echo $user->text;?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить</button>

    </form>
</div>
