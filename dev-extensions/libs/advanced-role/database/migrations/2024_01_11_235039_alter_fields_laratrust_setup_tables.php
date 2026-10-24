<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                if (!Schema::hasColumn('members', 'department_id')) {
                    $table->unsignedBigInteger('department_id')->nullable()->after('remember_token')->comment('move tạm Bên MSSQL cũ là Nguoi_Su_Dung.MaKhoa, Mã Khoa cấp cứu (emergency department - ED)');
                    $table->foreign('department_id')->references('id')->on('app_departments')
                        ->onUpdate('cascade')->nullOnDelete();
                }
                if (!Schema::hasColumn('members', 'last_login')) {
                    $table->timestamp('last_login')->nullable();
                }
                if (!Schema::hasColumn('members', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
        if (Schema::hasTable('app_permissions')) {
            Schema::table('app_permissions', function (Blueprint $table) {
                if (!Schema::hasColumn('app_permissions', 'alias')) {
                    $table->json('alias')->nullable()->after('description')->default('{}')->comment('eg: {"remove","restore","for_delete"}, nhóm các hành vi liên quan hoặc giống nhau về mặt logic sử dụng');
                }
                if (!Schema::hasColumn('app_permissions', 'allowed_scopes')) {
                    $table->json('allowed_scopes')->nullable()->after('description')->default('{}')->comment('eg: {"local","none"}, để xác định các scopes cho phép sử dụng trên mỗi permission');
                }
                if (!Schema::hasColumn('app_permissions', 'reference_type')) {
                    $table->string('reference_type', 191)->nullable()->after('description')->comment('Áp dụng cho Entity (Resource), hoặc có thể quản lý theo dạng plugin_id/module_id');
                }
            });
        }
        if (Schema::hasTable('app_roles')) {
            Schema::table('app_roles', function (Blueprint $table) {
                if (!Schema::hasColumn('app_roles', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
        if (Schema::hasTable('app__role_members')) {
            Schema::table('app__role_members', function (Blueprint $table) {
                if (!Schema::hasColumn('app__role_members', 'member_id')) {
                    $table->foreign('member_id')->references('id')->on('members')
                        ->onUpdate('cascade')->onDelete('cascade');
                }

                if (!Schema::hasColumn('app__role_members', 'created_at')) {
                    $table->timestamps();
                }
            });
        }

        if (Schema::hasTable('app_departments')) {
            Schema::table('app_departments', function (Blueprint $table) {
                $this->listTableForeignKeys('app_departments');
                $this->listTableIndexes('app_departments');

                if (Schema::hasColumn('app_departments', 'name')) {
                    $table->string('name')->unique()->comment("Sử dụng như Unique Code của Team, theo concept của gói phân quyền Laratrust")->change();
                }

                if (!Schema::hasColumn('app_departments', 'author_id')) {
                    $table->string('author_type')->nullable()->after('description');
                    $table->unsignedBigInteger('author_id')->nullable()->after('description');
                }
                if (!Schema::hasColumn('app_departments', 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable()->after('description');
                    $table->foreign('parent_id')
                        ->references('id')->on('app_departments')
                        ->cascadeOnUpdate()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('app_departments', 'display_name')) {
                    $table->string('display_name')->nullable()->after('name');
                }
                if (!Schema::hasColumn('app_departments', 'description')) {
                    $table->string('description')->nullable()->after('display_name');
                }
                if (!Schema::hasColumn('app_departments', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }

        if (Schema::hasTable('app__permission_roles')) {
            Schema::table('app__permission_roles', function (Blueprint $table) {
                if (!Schema::hasColumn('app__permission_roles', 'scope')) {
                    $table->enum('scope', ['none', 'basic', 'local', 'deep', 'global'])->nullable();
                    $table->foreign('scope')->references('name')->on('app_permission_scopes')
                        ->onUpdate('cascade')->onDelete('cascade');
                }
                if (!Schema::hasColumn('app__permission_roles', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
        if (Schema::hasTable('app__permission_members')) {
            Schema::table('app__permission_members', function (Blueprint $table) {
                if (!Schema::hasColumn('app__permission_members', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

    public function listTableForeignKeys($table)
    {
        return array_map(function ($key) {
            return $key['name'];
        }, Schema::getForeignKeys($table));
    }

    public function listTableIndexes($table)
    {
        return array_map(function ($key) {
            return $key['name'];
        }, Schema::getIndexes($table));
    }
};
