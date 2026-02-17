<?php

return [
    'organization' => [
        'name' => 'Talent Zone Academy',
        'tagline' => 'Nurturing Excellence, Inspiring Futures',
        'phone' => '+91 98765 43210',
        'email' => 'info@talentzoneacademy.edu',
        'address' => 'Karnal, Haryana, India',
    ],

    'schools' => [
        [
            'name' => 'Talent Zone Academy Karnal',
            'slug' => 'karnal',
            'tagline' => 'Where Excellence Meets Innovation',
            'address' => 'Karnal, Haryana 132001',
            'phone' => '+91 184 225 6789',
            'email' => 'karnal@talentzoneacademy.edu',
            'hero_image' => '/images/schools/karnal-hero.jpg',
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
                'message' => 'At Talent Zone Academy Karnal, we believe every child has the potential to achieve greatness. Our holistic approach to education combines academic excellence with character development.',
                'image' => '/images/staff/principal-karnal.jpg',
            ],
        ],
        [
            'name' => 'Talent Zone Academy Kurukshetra',
            'slug' => 'kurukshetra',
            'tagline' => 'Building Tomorrow\'s Leaders Today',
            'address' => 'Kurukshetra, Haryana 136118',
            'phone' => '+91 174 423 7890',
            'email' => 'kurukshetra@talentzoneacademy.edu',
            'hero_image' => '/images/schools/kurukshetra-hero.jpg',
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
                'message' => 'Our Kurukshetra campus is a vibrant community where students discover their passions and develop skills for the future. We nurture curiosity and creativity in every learner.',
                'image' => '/images/staff/principal-kurukshetra.jpg',
            ],
        ],
    ],

    'metrics' => [
        ['value' => '29+', 'label' => 'Years of Excellence'],
        ['value' => '4,300+', 'label' => 'Happy Students'],
        ['value' => '270+', 'label' => 'Expert Teachers'],
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
            'role' => 'Parent, Karnal Campus',
            'content' => 'Talent Zone Academy has transformed my daughter\'s learning experience. The teachers are truly dedicated and the facilities are outstanding.',
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
            'role' => 'Parent, Kurukshetra Campus',
            'content' => 'The perfect blend of academics and extracurriculars. Both my children have flourished here.',
            'image' => '/images/testimonials/parent-2.jpg',
        ],
    ],

    'leadership' => [
        [
            'name' => 'Mr. Vikram Malhotra',
            'role' => 'Chairman',
            'bio' => 'With over 40 years in education, Mr. Malhotra founded Talent Zone Academy with a vision to create world-class educational institutions accessible to all.',
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
