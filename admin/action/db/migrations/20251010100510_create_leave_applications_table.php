<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLeaveApplicationsTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tbl_leave_applications');
        $table
            ->addColumn('uuid', 'char', ['length' => 36])
            ->addColumn('employee_id', 'integer')
            ->addColumn('leave_type', 'enum', ['values' => ['sick','casual','annual','other']])
            ->addColumn('start_date', 'date')
            ->addColumn('end_date', 'date')
            ->addColumn('reason', 'text')
            ->addColumn('status_id', 'integer', ['limit' => 1, 'default' => 0])
            ->addColumn('approved_by', 'integer', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('created_by', 'integer', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('updated_by', 'integer', ['null' => true])
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->addColumn('deleted_by', 'integer', ['null' => true])
            // ->addForeignKey('employee_id', 'tbl_employees', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addIndex(['uuid'], ['unique' => true])
            ->create();
    }

    public function down(): void
    {
        $this->table('tbl_leave_applications')->drop()->save();
    }
}
