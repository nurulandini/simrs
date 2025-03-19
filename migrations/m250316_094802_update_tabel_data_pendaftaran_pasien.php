<?php

use yii\db\Migration;

/**
 * Class m250316_094802_update_tabel_data_pendaftaran_pasien
 */
class m250316_094802_update_tabel_data_pendaftaran_pasien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('data_pendaftaran_pasien', 'status', $this->tinyInteger(1)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250316_094802_update_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250316_094802_update_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }
    */
}
