<style>
    .contacts-item .disabled {
        cursor: not-allowed;
    }
</style>
<?php
$from_user = get_current_user_id();
$channels = \App\Addons\ChatController::get_inst()->getLatestChannels($from_user);
?>
@if(is_null($channels))
    <li>
        <div class="alert alert-warning">{{__('No session found')}}</div>
    </li>
@else
    <?php foreach($channels as $channel){
        $_users = \App\Addons\ChatController::get_inst()->getUsersInChannel($channel);
        $latest_message = \App\Addons\ChatController::get_inst()->getLastestMessageInChannel($channel->channel_id);
        $count = \App\Addons\ChatController::get_inst()->countNewMessageInChannel($_users['from_user'], $channel->channel_id);
        ?>
    <!-- Chat Item Start -->
    <li class="contacts-item friends @if($count > 0) unread @endif" data-name="{{get_username($_users['to_user'])}}">
        <a class="contacts-link @if($channel->status == 'waiting') disabled @endif" href="@if($channel->status == 'waiting') javascript:;; @else {{ esc_url(\App\Addons\ChatController::get_inst()->getChannelUrl($channel->channel_id, $_users['from_user'])) }} @endif">
            <div class="avatar">
                <img src="{{ get_user_avatar($_users['to_user'], [48, 48]) }}" alt="{{get_username($_users['to_user'])}}">
            </div>
            <div class="contacts-content">
                <div class="contacts-info">
                    <h6 class="chat-name text-truncate">{{ get_username($_users['to_user']) }}</h6>
                    <div class="chat-time">{{ get_time_since($latest_message->created_at) }}</div>
                </div>
                <div class="contacts-texts">
                    <p class="text-truncate">{!! balanceTags($latest_message->message, false) !!}</p>
                    @if($count > 0)
                        <div class="badge badge-rounded badge-primary ml-1">{{ $count }}</div>
                    @endif
                </div>
                @if($channel->status == 'waiting' && $channel->user_joined == get_current_user_id())
                    <form action="{{ url('/dashboard/messenger/update-flag') }}" data-google-captcha="yes" method="post"
                        data-validation-id="form-send-enquiry"
                        class="form-action form-sm has-reset">
                        <input type="hidden" name="id" value="{{$channel->ID}}"/>
                        <input type="hidden" name="channel_id" value="{{$channel->channel_id}}"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary float-right">REPLY</button>
                    </form>
                @endif
            </div>
        </a>
        
    </li>
    <!-- Chat Item End -->
    <?php } ?>
@endif
