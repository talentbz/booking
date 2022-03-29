<?php
show_lang_section('mb-2');
$langs = get_languages_field();
?>
<div class="form-group">
    <label for="term_name_update">
        {{__('Name')}}
    </label>
    @foreach($langs as $key => $item)
        <input type="text" class="form-control has-validation {{get_lang_class($key, $item)}}"
               data-validation="required" id="term_name_update{{get_lang_suffix($item)}}"
               name="term_name{{get_lang_suffix($item)}}"
               value="{{ get_translate($termObject->term_title, $item) }}" @if(!empty($item)) data-lang="{{$item}}"
               @endif
               placeholder="Name">
    @endforeach
    <input type="hidden" name="term_id" value="{{ $termObject->term_id }}">
    <input type="hidden" name="term_encrypt" value="{{ hh_encrypt($termObject->term_id) }}">
</div>
<div class="form-group">
    <label for="term_description_update">
        {{__('Description')}}
    </label>
    @foreach($langs as $key => $item)
        <textarea name="term_description{{get_lang_suffix($item)}}"
                  id="term_description_update{{get_lang_suffix($item)}}"
                  class="form-control {{get_lang_class($key, $item)}}"
                  placeholder="{{__('Description')}}"
                  @if(!empty($item)) data-lang="{{$item}}" @endif>{{ get_translate($termObject->term_description, $item) }}</textarea>
    @endforeach
</div>
<div class="form-group field-icon relative">
    <label for="term_icon_update">
        {{__('Icon')}}
    </label>
    <?php
    $icon = $termObject->term_icon;
    ?>
    <input type="text" class="form-control hh-icon-input"
           id="term_icon_update" name="term_icon"
           data-action="{{ dashboard_url('get-font-icon') }}"
           data-plugin="fonticon" value="{{ $icon }}"
           placeholder="{{__('Icon')}}">
</div>
