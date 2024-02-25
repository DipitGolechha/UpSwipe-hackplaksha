<?php
session_start();

$accountType = $_GET['type'] ?? 'default';
if ($accountType === 'default') {
  header("Location: index.php");
  exit;
}
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Consider hashing the password
        $accountType = $_GET['type'] ?? 'default'; // Using null coalescing operator to handle case where type is not set
        
        try {
            $pdo = new PDO('sqlite:upswipe.db');
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO login ('Name', 'Email', 'Password', 'Accounttype') VALUES (:name, :email, :password, :accountType)";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // Remember to hash the password
            $stmt->bindParam(':accountType', $accountType);

            // Execute the statement
            $stmt->execute();
            $userId = $pdo->lastInsertId();

            // Set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $userId;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["accountType"] = $accountType;

            if ($accountType == 'investor') {
              header('Location: investor_details.php');
              
              exit(); 
          } elseif ($accountType == 'startup') {
              header('Location: startup_details.php');
              exit();
          }
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $pdo = null;
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    <style>
        body {
            font-family:sans-serif;
            background-color: #110B11;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
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
        Up
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll -ml-2">
        Swipe
      </span>
    </h1>
      </div>
      <form class="space-y-6" method="POST">
        <div>
            <label class="text-sm font-medium text-white" for="name">
                Name
            </label>
            <input
                type="name" name="name"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="name"
                placeholder="Your name"
                style="color: white; border-color: #595959;"
            />
          </div>

        <div>
            <label class="text-sm font-medium text-white" for="email">
                Email
            </label>
            <input
                type="email" name="email"
                class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                id="email"
                placeholder="Your email"
                style="color: white; border-color: #595959;"
            />
        </div>
        <div>
            <label class="text-sm font-medium text-white" for="password">
    Password
</label>
<input
    type="password" name="password"
    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
    id="password"
    placeholder="Your password"
    style="color: white; border-color: #595959;"
/>
            
        </div>
        
        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full bg-gradient-to-r from-[#667EEA] to-[#764BA2] hover:from-[#764BA2] hover:to-[#667EEA] text-white">
          Sign Up
        </button>
      </form>
      <div class="mt-6 text-center">
        <span class="text-sm">Already a member?</span>
        <a class="text-sm text-blue-400 hover:text-blue-300" href="signin.php" rel="ugc">
          Sign in
        </a>
      </div>
    </div>
  </div>

</body>
</html>