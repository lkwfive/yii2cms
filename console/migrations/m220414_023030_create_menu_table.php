<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m220414_023030_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            //'tree' => $this->integer()->notNull(),  //多根目录
            'lft' => $this->integer(10)->notNull(),
            'rgt' => $this->integer(10)->notNull(),
            'depth' => $this->integer(10)->notNull(),
            'name' => $this->string(64)->notNull(),
            'url' => $this->string(255)->notNull(),
            'image' => $this->string(255),
            'isShow' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'target' => $this->string(16)->notNull()->defaultValue('_self'),
        ]);

        $this->insert('{{%menu}}', [
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'name' => 'root',
            'url' => 'null',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%menu}}');
    }
}
