<?php

use yii\db\Migration;

/**
 * Class m250313_045417_create_tabel_rekam_medis_detail
 */
class m250313_045417_create_tabel_rekam_medis_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = $this->getDb(); // Ambil koneksi database
        $transaction = $db->beginTransaction(); // Mulai transaksi

        try {
            $this->createTable(
                'rekam_medis_detail',
                [
                    'id' => $this->PrimaryKey(),
                    'rekam_medis_id' => $this->integer()->null(),
                    'layanan_id' => $this->integer()->null(),
                    'biaya' => $this->integer()->null(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_rekam_medis_detail_dan_rekam_medis',
                '{{%rekam_medis_detail}}',
                ['rekam_medis_id'],
                '{{%data_rekam_medis}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'relasi_rekam_medis_detail_dan_layanan',
                '{{%rekam_medis_detail}}',
                ['layanan_id'],
                '{{%layanan_medis}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );


            $this->addForeignKey(
                'FK_creted_by_rekam_medis_detail',
                '{{%rekam_medis_detail}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_rekam_medis_detail',
                '{{%rekam_medis_detail}}',
                ['updated_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack(); // Batalkan perubahan jika ada error
            throw $e; // Lempar error agar Yii2 menampilkan pesan kesalahan
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250313_045417_create_tabel_rekam_medis_detail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250313_045417_create_tabel_rekam_medis_detail cannot be reverted.\n";

        return false;
    }
    */
}
