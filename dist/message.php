<?php
session_start();

// Database connection
$pdo = new PDO('sqlite:upswipe.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Assuming you pass the chat ID through a GET parameter named 'chat_id'
$chatId = $_GET['chat_id'] ?? 0;
$loggedInUserId = $_SESSION['id'] ?? 0;
// Prepare and execute the SQL query
$stmt = $pdo->prepare("SELECT m.message, m.person_id, m.timestamp, l.Name FROM messages m JOIN login l ON m.person_id = l.id WHERE m.chat_id = ? ORDER BY m.timestamp ASC");
$stmt->execute([$chatId]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

/// Prepare SQL query to find the other person's ID in the chat
$query = "SELECT person1_id, person2_id FROM chat_twopeople WHERE chat_id = :chatId AND (person1_id = :loggedInUserId OR person2_id = :loggedInUserId)";
$stmt = $pdo->prepare($query);
$stmt->execute(['chatId' => $chatId, 'loggedInUserId' => $loggedInUserId]); // Corrected variable here

$otherPersonId = null;
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Determine the other person's ID
    $otherPersonId = ($row['person1_id'] == $loggedInUserId) ? $row['person2_id'] : $row['person1_id'];
}

// Get the other person's name from the login table
$otherPersonName = '';
if ($otherPersonId !== null) {
    $query = "SELECT Name, Accounttype FROM login WHERE id = :otherPersonId";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['otherPersonId' => $otherPersonId]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $otherPersonName = $row['Name'];
        $otherpersonrole = $row['Accounttype'];
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']) && !empty($_POST['message'])) {
  $message = trim($_POST['message']);

  if ($chatId > 0 && $loggedInUserId > 0 && !empty($message)) {
      // Prepare SQL query to insert message
      $insertQuery = "INSERT INTO messages (chat_id, person_id, message) VALUES (:chatId, :personId, :message)";
      $insertStmt = $pdo->prepare($insertQuery);
      $insertStmt->execute(['chatId' => $chatId, 'personId' => $loggedInUserId, 'message' => $message]);

      // Redirect to avoid form resubmission
      header("Location: ".$_SERVER['PHP_SELF']."?chat_id=".$chatId);
      exit();
  }
}

// AJAX request to fetch messages
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
  $stmt = $pdo->prepare("SELECT m.message, m.person_id, m.timestamp, l.Name FROM messages m JOIN login l ON m.person_id = l.id WHERE m.chat_id = ? ORDER BY m.timestamp ASC");
  $stmt->execute([$chatId]);
  $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($messages as $message) {
      $isUserMessage = $message['person_id'] == $loggedInUserId;
      echo '<div class="flex ' . ($isUserMessage ? 'justify-end' : '') . ' items-end space-x-2 mb-2">';
      if (!$isUserMessage) {
          echo '<span class="flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-300"><img class="h-full w-full object-cover" src="placeholder.jpg" alt="User avatar"></span>';
      }
      echo '<div class="max-w-xs p-3 rounded-lg ' . ($isUserMessage ? 'bg-gradient-to-r from-[#667EEA] to-[#764BA2]' : 'bg-gradient-to-r from-gray-500 to-gray-600') . '">';
      echo '<p class="' . ($isUserMessage ? 'text-white' : '') . '">' . htmlspecialchars($message['message']) . '</p>';
      echo '<span class="block text-xs text-right ' . ($isUserMessage ? 'text-blue-200' : 'text-gray-500') . '">' . date('H:i', strtotime($message['timestamp'])) . '</span>';
      echo '</div></div>';
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat |<?php echo $otherPersonName ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="flex flex-col h-screen max-w-md mx-auto bg-[#110B11]" >
    <div class="flex items-center p-4 border-b">
    <a href="chats.php" class="flex items-center space-x-3 pb-2 no-underline text-white hover:text-gray-200">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="text-blue-500"
      >

        <path d="m12 19-7-7 7-7"></path>
        <path d="M19 12H5"></path>
      </svg>
      </a>

<?php
      echo '<div class="flex flex-col flex-1 mx-4">';
      echo '<span class="font-semibold text-[#667EEA]">' . htmlspecialchars($otherPersonName) . '</span>';
      echo '        <span class="text-[#667EEA]">' . htmlspecialchars($otherpersonrole) . '</span> ';
      echo '</div>';
      ?>
    </div>

    
    <div class="flex-1 overflow-y-auto" id="chat-messages">
      <div class="p-4 space-y-4">
        <!-- Chat messages -->
    <div class="flex-1 overflow-y-auto p-4" >
      <?php foreach ($messages as $message): ?>
        <?php $isUserMessage = $message['person_id'] == $loggedInUserId; ?>
        <div class="flex <?php echo $isUserMessage ? 'justify-end' : ''; ?> items-end space-x-2 mb-2">
          <?php if (!$isUserMessage): ?>
            <!-- Avatar for other users -->
            <span class="flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gray-300">
              <img class="h-full w-full object-cover" src="placeholder.jpg" alt="User avatar">
            </span>
          <?php endif; ?>
          <div class="max-w-xs p-3 rounded-lg <?php echo $isUserMessage ? 'bg-gradient-to-r from-[#667EEA] to-[#764BA2]' : 'bg-gradient-to-r from-gray-500 to-gray-600'; ?>">
            <p class="<?php echo $isUserMessage ? 'text-white' : ''; ?>"><?= htmlspecialchars($message['message']) ?></p>
            <span class="block text-xs text-right <?php echo $isUserMessage ? 'text-blue-200' : 'text-gray-500'; ?>"><?= date('H:i', strtotime($message['timestamp'])) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
      </div>
      
    </div>
    <form method="POST" id="messageForm">
    <div class="p-4">
      <div class="flex items-center space-x-2">
        <input type="text" name="message" id="message" class="flex-1 border rounded-full px-4 py-2 focus:outline-none" placeholder="Type a message...">
        <button class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 focus:outline-none">Send</button>
      </div>
  </div>
  </form>
  <script>
document.addEventListener("DOMContentLoaded", function() {
    const chatMessagesInnerContainer = document.querySelector('.flex-1.overflow-y-auto.p-4'); // The container that scrolls

    // Function to scroll to the bottom of the chat messages
        // Ensure we scroll the correct container
        var element = document.querySelector('#chat-messages');

        function scrollBottom() {
        element.scrollTop = element.scrollHeight;
    }
    

    // Fetch and display messages
    function fetchMessages() {
        fetch('?chat_id=<?= $chatId ?>&ajax=1').then(response => response.text()).then(data => {
            chatMessagesInnerContainer.innerHTML = data;
            // Ensure we wait for the DOM to be updated before scrolling
            requestAnimationFrame(scrollBottom);
        }).catch(error => console.error('Error fetching messages:', error));
    }
    setInterval(fetchMessages, 1000); // Refresh messages every second

    // Select the message form and input
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('message');

    // Handle message submission via AJAX
    if (messageForm && messageInput) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('chat_id', '<?= $chatId ?>');

            fetch('?chat_id=<?= $chatId ?>', {
                method: 'POST',
                body: formData
            }).then(response => {
                messageInput.value = ''; // Clear input field
                fetchMessages(); // Fetch the latest messages
                // We must also scroll after sending a message
                requestAnimationFrame(scrollBottom);
            }).catch(error => console.error('Error sending message:', error));
        });
    }

    // Initial scroll to the bottom when the page loads
    scrollBottom();
});
</script>



</body>

</html>