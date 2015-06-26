<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:56
 */
namespace app\modules\channels\widgets\channelsTags;

use yii\base\Widget;

class ChannelsTags extends Widget
{
    public $label = '';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('index',['label' => $this->label]);
    }
}