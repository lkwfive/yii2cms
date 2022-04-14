<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $url
 * @property string $image
 * @property integer $isShow
 * @property string $target 
 */
class Menu extends \yii\db\ActiveRecord
{
    public static $targets = [
        '_self'=>'_self',
        '_blank'=>'_blank'
    ];

    private static $_image_type = ['image'];

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            foreach (self::$_image_type as $v) {
                $this->$v = json_encode(H::getImagesAttrbutes($this->$v));
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        foreach (self::$_image_type as $v) {
            $this->$v = json_decode($this->$v, true);
        }
    }

    public function backendData()
    {
        $this->afterFind();
        foreach (self::$_image_type as $v) {
            $this->$v = H::gentImagesContent($this->$v);
        }
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['lft', 'rgt', 'depth', 'isShow'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['url', 'image'], 'string', 'max' => 255],
            [['target'], 'string', 'max' => 16],
            [['name', 'url'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
            'url' => 'Url',
            'image' => 'Image',
            'isShow' => 'Is Show',
            'target' => 'target',
        ];
    }

    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public static function getAllData()
    {
        return self::find()->orderBy('lft')->all();
    }

    public static function getAllDataTree()
    {
        $data = self::find()->where(['>','depth',0])->orderBy('lft')->all();
        $r=[];
        foreach ($data as $v) {
            $v->afterFind();
            $r[] = $v->attributes;
        }
        return self::toHierarchy($r);
    }

    /**
     * 生成树状数组
     * @param  [type] $collection [description]
     * @return [type]             [description]
     */
    public static function toHierarchy($collection) {
        // Trees mapped
        $trees = array();
        $l = 0;
        if (count($collection) > 0) {
            // Node Stack. Used to help building the hierarchy
            $stack = array();
            foreach ($collection as $node) {
                $item = $node;
                $item['children'] = array();
                // Number of stack items
                $l = count($stack);
                // Check if we're dealing with different levels
                while($l > 0 && $stack[$l - 1]['depth'] >= $item['depth']) {
                    array_pop($stack);
                    $l--;
                }
                // Stack is empty (we are inspecting the root)
                if ($l == 0) {
                    // Assigning the root node
                    $i = count($trees);
                    $trees[$i] = $item;
                    $stack[] = & $trees[$i];
                    } else {
                    // Add node to parent
                    $i = count($stack[$l - 1]['children']);
                    $stack[$l - 1]['children'][$i] = $item;
                    $stack[] = & $stack[$l - 1]['children'][$i];
                }
            }
        }
        return $trees;
    }
}
