<?php

use yii\db\Migration;

/**
 * Class m250314_212950_update_tabel_data_pegawai
 */
class m250314_212950_update_tabel_data_pegawai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('data_pegawai', 'nip', $this->string(25)->unique()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250314_212950_update_tabel_data_pegawai cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250314_212950_update_tabel_data_pegawai cannot be reverted.\n";

        return false;
    }
    */
}
