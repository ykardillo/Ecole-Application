<?php

use App\Model\Cours;
use Illuminate\Database\Seeder;

class CourssTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = [
            [
                'id'         => 1,
                'class_id'   => 1,
                'weekday'    => 1,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 2,
                'class_id'   => 1,
                'weekday'    => 1,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 3,
                'class_id'   => 1,
                'weekday'    => 1,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 4,
                'class_id'   => 2,
                'weekday'    => 1,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 5,
                'class_id'   => 1,
                'weekday'    => 2,
                'start_time' => '08:00',
                'end_time'   => '10:00',
            ],
            [
                'id'         => 6,
                'class_id'   => 1,
                'weekday'    => 2,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 7,
                'class_id'   => 1,
                'weekday'    => 2,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 8,
                'class_id'   => 1,
                'weekday'    => 3,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 9,
                'class_id'   => 1,
                'weekday'    => 3,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 10,
                'class_id'   => 1,
                'weekday'    => 3,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 11,
                'class_id'   => 1,
                'weekday'    => 4,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 12,
                'class_id'   => 1,
                'weekday'    => 4,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
            [
                'id'         => 13,
                'class_id'   => 1,
                'weekday'    => 4,
                'start_time' => '14:00',
                'end_time'   => '16:00',
            ],
            [
                'id'         => 14,
                'class_id'   => 1,
                'weekday'    => 5,
                'start_time' => '08:00',
                'end_time'   => '10:00',
            ],
            [
                'id'         => 15,
                'class_id'   => 1,
                'weekday'    => 5,
                'start_time' => '10:00',
                'end_time'   => '12:00',
            ],
            [
                'id'         => 16,
                'class_id'   => 1,
                'weekday'    => 5,
                'start_time' => '12:00',
                'end_time'   => '14:00',
            ],
        ];

        Cours::insert($lessons);
    }
}
