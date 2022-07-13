<hr>
<h3>Магазин</h3>
<div style="float:left;width:30%;margin-bottom:10px;">
    <ul>
        <li>
            <a href="/shop/index?type=helm">Шлем</a>
        </li>
        <li>
            <a href="/shop/index?type=weapon">Оружие</a>
        </li>
        <li>
            <a href="/shop/index?type=armor">Броня</a>
        </li>
        <li>
            <a href="/shop/index?type=belt">Пояс</a>
        </li>
        <li>
            <a href="/shop/index?type=earrings">Серьги</a>
        </li>
        <li>
            <a href="/shop/index?type=necklace">Амулет</a>
        </li>
        <li>
            <a href="/shop/index?type=ring">Кольцо</a>
        </li>
        <li>
            <a href="/shop/index?type=shild">Щит</a>
        </li>
        <li>
            <a href="/shop/index?type=leggings">Поножи</a>
        </li>
        <li>
            <a href="/shop/index?type=boots">Ботинки</a>
        </li>
    </ul>
    <b>Золото:</b> <?php echo $user->gold;?><br>
    <a href="https://vk.com/djdnkey" target="_blank" style="margin: 10px;border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;">Купить золото</a><br>

</div>
<div style="float:left;width:70%;">
    <?php foreach ($items as $item):?>
    <div style="border:1px solid #bfbfbf;padding: 10px;border-radius: 20px 20px 20px 20px;margin:10px;">

        <div><center><img src="/img/<?php echo $item->img;?>"> <?php echo $item->name;?> </center></div>
            <div>
                    <?php echo $item->description;?>
            </div>
            <div>
                <?php echo $item->cost?> золота
            </div>
            <div>
                <a href="/shop/buy?id=<?php echo $item->id;?>"?>Купить</a>
            </div>
    </div>
    <?php endforeach;?>    
</div>