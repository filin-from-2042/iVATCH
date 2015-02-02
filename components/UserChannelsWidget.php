<?php
namespace app\components;

use yii\base\Widget;
use app\components\DummyImageWidget;
use yii\helpers\Html;

class UserChannelsWidget extends Widget{
    public $dataProvider;
    public $out;

    public function init()
    {
        parent::init();
        if ($this->dataProvider!=false)
        {
            $out='';
            foreach ($this->dataProvider as $single_channel)
            {
                $out .= '<div class="row single-channel">';
                    // Image
                    if (isset($single_channel['image_path']) && $single_channel['image_path']!=false)
                    {
                        $out .= '<div class="col-lg-3">' . Html::img(isset($single_channel['image_path'])?$single_channel['image_path']:'###', ['alt' => 'some', 'class' => 'img-responsive']) . '</div>';
                    }
                    else {$out .=''.DummyImageWidget::widget(['cols'=>'col-lg-3 col-md-3 col-sm-12 col-xs-12']) .'';}

                    // Title and Description
                    $out .= '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">';
                        $out .= '<div class="row channel-title"><h3>'.  $single_channel['title'].'</h3></div>';
                        $out .= '<div class="row channel-desc"><p>'. $single_channel['description'] .'</p></div>';
                    $out .='</div>';

                $out .= '</div>';
                $out .= '<br>';

            }

            $this->out = $out;
        }
    }

    public function run(){
        return ($this->out);
    }
}
?>