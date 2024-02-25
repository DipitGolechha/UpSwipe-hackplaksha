<?php
session_start();

if ($_SESSION["loggedin"] !== true || $_SESSION["accountType"] != 'investor') {
    header("Location: index.php");
    exit;
}

$pdo = new PDO('sqlite:upswipe.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$investorId = $_SESSION["id"]; // Assuming the session stores the investor's ID
$uploadDir = __DIR__ . '/uploads/';

$checkStmt = $pdo->prepare("SELECT 1 FROM information_investor WHERE investor_id = ?");
    $checkStmt->execute([$investorId]);
    if ($checkStmt->fetch()) {
        // If startup_id exists, redirect to feedstartups.php
        header("Location: feedvcs.php");
        exit;
    }

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $currentRole = filter_input(INPUT_POST, 'current_role', FILTER_SANITIZE_STRING);
    $yourStory = filter_input(INPUT_POST, 'your_story', FILTER_SANITIZE_STRING);
    $yourExperience = filter_input(INPUT_POST, 'your_experience', FILTER_SANITIZE_STRING);
    $yourEducation = filter_input(INPUT_POST, 'your_education', FILTER_SANITIZE_STRING);
    $yourExpertise = filter_input(INPUT_POST, 'your_expertise', FILTER_SANITIZE_STRING);
    $fundingPref = filter_input(INPUT_POST, 'funding_pref', FILTER_SANITIZE_STRING);
    $sinceyear = filter_input(INPUT_POST, 'sinceyear', FILTER_SANITIZE_STRING);
    $comp_invested = filter_input(INPUT_POST, 'comp_invested', FILTER_SANITIZE_STRING);
    $Revenuegen = filter_input(INPUT_POST, 'Revenuegen', FILTER_SANITIZE_STRING);

    
    // Handle file upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $fileName;
        if (!move_uploaded_file($tmpName, $imagePath)) {
            die('Failed to save uploaded image.');
        }
    }
    
    try {
        // Assuming PDO is already configured to use SQLite
        $pdo = new PDO('sqlite:upswipe.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into database
        $sql = "INSERT INTO information_investor (investor_id, location, currentrole, yourstory, experience, education, expertise, image, Funding_stage_preference,industry_since,companies_invested,revenue_gen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$investorId, $location, $currentRole, $yourStory, $yourExperience, $yourEducation, $yourExpertise, $imagePath, $fundingPref,$sinceyear,$comp_invested,$Revenuegen]);
        
        // Redirect after successful insertion
        header("Location: feedvcs.php");
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Details</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #110B11;
        }

        /* Custom Styles for Choices.js to match design */
        .choices {
            --choices-bg: #595959; /* Dropdown background */
            --choices-button-color: #ffffff; /* Button color */
            --choices-item-selectable-color: #ffffff; /* Item text color */
            --choices-item-highlight-color: #333333; /* Highlight color */
            --choices-border-color: #595959; /* Border color */
        }
        .choices_list--dropdown .choices_item {
            color: var(--choices-item-selectable-color);
        }
        .choices[data-type*="select-multiple"] .choices__button,
        .choices[data-type*="select-one"] .choices__button {
            color: var(--choices-button-color);
        }
        .choices__item--selectable.is-highlighted {
            background-color: var(--choices-item-highlight-color);
        }
        .choices[data-type*="select-multiple"] .choices__item,
        .choices[data-type*="select-one"] .choices__item {
            background-color: var(--choices-bg);
            border-color: var(--choices-border-color);
        }
        .choices__inner {
            background-color: var(--choices-bg);
            color: white;
            border-color: var(--choices-border-color);
        }
        .choices__input {
            color: white;
        }
        .choices_list--multiple .choices_item {
            background-color: var(--choices-bg);
            color: white;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
</head>
<body>
<!--
// v0 by Vercel.
// https://v0.dev/t/jnQOKxQnfYC
-->

<div class="min-h-screen bg-black text-white flex flex-col items-center justify-center">
    <div class="w-full max-w-xs">
    <div class="flex items-center justify-center mb-8">
      <h1 class="text-5xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
        Investor
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll ">
        Details
      </span>
    </h1>
      </div>
      <form class="space-y-6" method="POST" enctype="multipart/form-data">
        <div>
            <label class="text-sm font-medium text-white" for="location">
                Location
            </label>
            <input
                type="text" name="location"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="location"
                placeholder="Your location"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="current_role">
                Current Role
            </label>
            <input
                type="text" name="current_role"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="current_role"
                placeholder="Your current role"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="your_story">
                Your Story
            </label>
            <input
                type="text" name="your_story"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="your_story"
                placeholder="Your story"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="email">
                Your Experience
            </label>
            <input
                type="text" name="your_experience"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="your_experience"
                placeholder="Your experience"
                style="color: white; border-color: #595959;"
            />
        </div>
        
        <div>
            <label class="text-sm font-medium text-white" for="your_education">
    Your Education
</label>
<input
    type="text" name="your_education"
    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
    id="your_education"
    placeholder="Your education"
    style="color: white; border-color: #595959;"
/>
</div>
        <div>
            
        <label class="text-sm font-medium text-white" for="your_expertise">
                Your Expertise
            </label>
            <input
                type="text" name="your_expertise"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="your_expertise"
                placeholder="Your expertise"
                style="color: white; border-color: #595959;"
            />
        </div>
        
        <div>
            <label class="text-sm font-medium text-white" for="sinceyear">
               In the industry since 
            </label>
            <input
                type="number" name="sinceyear"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="sinceyear"
                placeholder="In the industry since (year)"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="comp_invested">
                No of comapnies invested in 
            </label>
            <input
                type="numbers" name="comp_invested"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="comp_invested"
                placeholder="No of comapnies invested in"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="Revenuegen">
            Revenue generated in million
            </label>
            <input
                type="number" name="Revenuegen"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="Revenuegen"
                placeholder="Revenue generated in million"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="image">
                Image
            </label>
            <input
            type="file"
            name="image"
            class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
            style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
            required
            />

        </div>


            <div>
            
                <label class="text-sm font-medium text-white" for="funding_pref">
                        Funding stage preference
                    </label>
                    <input
                        type="text" name="funding_pref"
                        class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                        id="funding_pref"
                        placeholder="Your funding preference"
                        style="color: white; border-color: #595959;"
                    />
                </div>
                <div>
            
        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full bg-gradient-to-r from-[#667EEA] to-[#764BA2] hover:from-[#764BA2] hover:to-[#667EEA] text-white">
         Done
        </button>
      </form>
      
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    var multipleCancelButton = new Choices('#your_interest', {
        removeItemButton: true,
    });
</script>

</body>
</html>