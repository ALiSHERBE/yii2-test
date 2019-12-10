<div class="container">
    <h2>Список данных</h2>
    <ul class="list-group">
	    <?foreach($items as $title => $item):?>
            <li class="list-group-item"><?= $title?> <span class="badge"><?=$item?></span></li>
	    <?endforeach;?>
    </ul>
</div>
