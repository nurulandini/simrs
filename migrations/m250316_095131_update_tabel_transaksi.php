<?php

use yii\db\Migration;

/**
 * Class m250316_095131_update_tabel_transaksi
 */
class m250316_095131_update_tabel_transaksi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('transaksi', 'status', $this->tinyInteger(1)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250316_095131_update_tabel_transaksi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250316_095131_update_tabel_transaksi cannot be reverted.\n";

        return false;
    }
    */
}
