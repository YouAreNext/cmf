<?php
    use app\models\User;
?>
<h1>Привет</h1>

<a href="/main/create" class="btn btn-primary">Создать</a>

<table>
        <?php foreach($arrayFck as $item): ?>
            <tr>
            <td width="100px">
                <?=$item->id?>
            </td>
            <td width="200px">
                <a href="/main/project/<?=$item->id?>"><?php echo $item->Title ?></a>
            </td>
            <td width="200px">
                <a href="/main/edit/<?=$item->id?>">Редактировать</a>
            </td>
            <td width="100px">
                <a href="/main/delete/<?=$item->id?>">Удалить</a>
            </td>
            </tr>
        <?php endforeach ?>

</table>



