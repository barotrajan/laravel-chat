<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Chat</title>
</head>

<body>
    <div class="container mx-auto">
        <form class="my-4 flex flex-row-reverse" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="inline-block rounded bg-cyan-500 hover:bg-cyan-600 px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                data-te-ripple-init="" data-te-ripple-color="light">
                Logout
            </button>
        </form>
        <div class="min-w-full border rounded lg:grid lg:grid-cols-1">
            <ul class="overflow-auto h-[32rem]">
                <div class="mx-3 my-3">
                    <div class="relative text-gray-600">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="search" id="search" class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none"
                            name="search" placeholder="Search" required />
                    </div>
                </div>
                <h2 class="my-2 mb-2 ml-5 text-lg text-gray-600">
                    {{ count($chats) != 0 ? 'Chats' : 'Start a Chat' }}
                </h2>

                @foreach ($chats as $chat)
                    <li>
                        <a href="{{ route('show', encrypt($chat->id)) }}"
                            class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
                            <img class="object-cover w-10 h-10 rounded-full" src="{{ asset('images/user.png') }}"
                                alt="username" />
                            <div class="w-full pb-2">
                                <div class="flex justify-between">
                                    <span
                                        class="block ml-2 font-semibold text-gray-600">{{ $chat->sender->id == Auth::user()->id ? $chat->receiver->name : $chat->sender->name }}</span>
                                    <span class="block ml-2 font-semibold text-gray-600">
                                        @if ($chat->updated_at->isToday())
                                            {{ $chat->updated_at->format('g:i:A') }}
                                        @elseif ($chat->updated_at->isYesterday())
                                            Yesterday
                                        @else
                                            {{ $chat->updated_at->diffForHumans() }}
                                        @endif
                                    </span>
                                </div>
                                <span
                                    class="block ml-2 text-sm text-gray-600">{{ isset($chat->messages) && count($chat->messages) > 0 ? $chat->messages[0]->message : '' }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
                <div id="users"></div>
            </ul>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $('#search').on('keypress', function(event) {
            var search = event.target.value
            if (search.length > 2) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('get-users') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        search: search
                    },
                    success: function(response) {
                        if (response.status) {
                            var html = '';

                            response.data.forEach(item => {
                                console.log(item.id);
                                html += `
                                    <li>
                                        <a id="user-${item.id}" data-id="${item.id}"
                                            class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none create-chat">
                                            <img class="object-cover w-10 h-10 rounded-full" src="{{ asset('images/user.png') }}"
                                                alt="username" />
                                            <div class="w-full pb-2">
                                                <div class="flex justify-between">
                                                    <span class="block ml-2 mt-2 font-semibold text-gray-600">${item.name}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>`;
                            });

                            $('#users').html(html);
                        }
                    },
                    error: function(result) {
                        console.log('error');
                    }
                });
            }
        });
        $(document).on('click','.create-chat', function() {
            var user_id = $(this).attr('data-id');
            
            if (user_id != '') {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('create-chat') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status) {
                            window.location.href = response.url;
                        }
                    },
                    error: function(result) {
                        console.log('error');
                    }
                });
            }
        })
    </script>
</body>

</html>
