<?php
session_start();

if ($_SESSION["loggedin"] !== true || $_SESSION["accountType"] != 'startup') {
    header("Location: index.php");
    exit;
}

$startupid = $_SESSION["id"];
$uploadDir = __DIR__ . '/uploads/';

// Ensure the uploads directory exists
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    die("Failed to create upload directory.");
}

try {
    $pdo = new PDO('sqlite:upswipe.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $checkStmt = $pdo->prepare("SELECT 1 FROM startups_information WHERE startup_id = ?");
    $checkStmt->execute([$startupid]);
    if ($checkStmt->fetch()) {
        // If startup_id exists, redirect to feedstartups.php
        header("Location: feedstartups.php");
        exit;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize inputs
        $startup_name = filter_input(INPUT_POST, 'startup_name', FILTER_SANITIZE_STRING);
        $industry = filter_input(INPUT_POST, 'industry', FILTER_SANITIZE_STRING);
        $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
        $vision = filter_input(INPUT_POST, 'vision', FILTER_SANITIZE_STRING);
        $usp = filter_input(INPUT_POST, 'usp', FILTER_SANITIZE_STRING);
        $motivation = filter_input(INPUT_POST, 'motivation', FILTER_SANITIZE_STRING);
        $target_market = filter_input(INPUT_POST, 'target_market', FILTER_SANITIZE_STRING);
        $customer_num = filter_input(INPUT_POST, 'nocustomers', FILTER_SANITIZE_NUMBER_INT);
        $revenue_till_date = filter_input(INPUT_POST, 'revenue', FILTER_SANITIZE_NUMBER_INT);
        $team_size = filter_input(INPUT_POST, 'number_team_members', FILTER_SANITIZE_NUMBER_INT);
        $founding_date = filter_input(INPUT_POST, 'founding_date', FILTER_SANITIZE_STRING);
        $funding_stage = filter_input(INPUT_POST, 'funding_stage', FILTER_SANITIZE_STRING);
        $customer_acc_cost = filter_input(INPUT_POST, 'customer_acquisition_cost', FILTER_SANITIZE_NUMBER_INT);
        $retention_rate_perc = filter_input(INPUT_POST, 'retention_rate', FILTER_SANITIZE_NUMBER_INT);
        $user_growth_perc = filter_input(INPUT_POST, 'user_growth_percentage', FILTER_SANITIZE_NUMBER_INT);
        $about_team = filter_input(INPUT_POST, 'abt_team', FILTER_SANITIZE_STRING);
        
        // Handle the logo upload
        $logoPath = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $logoPath = $uploadDir . basename($_FILES['logo']['name']);
            move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath);
        }

        // Insert into startups_information table
        $sql = "INSERT INTO startups_information (startup_id, startup_name, industry, location, vision, usp, motivation, target_market, customer_num, revenue_till_date, Team_size, Founding_year, logo, Funding_stage, Customer_acc_cost, Retention_rate_perc, User_growth_perc, about_team) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $founding_year = date('Y', strtotime($founding_date)); // Assuming the founding_date is in a valid date format
        $stmt->execute([$startupid, $startup_name, $industry, $location, $vision, $usp, $motivation, $target_market, $customer_num, $revenue_till_date, $team_size, $founding_year, $logoPath, $funding_stage, $customer_acc_cost, $retention_rate_perc, $user_growth_perc, $about_team]);

        // Insert into people_team_startups table
        $sql_people = "INSERT INTO people_team_startups (startup_id, Name, Role, Degree_uni, person_image_path) VALUES (?, ?, ?, ?, ?)";
        $stmt_people = $pdo->prepare($sql_people);

        for ($i = 1; $i <= 3; $i++) {
            $memberName = filter_input(INPUT_POST, "name$i", FILTER_SANITIZE_STRING);
            $memberRole = filter_input(INPUT_POST, "role$i", FILTER_SANITIZE_STRING);
            $memberEducation = filter_input(INPUT_POST, "education$i", FILTER_SANITIZE_STRING);
            $imagePath = null;
            if (isset($_FILES["picture$i"]) && $_FILES["picture$i"]['error'] === UPLOAD_ERR_OK) {
                $imagePath = $uploadDir . basename($_FILES["picture$i"]['name']);
                move_uploaded_file($_FILES["picture$i"]['tmp_name'], $imagePath);
            }
            if (!empty($memberName)) {
                $stmt_people->execute([
                    $startupid,
                    $memberName,
                    $memberRole,
                    $memberEducation,
                    $imagePath
                ]);
            }
        }

        header("Location: feedstartups.php");
        exit;
        // Consider redirecting to a confirmation page or displaying a success message.
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>


        


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup details</title>
    <style>
        body {
            font-family:sans-serif;
            background-color: #110B11;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="min-h-screen bg-black text-white flex flex-col items-center justify-center">
    <div class="w-full max-w-xs">
    <div class="flex items-center justify-center mb-8">
      <h1 class="text-5xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
        Startup
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll ">
        Details
      </span>
    </h1>
      </div>
      <form class="space-y-6" method="POST" enctype="multipart/form-data">
        <div>
            <label class="text-sm font-medium text-white" for="startup_name">
                Startup name
            </label>
            <input
                type="text" name="startup_name"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="startup_name"
                placeholder="Enter your startup name"
                style="color: white; border-color: #595959;"
                required
            />
        </div>
        

        <div>
            <label for="industry" class="block text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Industry</label>
<select 
    name="industry" 
    id="industry" 
    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white" 
    style="color: white; border-color: #595959;"
    required
>
    <option value="" selected disabled>Your industry</option>
    <option value="Agriculture">Agriculture</option>
    <option value="Manufacturing">Manufacturing</option>
    <option value="InformationTechnology">Information Technology</option>
    <option value="Pharmaceuticals">Pharmaceuticals</option>
    <option value="Automobile">Automobile</option>
    <option value="FinancialServices">Financial Services</option>
    <option value="Infrastructure">Infrastructure</option>
    <option value="TourismHospitality">Tourism & Hospitality</option>
    <option value="EducationTraining">Education & Training</option>
    <option value="RetailEcommerce">Retail & Ecommerce</option>
    <option value="Anyother">Any Other</option>
</select>

        </div>
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
                required
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="vision">
                Vision
            </label>
            <input
                type="text" name="vision"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="vision"
                placeholder="Your vision"
                style="color: white; border-color: #595959;"
                required
                />
        </div>
        
        <div>
            <label class="text-sm font-medium text-white" for="usp">
                Unique Selling Proposition (USP)
</label>
<input
    type="text" name="usp"
    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
    id="usp"
    placeholder="Your USP"
    style="color: white; border-color: #595959;"
    required
/>
            
        </div>

        <div>
            <label class="text-sm font-medium text-white" for="motivation">
                Motivation
            </label>
            <input
                type="text" name="motivation"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="motivation"
                placeholder="Your motivation"
                style="color: white; border-color: #595959;"
                required
                />
        </div>

        <div>
            <label class="text-sm font-medium text-white" for="target_market">
                Target Market
            </label>
            <input
                type="text" name="target_market"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="vision"
                placeholder="Your target market"
                style="color: white; border-color: #595959;"
                required
                />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="nocustomers">
                Number of customers in 100s
            </label>
            <input
                type="number" name="nocustomers"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="nocustomers"
                placeholder="Number of customers in 100s"
                style="color: white; border-color: #595959;"
                required
                />
        </div>

        <div>
            <label class="text-sm font-medium text-white" for="revenue">
                Revenue till date in lakhs
            </label>
            <input
                type="number" name="revenue"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="revenue"
                placeholder="Your revenue in lakhs"
                style="color: white; border-color: #595959;"
                required
                />
        </div>

       
        

        <div>
            <label class="text-sm font-medium text-white" for="number_team_members">
                Number of team members
            </label>
            <input
                type="number" name="number_team_members"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="number_team_members"
                placeholder="Enter number of team members"
                style="color: white; border-color: #595959;"
                required   
                />
        </div>
        <div style="position: relative;">
            <label class="text-sm font-medium text-white" for="name1">
                Founding member 1:
            </label>
            <input
                type="text" 
                name="name1"
                placeholder="Name"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="name1"
                style="color: white; border-color: #595959; position: relative; z-index: 1;"
                required
                />
            <!-- Sub text boxes for role and education -->
            <input
                type="text" 
                name="role1"
                placeholder="Role"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="role1"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
            <input
                type="text" 
                name="education1"
                placeholder="Education"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="education1"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
            <!-- Upload picture slot -->
            <input
                type="file"
                name="picture1"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
        </div>

        <div style="position: relative;">
            <label class="text-sm font-medium text-white" for="name2">
                Founding member 2:
            </label>
            <input
                type="text" 
                name="name2"
                placeholder="Name"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="name2"
                style="color: white; border-color: #595959; position: relative; z-index: 1;"
                required
                />
            <!-- Sub text boxes for role and education -->
            <input
                type="text" 
                name="role2"
                placeholder="Role"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="role2"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
            <input
                type="text" 
                name="education2"
                placeholder="Education"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="education2"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
            <!-- Upload picture slot -->
            <input
                type="file"
                name="picture2"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
        </div>



        <div style="position: relative;">
            <label class="text-sm font-medium text-white" for="name3">
                Founding member 3:
            </label>
            <input
                type="text" 
                name="name3"
                placeholder="Name"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="name3"
                style="color: white; border-color: #595959; position: relative; z-index: 1;"
                required           />
            <!-- Sub text boxes for role and education -->
            <input
                type="text" 
                name="role3"
                placeholder="Role"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="role3"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required />
            <input
                type="text" 
                name="education3"
                placeholder="Education"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="education3"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required/>
            <!-- Upload picture slot -->
            <input
                type="file"
                name="picture3"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
                required
                />
        </div>
        <div style="position: relative;">
            <label class="text-sm font-medium text-white" for="abt_team">
                About the team
            </label>
            <input
                type="text" 
                name="abt_team"
                placeholder="About your team"
                class="flex h-19 px-3 py-8 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="abt_team"
                style="color: white; border-color: #595959; position: relative; z-index: 1;"
                required/>
        </div>
        
        

        <div>
            <label class="text-sm font-medium text-white" for="founding_date">
                Founding Date
            </label>
            <input
                type="date" 
                name="founding_date"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="founding_date"
                style=" border-color: #595959;"
                required/>
        </div>

        <div>
            <label class="text-sm font-medium text-white" for="funding_stage">
                Funding Stage
            </label>
            <input
                type="text" 
                name="funding_stage"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="funding_stage"
                placeholder="Funding Stage"
                style="color: white; border-color: #595959;"
                required/>
        </div>

        <div>
            <label class="text-sm font-medium text-white" for="customer_acquisition_cost">
                Customer Acquisition Cost
            </label>
            <input
                type="number" 
                name="customer_acquisition_cost"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="customer_acquisition_cost"
                placeholder="Customer Acquisition Cost"
                style="color: white; border-color: #595959;"
                required/>
        </div>

        
        <div>
            <label class="text-sm font-medium text-white" for="retention_rate">
                Retention Rate in %
            </label>
            <input
                type="number" 
                name="retention_rate"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="retention_rate"
                placeholder="Retention Rate in %"
                style="color: white; border-color: #595959;"
                required/>
        </div>

        <div>
            <label class="text-sm font-medium text-white" for="user_growth_percentage">
                User Growth Percentage (Annual) in %
            </label>
            <input
                type="number" 
                name="user_growth_percentage"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="user_growth_percentage"
                placeholder="User Growth Percentage (Annual) in %"
                style="color: white; border-color: #595959;"
                required />
        </div>
        
        
        <div>
            <label class="text-sm font-medium text-white" for="logo">
                Startup logo
            </label>
            <input
            type="file"
            name="logo"
            class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
            style="color: white; border-color: #595959; position: relative; z-index: 1; margin-top: 10px;"
            required
            />

        </div>



        
        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full bg-gradient-to-r from-[#667EEA] to-[#764BA2] hover:from-[#764BA2] hover:to-[#667EEA] text-white">
         Done
        </button>
      </form>
      
    </div>
  </div>

</body>
</html>