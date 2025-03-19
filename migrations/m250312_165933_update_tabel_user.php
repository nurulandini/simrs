<?php

use yii\db\Migration;

/**
 * Class m250312_165933_update_tabel_user
 */
class m250312_165933_update_tabel_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'pegawai_id', $this->integer()->null());

        $this->addForeignKey(
            'relasi_pegawai',
            '{{%user}}',
            ['pegawai_id'],
            '{{%data_pegawai}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250312_165933_update_tabel_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_165933_update_tabel_user cannot be reverted.\n";

        return false;
    }
    */
}
