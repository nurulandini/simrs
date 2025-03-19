<?php

use yii\db\Migration;

/**
 * Class m250315_034022_delete_column_status_tabel_data_pendaftaran_pasien
 */
class m250315_034022_delete_column_status_tabel_data_pendaftaran_pasien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{data_pendaftaran_pasien}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250315_034022_delete_column_status_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250315_034022_delete_column_status_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }
    */
}
