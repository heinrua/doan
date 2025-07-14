import.meta.glob(["../images/**"]);



// import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

window.Echo.channel('chat-room')
    .listen('NewMessageEvent', (e) => {
        const box = document.getElementById('chatBox');
        box.innerHTML += `<div class="mb-1"><strong>${e.sender}:</strong> ${e.message}</div>`;
    });

