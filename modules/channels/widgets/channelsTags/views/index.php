<?php
use app\modules\channels\widgets\channelsTags\ChannelsTagsAsset;
use app\assets\BootstrapTagsAsset;
use app\assets\TypeaheadAsset;

TypeaheadAsset::register($this);
ChannelsTagsAsset::register($this);
BootstrapTagsAsset::register($this);

?>
<div id="channels_tags_container">
    <label for="channel_tags"><?=$label?></label>
        <input id="channel_tags" type="text" value=""  style="width:200px" >
</div>