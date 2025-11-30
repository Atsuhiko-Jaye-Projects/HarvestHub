<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Chat</title>
    <style>
        #chatBox {
            height: 250px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background: #f8f9fa;
            margin-bottom: 10px;
        }
        .message { margin-bottom: 8px; }
        .time { font-size: 10px; color: #777; }
    </style>
</head>
<body>

<div id="chatBox"></div>

<input id="chatInput" placeholder="Type a message..." style="width:70%;">
<button onclick="sendMessage()">Send</button>

<script>
const USER_ID = 1; // Change per user if you have login

function sendMessage() {
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if(msg === '') return;

    fetch('send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'user_id=' + USER_ID + '&message=' + encodeURIComponent(msg)
    }).then(res => res.text())
      .then(res => {
        input.value = '';
        loadMessages();
      }).catch(err => console.error(err));
}

function loadMessages() {
    fetch('fetch_messages.php')
      .then(res => res.json())
      .then(messages => {
          let html = '';
          messages.reverse().forEach(m => {
              html += `<div class="message">
                          <strong>User ${m.user_id}:</strong> ${m.message} 
                          <div class="time">${m.created_at}</div>
                       </div>`;
          });
          const chatBox = document.getElementById('chatBox');
          chatBox.innerHTML = html;
          chatBox.scrollTop = chatBox.scrollHeight;
      }).catch(err => console.error(err));
}

// Auto-refresh every 2 sec
setInterval(loadMessages, 2000);
loadMessages();
</script>

</body>
</html>
