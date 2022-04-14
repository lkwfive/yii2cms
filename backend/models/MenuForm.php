<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\H;
use common\models\Menu;

/**
* 
*/
class MenuForm extends Model
{
    public $parent=1;
    public $name;
    public $url;
    public $image;
    public $target;
    public $isShow=1;

    public $parents;
    public $disabled;

    public $menu;

    private $_oldParent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent','name', 'url'], 'required'],
            [['isShow','parent'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['url', 'image'], 'string', 'max' => 255],
            [['target'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => '上级分类',
            'name' => '名称',
            'url' => 'Url',
            'image' => '图片 （最佳像素220*220）',
            'isShow' => '是否显示',
            'target' => '新页面跳转',
        ];
    }

    public function init()
    {
        $menus = Menu::getAllData();
        foreach ($menus as $model) {
            if($model->depth==0)
                $name = $model->name;
            else
                $name = '|'.str_repeat("----", $model->depth).$model->name;
            $this->parents[$model->id] = $name;
        }
    }

    public function laodMenu($menu)
    {
        $this->menu = $menu;
        $this->attributes = $menu->attributes;
        $parent = $menu->parents(1)->one();
        $this->parent = $parent->id;
        $this->_oldParent = $parent->id;
    }

    public function save()
    {
        if ($this->validate()) {
            $model = $this->menu ? $this->menu : new Menu();
            $model->attributes = $this->attributes;
            if($this->parent==$this->_oldParent){
                return $model->save();
            }else if($this->parent){
                $parent = Menu::findOne($this->parent);
                return $model->appendTo($parent);
            }
            return false;
        }
        return false;
    }
}