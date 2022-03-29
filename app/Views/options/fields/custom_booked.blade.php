<?php
$layout = (!empty($layout)) ? $layout : 'col-12';
if (empty($value)) {
    $value = $std;
}
$idName = str_replace(['[', ']'], '_', $id);
enqueue_style('flatpickr-css');
enqueue_script('flatpickr-js');

global $post;
$booking_type = isset($post->booking_type) ? $post->booking_type : '';
?>
<div id="setting-{{ $idName }}" data-condition="{{ $condition }}"
     data-unique="{{ $unique }}" data-delete-url="{{ dashboard_url('delete-custom-availiability-item') }}"
     data-operator="{{ $operation }}"
     class="form-group mb-3 col {{ $layout }} field-{{ $type }} relative">
    @include('common.loading', ['class' => 'loading-custom-price'])
    <label for="{{ $idName }}">
        {{ __($label) }}
        @if (!empty($desc))
            <i class="dripicons-information field-desc" data-toggle="popover" data-placement="right"
               data-trigger="hover"
               data-content="{{ __($desc) }}"></i>
        @endif
    </label>
    <div class="w-100"></div>
    <a href="javascript: void(0)" data-post-id="{{ $post_id }}" data-toggle="modal"
       data-target="#hh-custom-book-edit-modal"
       class="btn btn-success btn-xs">{{ __('Add new') }}</a>
    <div class="book-render mt-4">
        <?php
        $customBooked = \App\Controllers\Services\HomeController::get_inst()->_getHomeAvailabilityCustomBook($post_id);
        ?>
        @include('dashboard.components.services.'.$post_type. '.custom_availability', ['custom_booked' =>$customBooked])
    </div>
</div>
@if($break)
    <div class="w-100"></div> @endif
<div id="hh-custom-book-edit-modal" data-action="{{ dashboard_url('add-new-custom-book') }}" class="modal fade" tabindex="-1"
     role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @include('common.loading')
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('Add new custom booked date')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <div id="custom-days_of_book_bulk" class="form-group field-select2_multiple has-validation"
                     data-unique="" data-operator="and"
                     data-condition="type_of_bulk:is(days_of_book)">
                    <label for="days_of_book_bulk">{{ __('Start Date') }} <span class="text-muted f11">(Select rent Start date)</span></label>
                    <input type="text" class="form-control"
                        data-plugin="datepicker"
                        data-date-format="d.m.Y."
                        data-min-date="{{ date('d.m.Y.')}}"
                        id="start_date_book"
                        name="start_date_book" value="">
                    <label for="days_of_book_bulk">{{ __('End Date') }} <span class="text-muted f11">(Select rent End date)</span></label>
                    <input type="text" class="form-control"
                        data-plugin="datepicker"
                        data-date-format="d.m.Y."
                        data-min-date="{{ date('d.m.Y.')}}"
                        id="end_date_book"
                        name="end_date_book" value="">
                </div>
            </div>
            <input type="hidden" id="custom_book_id" name="custom_book_id" value="{{ $post_id }}">
            <input type="hidden" name="custom_book_type" value="{{ $post_type }}">
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-info waves-effect waves-light add-book">{{__('Add New')}}
                </button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<style>
    #hh-bulk-edit-modal .switchery {
        margin-top: 6px;
    }
</style>
