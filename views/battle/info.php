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


<div style="float:left;width:50%;max-height: 550px;overflow-x: hidden;overflow-y: auto;">
    <?php foreach($battleHistory as $history):?>
        <?php echo $history->text;?> <br>
    <?php endforeach;?>
</div>