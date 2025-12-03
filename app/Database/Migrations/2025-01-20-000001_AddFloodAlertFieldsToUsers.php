<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFloodAlertFieldsToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'last_flood_alert_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'last_water_alert_level'
            ],
            'last_flood_alert_probability' => [
                'type' => 'DECIMAL',
                'constraint' => '10,4',
                'null' => true,
                'after' => 'last_flood_alert_date'
            ]
        ];
        
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['last_flood_alert_date', 'last_flood_alert_probability']);
    }
}
