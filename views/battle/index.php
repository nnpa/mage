<h3>Поединки</h3>
<center><a href="/battle/index/" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;    text-decoration: none;">Обновить</a></center>
<hr>
<?php if($user->battle_id == 0):?>
    <b>Заявка на бой</b><br>
    <form method="POST">
        Мой уровень <input name="level" type="radio" value="1"><br>
        Любой уровень <input name="level" type="radio" value="2"><br>
        <input type="submit" value="Подать">
    </form>
    <hr>
<?php endif;?>
<hr>
    <form method="POST">
        <?php foreach($battles as $battle):?>

            <?php if($user->battle_id == 0):?>

                <input name="battle" type="radio" value="<?php echo $battle->id;?>"><br>
            <?php endif;?>
            
            <?php foreach($battle->getUsers() as $battleUser):?>
                <?php $battleUser = $battleUser->getUser();?>
                <?php echo $battleUser->login;?> [<?php echo $battleUser->level;?>]  
                <a target="_blank" href="/inventory/info?id=<?php echo $battleUser->id?>">
                    <img src="/img/info.jpg">
                </a>
            <?php endforeach;?>
            Бой начнется через: <?php echo ceil(($battle->time - time())/60);?> минут

            <hr>
        <?php endforeach;?>
            
        <?php if($user->battle_id == 0 && count($battles) > 0):?>
            <input type="submit" value="Принять участие">
        <?php endif;?>
    
    </form>
