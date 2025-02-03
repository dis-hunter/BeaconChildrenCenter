<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BehaviourAssessment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            //Static
            genderSeeder::class,
            rolesSeeder::class,
            relationshipsSeeder::class,
            visit_typeSeeder::class,
            specializationSeeder::class,
            triage_assessmentSeeder::class,
            payment_modesSeeder::class,
            //Dynamic
            ParentsSeeder::class,
            ChildSeeder::class,
            child_parentSeeder::class,
            StaffSeeder::class,
            AppointmentSeeder::class,
            VisitSeeder::class,
            TriageSeeder::class,
            DevMilestonesSeeder::class,
            BehaviourAssessmentSeeder::class,
            FamSocialHistorySeeder::class,
            cnsSeeder::class,
            DevelopmentAssessmentSeeder::class,
            PastMedHistorySeeder::class,
            PerinatalHistorySeeder::class,
            PaymentsTableSeeder::class,
            StaffLeaveSeeder::class,

        ]);
    }
}
