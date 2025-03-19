<?php

use yii\db\Migration;

/**
 * Class m250312_075748_create_tabel_wilayah_kelurahan
 */
class m250312_075748_create_tabel_wilayah_kelurahan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = $this->getDb(); // Ambil koneksi database
        $transaction = $db->beginTransaction(); // Mulai transaksi

        try {
            $this->createTable('wilayah_kelurahan', [
                'id' => $this->PrimaryKey(),
                'kecamatan_id' => $this->integer()->notNull(),
                'kd_kelurahan' => $this->tinyInteger(4)->notNull(),
                'kelurahan' => $this->string(255)->notNull(),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
                'created_by' => $this->integer()->null(),
                'updated_by' => $this->integer()->null(),
            ]);

            $this->addForeignKey(
                'wilayah_kelurahan_ibfk_1',
                '{{%wilayah_kelurahan}}',
                ['kecamatan_id'],
                '{{%wilayah_kecamatan}}',
                ['id'],
                'CASCADE',
                'CASCADE'
    
            );

            $this->addForeignKey(
                'FK_created_by_wilayah_kelurahan',
                '{{%wilayah_kelurahan}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_wilayah_kelurahan',
                '{{%wilayah_kelurahan}}',
                ['updated_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack(); // Batalkan perubahan jika ada errorcls
            throw $e; // Lempar error agar Yii2 menampilkan pesan kesalahan
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250312_075748_create_tabel_wilayah_kelurahan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_075748_create_tabel_wilayah_kelurahan cannot be reverted.\n";

        return false;
    }
    */
}
