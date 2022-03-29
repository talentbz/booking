(function ($) {
    'use strict';
    let HHMessenger = {
        init: function () {
            let base = this;

            base._scrollEnOfChat();
            base.initSendMessage();
            base.initSearchChannel();
            base.initSaveSettings();
            base.initRefreshChannel();
            base.initRefreshMessage();
            base.initTranslator();

            setTimeout(() => {
                base._scrollEnOfChat();
            }, 100);
        },
        initRefreshMessage: function () {
            let base = this;
            let message_wrapper = $('#messageBody');
            if (message_wrapper.length === 0) {
                return false;
            }

            let refresh_time = messenger_params.refresh_time;
            if (typeof refresh_time == 'number' && refresh_time >= 5 && refresh_time <= 60) {
                refresh_time *= 1000;
                setInterval(function () {
                    base.refreshMessage();
                }, refresh_time);
            }
        },
        initTranslator: function () {
            let base = this;

            $('.button-language-wrapper').each(function () {
                let wrapper = $(this);

                $('.dropdown-item', wrapper).click(function () {
                    let t = $(this),
                        button = $('.dropdown-toggle', wrapper),
                        language_code = t.attr('data-lang'),
                        language_name = t.text();
                    let form = wrapper.closest('.form-translator');

                    button.attr('data-language', language_code).text(language_name);

                    if (button.hasClass('button-language-from')) {
                        $('input[name="language_from"]', form).val(language_code);
                    } else {
                        $('input[name="language_to"]', form).val(language_code);
                    }

                });
            });
            let form = $('.form-translator');

            form.on('submit', function (ev) {
                ev.preventDefault();

                let data = form.serializeArray();
                data.push({
                    name: '_token',
                    value: $('meta[name="csrf-token"]').attr('content'),
                });
                $('.hh-loading', form).show();
                $('.translate-text-result', form).empty();
                $.post(form.attr('action'), data, function (respon) {
                    if (typeof respon == 'object') {
                        if (respon.status === 1) {
                            $('.translate-text-result', form).html(respon.html);
                        } else {
                            alert(respon.message);
                        }
                    }
                }, 'json').always(function () {
                    $('.hh-loading', form).hide();
                });
            });
        },
        initRefreshChannel: function () {
            let base = this;
            let refresh_time = messenger_params.refresh_time;
            if (typeof refresh_time == 'number' && refresh_time >= 5 && refresh_time <= 60) {
                refresh_time *= 1000;
                setInterval(function () {
                    base.refreshChannel();
                }, refresh_time);
            }
        },
        initSaveSettings: function () {
            let form = $('.form-messenger-settings');
            form.on('submit', function (ev) {
                ev.preventDefault();

                let data = form.serializeArray();
                data.push({
                    name: '_token',
                    value: $('meta[name="csrf-token"]').attr('content'),
                });
                $('.hh-loading', form).show();
                $('.form-message', form).empty();
                $.post(form.attr('action'), data, function (respon) {
                    if (typeof respon == 'object') {
                        $('.form-message', form).html(respon.message);
                    }
                }, 'json').always(function () {
                    $('.hh-loading', form).hide();
                });
            });
        },
        _scrollEnOfChat: function () {
            // Scroll to end of chat
            let chat_finished = document.querySelector('.chat-finished');
            if (chat_finished) {
                chat_finished.scrollIntoView({
                    block: 'end',               // "start" | "center" | "end" | "nearest",
                    behavior: 'auto'          //"auto"  | "instant" | "smooth",
                })
            }
        },
        initSearchChannel: function () {
            let base = this;
            let timeout = null;
            let channels = $('#chatContactTab');

            $(document.body).on('keyup', '.sidebar-sub-header input.search', function (ev) {
                ev.preventDefault();
                let input = $(this),
                    value = input.val();
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (value.trim() !== '') {
                        $('.contacts-item', channels).hide();
                        $('.contacts-item[data-name*="' + value + '"]', channels).show();
                    } else {
                        $('.contacts-item', channels).show();
                    }
                }, 200);
            })

            let startConversation = $('#startConversation');
            $(startConversation).on('keyup', 'input.search', function (ev) {
                ev.preventDefault();
                let input = $(this),
                    value = input.val();
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (value.trim() !== '') {
                        $('.list-group-item', startConversation).hide();
                        $('.list-group-item[data-name*="' + value + '"]', startConversation).show();
                    } else {
                        $('.list-group-item', startConversation).show();
                    }
                }, 200);
            })
        },
        initSendMessage: function () {
            let base = this;
            let form = $('.form-messenger-input');
            let input = $('textarea[name="message"]', form);
            let textarea = document.getElementsByClassName('emojionearea-editor');
            let submit = $('button[type="submit"]', form);

            form.on('submit', function (ev) {
                ev.preventDefault();

                let message = input.val();
                if (message.trim().length <= 0) {
                    alert('Please enter message before sending');
                } else {

                    let data = form.serializeArray();
                    data.push({
                        name: '_token',
                        value: $('meta[name="csrf-token"]').attr('content')
                    });

                    submit.prop('disabled', true);

                    $.post(form.attr('action'), data, function (respon) {
                        if (typeof respon == 'object') {
                            if (respon.status == 0) {
                                base._moveCursorToEnd(textarea[0]);
                                alert(respon.message);
                            } else {
                                textarea[0].innerHTML = '';
                                input.val('');
                                base.refreshMessage();
                                base.refreshChannel();
                            }
                        }
                    }, 'json').always(function () {
                        textarea[0].focus();
                        submit.prop('disabled', false);
                    });

                }
            })
        },
        _moveCursorToEnd: function (el) {
            let range, selection;
            if (document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
            {
                range = document.createRange();//Create a range (a range is a like the selection but invisible)
                range.selectNodeContents(el);//Select the entire contents of the element with the range
                range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
                selection = window.getSelection();//get the selection object (allows you to change selection)
                selection.removeAllRanges();//remove any selections already made
                selection.addRange(range);//make the range you have just created the visible selection
            } else if (document.selection)//IE 8 and lower
            {
                range = document.body.createTextRange();//Create a range (a range is a like the selection but invisible)
                range.moveToElementText(el);//Select the entire contents of the element with the range
                range.collapse(false);//collapse the range to the end point. false means collapse to end rather than the start
                range.select();//Select the range (make it the visible selection
            }
        },
        refreshMessage: function () {
            let base = this;

            let messenger_list = $('#messageBody');

            let data = {
                channel_id: messenger_list.data('channel_id'),
                encrypt: messenger_list.data('encrypt'),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.post(messenger_list.data('action'), data, function (respon) {
                if (typeof respon == 'object') {
                    $('.chat-content-render', messenger_list).html(respon.html);
                    // Scroll to end of chat
                    base._scrollEnOfChat();
                } else {
                    alert(respon.message);
                }
            }, 'json');
        },
        refreshChannel: function () {
            let channel_list = $('#chatContactTab');

            let data = {
                user_id: channel_list.data('user-id'),
                encrypt: channel_list.data('encrypt'),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            $.post(channel_list.data('action'), data, function (respon) {
                if (typeof respon == 'object') {
                    channel_list.html(respon.html);
                } else {
                    alert(respon.message);
                }
            }, 'json');
        }
    };
    HHMessenger.init();
})(jQuery);
