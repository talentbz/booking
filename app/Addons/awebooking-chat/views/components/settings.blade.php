<div class="tab-pane" id="settings-content">
    <div class="d-flex flex-column h-100">
        <div class="hide-scrollbar">
            <!-- Sidebar Header Start -->
            <div class="sidebar-header sticky-top p-2 pt-3 mb-3">
                <h5 class="font-weight-semibold">{{__('Settings')}}</h5>
                <p class="text-muted mb-0">{{__('System & Settings')}}</p>
            </div>
            <!-- Sidebar Header end -->
            <!-- Sidebar Content Start -->
            <div class="container-xl">
                <div class="row">
                    <div class="col">
                        <div class="appnavbar-body">
                            <form action="{{dashboard_url('messenger/save-settings')}}"
                                  class="form relative form-messenger-settings">
                                @include("messenger::loading")
                                <ul class="list-group border list-group-flush">
                                    <li class="list-group-item py-2">
                                        <?php
                                        $refresh_time = get_opt('messenger_refresh_time', 5);
                                        ?>
                                        <label for="setting-refresh-time">{{__('Refresh Time')}}</label>
                                        <p class="text-description">{{__('The time that the system refreshes the conversations (unit: seconds) ')}}</p>
                                        <input id="setting-refresh-time" type="number" step="5" min="5" max="60"
                                               class="form-control" name="refresh_time" value="{{$refresh_time}}">
                                    </li>
                                </ul>
                                <div class="form-message"></div>
                                <button type="submit"
                                        class="btn btn-primary btn-block mt-3">{{__('Save settings')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar Content End -->
        </div>
    </div>
</div>
