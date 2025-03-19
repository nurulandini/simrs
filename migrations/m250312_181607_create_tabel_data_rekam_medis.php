<?php

use yii\db\Migration;

/**
 * Class m250312_181607_create_tabel_data_rekam_medis
 */
class m250312_181607_create_tabel_data_rekam_medis extends Migration
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
                'data_rekam_medis',
                [
                    'id' => $this->PrimaryKey(),
                    'skrinning_id' => $this->integer()->notNull(),
                    'diagnosa' => $this->text()->notNull(),
                    'catatan' => $this->text()->null(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_data_rekam_medis_dan_skrinning',
                '{{%data_rekam_medis}}',
                ['skrinning_id'],
                '{{%data_skrinning}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_creted_by_data_rekam_medis',
                '{{%data_rekam_medis}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_rekam_medis',
                '{{%data_rekam_medis}}',
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
        echo "m250312_181607_create_tabel_data_rekam_medis cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_181607_create_tabel_data_rekam_medis cannot be reverted.\n";

        return false;
    }
    */
}
