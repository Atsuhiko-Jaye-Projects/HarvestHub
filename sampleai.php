<textarea id="message" placeholder="Ask something..."></textarea>
<button onclick="sendMessage()">Send</button>
<div id="reply"></div>

<script>
function sendMessage() {
    const message = document.getElementById("message").value;

    fetch("test.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data); // <-- check this for debugging
        document.getElementById("reply").innerText = data.reply;
    })
    .catch(err => console.error(err));
}
</script>
