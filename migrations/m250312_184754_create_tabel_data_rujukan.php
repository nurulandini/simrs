<?php

use yii\db\Migration;

/**
 * Class m250312_184754_create_tabel_data_rujukan
 */
class m250312_184754_create_tabel_data_rujukan extends Migration
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
                'data_rujukan',
                [
                    'id' => $this->PrimaryKey(),
                    'rekam_medis_id' => $this->integer()->null(),
                    'rumah_sakit' => $this->text()->null(),
                    'catatan' => $this->text()->null(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_data_rujukan_dan_rekam_medis',
                '{{%data_rujukan}}',
                ['rekam_medis_id'],
                '{{%data_rekam_medis}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );


            $this->addForeignKey(
                'FK_creted_by_data_rujukan',
                '{{%data_rujukan}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_rujukan',
                '{{%data_rujukan}}',
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
        echo "m250312_184754_create_tabel_data_rujukan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_184754_create_tabel_data_rujukan cannot be reverted.\n";

        return false;
    }
    */
}
