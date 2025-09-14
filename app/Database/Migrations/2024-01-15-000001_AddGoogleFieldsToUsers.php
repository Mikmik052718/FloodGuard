<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'unique' => true,
                'after' => 'email'
            ],
            'google_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'google_id'
            ],
            'google_picture' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'google_name'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['google_id', 'google_name', 'google_picture']);
    }
}
