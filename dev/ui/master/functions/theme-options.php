<?php

app()->booted(function () {
    theme_option()
        ->setField([
            'id'         => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'customColor',
            'label'      => __('Primary color'),
            'attributes' => [
                'name'  => 'primary_color',
                'value' => '#ff2b4a',
            ],
        ])
        ->setField([
            'id'         => 'version_theme',
            'section_id' => 'opt-text-subsection-general',
            'type'       => 'text',
            'label'      => __('Version Theme(use to mac, iphone)'),
            'attributes' => [
                'name'    => 'version_theme',
                'value'   => '1.0.0',
                'options' => [
                    'class' => 'form-control',
                ],

            ],
        ]);
});
