<?php

use yii\db\Migration;

/**
 * Class m250315_025123_add_FK_tabel_data_pendaftaran_pasien
 */
class m250315_025123_add_FK_tabel_data_pendaftaran_pasien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'data_pendaftaran_pasien_dan_pasien',
            '{{%data_pendaftaran_pasien}}',
            ['pasien_id'],
            '{{%data_pasien}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250315_025123_add_FK_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250315_025123_add_FK_tabel_data_pendaftaran_pasien cannot be reverted.\n";

        return false;
    }
    */
}
