<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upswipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

.button-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .button {
            width: 150px;
            background: linear-gradient(to right, #667EEA, #764BA2);
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background: linear-gradient(to right, #764BA2, #667EEA);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            align-content: center;
        }

        body {
            background-color: #0D0D0D;
            color: white;
            font-family: sans-serif;
        }

        .hidden {
            display: none;
        }

        .swipe-up {
            animation: swipeUpAnimation 1.3s ease forwards;
        }

        @keyframes swipeUpAnimation {
            0% {
                transform: translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateY(-300%);
                opacity: 0;
            }
        }

        
    </style>
</head>

<body>

<div id="page1" class="flex h-screen w-full flex-col items-center justify-center bg-[#0D0D0D] text-white ">
<div id="swipeUpElement"> 
    <h1 class="text-6xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
        Up
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        Swipe
      </span>
    </h1>
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll ">
        where 
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        innovation 
       </span>
       <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
        meets
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        investments
      </span>
    </div>
</div>

<div id="page2" class="bg-black text-white min-h-screen flex flex-col items-center justify-between p-4">
    <header class="w-full flex justify-between items-center">
    </header>
    <main class="flex flex-col items-center space-y-8">
    <h1 class="text-6xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
        Up
      </span>
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        Swipe
      </span>
    </h1>
        
        
        <h2 class="text-3xl font-semibold">Get Started!</h2>
        <div class="button-container">
            <button  onclick="window.location.href='signup.php?type=startup';" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/90 h-10 px-4 py-2 bg-transparent text-white button">I'm a Startup</button>
            <button  onclick="window.location.href='signup.php?type=investor';" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/90 h-10 px-4 py-2 bg-transparent text-white button">I'm an Investor</button>
        </div>
    </main>
    <footer class="w-full flex flex-col items-center space-y-4">
        <!-- Adjusted styles for SVG icons -->
        <div class="svg-container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="icon">
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667EEA" />
                        <stop offset="100%" style="stop-color:#764BA2" />
                    </linearGradient>
                </defs>
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="icon">
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667EEA" />
                        <stop offset="100%" style="stop-color:#764BA2" />
                    </linearGradient>
                </defs>
                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
            </svg>
        </div>
    </footer>
</div>

<script>
  document.addEventListener('click', function() {
            const swipeUpElement = document.getElementById('swipeUpElement');
            swipeUpElement.classList.add('swipe-up');

            swipeUpElement.addEventListener('animationend', () => {
                document.getElementById('page1').classList.add('hidden'); // Hide the first page content
                const page2 = document.getElementById('page2');
                page2.classList.remove('hidden'); // Show the second page content
                page2.classList.add('fade-in'); // Apply fade-in effect
            });
        });
    </script>
    </body>
  </html>