@extends('themes.base')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('subcontent')
 
    <h2>💬 Chat Realtime</h2>

    <div id="chatBox" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 1rem; margin-bottom: 1rem;">
        @foreach($messages as $msg)
            <div><strong>{{ $msg->sender_name }}</strong>: {{ $msg->message }}</div>
        @endforeach
    </div>

    <form id="chatForm">
        <textarea name="message" placeholder="Nhập tin..." style="width: 100%; padding: 0.5rem;"></textarea>
        <button type="submit">Gửi</button>
    </form>
       <!-- Load thư viện -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>      <!-- Nếu bạn có dùng jQuery -->
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
            box.innerHTML += `<div><strong>${data.sender}</strong>: ${data.message}</div>`;
            box.scrollTop = box.scrollHeight;
        });

    </script>


@endsection