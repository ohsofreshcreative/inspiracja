<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Tabs extends Block
{
    public $name = 'Zakładki';
    public $description = 'tabs';
    public $slug = 'tabs';
    public $category = 'formatting';
    public $icon = 'welcome-widgets-menus';
    public $keywords = ['tabs', 'kafelki'];
    public $mode = 'edit';
    public $supports = [
        'align' => false,
        'mode' => false,
        'jsx' => true,
    ];

    public function fields()
    {
        $tabs = new FieldsBuilder('tabs');

        $tabs
            ->setLocation('block', '==', 'acf/tabs')

            ->addText('block-title', [
                'label' => 'Tytuł',
                'required' => 0,
            ])
            ->addAccordion('accordion1', [
                'label' => 'Zakładki',
                'open' => false,
                'multi_expand' => true,
            ])

            /*--- TREŚCI NAGŁÓWKA ---*/
            ->addTab('Treści', ['placement' => 'top'])
            ->addGroup('g_tabs', ['label' => ''])
                ->addText('title', ['label' => 'Tytuł'])
                ->addText('txt', ['label' => 'Opis'])
            ->endGroup()

            /*--- KAFELKI / ZAKŁADKI ---*/
            ->addTab('Kafelki', ['placement' => 'top'])
            ->addRepeater('r_tabs', [
                'label' => 'Zakładki',
                'layout' => 'block',
                'min' => 1,
                'max' => 8,
                'button_label' => 'Dodaj zakładkę',
            ])
                ->addText('tab', [
                    'label' => 'Nazwa punktu',
                    'required' => 1,
                ])
                ->addTextarea('tab_desc', [
                    'label' => 'Adres',
                    'rows' => 2,
                    'new_lines' => 'br',
                ])
                ->addText('tab_extra', [
                    'label' => 'Numer telefonu',
                ])
                ->addText('tab_title', [
                    'label' => 'Nagłówek treści (prawy panel)',
                ])
                ->addNumber('map_lat', [
                    'label' => 'Lat (do podświetlenia po kliknięciu)',
                    'step' => 'any',
                ])
                ->addNumber('map_lng', [
                    'label' => 'Lng (do podświetlenia po kliknięciu)',
                    'step' => 'any',
                ])
            ->endRepeater()

            /*--- WSPÓLNA MAPA ---*/
            ->addTab('Mapa (wspólna)', ['placement' => 'top'])
            ->addRepeater('locations', [
                'label' => 'Lokalizacje na mapie',
                'layout' => 'block',
                'button_label' => 'Dodaj lokalizację',
            ])
                ->addText('label', ['label' => 'Etykieta (krótka)'])
                ->addTextarea('address', [
                    'label' => 'Adres / treść popupa',
                    'rows' => 4,
                    'new_lines' => 'br',
                ])
                ->addNumber('lat', ['label' => 'Lat', 'step' => 'any'])
                ->addNumber('lng', ['label' => 'Lng', 'step' => 'any'])
            ->endRepeater()
            ->addNumber('map_zoom', [
                'label' => 'Zoom początkowy (opcjonalnie)',
                'min' => 1,
                'max' => 19,
            ])

            /*--- USTAWIENIA BLOKU ---*/
            ->addTab('Ustawienia bloku', ['placement' => 'top'])
            ->addText('id', ['label' => 'ID'])
            ->addText('class', ['label' => 'Dodatkowe klasy CSS'])
            ->addTrueFalse('flip', [
                'label' => 'Odwrotna kolejność',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('wide', [
                'label' => 'Szeroka kolumna',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('nomt', [
                'label' => 'Usunięcie marginesu górnego',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('gap', [
                'label' => 'Większy odstęp',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('lightbg', [
                'label' => 'Jasne tło',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('graybg', [
                'label' => 'Szare tło',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('whitebg', [
                'label' => 'Białe tło',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ])
            ->addTrueFalse('brandbg', [
                'label' => 'Tło marki',
                'ui' => 1, 'ui_on_text' => 'Tak', 'ui_off_text' => 'Nie',
            ]);

        return $tabs;
    }

    public function with()
    {
        return [
            'g_tabs'    => get_field('g_tabs'),
            'r_tabs'    => get_field('r_tabs'),
            'locations' => get_field('locations'),
            'map_zoom'  => get_field('map_zoom'),
            'id'        => get_field('id'),
            'class'     => get_field('class'),
            'flip'      => get_field('flip'),
            'wide'      => get_field('wide'),
            'nomt'      => get_field('nomt'),
            'gap'       => get_field('gap'),
            'lightbg'   => get_field('lightbg'),
            'graybg'    => get_field('graybg'),
            'whitebg'   => get_field('whitebg'),
            'brandbg'   => get_field('brandbg'),
        ];
    }
}