<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\H;
use yii\helpers\Json;

/**
* 
*/
class SettingSiteForm extends Model
{
    public $title;
    public $keywords;
    public $description;

    public $qrCode;
    public $copyright;
    public $code;
    public $links;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'keywords', 'links', 'description', 'code', 'qrCode'], 'safe'],
            // ['contactEmail', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '网站标题',
            'keywords' => '网站关键词',
            'description' => '网址描述',
            'qrCode' => '图片',
            'copyright' => '版权信息',
            'code' => '各类代码',
            'links' => '友情链接',
        ];
    }

    public function init()
    {
        parent::init();
        $data = $this->getData();
        if($data){
            $data['qrCode'] = H::gentImagesContent($data['qrCode']);
            $this->attributes = $data;
        }
    }

    public function save()
    {
        if ($this->validate()) {
            $this->qrCode = H::getImagesAttrbutes($this->qrCode);
            Yii::$app->settings->set('setting.site', Json::encode($this->attributes));
            return true;
        }
        return false;
    }

    public static function getData()
    {
        $data = Yii::$app->settings->get('setting.site');
        if($data)
            $data['qrCode'] = Json::decode($data['qrCode'], true);
            return $data;
        return [];
    }

}