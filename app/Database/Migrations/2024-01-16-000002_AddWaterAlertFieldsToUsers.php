<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWaterAlertFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'last_water_alert_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'alert_min_probability'
            ],
            'last_water_alert_level' => [
                'type' => 'ENUM',
                'constraint' => ['none', 'alert', 'alarm', 'critical'],
                'default' => 'none',
                'null' => true,
                'after' => 'last_water_alert_date'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'last_water_alert_date');
        $this->forge->dropColumn('users', 'last_water_alert_level');
    }
}
