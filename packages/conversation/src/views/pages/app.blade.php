<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('Conversation::layouts.head')
<body>
<div id="app">
    <div class="conversation_wrapper flex">
        <div class="conversation_list">
            <div class="current_user">
                <img src="{{ $user->avatar ? asset('storage/users-avatar/'.$user->avatar) : 'https://cdn.onlinewebfonts.com/svg/img_569204.png' }}" alt="" class="avatar_image">
                {{ $user->name }}
            </div>
        </div>
        <div class="message_card flex">
            <div class="message_card_header">

            </div>
            <div class="message_card_body">

            </div>
            <div class="message_card_footer">
                <form class="flex">
                    <label class="flex1">
                        <textarea rows="1"></textarea>
                    </label>
                    <div>
                        <button type="submit" class="submit-button"></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="message_info">

        </div>
    </div>
</div>
</body>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    options = {
        broadcaster: "pusher",
        key: `ae1238c8d625f7d212d3`,
        cluster: `ap2`,
        // forceTLS: '',
        encrypted: true,
        authEndpoint: `${broadcastAPI}`,
        auth: {
            headers: {
                x: `{{csrf_token()}}`,
                Accept: "application/json",
            },
        },
    };

    const pusher = new Pusher(options.key, ...options);

    const channel = pusher.subscribe('private-conversation.{{ auth()->id() }}');
    channel.bind('my-event', function (data) {
        alert(JSON.stringify(data));
    });
</script>
</html>
