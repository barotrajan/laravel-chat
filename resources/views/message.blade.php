<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="NEW_SHA512_VALUE" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="hidden lg:col-span-2 lg:block">
        <div class="w-full" id="chatBox">
            <div class="relative flex items-center p-3 border-b border-gray-300">
                <img class="object-cover w-10 h-10 rounded-full" src="{{ asset('images/user.png') }}" alt="username" />
                <span
                    class="block ml-2 font-bold text-gray-600">{{ $chat->sender->id == Auth::user()->id ? $chat->receiver->name : $chat->sender->name }}</span>
                <a href="{{ route('index') }}"
                    class="inline-block rounded bg-cyan-500 hover:bg-cyan-600 px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init="" data-te-ripple-color="light">Back</a>
            </div>
            <div class="relative w-full p-6 overflow-y-auto h-[40rem] chat-room">
                <ul class="space-y-2 chat-messages">
                    @foreach ($chat->messages as $message)
                        <li class="flex {{ $message->send_by != auth()->user()->id ? 'justify-start' : 'justify-end' }}" id="message-{{$message->id}}">
                            <div
                                class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow {{ $message->send_by != auth()->user()->id ? 'bg-gray-100' : '' }}">
                                <span class="block">{{ $message->message }}</span>
                            </div>
                            @if ($message->send_by == auth()->user()->id)
                                <div>
                                    <button onclick="deleteMessage('{{$message->id}}')"><i class="fas fa-trash"></i></button>
                                </div>
                            @endif
                        </li>

                        {{-- @if ($chat->sender->id == Auth::user()->id)
                            <li class="flex {{ $message->type === 'receiver' ? 'justify-start' : 'justify-end' }}">
                                <div
                                    class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow {{ $message->type === 'sender' ? 'bg-gray-100' : '' }}">
                                    <span class="block">{{ $message->message }}</span>
                                </div>
                            </li>
                        @else
                            <li class="flex {{ $message->type === 'sender' ? 'justify-start' : 'justify-end' }}">
                                <div
                                    class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow {{ $message->type === 'receiver' ? 'bg-gray-100' : '' }}">
                                    <span class="block">{{ $message->message }}</span>
                                </div>
                            </li>
                        @endif --}}
                    @endforeach
                </ul>
            </div>

            <div class="flex items-center justify-between w-full p-3 border-t border-gray-300">
                <input type="text" placeholder="Message" id="message"
                    class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700"
                    name="message" required />

                <button type="submit" id="send-message">
                    <svg class="w-5 h-5 text-gray-500 origin-center transform rotate-90"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            scrollToBottom();
        })
        $("#message").on("keydown", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault(); 
                $("#send-message").trigger("click"); 
            }
        });
        const pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: "{{env('PUSHER_APP_CLUSTER')}}",
            encrypted: true,
        });
        const channel = pusher.subscribe('public');
        channel.bind('chat', function(data) {
            console.log(data);
            $.ajax({
                type: 'POST',
                url: "{{route('receive-message')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    receiver_id : data.receiver_id,
                    chat_id : data.chat_id,
                },
                success: function(data) {
                    if(data.status) {
                        var html = `
                        <li class="flex justify-start">
                            <div
                                class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow bg-gray-100">
                                <span class="block">`+data.message+`</span>
                            </div>
                        </li>`;
                        $('.chat-messages').append(html);
                        scrollToBottom();
                    } 
                },
                error: function(result) {
                    console.log('error');
                }
            });
        });

        channel.bind('message', function(data) {
            $('#message-'+data.message).remove();
        });

        $("#send-message").on("click", function(event) {
            event.preventDefault();
            var message = $('#message').val();
            if(message != '') {
                
                var formData = {
                    'message' : $('#message').val(),
                    'chat_id' : '{{encrypt($chat->id)}}',
                };
                $.ajax({
                    type: 'POST',
                    url: "{{route('send-message')}}",
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}",
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: formData,
                    success: function(data) {
                        scrollToBottom();
                        var html = `
                        <li class="flex justify-end">
                            <div
                                class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow" id="message-` + data
                            .messageId + `">
                                <span class="block">` + message + `</span>
                            </div>
                            <div>
                                <button onclick="deleteMessage(` + data.messageId + `)"><i class="fas fa-trash"></i></button>
                            </div>
                        </li>`;
                        $('.chat-messages').append(html);
                        $('#message').val('');
                    },
                    error: function(result) {
                        console.log('error');
                    }
                });
            }
        });

        function deleteMessage(id) {
            $.ajax({
                type: 'POST',
                url: "{{route('delete-message')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                    'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                    'message' : id,
                },
                success: function(data) {
                    $('#message-'+id).remove();
                },
                error: function(result) {
                    console.log('error');
                }
            });
        }
        function scrollToBottom() {
            var chatContainer = $(".chat-room");
            chatContainer.scrollTop(chatContainer[0].scrollHeight);
        }
    </script>
</body>

</html>
