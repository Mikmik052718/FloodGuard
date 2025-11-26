<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhoneAndSmsFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'email'
            ],
            'alert_sms_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'alert_email_enabled'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['phone', 'alert_sms_enabled']);
    }
}
