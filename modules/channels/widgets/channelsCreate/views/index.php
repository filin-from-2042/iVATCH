<?php
    use app\modules\channels\widgets\сhannelsCreate\ChannelsCreateAsset;

    ChannelsCreateAsset::register($this);
?>
<div class="panel panel-default" id="channelList">
    <div class="panel-heading controls_container">
        <!-- Order button -->
        <div>
            <select name="order" class="form-control" >
                    <option value="title" <?= ($order === 'title')?'selected':''?>>Названию</option>
                    <option value="subscribers_count" <?= ($order === 'subscribers_count')?'selected':''?>>Количеству подписчиков</option>
<!--                    <option value="watchers_count" --><?//= ($order === 'watchers_count')?'selected':''?><!-->Количеству просматривающих</option>-->
<!--                    <option value="default" --><?//= ($order === '')?'selected':''?><!-->Без сортировки</option>-->
            </select>
        </div>
        <!-- Order button -->
        <div>
            <select name="direction" class="form-control" >
                    <option value="descending" <?= ($direction === 'DESC')?'selected':''?>>Убыванию</option>
                    <option value="ascending" <?= ($direction === 'ASC')?'selected':''?>>Возрастанию</option>
            </select>
        </div>
        <input type="checkbox" name="broadcasting-now">
    </div>
    <div class="panel-body channels_container">
        <div id="channels_wrap">
            <?php
                foreach($channels as $channel)
                        {
                                    echo $this->render('channel',['title'=>$channel->title,'description'=>$channel->description,'category_id'=>$channel->category_id]);
                        }
            ?>
        </div>
    </div>
</div>