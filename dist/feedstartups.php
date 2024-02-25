<?php
// Establish connection with the SQLite database
$pdo = new PDO('sqlite:upswipe.db');
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the investor ID from the URL
$investorId = isset($_GET['no']) ? (int)$_GET['no'] : 0;

// Initialize variables
$name = $location = $currentRole = $yourStory = $experience = $education = $expertise = '';

// Check if investor ID is valid
if ($investorId > 0) {
    // Prepare SQL query to fetch investor information
    $investorQuery = "SELECT login.Name, information_investor.location, information_investor.currentrole, information_investor.yourstory, information_investor.experience, information_investor.education, information_investor.expertise FROM login JOIN information_investor ON login.id = information_investor.investor_id WHERE login.id = :investorId";
    $stmt = $pdo->prepare($investorQuery);
    $stmt->bindParam(':investorId', $investorId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch result
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = htmlspecialchars($row['Name']);
        $location = htmlspecialchars($row['location']);
        $currentRole = htmlspecialchars($row['currentrole']);
        $yourStory = htmlspecialchars($row['yourstory']);
        $experience = htmlspecialchars($row['experience']);
        $education = htmlspecialchars($row['education']);
        $expertise = htmlspecialchars($row['expertise']);
    } else {
        echo "No investor found with ID: " . $investorId;
    }
} else {
    echo "Invalid investor ID.";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>fEED STARTUPS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  
</head>
<style>
  
   body {
            font-family:sans-serif;
        }

    /* Existing styles... */
    @keyframes swipeDownAndRed {
        0%, 20% {
            transform: translateY(0);
            background-color: #FF0000; /* Start with red */
        }
        20%, 80% {
            transform: translateY(100%);
            background-color: #B80F0A; /* Maintain red */
        }
        80%, 100% {
            transform: translateY(100%);
            background-color: #B80F0A; /* Keep red */
        }
    }

    .swipe-down {
        animation: swipeDownAndRed 3s forwards; /* Use forwards to maintain final state */
    }

    /* Ensure the swipe-up class is correctly defined as per your requirement */
    @keyframes swipeUpAndGreen {
        0%, 20% {
            transform: translateY(0);
            background-color: #4CBB17; /* Green background */
        }
        20%, 80% {
            transform: translateY(-100%);
            background-color: #4CBB17; /* Maintain green */
        }
        80%, 100% {
            transform: translateY(-100%);
            background-color: #4CBB17; /* Keep green */
        }
    }

    .swipe-up {
        animation: swipeUpAndGreen 3s forwards; /* Adjusted total animation time */
    }

    .swipe-reset {
        animation: none;
        background-color: #E9EAEB; /* Reset background color */
        transform: translateY(0); /* Instantly reset position */
    }
</style>



</head>

<body class="bg-[#110B11] min-h-screen  pb-1 px-4 text-white">

<div class="max-w-2xl mx-auto bg-[#110B11] rounded-xl overflow-hidden shadow-lg wrapper">
      
<div class="max-w-2xl mx-auto rounded-xl overflow-hidden shadow-lg">
<br>
    <div class="flex flex-col items-center pb-0">
        <img alt="John Doe" class="mb-3 w-24 h-24 rounded-full shadow-lg" height="96" src="placeholder.jpg" width="96" style="aspect-ratio: 96 / 96; object-fit: cover;"/>
        </div>
    <div class="p-6 pb-0">
        
          <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-white p-2 rounded-md mb-4 shadow">
            <p class="text-center"><?= htmlspecialchars($location) ?></p>
          </div>
      </div>

    <div class="px-6 py-0">
        <div class="flex flex-col items-center">
            <h2 class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll text-xl font-semibold pt-2">
            <?= htmlspecialchars($name) ?>
              </h2>
            <p class="text-white pb-4">
            <?= nl2br(htmlspecialchars($currentRole)) ?>
            </p>
        </div>
      </div>
      <div class="px-6 py-4 border-t border-gray-200"><p class="text-white text-justify">
      <?= nl2br(htmlspecialchars($yourStory)) ?>
        </p></div><div class="px-6 py-4 border-t border-gray-200"><h3 class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll text-lg font-semibold text-white">
            Investment Portfolio
          </h3><div class="mt-2 grid grid-cols-2 gap-2 text-white"><div><strong>NeoBankX:</strong> Digital banking redefined.
            </div><div><strong>RoboTrade:</strong> AI-driven investment strategies.
            </div><div><strong>Cryptex:</strong> Secure cryptocurrency exchange.
            </div><div><strong>PayTech Solutions:</strong> Contactless payment pioneers.
            </div></div></div><div class="px-6 py-4 border-t border-gray-200"><h3 class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll text-lg font-semibold text-white">
            Past Experiences
          </h3><ul class="mt-2 list-disc list-inside text-white"><li>
          Experience: <?= nl2br(htmlspecialchars($experience)) ?>
            </li><li>
          Education: <?= nl2br(htmlspecialchars($education)) ?>
            </li><li>
          Expertise: <?= nl2br(htmlspecialchars($expertise)) ?>
            </li>
    
        <br>
        <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between bg-gradient-to-r from-[#667EEA] to-[#764BA2] rounded-lg shadow">
          <!-- Cross (Cancel) Button on the Left -->
          <button class="p-2 rounded-full bg-red-500 text-white" class="btn swipe-btn" id="reset" >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>
  
          <!-- Content Here -->
  
          <!-- Tick (Check) Button on the Right -->
          <button class="p-2 rounded-full bg-green-500 text-white" class="btn swipe-btn" id="run">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
          </button>
      </div>
  
      </div>
</div>
<script>
    document.getElementById("run").addEventListener("click", function () {
        var wrapper = document.querySelector('.wrapper');
        wrapper.classList.add('swipe-up');
        wrapper.classList.remove('swipe-down', 'swipe-reset'); // Ensure other classes are removed
    });

    document.getElementById("reset").addEventListener("click", function () {
        var wrapper = document.querySelector('.wrapper');
        wrapper.classList.add('swipe-down');
        wrapper.classList.remove('swipe-up', 'swipe-reset'); // Ensure other classes are removed
    });
</script>


</body>

</html>