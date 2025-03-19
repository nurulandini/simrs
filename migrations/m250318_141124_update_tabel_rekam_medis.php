<?php

use yii\db\Migration;

/**
 * Class m250318_141124_update_tabel_rekam_medis
 */
class m250318_141124_update_tabel_rekam_medis extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('data_rekam_medis', 'status', $this->tinyInteger(1)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250318_141124_update_tabel_rekam_medis cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250318_141124_update_tabel_rekam_medis cannot be reverted.\n";

        return false;
    }
    */
}
