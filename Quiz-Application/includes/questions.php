<?php
function getQuizQuestions($category, $difficulty) {
    $quizData = [
        'general' => [
            'easy' => [
                [
                    'question' => 'What is the capital of France?',
                    'options' => ['London', 'Berlin', 'Paris', 'Madrid'],
                    'answer' => 2
                ],
                [
                    'question' => 'Which planet is known as the Red Planet?',
                    'options' => ['Venus', 'Mars', 'Jupiter', 'Saturn'],
                    'answer' => 1
                ],
                [
                    'question' => 'Who painted the Mona Lisa?',
                    'options' => ['Vincent van Gogh', 'Pablo Picasso', 'Leonardo da Vinci', 'Michelangelo'],
                    'answer' => 2
                ],
                [
                    'question' => 'What is the largest mammal?',
                    'options' => ['Elephant', 'Blue Whale', 'Giraffe', 'Polar Bear'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which element has the chemical symbol "O"?',
                    'options' => ['Gold', 'Oxygen', 'Osmium', 'Oganesson'],
                    'answer' => 1
                ]
            ],
            'medium' => [
                [
                    'question' => 'What year did World War II end?',
                    'options' => ['1944', '1945', '1946', '1947'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which country has the most natural lakes?',
                    'options' => ['Canada', 'Russia', 'USA', 'China'],
                    'answer' => 0
                ],
                [
                    'question' => 'What is the smallest country in the world?',
                    'options' => ['Monaco', 'Vatican City', 'San Marino', 'Liechtenstein'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which language has the most native speakers?',
                    'options' => ['English', 'Spanish', 'Hindi', 'Mandarin Chinese'],
                    'answer' => 3
                ],
                [
                    'question' => 'What is the most abundant gas in Earth\'s atmosphere?',
                    'options' => ['Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Argon'],
                    'answer' => 2
                ]
            ],
            'hard' => [
                [
                    'question' => 'What is the atomic number of Gold?',
                    'options' => ['78', '79', '80', '81'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which philosopher wrote "Thus Spoke Zarathustra"?',
                    'options' => ['Søren Kierkegaard', 'Friedrich Nietzsche', 'Jean-Paul Sartre', 'Albert Camus'],
                    'answer' => 1
                ],
                [
                    'question' => 'What is the speed of light in a vacuum?',
                    'options' => ['299,792,458 m/s', '300,000,000 m/s', '299,792,458 km/s', '300,000 km/s'],
                    'answer' => 0
                ],
                [
                    'question' => 'Which element has the highest melting point?',
                    'options' => ['Tungsten', 'Carbon', 'Osmium', 'Rhenium'],
                    'answer' => 1
                ],
                [
                    'question' => 'Who discovered the structure of DNA?',
                    'options' => ['Rosalind Franklin', 'James Watson and Francis Crick', 'Gregor Mendel', 'Linus Pauling'],
                    'answer' => 1
                ]
            ]
        ],
        'science' => [
            'easy' => [
                [
                    'question' => 'What is H2O?',
                    'options' => ['Hydrogen', 'Oxygen', 'Water', 'Helium'],
                    'answer' => 2
                ],
                [
                    'question' => 'What force pulls objects toward the center of the Earth?',
                    'options' => ['Magnetism', 'Gravity', 'Friction', 'Inertia'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which planet is closest to the Sun?',
                    'options' => ['Venus', 'Earth', 'Mars', 'Mercury'],
                    'answer' => 3
                ],
                [
                    'question' => 'What is the main gas found in the air we breathe?',
                    'options' => ['Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen'],
                    'answer' => 2
                ],
                [
                    'question' => 'How many bones are in the human body?',
                    'options' => ['196', '206', '216', '226'],
                    'answer' => 1
                ]
            ],
            'medium' => [
                [
                    'question' => 'What is the chemical symbol for silver?',
                    'options' => ['Si', 'Ag', 'Au', 'Sr'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which organ produces insulin?',
                    'options' => ['Liver', 'Pancreas', 'Kidney', 'Stomach'],
                    'answer' => 1
                ],
                [
                    'question' => 'What is the hardest natural substance on Earth?',
                    'options' => ['Gold', 'Iron', 'Diamond', 'Platinum'],
                    'answer' => 2
                ],
                [
                    'question' => 'What is the most abundant element in the universe?',
                    'options' => ['Oxygen', 'Carbon', 'Hydrogen', 'Helium'],
                    'answer' => 2
                ],
                [
                    'question' => 'Which blood type is known as the universal donor?',
                    'options' => ['A', 'B', 'AB', 'O'],
                    'answer' => 3
                ]
            ],
            'hard' => [
                [
                    'question' => 'What is the approximate age of the universe?',
                    'options' => ['4.5 billion years', '13.8 billion years', '10.2 billion years', '20.5 billion years'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which subatomic particle has a positive charge?',
                    'options' => ['Electron', 'Neutron', 'Proton', 'Photon'],
                    'answer' => 2
                ],
                [
                    'question' => 'What is the speed of sound in air at 20°C?',
                    'options' => ['331 m/s', '343 m/s', '299 m/s', '320 m/s'],
                    'answer' => 1
                ],
                [
                    'question' => 'Which vitamin is produced when the human skin is exposed to sunlight?',
                    'options' => ['Vitamin A', 'Vitamin B12', 'Vitamin C', 'Vitamin D'],
                    'answer' => 3
                ],
                [
                    'question' => 'What is the chemical formula for table salt?',
                    'options' => ['NaCl', 'KCl', 'CaCl2', 'MgCl2'],
                    'answer' => 0
                ]
            ]
        ]
    ];

    return $quizData[$category][$difficulty] ?? [];
}
?>