<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses=[
    // Educational Foundations and Counseling Psychology
    [
        'title' => 'Sociology of Education',
        'code' => 'EDU 121',
        'unit' => '2'
    ],
    [
        'title' => 'History of Education',
        'code' => 'EDU 102',
        'unit' => '2'
    ],
    [
        'title' => 'Foundations of Education',
        'code' => 'EDU 103',
        'unit' => '2'
    ],
    [
        'title' => 'Educational Psychology',
        'code' => 'ED 211',
        'unit' => '2'
    ],

    // Curriculum and Instruction
    [
        'title' => 'Curriculum Studies I',
        'code' => 'EDU 221',
        'unit' => '1'
    ],
    [
        'title' => 'Micro-Teaching Practicum',
        'code' => 'EDU 223',
        'unit' => '1'
    ],
    [
        'title' => 'Introduction to Curriculum and Instruction',
        'code' => 'EDU 241',
        'unit' => '3'
    ],
    [
        'title' => 'Curriculum Studies II',
        'code' => 'EDU 322',
        'unit' => '2'
    ],

    // Educational Management
    [
        'title' => 'School Administration and Supervision',
        'code' => 'EME 205',
        'unit' => '3'
    ],
    [
        'title' => 'Demographic Data and Statistics for Educational Management',
        'code' => 'EME 104',
        'unit' => '3'
    ],
    [
        'title' => 'Accounting for School Management',
        'code' => 'EME 305',
        'unit' => '3'
    ],
    [
        'title' => 'Practicum in Educational Management',
        'code' => 'EME 406',
        'unit' => '3'
    ],

    // Science and Technology Education
    [
        'title' => 'Research Methods in Education',
        'code' => 'STE 302',
        'unit' => '3'
    ],
    [
        'title' => 'Introduction to Instructional Technology',
        'code' => 'STE 353',
        'unit' => '3'
    ],
    [
        'title' => 'General Principles of Curriculum and Instruction',
        'code' => 'ASE 303',
        'unit' => '3'
    ],
    [
        'title' => 'Fundamentals of Integrated Science',
        'code' => 'STE 201',
        'unit' => '2'
    ],

    // General Studies Education (GSE)
    [
        'title' => 'Use of English I',
        'code' => 'GNS 101',
        'unit' => '2'
    ],
    [
        'title' => 'Introduction to Information and Communication Technology',
        'code' => 'CIT 111',
        'unit' => '2'
    ],
    [
        'title' => 'Use of Library',
        'code' => 'LIB 101',
        'unit' => '1'
    ],
    [
        'title' => 'Introduction to Entrepreneurship',
        'code' => 'ENT 101',
        'unit' => '2'
    ],

    // Human Kinetic Sports and Health Education
    [
        'title' => 'Introduction to Physical Education',
        'code' => 'HKS 111',
        'unit' => '2'
    ],
    [
        'title' => 'First Aid and Safety Education',
        'code' => 'HKS 223',
        'unit' => '2'
    ],

    // Language Arts and Social Science Education
    [
        'title' => 'Introduction to Social Studies',
        'code' => 'LSS 101',
        'unit' => '2'
    ],
    [
        'title' => 'Methods of Teaching English',
        'code' => 'LSS 213',
        'unit' => '3'
    ],

    // Early Childhood Care and Education
    [
        'title' => 'Child Development',
        'code' => 'ECE 101',
        'unit' => '2'
    ],
    [
        'title' => 'Play and Early Childhood Education',
        'code' => 'ECE 211',
        'unit' => '2'
    ],

    // Special Education
    [
        'title' => 'Introduction to Special Education',
        'code' => 'SPE 101',
        'unit' => '2'
    ],
    [
        'title' => 'Teaching Children with Learning Disabilities',
        'code' => 'SPE 315',
        'unit' => '3'
    ],

    // Library and Information Science
    [
        'title' => 'Introduction to Library Science',
        'code' => 'LIS 101',
        'unit' => '2'
    ],
    [
        'title' => 'Cataloguing and Classification',
        'code' => 'LIS 205',
        'unit' => '3'
    ],

    // Mathematics Education
    [
        'title' => 'Introduction to Mathematics Education',
        'code' => 'MED 101',
        'unit' => '2'
    ],
    [
        'title' => 'Teaching Methods in Mathematics',
        'code' => 'MED 205',
        'unit' => '3'
    ],

    // Guidance and Counselling
    [
        'title' => 'Introduction to Guidance and Counselling',
        'code' => 'GDC 101',
        'unit' => '2'
    ],
    [
        'title' => 'Theories of Counselling',
        'code' => 'GDC 311',
        'unit' => '3'
    ],

    // Vocational and Technical Education
    [
        'title' => 'Introduction to Vocational Education',
        'code' => 'VTE 101',
        'unit' => '2'
    ],
    [
        'title' => 'Curriculum in Technical Education',
        'code' => 'VTE 205',
        'unit' => '3'
    ],

    // Computer Science Education
    [
        'title' => 'Introduction to Computer Education',
        'code' => 'CSE 101',
        'unit' => '2'
    ],
    [
        'title' => 'Instructional Software Design',
        'code' => 'CSE 207',
        'unit' => '3'
    ],

    // Business Studies Education
    [
        'title' => 'Introduction to Business Education',
        'code' => 'BSE 101',
        'unit' => '2'
    ],
    [
        'title' => 'Office Management and Technology',
        'code' => 'BSE 211',
        'unit' => '3'
    ]
    ];

        foreach($courses as $course){
        Course::create($course);
        }

    }
}
