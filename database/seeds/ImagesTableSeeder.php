<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Image::saveAll([
            ['name' => 'avatar.jpg', 'src' => 'images/B7fjNifSylmUBiY6u40MDXqfwrENrl3GatyEPioj.jpeg'],
        ]);
    }
}
