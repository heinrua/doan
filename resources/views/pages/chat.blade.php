
@extends('themes.base')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('subcontent')
 
    <div class="flex items-center text-lg font-medium uppercase p-5">
            {!! $icons['chat'] !!}
            Cộng đồng
    </div>

    <div id="chatBox" class="h-[500px] overflow-y-auto border border-gray-300 p-4 mb-4 space-y-4">
        @foreach($messages as $msg)
            <div class="flex items-start space-x-2">
                
                <div class="text-sm font-semibold text-gray-600  mt-1 w-[15%] flex-shrink-0">
                    {{ $msg->sender_name }} :
                </div>

                <div class="bg-blue-400 text-white px-4 py-2 rounded-2xl max-w-[75%] break-words">
                    {{ $msg->message }}
                </div>
            </div>
        @endforeach
    </div>

    <form id="chatForm"> 
        <label for="chat" class="sr-only">Nhập tin nhắn</label>
        <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50">
            <button type="button" onclick="document.getElementById('imageInput').click()" class="...">
                {!!$icons['paper-clip']!!}
                <span class="sr-only">Upload image</span>
            </button>
           
            <input type="file" id="imageInput" name="file" accept="image/*,video/*" class="hidden">

            <textarea id="chat" name="message" class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Your message..."></textarea>
            <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100">
                {!!$icons['send']!!}
                <span class="sr-only">Send message</span>
            </button>
        </div>
       
    </form>

    <div id="videoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50">
        <div class="relative w-[80%] max-w-4xl">
            <video id="videoPlayer" class="w-full rounded-lg shadow-lg" controls>
                <source id="videoSource" src="" type="video/mp4">
            </video>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>      
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>    

    <script>
        const form = document.querySelector('#chatForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = this.message.value;

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            });

            this.message.value = '';
        });
        Pusher.logToConsole = true;

        const pusher = new Pusher('00f4436dc6cf0d006352', {
            cluster: 'us3',
            forceTLS: true
        });

        const channel = pusher.subscribe('chat-room');
        channel.bind('new-message', function(data) {
            console.log("📥 Nhận được:", data);
            const box = document.getElementById('chatBox');

            const html = `
            <div class="flex items-start space-x-2">
                <div class="text-sm font-semibold text-gray-600 mt-1 w-[15%] flex-shrink-0">
                ${data.sender} :
                </div>
                <div class="bg-blue-400 text-white px-4 py-2 rounded-2xl max-w-[75%] break-words">
                ${data.message}
                </div>
            </div>
            `;

            box.insertAdjacentHTML('beforeend', html);
            box.scrollTop = box.scrollHeight;
        });

    </script>

@endsection