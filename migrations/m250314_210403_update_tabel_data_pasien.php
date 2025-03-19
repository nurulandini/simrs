<?php

use yii\db\Migration;

/**
 * Class m250314_210403_update_tabel_data_pasien
 */
class m250314_210403_update_tabel_data_pasien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('data_pasien', 'nik', $this->string(25)->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250314_210403_update_tabel_data_pasien cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250314_210403_update_tabel_data_pasien cannot be reverted.\n";

        return false;
    }
    */
}
