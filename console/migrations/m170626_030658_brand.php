<?php

use yii\db\Migration;

class m170626_030658_brand extends Migration
{
    public function safeUp()
    {
            $this->createTable('{{%brand}}',[
                'id'=>$this->primaryKey(11)->unsigned()->comment('id自正'),
             'name'=>$this->string(50)->notNull()->defaultValue("")->comment('品牌名'),
               'logo'=>$this->string(250)->notNull()->defaultValue("")->comment('logo路劲'),
              'introduce'=>$this->string(250)->notNull()->defaultValue("")->comment('品牌描述'),
      'sort_num'=>$this->integer(11)->notNull()->defaultValue(0)->unsigned()->comment('排序'),
               'status'=>$this->smallInteger(1)->notNull()->defaultValue(0)->comment('状态'),
                    'create_time'=>$this->integer(10)->notNull()->defaultValue(0)->comment('创建时间'),
                ],"ENGINE=InnoDB,charset=utf8,comment='用户基本信息表'"

            );

    }

    public function safeDown()
    {
        echo "m170626_030658_brand cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170626_030658_brand cannot be reverted.\n";

        return false;
    }
    */
}
