<?php

// config/curriculum.php
//
// Built from CS_Course_List_100-400_Level.md — full ND1-HND2, both
// semesters, 7 courses each. Replace any of these with your real
// department codes/titles if this file ever needs to diverge from
// the standard NBTE ND/HND Computer Science structure.

return [
    'levels' => [
        '100' => [
            'semesters' => [
                'First' => [
                    ['code' => 'GNS 101', 'title' => 'Use of English I', 'units' => 2],
                    ['code' => 'COM 111', 'title' => 'Introduction to Computer Science', 'units' => 3],
                    ['code' => 'COM 112', 'title' => 'Computer Programming I', 'units' => 3],
                    ['code' => 'COM 113', 'title' => 'Digital Electronics', 'units' => 2],
                    ['code' => 'MTH 111', 'title' => 'Elementary Mathematics I', 'units' => 3],
                    ['code' => 'PHY 101', 'title' => 'General Physics I', 'units' => 2],
                    ['code' => 'GNS 103', 'title' => 'Citizenship Education', 'units' => 2],
                ],
                'Second' => [
                    ['code' => 'GNS 102', 'title' => 'Use of English II', 'units' => 2],
                    ['code' => 'COM 121', 'title' => 'Computer Programming II', 'units' => 3],
                    ['code' => 'COM 122', 'title' => 'Data Processing', 'units' => 2],
                    ['code' => 'COM 123', 'title' => 'Introduction to ICT', 'units' => 2],
                    ['code' => 'MTH 121', 'title' => 'Elementary Mathematics II', 'units' => 3],
                    ['code' => 'STA 121', 'title' => 'Statistics I', 'units' => 2],
                    ['code' => 'GNS 104', 'title' => 'Basic Science and Technology', 'units' => 2],
                ],
            ],
        ],

        '200' => [
            'semesters' => [
                'First' => [
                    ['code' => 'COM 211', 'title' => 'Data Structures', 'units' => 3],
                    ['code' => 'COM 212', 'title' => 'Systems Analysis and Design', 'units' => 3],
                    ['code' => 'COM 213', 'title' => 'Operating Systems I', 'units' => 3],
                    ['code' => 'COM 214', 'title' => 'Computer Programming III (OOP)', 'units' => 3],
                    ['code' => 'COM 215', 'title' => 'Computer Architecture', 'units' => 2],
                    ['code' => 'MTH 211', 'title' => 'Mathematical Methods', 'units' => 3],
                    ['code' => 'ENT 211', 'title' => 'Entrepreneurship I', 'units' => 2],
                ],
                'Second' => [
                    ['code' => 'COM 221', 'title' => 'File Processing and Management', 'units' => 2],
                    ['code' => 'COM 222', 'title' => 'Operating Systems II', 'units' => 3],
                    ['code' => 'COM 223', 'title' => 'Visual Programming', 'units' => 3],
                    ['code' => 'COM 224', 'title' => 'Web Technology I', 'units' => 3],
                    ['code' => 'COM 225', 'title' => 'Computer Networks I', 'units' => 3],
                    ['code' => 'ENT 221', 'title' => 'Entrepreneurship II', 'units' => 2],
                    ['code' => 'IT 200', 'title' => 'Industrial Training Briefing (SIWES)', 'units' => 0],
                ],
            ],
        ],

        '300' => [
            'semesters' => [
                'First' => [
                    ['code' => 'COM 311', 'title' => 'Database Management Systems I', 'units' => 3],
                    ['code' => 'COM 312', 'title' => 'Software Engineering I', 'units' => 3],
                    ['code' => 'COM 313', 'title' => 'Computer Networks II', 'units' => 3],
                    ['code' => 'COM 314', 'title' => 'Object Oriented Programming', 'units' => 3],
                    ['code' => 'COM 315', 'title' => 'Human Computer Interaction', 'units' => 2],
                    ['code' => 'COM 316', 'title' => 'Operations Research', 'units' => 2],
                    ['code' => 'GNS 311', 'title' => 'Entrepreneurship Development', 'units' => 2],
                ],
                'Second' => [
                    ['code' => 'COM 321', 'title' => 'Database Management Systems II', 'units' => 3],
                    ['code' => 'COM 322', 'title' => 'Software Engineering II', 'units' => 3],
                    ['code' => 'COM 323', 'title' => 'Web Technology II', 'units' => 3],
                    ['code' => 'COM 324', 'title' => 'Computer Graphics', 'units' => 2],
                    ['code' => 'COM 325', 'title' => 'Data Communication', 'units' => 3],
                    ['code' => 'COM 326', 'title' => 'System Programming', 'units' => 2],
                    ['code' => 'PRO 320', 'title' => 'Research Project Proposal', 'units' => 1],
                ],
            ],
        ],

        '400' => [
            'semesters' => [
                'First' => [
                    ['code' => 'COM 411', 'title' => 'Advanced Database Management', 'units' => 3],
                    ['code' => 'COM 412', 'title' => 'Artificial Intelligence', 'units' => 3],
                    ['code' => 'COM 413', 'title' => 'Computer Security', 'units' => 3],
                    ['code' => 'COM 414', 'title' => 'Distributed Systems', 'units' => 3],
                    ['code' => 'COM 415', 'title' => 'Mobile Application Development', 'units' => 3],
                    ['code' => 'COM 416', 'title' => 'Final Year Project I', 'units' => 3],
                    ['code' => 'COM 417', 'title' => 'Compiler Construction', 'units' => 2],
                ],
                'Second' => [
                    ['code' => 'COM 421', 'title' => 'Software Project Management', 'units' => 2],
                    ['code' => 'COM 422', 'title' => 'Cloud Computing', 'units' => 3],
                    ['code' => 'COM 423', 'title' => 'Machine Learning / Data Mining', 'units' => 3],
                    ['code' => 'COM 424', 'title' => 'E-Commerce Technologies', 'units' => 2],
                    ['code' => 'COM 425', 'title' => 'Final Year Project II', 'units' => 4],
                    ['code' => 'COM 426', 'title' => 'Seminar', 'units' => 1],
                    ['code' => 'ENT 421', 'title' => 'Innovation and Entrepreneurship', 'units' => 2],
                ],
            ],
        ],
    ],
];