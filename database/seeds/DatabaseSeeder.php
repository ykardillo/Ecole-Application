<?php

use Illuminate\Database\Seeder;
use App\Model\Cours;
use App\Database\Seeds\CourssTableSeeder;
 

class DatabaseSeeder extends Seeder {

    public function run()
    {
        $this->call('CourssTableSeeders');

        $this->command->info('User table seeded!');
    }

}

class CourssTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    }
}
