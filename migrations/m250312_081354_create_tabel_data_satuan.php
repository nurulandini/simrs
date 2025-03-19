<?php

use yii\db\Migration;

/**
 * Class m250312_081354_create_tabel_data_satuan
 */
class m250312_081354_create_tabel_data_satuan extends Migration
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
                'data_satuan',
                [
                    'id' => $this->PrimaryKey(),
                    'satuan' => $this->string(100)->notNull(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->createIndex('satuan', '{{%data_satuan}}', 'satuan', false);

            $this->addForeignKey(
                'FK_creted_by_data_satuan',
                '{{%data_satuan}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_satuan',
                '{{%data_satuan}}',
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
        echo "m250312_081354_create_tabel_data_satuan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_081354_create_tabel_data_satuan cannot be reverted.\n";

        return false;
    }
    */
}
