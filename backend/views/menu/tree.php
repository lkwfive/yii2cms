<?php 
use yii\helpers\Html;
use common\models\Menu;

$data = Menu::getAllDataTree();
?>
<style type="text/css">
    .menu-tree {
        min-height:20px;
        padding:19px;
        margin-bottom:20px;
        background-color:#fbfbfb;
        border:1px solid #999;
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
        -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
    }
    .menu-tree li {
        list-style-type:none;
        margin:0;
        padding:10px 5px 0 5px;
        position:relative
    }
    .menu-tree li::before, .menu-tree li::after {
        content:'';
        left:-20px;
        position:absolute;
        right:auto
    }
    .menu-tree li::before {
        border-left:1px solid #999;
        bottom:50px;
        height:100%;
        top:0;
        width:1px
    }
    .menu-tree li::after {
        border-top:1px solid #999;
        height:20px;
        top:25px;
        width:25px
    }
    .menu-tree li span,.menu-tree li b {
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border:1px solid #999;
        border-radius:5px;
        display:inline-block;
        padding:3px 8px;
        text-decoration:none
    }
    .menu-tree li.parent_li>span {
        cursor:pointer
    }
    .menu-tree>ul>li::before, .menu-tree>ul>li::after {
        border:0
    }
    .menu-tree li:last-child::before {
        height:30px
    }
    .menu-tree li.parent_li>span:hover, .menu-tree li.parent_li>span:hover+ul li span {
        background:#eee;
        border:1px solid #94a0b4;
        color:#000
    }

</style>
<p>
    <?= Html::a('Create Menu', ['/menu/create'], ['class' => 'btn btn-success']) ?>
</p>

<div class="menu-tree">
    <ul>
        <?php foreach ($data as $root):?>
        <li>
            <span><?= $root['name']?></span>
            <a href="/menu/move?updown=up&id=<?= $root['id']?>" title="上移" aria-label="上移" data-pjax="0"><b class="glyphicon glyphicon-arrow-up"></b></a>
            <a href="/menu/move?updown=down&id=<?= $root['id']?>" title="下移" aria-label="下移" data-pjax="0"><b class="glyphicon glyphicon-arrow-down"></b></a>
            <a href="/menu/update?id=<?= $root['id']?>" title="更新" aria-label="更新" data-pjax="0"><b class="glyphicon glyphicon-pencil"></b></a>
            <a href="/menu/delete?id=<?= $root['id']?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><b class="glyphicon glyphicon-trash"></b></a>
            <?php if(count($root['children'])): ?>
            <ul>
                <?php foreach ($root['children'] as $v1):?>
                <li>
                    <span><?= $v1['name']?></span>
                    <a href="/menu/move?updown=up&id=<?= $v1['id']?>" title="上移" aria-label="上移" data-pjax="0"><b class="glyphicon glyphicon-arrow-up"></b></a>
                    <a href="/menu/move?updown=down&id=<?= $v1['id']?>" title="下移" aria-label="下移" data-pjax="0"><b class="glyphicon glyphicon-arrow-down"></b></a>
                    <a href="/menu/update?id=<?= $v1['id']?>" title="更新" aria-label="更新" data-pjax="0"><b class="glyphicon glyphicon-pencil"></b></a>
                    <a href="/menu/delete?id=<?= $v1['id']?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><b class="glyphicon glyphicon-trash"></b></a>
                    <?php if(count($v1['children'])): ?>
                    <ul>
                        <?php foreach ($v1['children'] as $v2):?>
                        <li>
                            <span><?= $v2['name']?></span>
                            <a href="/menu/move?updown=up&id=<?= $v2['id']?>" title="上移" aria-label="上移" data-pjax="0"><b class="glyphicon glyphicon-arrow-up"></b></a>
                            <a href="/menu/move?updown=down&id=<?= $v2['id']?>" title="下移" aria-label="下移" data-pjax="0"><b class="glyphicon glyphicon-arrow-down"></b></a>
                            <a href="/menu/update?id=<?= $v2['id']?>" title="更新" aria-label="更新" data-pjax="0"><b class="glyphicon glyphicon-pencil"></b></a>
                            <a href="/menu/delete?id=<?= $v2['id']?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><b class="glyphicon glyphicon-trash"></b></a>
                            <?php if(count($v2['children'])): ?>
                            <ul>
                                <?php foreach ($v2['children'] as $v3):?>
                                <li>
                                    <span><?= $v3['name']?></span>
                                    <a href="/menu/move?updown=up&id=<?= $v3['id']?>" title="上移" aria-label="上移" data-pjax="0"><b class="glyphicon glyphicon-arrow-up"></b></a>
                                    <a href="/menu/move?updown=down&id=<?= $v3['id']?>" title="下移" aria-label="下移" data-pjax="0"><b class="glyphicon glyphicon-arrow-down"></b></a>
                                    <a href="/menu/update?id=<?= $v3['id']?>" title="更新" aria-label="更新" data-pjax="0"><b class="glyphicon glyphicon-pencil"></b></a>
                                    <a href="/menu/delete?id=<?= $v3['id']?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><b class="glyphicon glyphicon-trash"></b></a>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <?php endif;?>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                </li>
                <?php endforeach;?>
            </ul>
            <?php endif;?>
        </li>
        <?php endforeach;?>
    </ul>
</div>
<?php 
$this->registerJs("
$(function () {
    $('.menu-tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.menu-tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(':visible')) {
            children.hide();
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show();
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
});
", \yii\web\View::POS_END);
?>