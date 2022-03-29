<?php
$author = get_current_user_data();
?>
<div class="chats">
    <div class="d-flex flex-column justify-content-center text-center h-100 w-100">
        <div class="container">
            <div class="avatar avatar-lg mb-2">
                <img class="avatar-img" src="{{get_user_avatar($author->getUserId())}}"
                     alt="{{ get_username($author->getUserId()) }}">
            </div>

            <h5>{{ sprintf(__('Welcome, %s!'), get_username($author->getUserId())) }}</h5>
            <p class="text-muted">{{__('Please select a chat to Start messaging.')}}</p>

            <button class="btn btn-outline-primary no-box-shadow" type="button" data-toggle="modal"
                    data-target="#startConversation">{{__('Start a conversation')}}</button>
        </div>
    </div>
</div>
