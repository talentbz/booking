<div id="hh-gallery-order-modal" class="modal fade hh-get-modal-content" tabindex="-1" role="dialog"
     aria-hidden="true" data-url="{{ dashboard_url('get-gallery-order') }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form form-action relative"
                  action="{{ dashboard_url('gallery-order-change') }}">
                @include('common.loading')
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Change gallery order')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
