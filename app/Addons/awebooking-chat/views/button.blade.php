<?php
global $post;
if (is_null($post)) {
    return;
}
$owner = $post->author;
$customer = get_current_user_id();
if ($owner == $customer) {
    return;
}
enqueue_script('messenger-frontend-js');
enqueue_style('messenger-frontend-css');
$url = get_the_permalink($post->post_id, $post->post_slug, $post->post_type);
$author = get_user_by_id($post->author);
$code = [
    'from_user' => $customer,
    'to_user' => $owner,
    'post_id' => $post->post_id,
    'post_type' => $post->post_type,
    'refer_link' => $url
];
?>
<a href="javascript:void(0)"
   class="btn btn-contact-host d-inline-flex align-items-center button-contact-host-{{ $post->post_type }}"
   data-code="{{base64_encode(json_encode($code))}}"
   data-action="{{url('messenger/start-message')}}"
>
    <span class="d-inline-block">{{sprintf(__('Contact %s'), get_username($author->getUserId()) )}}</span>
    <div class="spinner-border spinner-border-sm d-none ml-2" role="status">
        <span class="sr-only">{{__('Loading...')}}</span>
    </div>
</a>
