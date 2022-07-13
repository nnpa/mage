<?php foreach ($errors as $error):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
    </div>
<?php endforeach;?>
    


<form method="POST" action="/site/register">
    <div class="form-group">
        <label for="exampleInputEmail1">Логин</label>

        <input class="form-control" type="text" name="login" value="<?php echo $login?>">
        
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>

        <input class="form-control" type="text" name="email" value="<?php echo $email?>">
        
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Пароль</label>

        <input class="form-control" type="password" name="password">
        
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Пароль повторно</label>

        <input class="form-control" type="password" name="password2">
        
    </div>
      <button type="submit" class="btn btn-primary">Зарегистрироваться</button>

</form>