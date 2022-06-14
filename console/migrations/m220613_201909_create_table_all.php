<?php

use yii\db\Migration;

/**
 * Class m220613_201909_create_table_all
 */
class m220613_201909_create_table_all extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('user','fullName',$this->string(255));
        $this->addColumn('user','tg_user_id',$this->integer());
        $this->addColumn('user','tg_chat_id',$this->integer());
        $this->addColumn('user','tg_phone',$this->string(255));
        $this->addColumn('user','money',$this->integer());


        $this->createTable('rules',[
            'id'=>$this->primaryKey(),
            'description'=>$this->text()->null(),
            'created_at'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null()
        ]);


        $this->createTable('contact',[
            'id'=>$this->primaryKey(),
            'description'=>$this->text()->null(),
            'tg_chat_id'=>$this->integer()->null(),
            'created_at'=>$this->integer()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user','fullName');
        $this->dropColumn('user','tg_user_id');
        $this->dropColumn('user','tg_chat_id');
        $this->dropColumn('user','tg_phone');
        $this->dropColumn('user','money');
        $this->dropTable('rules');
        $this->dropTable('contact');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220613_201909_create_table_all cannot be reverted.\n";

        return false;
    }
    */
}
