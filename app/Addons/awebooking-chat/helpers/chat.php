<?php

function get_translator_languages($return = 'all')
{
    $languages = apply_filters('awebooking_translator_languages', [
        'en' => __('English'),
        'fr' => __('French'),
        'de' => __('German'),
        'ar' => __('Arabic'),
        'zh-CN' => __('Chinese'),
        'it' => __('Italian'),
        'pt' => __('Portuguese'),
        'es' => __('Spanish'),
        'th' => __('Thai'),
        'vi' => __('Vietnamese'),
    ]);
    return $return == 'key' ? array_keys($languages) : $languages;
}
