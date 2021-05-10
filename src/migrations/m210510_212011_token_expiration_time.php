<?php

namespace melvilleco\instagrambasicdisplay\migrations;

use Craft;
use craft\db\Migration;

/**
 * m210510_212011_token_expiration_time migration.
 */
class m210510_212011_token_expiration_time extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('instagram_access_token', 'token_expiration_time', $this->dateTime());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m210510_212011_token_expiration_time cannot be reverted.\n";
        return false;
    }
}
