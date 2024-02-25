<?php
session_start();

if ($_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
$userId = $_SESSION["id"];

try {
  $pdo = new PDO('sqlite:upswipe.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch chats involving the logged-in user
// Assuming the 'login' table has columns 'id' and 'name'
$sql = "SELECT 
c.id AS chat_id, 
m.message, 
m.timestamp, 
l.id AS other_person_id, 
l.Accounttype AS other_person_type,
l.Name AS other_person_name
FROM 
chats c
JOIN 
messages m ON c.id = m.chat_id
JOIN 
chat_twopeople cp ON c.id = cp.chat_id
JOIN 
login l ON l.id = (CASE WHEN cp.person1_id = :userId THEN cp.person2_id ELSE cp.person1_id END)
WHERE 
cp.person1_id = :userId OR cp.person2_id = :userId
GROUP BY 
c.id
ORDER BY 
m.timestamp DESC;";


  $stmt = $pdo->prepare($sql);
  $stmt->execute(['userId' => $userId]);
  $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Chat </title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#110B11] min-h-screen flex items-center justify-center">
  <div class="w-full max-w-sm mx-auto rounded-lg shadow-lg">
    <div class="flex items-center justify-between bg-gradient-to-r from-[#667EEA] to-[#764BA2] p-4 text-white">
      <!-- Menu Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <!-- Title -->
      <h1 class="text-xl font-semibold">Chats</h1>
      <!-- Placeholder for menu icon to center the title -->
      <div class="w-6 h-6"></div>
    </div>
    <!-- Chat List -->
    <br>
    <div class="overflow-y-auto" style="height: calc(100vh - 4rem);"> <!-- Adjusted height for full screen minus header/footer -->
      <!-- Chat Item -->
      <!-- ... Repeat for each chat item ... -->
    
      <?php foreach ($chats as $chat): ?>
    <?php
    // Initialize variables
    $profileImagePath = null;

    // Determine the correct SQL based on other_person_type
    if ($chat['other_person_type'] === 'startup') {
        $sql = "SELECT logo AS profile_image_path FROM startups_information WHERE startup_id = :other_person_id";
    } elseif ($chat['other_person_type'] === 'investor') {
        $sql = "SELECT image AS profile_image_path FROM information_investor WHERE investor_id = :other_person_id";
    }

    // Execute the SQL if it's defined
    if (isset($sql)) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['other_person_id' => $chat['other_person_id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $profileImagePath = $result ? $result['profile_image_path'] : null;
    }

    // Adjust the image path
    $basePath = '/home/dipit/Dipit/UpSwipe/dist/'; // Base directory path to be removed
    $relativePath = str_replace($basePath, '', $profileImagePath);
    $relativePath = ltrim($relativePath, '/');
    ?>
    <!-- Wrap the chat item in an anchor tag for redirection -->
    <a href="message.php?chat_id=<?= htmlspecialchars($chat['chat_id']) ?>" class="flex items-center space-x-3 pb-2 no-underline text-white hover:text-gray-200">
        <!-- Display profile image if available -->
        <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <?php if (!empty($profileImagePath)): ?>
                <img src="<?= htmlspecialchars($relativePath) ?>" alt="Profile Image" class="rounded-full object-cover">
            <?php else: ?>
                <!-- Placeholder if no image is available -->
                <span class="flex h-full w-full items-center justify-center rounded-full bg-muted">N/A</span>
            <?php endif; ?>
        </span>
        <!-- Chat Details -->
        <div class="flex-1">
            <p class="text-sm font-semibold"><?= htmlspecialchars($chat['other_person_name']) ?></p>
            <p class="text-xs text-gray-500"><?= htmlspecialchars($chat['message']) ?></p>
        </div>
        <p class="text-xs text-gray-500"><?= htmlspecialchars($chat['timestamp']) ?></p>
    </a>
<?php endforeach; ?>




    
      <!-- Add Chat Button --><br>
      <nav class="fixed bottom-0 left-0 right-0 bg-gray-900 flex justify-around py-4">
    <!-- Home Icon -->
    <a href="chats.php" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 2a1 1 0 0 1 .755.344l7.5 9a1 1 0 1 1-1.51 1.312L10 4.796 3.755 12.656a1 1 0 1 1-1.51-1.312l7.5-9A1 1 0 0 1 10 2zM5.293 13.707a1 1 0 0 1 0-1.414A1 1 0 0 1 6.707 13.707L10 17l3.293-3.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
      </svg>
    </a>
    <!-- Chat Icon -->
    <a href="feedstartups.php" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
        <path d="M3 6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6zm2-2v2h10V4H5zm1 4v2h8V8H6zm0 3v2h8v-2H6z" />
      </svg>
    </a>
    <!-- Profile Icon -->
    <a href="index.php" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
        <path d="M10 2a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 18v-2a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1h1z" />
      </svg>
    </a>
  </nav>
    </div>
  </div>
  <script>
    // JS if needed
  </script>
  
</body>
</html>
