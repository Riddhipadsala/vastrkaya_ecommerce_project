<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(
                "
                    CREATE TRIGGER after_product_stock_update
                    AFTER UPDATE ON products
                    FOR EACH ROW
                    BEGIN
                        if old.stock <> new.stock then
                            insert into product_stock_logs(
                                product_id, old_stock, new_stock, difference, changed_at
                            )
                            VALUES(
                                old.id, old.stock, new.stock, (CAST(NEW.stock AS SIGNED) - CAST(OLD.stock AS SIGNED)), now()   
                            );
                        end if;
                    END;
                "
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_product_stock_update;");
    }
};
