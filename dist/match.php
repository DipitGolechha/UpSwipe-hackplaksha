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
      Congratulations! You have matched with,
      </span>
      
    </h1>
        </div>
        <div class="flex h-36 items-center justify-center p-8 rounded-xl border border-gray-200 border-dashed border-2 border-gray-200 dark:border-gray-800">
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
            class="w-20 h-20"
          >
            <circle cx="12" cy="8" r="5"></circle>
            <path d="M20 21a8 8 0 1 0-16 0"></path>
          </svg>
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
                <button class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-primary-foreground hover:bg-primary/90 h-11 rounded-md px-4 md:px-6" style="width: 100px;">
                    Chat
                </button>
            </div>
            
            
            
        </div>
      </div>
  
</body>

</html>