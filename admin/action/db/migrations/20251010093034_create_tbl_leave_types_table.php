<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTblLeaveTypesTable extends AbstractMigration
{
    public function up(): void
    {
        // 1️⃣ Create the table
        $table = $this->table('tbl_leave_types');
        $table
            ->addColumn('uuid', 'char', ['length' => 36])
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('status_id', 'integer', ['limit' => 1, 'default' => 1])
            ->addColumn('created_at', 'datetime')
            ->addColumn('created_by', 'integer', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('updated_by', 'integer', ['null' => true])
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->addColumn('deleted_by', 'integer', ['null' => true])
            ->addIndex(['uuid'], ['unique' => true])
            ->create();

        // 2️⃣ Insert default leave types
        $leaveTypes = [
            [
                'uuid' => bin2hex(random_bytes(16)),
                'name' => 'Sick Leave',
                'description' => 'Leave for illness or medical reasons',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => null,
            ],
            [
                'uuid' => bin2hex(random_bytes(16)),
                'name' => 'Casual Leave',
                'description' => 'Short-term leave for personal reasons',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => null,
            ],
            [
                'uuid' => bin2hex(random_bytes(16)),
                'name' => 'Annual Leave',
                'description' => 'Paid leave granted yearly',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => null,
            ],
            [
                'uuid' => bin2hex(random_bytes(16)),
                'name' => 'Other',
                'description' => 'Other types of leave',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => null,
            ],
        ];

        $this->table('tbl_leave_types')->insert($leaveTypes)->saveData();
    }

    public function down(): void
    {
        $this->table('tbl_leave_types')->drop()->save();
    }
}
