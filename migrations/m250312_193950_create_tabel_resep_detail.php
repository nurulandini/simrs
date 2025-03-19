<?php

use yii\db\Migration;

/**
 * Class m250312_193950_create_tabel_resep_detail
 */
class m250312_193950_create_tabel_resep_detail extends Migration
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
                'data_resep_detail',
                [
                    'id' => $this->PrimaryKey(),
                    'rekam_medis_id' => $this->integer()->null(),
                    'obat_id' => $this->integer()->null(),
                    'dosis' => $this->string(50)->null(),
                    'jumlah' => $this->integer()->null(),
                    'biaya' => $this->integer()->null(),
                    'instruksi' => $this->text()->null(),
                    'status' => $this->tinyInteger(1)->null(), // Status resep: "Menunggu", "Diproses", "Selesai", "Dibatalkan"
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_data_resep_detail_dan_rekam_medis',
                '{{%data_resep_detail}}',
                ['rekam_medis_id'],
                '{{%data_rekam_medis}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'relasi_data_resep_detail_dan_obat',
                '{{%data_resep_detail}}',
                ['obat_id'],
                '{{%data_obat}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );


            $this->addForeignKey(
                'FK_creted_by_data_resep_detail',
                '{{%data_resep_detail}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_resep_detail',
                '{{%data_resep_detail}}',
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
        echo "m250312_193950_create_tabel_resep_detail cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_193950_create_tabel_resep_detail cannot be reverted.\n";

        return false;
    }
    */
}
