<?php

use Diviky\LaravelFormComponents\Components;

return [
    'prefix' => env('COMPONENTS_PREFIX'),

    /** tailwind | bootstrap-5 */
    'framework' => env('COMPONENTS_FRAMEWORK', 'bootstrap-5'),

    'use_eloquent_date_casting' => false,

    /** bool | string */
    'default_wire' => false,

    /**
     * How the form filed should display
     */
    'form_style' => null,

    'components' => [
        'form' => [
            'view' => 'form-components::{framework}.form',
            'class' => Components\Form::class,
        ],

        'form-checkbox' => [
            'view' => 'form-components::{framework}.form-checkbox',
            'class' => Components\FormCheckbox::class,
        ],

        'form-errors' => [
            'view' => 'form-components::{framework}.form-errors',
            'class' => Components\FormErrors::class,
        ],

        'form-group' => [
            'view' => 'form-components::{framework}.form-group',
            'class' => Components\FormGroup::class,
        ],

        'form-input' => [
            'view' => 'form-components::{framework}.form-input',
            'class' => Components\FormInput::class,
        ],

        'form-hidden' => [
            'view' => 'form-components::{framework}.form-hidden',
            'class' => Components\FormHidden::class,
        ],

        'form-input-group' => [
            'view' => 'form-components::{framework}.form-input-group',
            'class' => Components\FormInputGroup::class,
        ],

        'form-input-group-text' => [
            'view' => 'form-components::{framework}.form-input-group-text',
            'class' => Components\FormInputGroupText::class,
        ],

        'form-label' => [
            'view' => 'form-components::{framework}.form-label',
            'class' => Components\FormLabel::class,
        ],

        'form-radio' => [
            'view' => 'form-components::{framework}.form-radio',
            'class' => Components\FormRadio::class,
        ],

        'form-range' => [
            'view' => 'form-components::{framework}.form-range',
            'class' => Components\FormRange::class,
        ],

        'form-select' => [
            'view' => 'form-components::{framework}.form-select',
            'class' => Components\FormSelect::class,
        ],

        'form-submit' => [
            'view' => 'form-components::{framework}.form-submit',
            'class' => Components\FormSubmit::class,
        ],

        'form-textarea' => [
            'view' => 'form-components::{framework}.form-textarea',
            'class' => Components\FormTextarea::class,
        ],

        'form-timezones' => [
            'view' => 'form-components::{framework}.form-select',
            'class' => Components\FormTimezones::class,
        ],

        'help' => [
            'view' => 'form-components::{framework}.help',
        ],

        'icon' => [
            'view' => 'form-components::{framework}.icon',
            'class' => Components\Icon::class,
        ],
    ],
];
