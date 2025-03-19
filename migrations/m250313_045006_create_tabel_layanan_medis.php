<?php

use yii\db\Migration;

/**
 * Class m250313_045006_create_tabel_layanan_medis
 */
class m250313_045006_create_tabel_layanan_medis extends Migration
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
                'layanan_medis',
                [
                    'id' => $this->PrimaryKey(),
                    'layanan' => $this->string(100)->notNull(),
                    'deskripsi' => $this->text()->null(),
                    'biaya' => $this->integer()->notNull(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'FK_creted_by_layanan_medis',
                '{{%layanan_medis}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_layanan_medis',
                '{{%layanan_medis}}',
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
        echo "m250313_045006_create_tabel_layanan_medis cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250313_045006_create_tabel_layanan_medis cannot be reverted.\n";

        return false;
    }
    */
}
