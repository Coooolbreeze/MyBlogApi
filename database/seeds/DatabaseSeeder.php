<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTablesSeeder::class,
            UsersTableSeeder::class,
            UserAuthsTableSeeder::class,
            ImagesTableSeeder::class,
            CacheFlushSeeder::class,
        ]);
    }
}
