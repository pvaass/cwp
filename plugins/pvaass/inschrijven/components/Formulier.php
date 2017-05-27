<?php namespace pvaass\Inschrijven\Components;


use Cms\Classes\ComponentBase;
use October\Rain\Exception\ValidationException;
use pvaass\Inschrijven\Controllers\Inschrijvingen;
use pvaass\Inschrijven\Models\InschrijfSettings;
use pvaass\Inschrijven\Models\Inschrijving;
use Redirect;
use Response;

class Formulier extends ComponentBase
{

    const ZWEMBADEN = [
            [
                'name' => "Het Zuiderpark",
                'description' => 'Moerwijk',
                'location' => 'denhaag',
                'location_label' => 'Den Haag',
                'image' => 'assets/images/portfolio/XZuiderpark poort2.jpg',
                'fields' => [
                    [
                        'name' => 'kind',
                        'fields' => [
                            "Maandag 17:45 - 18:30",
                            "Maandag 18:30 - 19:15"
                        ]
                    ],
                    [
                        'name' => 'volwassen',
                        'fields' => [
                            "Maandag 19:15 - 20:00",
                        ]
                    ],
                    [
                        'name' => 'volwassen-rec',
                        'fields' => [
                            'Maandag 19:15 - 20:00 (conditie)'
                        ]
                    ],
                    [
                        'name' => 'waterpolo',
                        'fields' => [
                            'Alle uren'
                        ]
                    ]
                ]
            ],
            [
                'name' => "Houtzagerij",
                'description' => 'Schilderswijk',
                'location' => 'denhaag',
                'location_label' => 'Den Haag',
                'image' => 'assets/images/portfolio/XHoutzagerij1.jpg',
                'fields' => [
                    [
                        'name' => 'kind',
                        'fields' => [
                            "Woensdag 18:25 - 19:05"
                        ]
                    ],
                    [
                        'name' => 'volwassen',
                        'fields' => [
                            'Woendag 19:20 - 20:00 (Vrouwen - alle niveaus)',
                            'Woendag 20:00 - 20:40 (Vrouwen - alle niveaus)',
                            'Woendag 20:40 - 21:20 (Vrouwen - alle niveaus)',
                            'Woendag 21:20 - 22:00 (Vrouwen - beginners)',
                        ]
                    ],
                    [
                        'name' => 'volwassen-rec',
                        'fields' => [
                            'Woendag 21:20 - 22:00 (Vrouwen)'
                        ]
                    ]

                ]
            ],
            [
                'name' => "De Blinkerd",
                'description' => 'Scheveningen',
                'location' => 'denhaag',
                'location_label' => 'Den Haag',
                'image' => 'assets/images/portfolio/XBlinkerd3.jpg',
                'fields' => [
                    [
                        'name' => 'kind',
                        'fields' => [
                            "Donderdag 17:00 - 17:45",
                            "Donderdag 17:45 - 18:30",
                            "Donderdag 18:30 - 19:15",
                        ]
                    ],
                    [
                        'name' => 'volwassen-rec',
                        'fields' => [
                            "Donderdag 19:15 - 20:00 (55+)",
                            "Donderdag 19:15 - 20:00 (Conditiezwemmen)",
                        ]
                    ]
                ]
            ],
            [
                'name' => "De Waterthor",
                'description' => 'Waldeck',
                'location' => 'denhaag',
                'location_label' => 'Den Haag',
                'image' => 'assets/images/portfolio/XWaterthor hoofdingang.jpg',
                'fields' => [
                    [
                        'name' => 'kind',
                        'fields' => [
                            "Vrijdag 18:30 - 19:15",
                            "Vrijdag 19:15 - 20:00",
                            "Zaterdag 16:15 - 17:00",
                            "Zaterdag 17:00 - 17:45 (t/m B diploma)",
                        ]
                    ],
                    [
                        'name' => 'volwassen',
                        'fields' => [
                            'Zaterdag 17:00 - 17:45'
                        ]
                    ],
                    [
                        'name' => 'volwassen-rec',
                        'fields' => [
                            'Zaterdag 17:00 -17:45'
                        ]
                    ],
                    [
                        'name' => 'waterpolo',
                        'fields' => [
                            'Alle uren'
                        ]
                    ]
                ]
            ],
            [
                'name' => "Steenvoorde",
                'description' => 'Op het terrein van Florence',
                'location' => 'rijswijk',
                'location_label' => 'Rijswijk',
                'image' => 'assets/images/portfolio/Steenvoorde Florence_kl.jpg',
                'fields' => [
                    [
                        'name' => 'kind',
                        'fields' => [
                            "Zondag 13:30 - 14:10 (vanaf 5 jaar)",
                            "Zondag 14:10 - 14:50 (Gevorderd - vanaf 5 jaar)",
                            "Zondag 14:50 - 15:30 (Gevorderd - vanaf 5 jaar)"
                        ]
                    ],
                    [
                        'name' => 'volwassen',
                        'fields' => [
                            'Maandag 19:30 - 20:30 (Mannen)',
                            'Maandag 19:30 - 20:30 (Gevorderd - Mannen)'
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Escamphof',
                'description' => 'Rustenburg',
                'location' => 'denhaag',
                'location_label' => 'Den Haag',
                'image' => 'assets/images/portfolio/Escamphof.jpg',
                'fields' => [
                    [
                        'name' => 'volwassen',
                        'fields' => [
                            'Woendag 08:30 - 09:15 (Vrouwen)',
                            'Woendag 09:15 - 10:00 (Vrouwen)',
                        ]
                    ],
                    [
                        'name' => 'mbvo',
                        'fields' => [
                            'Woensdag 10:00 - 10:30',
                            'Woensdag 10:30 - 11:00',
                            'Woensdag 11:00 - 11:30',
                            'Woensdag 11:30 - 12:00',
                            'Woensdag 12:00 - 12:30',
                            'Woensdag 12:30 - 13:00',
                            'Woensdag 13:00 - 13:30',
                            'Woensdag 13:30 - 14:00',
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Het Hofbad',
                'description' => 'Ypenburg',
                'location' => 'denhaag',
                'location_label' => 'Den Haag',
                'image' => 'assets/images/portfolio/Hofbad_kl.jpg',
                'fields' => [
                    [
                        'name' => 'waterpolo',
                        'fields' => [
                            'Alle uren'
                        ]
                    ]
                ]
            ],

            [
                'name' => 'De Schilp',
                'description' => 'Presidentenbuurt',
                'location' => 'rijswijk',
                'location_label' => 'Rijswijk',
                'image' => 'assets/images/portfolio/XSchilp3_klein.jpg',
                'fields' => [
                    [
                        'name' => 'waterpolo',
                        'fields' => [
                            'Alle uren'
                        ]
                    ]
                ]
            ]
        ];


    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Inschrijf formulier',
            'description' => 'Het CWP inschrijf formulier'
        ];
    }

//    /**
//     * Renders a requested partial in context of this component,
//     * see Cms\Classes\Controller@renderPartial for usage.
//     */
//    public function renderPartial()
//    {
//        $this->controller->setComponentContext($this);
//        $result = call_user_func_array([$this->controller, 'renderPartial'], func_get_args());
//        $this->controller->setComponentContext(null);
//
//        return $result;
//    }


    public function onRun()
    {


        $this->addJs('assets/javascript/zwembaden.js');
        //$this->addCss('/modules/system/assets/ui/storm.css?v1', 'core');

    }


    public function onRender()
    {

        //$zwembaden = InschrijfSettings::get('zwembaden');


        //assets/images/portfolio/XSchilp3_klein.jpg
        //'assets/images/portfolio/Hofbad_kl.jpg'
//
//        $this->page['zwembaden'] = $zwembaden;
//        $this->page['zwembad_type'] = 'kind';

        $this->addJs('assets/javascript/zwembaden.js');

//        die(dump($this->controller->getRouter()->getUrl()));
//
        if ($this->controller->getRouter()->getUrl() === "inschrijven/kinderen")
            return $this->renderPartial("inschrijfFormulier::zwembad-picker");
    }

    public function onSave()
    {
        Inschrijving::create(post('Inschrijving'));
        return Redirect::to('inschrijven/success');
    }

    public function onTypeSubmit($back = true)
    {
        return [
            "#inschrijven-content" => $this->renderPartial("inschrijfFormulier::zwembad-picker",
                [
                    'zwembaden' => self::ZWEMBADEN,
                    'zwembad_type' => \Request::get('type')
                ]
            ),
            '.guide' => $this->renderPartial("inschrijfFormulier::guide", [
                'selected' => 2
            ])
        ];
    }

    public function onZwembadSubmit($back = false) {
        $zwembad = \Request::get('zwembad-info');

        if(empty($zwembad)) {
            throw new ValidationException(['name' => 'Je moet eerst een zwembad en een tijd selecteren.']);
        }

        // Build a back-end form with the context of ‘frontend’
        $formController = new Inschrijvingen();
        $formController->create('frontend');

        return [
            "#inschrijven-content" => $this->renderPartial("inschrijfFormulier::form", [
                'form' => $formController,
                'zwembad_type' => \Request::get('type'),
                'zwembad_all' => \Request::get('zwembad-info')
            ]),
            '.guide' => $this->guide(3)
        ];
    }


    public function onBack() {
        $back = \Request::get('back');

        if($back == 1) {
            return [
                "#inschrijven-content" => $this->renderPartial("inschrijfFormulier::type"),
                '.guide' => $this->guide(1)
            ];
        }

        if($back == 2) {
            return $this->onTypeSubmit(true);
        }
        if($back == 3) {
            return $this->onZwembadSubmit(true);
        }
    }

    private function guide($selected) {
        return $this->renderPartial("inschrijfFormulier::guide", [
            'selected' => $selected
        ]);
    }
}