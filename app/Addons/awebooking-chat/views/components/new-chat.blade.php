<div class="modal fade" id="startConversation" tabindex="-1" role="dialog"
     aria-labelledby="startConversationLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="startConversationLabel">{{__('Start a conversation')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 hide-scrollbar">
                <?php
                $from_user = get_current_user_id();
                $channels = \App\Addons\ChatController::get_inst()->getLatestStateChannel($from_user, 'open');
                ?>
                @if(is_null($channels))
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="alert alert-warning">{{__('No channel found')}}</div>
                        </li>
                    </ul>
                @else
                    <div class="row">
                        <div class="col-12">
                            <!-- Search Start -->
                            <form class="form-inline w-100 p-2 border-bottom">
                                <div class="input-group w-100 bg-light">
                                    <input type="text"
                                           class="form-control form-control-md search border-right-0 transparent-bg pr-0"
                                           placeholder="{{__('Search users')}}">
                                    <div class="input-group-append">
                                        <div class="input-group-text transparent-bg border-left-0" role="button">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Search End -->
                        </div>
                        <div class="col-12">
                            <!-- List Group Start -->
                            <ul class="list-group list-group-flush">
                            <?php foreach($channels as $channel){
                            $_users = \App\Addons\ChatController::get_inst()->getUsersInChannel($channel);
                            $latest_message = \App\Addons\ChatController::get_inst()->getLastestMessageInChannel($channel->channel_id);
                            $count = \App\Addons\ChatController::get_inst()->countNewMessageInChannel($_users['from_user'], $channel->channel_id);
                            ?>
                            <!-- List Group Item Start -->
                                <li class="list-group-item @if($count > 0) unread @endif" data-name="{{get_username($_users['to_user'])}}" >
                                    <div class="media">
                                        <div class="avatar mr-2">
                                            <img src="{{ get_user_avatar($_users['to_user'], [48, 48]) }}" alt="{{get_username($_users['to_user'])}}">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="text-truncate">
                                                <a href="{{ esc_url(\App\Addons\ChatController::get_inst()->getChannelUrl($channel->channel_id, $_users['from_user'])) }}" class="text-reset">{{ get_username($_users['to_user']) }}</a>
                                            </h6>
                                            <p class="text-muted mb-0">{{ balanceTags($latest_message->message) }}</p>
                                        </div>
                                    </div>
                                </li>
                                <!-- List Group Item End -->
                                <?php } ?>
                            </ul>
                            <!-- List Group End -->
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
