<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Match</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="flex flex-col h-screen p-4 items-center justify-center gap-4 text-center md:gap-8 bg-[#110B11] text-white">
        <div class="space-y-2">
          <h1 class="text-3xl font-bold tracking-tighter sm:text-5xl bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-transparent bg-clip-text">
            It's a Match!
          </h1>
          <h1 class="text-2xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
      Congratulations! You have a Match With StartUp 1, 
      </span>
      
    </h1>
        </div>
        <div class="flex h-36 items-center justify-center rounded-xl border border-gray-200 border-dashed border-gray-200 dark:border-gray-800">
        <img src="/dist/uploads/startup-india-hub-logo-vector.png" width="168px" height="144px"> 
       
        </div>
        <div class="space-y-2">
        <h1 class="text-2xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
      We wish you a successful journey ahead!
      </span>
      
    </h1>

        </div>
        <div class="flex w-full flex-col gap-2 min-[400px]:flex-row justify-center">
            <div class="flex justify-center">
              <a href="chats.php">
                <button  class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-primary-foreground hover:bg-primary/90 h-11 rounded-md px-4 md:px-6" style="width: 100px;">
                    Chat
                </button>
</a>
            </div>
            
            
            
        </div>
      </div>
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
</body>

</html>