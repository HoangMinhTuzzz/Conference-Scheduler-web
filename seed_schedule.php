<?php
// seed_schedule.php
require_once __DIR__ . '/models/ScheduleModel.php';

$scheduleModel = new ScheduleModel();

$schedules = [
    [
        'title' => 'Opening Keynote',
        'conference_id' => 'conf1',
        'user_id' => 'admin',
        'time' => '2026-06-01 09:00',
        'location' => 'Main Hall',
    ],
    [
        'title' => 'AI in Education',
        'conference_id' => 'conf1',
        'user_id' => 'admin',
        'time' => '2026-06-01 10:00',
        'location' => 'Room 101',
    ],
    [
        'title' => 'Networking Lunch',
        'conference_id' => 'conf1',
        'user_id' => 'admin',
        'time' => '2026-06-01 12:00',
        'location' => 'Cafeteria',
    ],
    [
        'title' => 'Panel Discussion',
        'conference_id' => 'conf2',
        'user_id' => 'admin',
        'time' => '2026-06-02 14:00',
        'location' => 'Main Hall',
    ],
];

foreach ($schedules as $schedule) {
    $scheduleModel->addSchedule($schedule);
}

echo "Seeded schedules successfully!\n";
