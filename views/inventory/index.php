<h3>Инвьентарь</h3>
<hr>
<div style="width: 40%;float:left;">
        Жизни: <span style="color:red"><?php echo $loadUser->hp;?></span><br>
    Мана: <span style="color:blue"><?php echo $loadUser->mp;?></span>
    <table>
        <tr>
            <td width="60px" height="60px" rowspan="3">
                <?php if(!is_null($item = $user->getItem('helm'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->helm?>&type=helm">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;	
                <?php endif;?>
            </td>
            <td rowspan="7" width="120px"> </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('earrings'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->earrings?>&type=earrings">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>

        </tr>
        <tr>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('necklace'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->necklace?>&type=necklace">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring1'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->ring1?>&type=ring1">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring2'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->ring2?>&type=ring2">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring3'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->ring3?>&type=ring3">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="50px" height="90px">
                <?php if(!is_null($item = $user->getItem('armor'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->armor?>&type=armor">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('shild'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->shild?>&type=shild">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="50px" height="60px">
                <?php if(!is_null($item = $user->getItem('weapon'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->weapon?>&type=weapon">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?></td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('leggings'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->leggings?>&type=leggings">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?></td></td>

        </tr>
        <tr>
            <td width="60px" height="60px">
                <?php if(!is_null($item = $user->getItem('belt'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->belt?>&type=belt">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td></td>
            </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('boots'))):?>
                    <a href="/inventory/unequip?id=<?php echo $user->boots?>&type=boots">
                        <img src="/img/<?php echo $item->img;?>">
                    </a>
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>

        </tr>
    </table>
    <hr>
        <b>Побед:</b> <?php echo $user->win;?><br>
        <b>Поражений:</b> <?php echo $user->lose;?>

    <hr>
        <b>Атака:</b> <?php echo $loadUser->damage;?><br>
        <b>Защита:</b> <?php echo $loadUser->defence;?>

    <hr>
    <b>Сила:</b> <?php echo $user->strength;?> <span style="color:#5ECA11">+<?php echo ($loadUser->strength - $user->strength);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=strength">+</a>
        <?php endif;?>
    <br>
    <b>Интуиция:</b> <?php echo $user->intuition;?> <span style="color:#5ECA11">+<?php echo ($loadUser->intuition - $user->intuition);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=intuition">+</a>
        <?php endif;?>  
    <br>
    <b>Ловкость:</b> <?php echo $user->dexterity;?> <span style="color:#5ECA11">+<?php echo ($loadUser->dexterity - $user->dexterity);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=dexterity">+</a>
        <?php endif;?> 
    <br>
    <b>Выносливость:</b> <?php echo $user->endurance;?> <span style="color:#5ECA11"> +<?php echo ($loadUser->endurance - $user->endurance);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=endurance">+</a>
        <?php endif;?> 
    <br>
    <b>Интелект:</b> <?php echo $user->intelligence;?> <span style="color:#5ECA11">+<?php echo ($loadUser->intelligence - $user->intelligence);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=intelligence">+</a>
        <?php endif;?> 
    <br>
    <b>Ментальность:</b> <?php echo $user->mental;?> <span style="color:#5ECA11">+<?php echo ($loadUser->mental - $user->mental);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=mental">+</a>
        <?php endif;?>
    <br>
    <b>Огонь:</b> <?php echo $user->fire;?> <span style="color:#5ECA11">+<?php echo ($loadUser->fire - $user->fire);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=fire">+</a>
        <?php endif;?>
    <br>
    <b>Вода:</b> <?php echo $user->woter;?> <span style="color:#5ECA11">+<?php echo ($loadUser->woter - $user->woter);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=woter">+</a>
        <?php endif;?>
    <br>
    <b>Земля:</b> <?php echo $user->earth;?> <span style="color:#5ECA11">+<?php echo ($loadUser->earth - $user->earth);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=earth">+</a>
        <?php endif;?>
    <br>
    <b>Воздух:</b> <?php echo $user->air;?> <span style="color:#5ECA11">+<?php echo ($loadUser->air - $user->air);?></span>
        <?php if($user->stats > 0):?>
            <a href="/inventory/stat/?atr=air">+</a>
        <?php endif;?>
    <br>
    <b>Свободных статов:</b> <?php echo $user->stats;?><br>
    <b>Золота:</b> <?php echo $user->gold;?><br>
    <a href="/inventory/reset/"  onclick="return confirm('Сбросить?')">Сбросить статы</a>
    <br>
</div>
<div style="width: 60%;float:left;">
    <?php foreach ($items as $item):?>
        <div style="border:1px solid #bfbfbf;padding: 10px;border-radius: 20px 20px 20px 20px;margin-top:10px;">
            <div><center><img src="/img/<?php echo $item->item->img;?>"> <?php echo $item->item->name;?> </center></div>
            <div>
                    <?php echo $item->item->description;?>
            </div>
            <div>
                <?php echo $item->item->cost?> золота
            </div>
            <div style="height:25px">
                    <a style="float:left" href="/inventory/equip?id=<?php echo $item->item->id;?>"?>Надеть</a>

                    <a style="float:right" onclick="return confirm('Продать?')" href="/shop/sell?id=<?php echo $item->item->id;?>"?>Продать</a>

            </div>
        </div>
    <?php endforeach;?>
 
</div>