<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductBooking extends Field
{
    public function fields(): array
    {
        $booking = new FieldsBuilder('product_booking');

        $booking
            ->setLocation('post_type', '==', 'product')
            ->addTab('Rezerwacje', ['placement' => 'top'])
            ->addTrueFalse('enable_booking', [
                'label' => 'Włącz system rezerwacji',
                'instructions' => 'Produkt będzie dostępny do rezerwacji z wyborem daty i godzin (9:00-17:00)',
                'ui' => 1,
                'default_value' => 0,
            ]);

        return [$booking];
    }
}