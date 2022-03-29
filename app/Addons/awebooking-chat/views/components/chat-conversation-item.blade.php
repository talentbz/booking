<?php
$list_messages = \App\Addons\ChatController::get_inst()->getListMessageInChannel($channel_id);
if ($list_messages) {
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $time_group = 0;
    $total = count($list_messages);
    foreach ($list_messages as $key => $message) {
        $message = new \App\Addons\ChatObject($message);
        $created_at = $message->getCreatedAt();
        $date = date('Y-m-d', $created_at);
        $li_class = '';
        if($key == 0){
            echo '<div class="message-day">';
            if ($date == $yesterday) {
                echo '<div class="message-divider sticky-top pb-2" data-label="' . __('Yesterday') . '">&nbsp;</div>';
            } elseif ($date == $today) {
                echo '<div class="message-divider sticky-top pb-2" data-label="' . __('Today') . '">&nbsp;</div>';
            } else {
                echo '<div class="message-divider sticky-top pb-2" data-label="' . date(hh_date_format(), $created_at) . '">&nbsp;</div>';
            }
            if($total == 1){
                echo '</div>';
            }
            $time_group = $date;
        }elseif($key == $total - 1){
            echo '</div>';
        }else{
            if ($time_group != $date) {
                $time_group = $date;
                echo '</div><div class="message-day">';
                if ($date == $yesterday) {
                    echo '<div class="message-divider sticky-top pb-2" data-label="' . __('Yesterday') . '">&nbsp;</div>';
                } elseif ($date == $today) {
                    echo '<div class="message-divider sticky-top pb-2" data-label="' . __('Today') . '">&nbsp;</div>';
                } else {
                    echo '<div class="message-divider sticky-top pb-2" data-label="' . date(hh_date_format(), $created_at) . '">&nbsp;</div>';
                }
            }
        }

        $class_message = '';
        if (get_current_user_id() == $message->getFromUser()) {
            $class_message = 'self';
        }
        ?>
        <div class="message {{ $class_message }}">
            <div class="message-wrapper">
                <div class="message-content">
                    {!! balanceTags(nl2br($message->getMessage()), false, true) !!}
                </div>
            </div>
            <div class="message-options">
                <div class="avatar avatar-sm">
                    <img alt="{{ get_username($message->getFromUser()) }}"
                         src="{{ get_user_avatar($message->getFromUser()) }}">
                </div>
                <span class="message-date">{{ date(hh_time_format(), $created_at) }}</span>
            </div>
        </div>
    <?php
    } // end foreach
} // endif
?>
