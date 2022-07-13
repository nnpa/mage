<hr>
<center>
    <?php foreach($command1 as $battleUserCommand):?>
        <?php $battleUserObj = $battleUserCommand->getUser();?>
        <?php echo $battleUserObj->login;?> 
        [<?php echo $battleUserObj->level;?>]
        [<span style="color:red;"><?php echo $battleUserCommand->hp;?> / <?php echo $battleUserCommand->max_xp;?></span>]
        <a target="_blank" href="/inventory/info?id=<?php echo $battleUserObj->id?>">
            <img src="/img/info.jpg">
        </a>,
        
    <?php endforeach;?>
    <b>против</b> 
    <?php foreach($command2 as $battleUserCommand):?>
        <?php $battleUserObj = $battleUserCommand->getUser();?>
        <?php echo $battleUserObj->login;?> 
        [<?php echo $battleUserObj->level;?>]
        [<span style="color:red;"><?php echo $battleUserCommand->hp;?> / <?php echo $battleUserCommand->max_xp;?></span>]
        
        <a target="_blank" href="/inventory/info?id=<?php echo $battleUserObj->id?>">
            <img src="/img/info.jpg">
        </a>,
    <?php endforeach;?>
</center>

<div style="padding-top: 20px">
    <?php if($battleUser->cd < time()):?>
        <?php if(!$endBattle):?>

            <center>

                <a href="/battle/attack?type=1"><img title="атака оружием" src="/img/sword_icon.jpg">Aтака оружием</a>

                <?php if($earth):?>
                    <a href="/battle/attack?type=2"><img title="атака землей" src="/img/stone_icon.jpg">Атака землей</a>
                <?php endif;?>

                <?php if($fire):?>
                    <a href="/battle/attack?type=3"><img title="атака огнем" src="/img/fire_icon.jpg">Атака огнем</a>
                <?php endif;?>

                <?php if($woter):?>

                    <a href="/battle/attack?type=4"><img title="лечение" src="/img/medic_icon.jpg">Лечение водой</a>
                <?php endif;?>

                <?php if($air):?>

                    <a href="/battle/attack?type=5"><img title="атака воздухом" src="/img/lightning_icon.jpg">Атака воздухом</a>
                <?php endif;?>

            </center>
        <?php else:?>
            <center>Бой закончен <a href="/battle/endbattle">Покинуть поединок </a></center>
        <?php endif;?>
    <?php else:?>
            <center><a href="/battle/battle">Обновить</a></center>
    <?php endif;?>
</div>
<hr>
<div style="float:left;width:25%">
    <center>
        <b><?php echo $user->login;?></b><br> 
        Жизни [<span style="color:red;"><?php echo $battleUser->hp;?> / <?php echo $battleUser->max_xp;?></span>] <br>
        Мана [<span style="color:blue;"><?php echo $battleUser->mp;?> / <?php echo $battleUser->max_mp;?></span>]
    </center>
    <table>
        <tr>
            <td width="60px" height="60px" rowspan="3">
                <?php if(!is_null($item = $user->getItem('helm'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;	
                <?php endif;?>
            </td>
            <td rowspan="7" width="120px"> </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('earrings'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>

        </tr>
        <tr>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('necklace'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring1'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring2'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td width="20px" height="20px">
                <?php if(!is_null($item = $user->getItem('ring3'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="50px" height="90px">
                <?php if(!is_null($item = $user->getItem('armor'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('shild'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td width="50px" height="60px">
                <?php if(!is_null($item = $user->getItem('weapon'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?></td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('leggings'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?></td></td>

        </tr>
        <tr>
            <td width="60px" height="60px">
                <?php if(!is_null($item = $user->getItem('belt'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td></td>
            </td>
            <td colspan="3">
                <?php if(!is_null($item = $user->getItem('boots'))):?>
                        <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                <?php else:?>
                    &nbsp;
                <?php endif;?>
            </td>

        </tr>
    </table>
    
    <b>Сила:</b> <?php echo $loadUser->strength;?>

    <br>
    <b>Интуиция:</b> <?php echo $loadUser->intuition;?>
        
    <br>
    <b>Ловкость:</b> <?php echo $loadUser->dexterity;?>

    <br>
    <b>Выносливость:</b> <?php echo $loadUser->endurance;?>
        
    <br>
    <b>Интелект:</b> <?php echo $loadUser->intelligence;?>
       
    <br>
    <b>Ментальность:</b> <?php echo $loadUser->mental;?>
        
    <br>
    <b>Огонь:</b> <?php echo $loadUser->fire;?>
        
    <br>
    <b>Вода:</b> <?php echo $loadUser->woter;?>
        
    <br>
    <b>Земля:</b> <?php echo $loadUser->earth;?>
        
    <br>
    <b>Воздух:</b> <?php echo $loadUser->air;?>
        
    <br>
</div>
<div style="float:left;width:50%;max-height: 550px;overflow-x: hidden;overflow-y: auto;">
    &nbsp;
    <b>Урона нанесено: <?php echo $battleUser->damage;?></b><br>
    <?php foreach($battleHistory as $history):?>
        <?php echo $history->text;?> <br>
    <?php endforeach;?>
</div>
<div style="float:left;width:25%">
    <?php if(is_object($user2)):?>
    <center>
        <b><?php echo $user2->login;?></b><br> 
        Жизни [<span style="color:red;"><?php echo $battleUserEnemy->hp;?> / <?php echo $battleUserEnemy->max_xp;?></span>] <br>
        Мана [<span style="color:blue;"><?php echo $battleUserEnemy->mp;?> / <?php echo $battleUserEnemy->max_mp;?></span>]
    </center>
        <table>
            <tr>
                <td width="60px" height="60px" rowspan="3">
                    <?php if(!is_null($item = $user2->getItem('helm'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;	
                    <?php endif;?>
                </td>
                <td rowspan="7" width="120px"> </td>
                <td colspan="3">
                    <?php if(!is_null($item = $user2->getItem('earrings'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>

            </tr>
            <tr>
                <td colspan="3">
                    <?php if(!is_null($item = $user2->getItem('necklace'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td width="20px" height="20px">
                    <?php if(!is_null($item = $user2->getItem('ring1'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
                <td width="20px" height="20px">
                    <?php if(!is_null($item = $user2->getItem('ring2'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
                <td width="20px" height="20px">
                    <?php if(!is_null($item = $user2->getItem('ring3'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td width="50px" height="90px">
                    <?php if(!is_null($item = $user2->getItem('armor'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
                <td colspan="3">
                    <?php if(!is_null($item = $user2->getItem('shild'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td width="50px" height="60px">
                    <?php if(!is_null($item = $user2->getItem('weapon'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?></td>
                <td colspan="3">
                    <?php if(!is_null($item = $user2->getItem('leggings'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?></td></td>

            </tr>
            <tr>
                <td width="60px" height="60px">
                    <?php if(!is_null($item = $user2->getItem('belt'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td></td>
                </td>
                <td colspan="3">
                    <?php if(!is_null($item = $user2->getItem('boots'))):?>
                            <img src="/img/<?php echo $item->img;?>" title="<?php echo $item->name;?>">
                    <?php else:?>
                        &nbsp;
                    <?php endif;?>
                </td>
            </tr>
        </table>
    <?php endif;?>
</div>