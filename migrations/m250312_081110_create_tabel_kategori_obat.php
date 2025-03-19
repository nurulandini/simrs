<?php

use yii\db\Migration;

/**
 * Class m250312_081110_create_tabel_kategori_obat
 */
class m250312_081110_create_tabel_kategori_obat extends Migration
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
                'kategori_obat',
                [
                    'id' => $this->PrimaryKey(),
                    'kategori' => $this->string(100)->notNull(), // alat medis, tablet, kapsul, dll
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'FK_creted_by_kategori_obat',
                '{{%kategori_obat}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_kategori_obat',
                '{{%kategori_obat}}',
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
        echo "m250312_081110_create_tabel_kategori_obat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_081110_create_tabel_kategori_obat cannot be reverted.\n";

        return false;
    }
    */
}
