<?php
    use app\models\Battle;
?>
<hr>
<center>
    <h4><?php echo $user->login;?> <?php echo $user->level;?></h4>
</center>
<div style="width: 40%;float:left;">
    Жизни: <span style="color:red"><?php echo $loadUser->hp;?></span><br>
    Мана: <span style="color:blue"><?php echo $loadUser->mp;?></span>

    <table>
        <tr>
            <td width="60px" height="60px" rowspan="3">
                <?php if(!is_null($item = $user->getItem('helm'))):?>
                    <a  target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;	
                <?php endif;?>
            </td>
            <td rowspan="7" width="120px"> </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('earrings'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>

        </tr>
        <tr>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('necklace'))):?>
                 <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                 </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring1'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring2'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring3'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="50px" height="90px">
                <?php if(!is_null($item = $user->getItem('armor'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('shild'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="50px" height="60px">
                <?php if(!is_null($item = $user->getItem('weapon'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?></td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('leggings'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?></td></td>

        </tr>
        <tr>
            <td width="60px" height="60px">
                <?php if(!is_null($item = $user->getItem('belt'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td></td>
            </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('boots'))):?>
                    <a target="_blank" href="/shop/info?id=<?php echo $item->id;?>">   
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>

        </tr>
    </table>
    <?php 
        if($user->battle_id != 0){
            $battle = Battle::find()->where(["id" => $user->battle_id,"started" => 1])->one();
            if(!is_null($battle)){
                echo "<a target='_blanks' href='/battle/info?id=".$user->battle_id."'>в поединке</a>";
            }
        }
    ?>
    <hr>
        <b>Побед:</b> <?php echo $user->win;?><br>
        <b>Поражений:</b> <?php echo $user->lose;?>

    <hr>
    <b>Сила:</b> <?php echo $user->strength;?> <span style="color:#5ECA11">+<?php echo ($loadUser->strength - $user->strength);?></span>

    <br>
    <b>Интуиция:</b> <?php echo $user->intuition;?> <span style="color:#5ECA11">+<?php echo ($loadUser->intuition - $user->intuition);?></span>

    <br>
    <b>Ловкость:</b> <?php echo $user->dexterity;?> <span style="color:#5ECA11">+<?php echo ($loadUser->dexterity - $user->dexterity);?></span>

    <br>
    <b>Выносливость:</b> <?php echo $user->endurance;?> <span style="color:#5ECA11">+<?php echo ($loadUser->endurance - $user->endurance);?></span>

    <br>
    <b>Интелект:</b> <?php echo $user->intelligence;?> <span style="color:#5ECA11">+<?php echo ($loadUser->intelligence - $user->intelligence);?></span>

    <br>
    <b>Ментальность:</b> <?php echo $user->mental;?> <span style="color:#5ECA11">+<?php echo ($loadUser->mental - $user->mental);?></span>

    <br>
    <b>Огонь:</b> <?php echo $user->fire;?> <span style="color:#5ECA11">+<?php echo ($loadUser->fire - $user->mental);?></span>

    <br>
    <b>Вода:</b> <?php echo $user->woter;?> <span style="color:#5ECA11">+<?php echo ($loadUser->woter - $user->woter);?></span>

    <br>
    <b>Земля:</b> <?php echo $user->earth;?> <span style="color:#5ECA11">+<?php echo ($loadUser->earth - $user->woter);?></span>

    <br>
    <b>Воздух:</b> <?php echo $user->air;?> <span style="color:#5ECA11">+<?php echo ($loadUser->air - $user->air);?></span>

    <br>

    <br>
</div>
<div style="width: 40%;float:left;">
    <pre><?php echo htmlspecialchars($user->text);?></pre>
</div>
