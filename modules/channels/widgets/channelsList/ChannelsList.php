<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:56
 */
namespace app\modules\channels\widgets\channelsList;

use yii\base\Widget;
use app\modules\channels\models\Channels;

class ChannelsList extends Widget
{
    public $cTag = '';
    public $order = 'subscribers_count';
    public $direction = 'DESC';
    public $bBroadcasting = false;
    public $nLimit = 49;

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $query = Channels::find();
        $channels = $query->orderBy($this->order.' '.$this->direction)
                            ->limit($this->nLimit)
                            ->all();

        return $this->render('index',['channels'=>$channels,
            'order'=> $this->order,
            'direction'=> $this->direction,
            'broadcasting'=>$this->bBroadcasting]
        );
    }

    public function getFiltering( $cOrder, $cDirection, $bBroadcastingOnly)
    {
        switch($cDirection)
        {
            case 'descending' : $cDirection = 'DESC';break;
            case 'ascending' : $cDirection = 'ASC';break;
        }

//        if($cOrder='default') $cOrder='';$cDirection='';

        $query = Channels::find();
        $channels = $query->orderBy($cOrder.' '.$cDirection)
            ->limit($this->nLimit)
            ->all();

        ob_start();
        foreach($channels as $channel)
        {
            echo $this->render('channel',['title'=>$channel->title,'description'=>$channel->description,'category_id'=>$channel->category_id]);
        }
        $cContent = ob_get_clean();

        return $cContent;
    }


    public function getSegment( $cOrder, $cDirection, $bBroadcastingOnly, $nExistCount )
    {
        switch($cDirection)
        {
            case 'descending' : $cDirection = 'DESC';break;
            case 'ascending' : $cDirection = 'ASC';break;
        }
        $query = Channels::find();
        $channels = $query->orderBy($cOrder.' '.$cDirection)
            ->limit($this->nLimit)
            ->offset($nExistCount)
            ->all();

        ob_start();
        foreach($channels as $channel)
        {
            echo $this->render('channel',['title'=>$channel->title,'description'=>$channel->description,'category_id'=>$channel->category_id]);
        }
        $cContent = ob_get_clean();

        return $cContent;
    }
}