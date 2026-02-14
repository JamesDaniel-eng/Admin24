<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class InventoryV4124 extends Migration
{
    protected function prefixed(string $table): string
    {
        return DB::getTablePrefix() . $table;
    }

    public function up()
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite does not support: modifying column types (MODIFY)
            return;
        }

        // Laravel does not always allow direct modifications on existing double columns.
        // Therefore, the type updates were applied via raw SQL. The code below is provided as an example only.
        // Schema::table('inventory_adjustment_items', function (Blueprint $table) {
        //     $table->double('item_quantity', 12, 2)->change();
        //     $table->double('adjusted_quantity', 12, 2)->change();
        // });

        DB::statement("ALTER TABLE {$this->prefixed('inventory_adjustment_items')} MODIFY item_quantity DOUBLE(12,2) NOT NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_adjustment_items')} MODIFY adjusted_quantity DOUBLE(12,2) NOT NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_document_items')} MODIFY quantity DOUBLE(12,2) NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_histories')} MODIFY quantity DOUBLE(12,2) NOT NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_items')} MODIFY opening_stock DOUBLE(12,2) NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_items')} MODIFY opening_stock_value DOUBLE(12,2) NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_items')} MODIFY reorder_level DOUBLE(12,2) NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_transfer_order_items')} MODIFY item_quantity DOUBLE(12,2) NOT NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_transfer_order_items')} MODIFY transfer_quantity DOUBLE(12,2) NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_transfer_orders')} MODIFY transfer_quantity DOUBLE(12,2) NULL");

        Schema::dropIfExists('inventory_bill_items');
        Schema::dropIfExists('inventory_invoice_items');
        Schema::dropIfExists('inventory_manufacturers');
        Schema::dropIfExists('inventory_manufacturer_items');
        Schema::dropIfExists('inventory_manufacturer_vendors');
        Schema::dropIfExists('inventory_warehouse_items');
    }

    public function down()
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite does not support: modifying column types (MODIFY)
            return;
        }

        DB::statement("ALTER TABLE {$this->prefixed('inventory_adjustment_items')} MODIFY item_quantity INT NOT NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_adjustment_items')} MODIFY adjusted_quantity INT NOT NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_document_items')} MODIFY quantity DOUBLE(7,2) NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_histories')} MODIFY quantity DOUBLE(7,2) NOT NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_items')} MODIFY opening_stock DOUBLE(7,2) NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_items')} MODIFY opening_stock_value DOUBLE(7,2) NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_items')} MODIFY reorder_level DOUBLE(7,2) NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_transfer_order_items')} MODIFY item_quantity INT NOT NULL");
        DB::statement("ALTER TABLE {$this->prefixed('inventory_transfer_order_items')} MODIFY transfer_quantity DOUBLE(7,2) NULL");

        DB::statement("ALTER TABLE {$this->prefixed('inventory_transfer_orders')} MODIFY transfer_quantity DOUBLE(7,2) NULL");
    }
}
