<?php

return [
    'organization' => [
        'name' => 'TalentZone Academy',
        'tagline' => 'Nurturing Excellence, Inspiring Futures',
        'phone' => '+91 98765 43210',
        'email' => 'info@talentzoneacademy.edu',
        'address' => '123 Education Boulevard, Mumbai, Maharashtra 400001',
    ],

    'schools' => [
        [
            'name' => 'TalentZone Academy Central Campus',
            'slug' => 'central-campus',
            'tagline' => 'Where Excellence Meets Innovation',
            'address' => '45 Central Avenue, Andheri West, Mumbai 400058',
            'phone' => '+91 22 2345 6789',
            'email' => 'central@talentzoneacademy.edu',
            'hero_image' => '/images/schools/central-hero.jpg',
            'color' => 'primary',
            'established' => '1995',
            'students' => '2,500+',
            'teachers' => '150+',
            'highlights' => [
                'Smart Classrooms',
                'Olympic Swimming Pool',
                'STEM Labs',
                'International Curriculum',
            ],
            'principal' => [
                'name' => 'Dr. Priya Sharma',
                'message' => 'At Central Campus, we believe every child has the potential to achieve greatness. Our holistic approach to education combines academic excellence with character development.',
                'image' => '/images/staff/principal-central.jpg',
            ],
        ],
        [
            'name' => 'TalentZone Academy North Campus',
            'slug' => 'north-campus',
            'tagline' => 'Building Tomorrow\'s Leaders Today',
            'address' => '78 Lake Road, Powai, Mumbai 400076',
            'phone' => '+91 22 3456 7890',
            'email' => 'north@talentzoneacademy.edu',
            'hero_image' => '/images/schools/north-hero.jpg',
            'color' => 'accent',
            'established' => '2005',
            'students' => '1,800+',
            'teachers' => '120+',
            'highlights' => [
                'Robotics Center',
                'Sports Academy',
                'Music & Arts Wing',
                'Eco-Friendly Campus',
            ],
            'principal' => [
                'name' => 'Mr. Rajesh Kumar',
                'message' => 'Our North Campus is a vibrant community where students discover their passions and develop skills for the future. We nurture curiosity and creativity in every learner.',
                'image' => '/images/staff/principal-north.jpg',
            ],
        ],
        [
            'name' => 'TalentZone Academy East Campus',
            'slug' => 'east-campus',
            'tagline' => 'Empowering Minds, Enriching Lives',
            'address' => '156 Garden Lane, Thane West, Mumbai 400607',
            'phone' => '+91 22 4567 8901',
            'email' => 'east@talentzoneacademy.edu',
            'hero_image' => '/images/schools/east-hero.jpg',
            'color' => 'warm',
            'established' => '2012',
            'students' => '1,200+',
            'teachers' => '85+',
            'highlights' => [
                'Language Lab',
                'Indoor Sports Complex',
                'Transport Fleet',
                'After-School Programs',
            ],
            'principal' => [
                'name' => 'Mrs. Anita Desai',
                'message' => 'East Campus provides a nurturing environment where every student feels valued. We blend traditional values with modern teaching methods.',
                'image' => '/images/staff/principal-east.jpg',
            ],
        ],
    ],

    'metrics' => [
        ['value' => '29+', 'label' => 'Years of Excellence'],
        ['value' => '5,500+', 'label' => 'Happy Students'],
        ['value' => '355+', 'label' => 'Expert Teachers'],
        ['value' => '98%', 'label' => 'Success Rate'],
    ],

    'features' => [
        [
            'title' => 'Smart Classrooms',
            'description' => 'Interactive digital learning with modern technology integration.',
            'icon' => 'computer',
        ],
        [
            'title' => 'Sports Excellence',
            'description' => 'World-class facilities for athletics, swimming, and team sports.',
            'icon' => 'trophy',
        ],
        [
            'title' => 'Arts & Culture',
            'description' => 'Comprehensive programs in music, dance, drama, and visual arts.',
            'icon' => 'palette',
        ],
        [
            'title' => 'STEM Education',
            'description' => 'Cutting-edge labs for science, technology, engineering, and math.',
            'icon' => 'beaker',
        ],
        [
            'title' => 'Safe Transport',
            'description' => 'GPS-enabled buses covering all major areas with trained staff.',
            'icon' => 'bus',
        ],
        [
            'title' => 'Holistic Growth',
            'description' => 'Focus on mental wellness, life skills, and character building.',
            'icon' => 'heart',
        ],
    ],

    'testimonials' => [
        [
            'name' => 'Meera Patel',
            'role' => 'Parent, Central Campus',
            'content' => 'TalentZone Academy has transformed my daughter\'s learning experience. The teachers are truly dedicated and the facilities are outstanding.',
            'image' => '/images/testimonials/parent-1.jpg',
        ],
        [
            'name' => 'Arjun Mehta',
            'role' => 'Alumni, Batch of 2020',
            'content' => 'The values and education I received here prepared me for success at IIT. Forever grateful to my teachers.',
            'image' => '/images/testimonials/alumni-1.jpg',
        ],
        [
            'name' => 'Dr. Sunita Rao',
            'role' => 'Parent, North Campus',
            'content' => 'The perfect blend of academics and extracurriculars. Both my children have flourished here.',
            'image' => '/images/testimonials/parent-2.jpg',
        ],
    ],

    'leadership' => [
        [
            'name' => 'Mr. Vikram Malhotra',
            'role' => 'Chairman',
            'bio' => 'With over 40 years in education, Mr. Malhotra founded TalentZone Academy with a vision to create world-class educational institutions accessible to all.',
            'image' => '/images/staff/chairman.jpg',
        ],
        [
            'name' => 'Dr. Kavita Reddy',
            'role' => 'Director of Education',
            'bio' => 'A PhD in Educational Psychology from Cambridge, Dr. Reddy oversees curriculum development and teacher training across all campuses.',
            'image' => '/images/staff/director.jpg',
        ],
    ],

    'gallery_categories' => ['All', 'Campus', 'Events', 'Sports', 'Labs'],
];
