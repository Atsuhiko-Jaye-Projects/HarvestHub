<?php 
$farmer_id = isset($_GET['fid']) ? intval($_GET['fid']) : 0;

include_once '../../../config/core.php';
include_once '../../../config/database.php';
include_once '../../../objects/user.php';
$user_id = $_SESSION['user_id'];


$page_title = "Messages";
include_once "../layout/layout_head.php";

$require_login = true;
include_once "../../../login_checker.php";

$database = new Database();
$db = $database->getConnection();


// check if the farmer_id is set

if (!empty($farmer_id)) {
  
$farmer_info = new User($db);
$farmer_info->id = $farmer_id;
$farmer_info->getFarmerInfo();
$image = $farmer_info->profile_pic;
$default_image = "{$base_url}user/uploads/logo.png";
$farmer_profile_path = "{$base_url}user/uploads/profile_picures/farmer/{$farmer_id}/$image";
// Check if file exists on server
if (!empty($image) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/user/uploads/profile_picures/farmer/{$farmer_id}/$image")) {
    $display_image = $farmer_profile_path;
} else {
    $display_image = $default_image;
}
?>

<div class="container-fluid mt-3">
  <div class="row">

    <!-- Conversations List Sidebar -->
    <div class="col-md-4">
      <div class="card h-100 p-2 shadow-sm">
        <h6 class="mb-3">Inbox</h6>
        <ul class="list-group list-group-flush" id="conversationList">
          <!-- PHP loop will populate conversation items -->
        </ul>
      </div>
    </div>

    <!-- Chat Content -->
    <div class="col-md-8">
      <div class="card h-100 shadow-sm p-3" id="chatContent">

        <!-- Farmer Profile Header -->
        <div class="d-flex align-items-center mb-3">
        <div class="avatar bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:50px; height:50px; overflow:hidden;">
            <img src="<?php echo $display_image; ?>" alt="" style="width:100%; height:100%; object-fit:cover;">
        </div>
          <strong><?= $farmer_info->firstname ?></strong>
        </div>

        <!-- Messages Area -->
        <div id="messages" style="width:100%; height:500px; overflow-y:auto; border:1px solid #ccc; padding:5px; display:flex; flex-direction:column;">
          <p class="text-center text-muted mt-5">Start your conversation...</p>
        </div>


        <!-- Input Field -->
        <div class="mt-3">
          <div class="input-group">
            <input id="messageInput" type="text" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary" id="sendBtn">Send</button>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>


<?php 
}else{
?>

  <div class="row">

    <!-- Conversations List -->
    <div class="col-md-4">
      <div class="card h-100 p-2 shadow-sm">
        <h6 class="mb-3">Inbox</h6>
        <ul class="list-group list-group-flush" id="conversationList">
          <!-- Sample conversation -->
          <li class="list-group-item d-flex align-items-center cursor-pointer">
            <div class="avatar bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px; height:40px;">
            </div>
            <div>
              <strong>Sadiwa, Jessi</strong><br>
              <small class="text-muted">Hello!</small>
            </div>
          </li>
          <li class="list-group-item text-center text-muted">No more conversations</li>
        </ul>
      </div>
    </div>

    <!-- Chat Content -->
    <div class="col-md-8">
      <div class="card h-100 shadow-sm p-3" id="chatContent">
        <p class="text-center text-muted mt-5">Select a conversation to start chatting</p>
      </div>
    </div>
  </div>
</div>
<?php
}
include_once "../layout/layout_foot.php"; 
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let sender_id = <?= intval($user_id); ?>; //logged user
let receiver_id  = <?= intval($farmer_id); ?>; //farmer id
let farmer_id = <?= intval($farmer_id); ?>;
let currentConversation = 0;

// -----------------------------------------------------
// OPEN CHAT WHEN CLICKED
// -----------------------------------------------------
function openChat(conversation_id, name) {
    currentConversation = conversation_id;

    $("#chatName").text(name); // set chat header

    loadMessages();
    
}



// -----------------------------------------------------
// LOAD MESSAGES FOR CURRENT CONVERSATION
// -----------------------------------------------------
let lastMessageId = 0; // Track last message loaded

