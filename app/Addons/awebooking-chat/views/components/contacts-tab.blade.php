<ul class="contacts-list" id="chatContactTab" data-chat-list=""
    data-action="{{dashboard_url('messenger/refresh-channel')}}"
    data-user-id="{{get_current_user_id()}}"
    data-encrypt="{{hh_encrypt(get_current_user_id())}}">
    @include("messenger::components.contact-items")
</ul>
