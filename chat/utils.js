function sendMessage() {
  const message = document.getElementById("chatInput").value;

  fetch("send_message.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "user_id=1&message=" + encodeURIComponent(message)
  });

  document.getElementById("chatInput").value = "";
}

function loadMessages() {
  fetch("fetch_messages.php")
    .then(res => res.json())
    .then(messages => {
      let html = "";
      messages.reverse().forEach(m => {
        html += `<div><strong>User ${m.user_id}:</strong> ${m.message}</div>`;
      });
      document.getElementById("chatBox").innerHTML = html;
    });
}

setInterval(loadMessages, 2000); // refresh every 2 sec
