<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('conversation.name') ?? 'Laravel Conversation'}}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="id" content="{{ $id }}">
    <meta name="messenger-color" content="{{ $messengerColor }}">
    <meta name="messenger-theme" content="{{ $dark_mode }}">
    <link href="../../assets/css/style.css" rel="stylesheet"/>

    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        :root {
            --primary-color: {{ $messengerColor }};
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
        }

        .flex {
            display: flex;
        }

        .flex1 {
            flex: 1;
        }

        .conversation_wrapper {
            width: 100%;
            height: 100vh;
            /*overflow: hidden;*/
            flex-wrap: wrap;
        }

        .conversation_list {
            height: 100%;
            max-width: 320px;
            width: 100%;
        }

        .message_card {
            flex: 1 0 320px;
            width: 100%;
            background-color: #f5f5f5;
            flex-direction: column;
        }


        .current_user {
            padding: 10px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }

        .current_user .avatar_image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ccc;
            margin-right: 10px;
        }

        .message_card .message_card_header {
        }

        .message_card .message_card_body {
            flex: 1;
        }

        .message_card .message_card_footer {
            padding: 4px 10px;
        }

        .message_card .message_card_footer form textarea {
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 20px;
            resize: none;
        }

        .message_info {
            height: 100%;
            max-width: 260px;
            width: 100%;
            min-width: 20px;
        }

        .submit-button {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            background-color: dodgerblue;
            border: none;
            cursor: pointer;
            margin-left: 6px;
        }
    </style>
</head>
