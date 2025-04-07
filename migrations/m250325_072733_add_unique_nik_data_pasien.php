<?php

use yii\db\Migration;

/**
 * Class m250325_072733_add_unique_nik_data_pasien
 */
class m250325_072733_add_unique_nik_data_pasien extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Matikan pemeriksaan foreign key sementara
        $this->execute('SET FOREIGN_KEY_CHECKS=0;');

        // Ubah kolom nik menjadi BIGINT, NOT NULL, dan UNIQUE
        $this->alterColumn('data_pasien', 'nik', $this->bigInteger()->notNull()->unique());

        // Aktifkan kembali pemeriksaan foreign key
        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250325_072733_add_unique_nik_data_pasien cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250325_072733_add_unique_nik_data_pasien cannot be reverted.\n";

        return false;
    }
    */
}