function loadMessages() {
    if (!currentConversation) return;
    if ($("#messages").length === 0) return;

    $.get("getMessage.php", { 
        cid: currentConversation,
        last_id: lastMessageId // Only get messages newer than this
    }, function(response) {
        let msgs;
        try {
            msgs = JSON.parse(response);
        } catch (err) {
            console.error("Invalid JSON from PHP:", err);
            return;
        }

        if(msgs.length === 0) return; // Nothing new

        msgs.forEach(msg => {
            const bubble = $('<div>')
                .addClass("message")
                .addClass(Number(msg.sender_id) === Number(sender_id) ? "me" : "other")
                .text(msg.message)
                .css({
                    border: '1px solid',
                    borderColor: Number(msg.sender_id) === Number(sender_id) ? '#28a745' : '#dc3545',
                    borderRadius: '10px',
                    padding: '8px 12px',
                    margin: '5px 0',
                    maxWidth: '70%',
                    wordBreak: 'break-word',
                    backgroundColor: Number(msg.sender_id) === Number(sender_id) ? '#e6ffed' : '#ffe6e6',
                    alignSelf: Number(msg.sender_id) === Number(sender_id) ? 'flex-end' : 'flex-start'
                });

            $("#messages").append(bubble);

            // Update lastMessageId
            lastMessageId = Math.max(lastMessageId, msg.id);
        });

        // Auto-scroll to bottom
        $("#messages")[0].scrollTop = $("#messages")[0].scrollHeight;
    });
}

// Start polling every 2 seconds
//setInterval(loadMessages, 2000);

// Send message function
function sendMessage() {
    const msg = $("#messageInput").val().trim();
    
    console.log("MSG:", msg, "CONV:", currentConversation);
    // if (!msg || !currentConversation) return;

    $.post("sendMessage.php", {
        message: msg,
        receiver_id: receiver_id,
        sender_id: sender_id,
        conversation_id: currentConversation
    }, function(response) {
        if (response.trim() === "message sent") {
            const div = $('<div>')
                .addClass('me')
                .text(msg)
                .css({
                    border: '1px solid #28a745',
                    borderRadius: '10px',
                    padding: '8px 12px',
                    margin: '5px 0',
                    maxWidth: '70%',
                    wordBreak: 'break-word',
                    backgroundColor: '#e6ffed',
                    alignSelf: 'flex-end'
                });
            $("#messages").append(div);
            $("#messages")[0].scrollTop = $("#messages")[0].scrollHeight;
            $("#messageInput").val(''); // clear input
        } else {
            console.error("Failed to send message:", response);
        }
    });
}

// Click button
$("#sendBtn").click(sendMessage);

// Press Enter key
$("#messageInput").keypress(function(e){
    if(e.which === 13) { // Enter key
        sendMessage();
        e.preventDefault();
    }
});


// -----------------------------------------------------
// LOAD CONVERSATIONS SIDEBAR
// -----------------------------------------------------
function loadConversationsSidebar() {
    $.get("getConversation.php", function(data) {
        
        console.log("Raw response Conversation list:", data);

        let convs;
        try {
            convs = JSON.parse(data);
        } catch (err) {
            console.error("Invalid JSON:", err);
            return;
        }

        const list = $("#conversationList");
        list.empty();
        

        if (convs.length === 0) {
            list.html('<li class="list-group-item text-center text-muted">No conversations</li>');
            return;
        }

        convs.forEach(c => {
            const li = $('<li>')
                .addClass('list-group-item d-flex align-items-center cursor-pointer mt-2')
                .attr('data-conversation-id', c.conversation_id)
                .attr('data-receiver-id', c.receiver_id)
                .attr('data-name', c.name)
                .css({
                    border: '1px solid #dee2e6',
                    borderRadius: '6px',
                    marginBottom: '5px',
                    maxWidth: '100%',      // prevent overflow
                    wordBreak: 'break-word' // wrap long messages
                });


            const avatar = $('<div>')
                .addClass('avatar rounded-circle me-2 overflow-hidden')
                .css({ width:'40px', height:'40px', border:'1px solid black' });

            const img = $('<img>')
                .attr('src', c.profile_pic)
                .css({ width:'100%', height:'100%', objectFit:'cover' });

            avatar.append(img);

            const info = $('<div>')
                .html(`<strong>${c.name}</strong><br><small class="text-muted">${c.last_message || 'No messages yet'}</small>`);

            li.append(avatar).append(info);
            list.append(li);
            
        });
        
    });
}

// -----------------------------------------------------
// CLICK EVENT FOR CONVERSATIONS
// -----------------------------------------------------
  $("#conversationList").on("click", "li", function () {
      const convId = $(this).data("conversation-id");
      const name   = $(this).data("name");
      const receiver_id   = $(this).data("receiver-id");

      currentConversation = convId;

      const newUrl = window.location.pathname + "?fid=" + receiver_id + "&cid=" + convId;
      window.history.pushState({}, "", newUrl);

      openChat(convId, name);
      location.reload();
  });

// -----------------------------------------------------
// INIT
// -----------------------------------------------------
$(document).ready(function() {

    // Load sidebar
    loadConversationsSidebar();

    // Restore previous conversation (if URL contains cid)
    const urlParams = new URLSearchParams(window.location.search);
    const cid = urlParams.get("cid");
    const name = urlParams.get("name");

    if (cid) {
        currentConversation = cid;
        loadMessages();
    }
});
</script>
