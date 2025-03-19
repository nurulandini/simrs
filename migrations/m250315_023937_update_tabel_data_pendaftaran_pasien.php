<?php

use yii\db\Migration;

/**
 * Class m250315_023937_update_tabel_data_pendaftaran_pasien
 */
class m250315_023937_update_tabel_data_pendaftaran_pasien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('data_pendaftaran_pasien', 'tanggal_kunjungan', $this->date()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250315_023937_update_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250315_023937_update_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }
    */
}
