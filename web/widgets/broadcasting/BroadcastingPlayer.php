<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:56
 */
namespace webroot\widgets\broadcasting;

use yii\base\Widget;

class BroadcastingPlayer extends Widget
{
    public function run()
    {

        return $this->render('index');
    }
}