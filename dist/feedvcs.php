<?php
session_start();

if ($_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
$userId = $_SESSION["id"];


if($_SESSION["accountType"] == "startup"){
  header("Location: feedstartup.php");
  exit;
}
?>

!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>feeds vcs </title>
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
 

<body class="bg-[#110B11] min-h-screen pt-8 pb-16 px-4">
    <div class="relative">
      
      <div class="absolute right-4 top-4 text-white flex items-center">
      
       
      </div>
    </div>
    <div class="max-w-2xl mx-auto  bg-[#110B11]

    rounded-xl overflow-hidden shadow-lg wrapper">

    <div class="max-w-2xl mx-auto bg-[#110B11] rounded-xl overflow-hidden shadow-lg">
        <div class="p-0 items-center">
            <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-white p-2 rounded-md mb-4 shadow w-auto max-w-xs mx-auto">
                <h2 class="font-semibold text-center">FINANCIAL TECHNOLOGY</h2>
            </div>
            <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-white p-2 rounded-md mb-6 shadow w-auto max-w-xs mx-auto">
                <p class="text-center">CHANDIGARH, INDIA</p>
            </div>

        </div>
        <!-- Image Placeholder -->
        <div class="flex justify-center items-center mt-4">
            <div class="w-40 h-24 bg-gray-300 rounded-lg overflow-hidden">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUUAAACbCAMAAADC6XmEAAAAe1BMVEUAAAD////R0dGrq6vp6en8/Pz19fVNTU3Z2dmxsbGLi4tjY2N9fX0MDAzOzs739/fBwcGgoKDt7e1WVlYtLS1bW1vHx8e6urpsbGyRkZHd3d1zc3Pq6uooKCiUlJQ8PDxGRkYgICA5OTmDg4OcnJwaGho7OztPT09wcHDgL6vJAAAFL0lEQVR4nO3c6YKiMAwA4K0oioqC96ijeM34/k+4CupQOQqlaQrm+78mdCcQ2ui/f4QQQgghhBBCCCGEEEIIIYQQQgghhBDTTbETaILhADsDjWbfMJ87H8F8roEG1q4L88l7BvS/Y5j9rje2LkAffmAO0Ccb5HLyxqw9hAtgM7jPNsLl6rQZY14AGGPNLMBPRze31rcVZPbZhYzSYgz08zF1dy0W6m1gA3msoXfFWX8xjpaQLQPgWP4tSPMe0O5mOXmsILN34KXWv4VZQAfRbGC12UtvpSHgPdAcPo42v+ceiwEv5bvgHqmtIZAWP/1RfAXZZKclrNu5B/vSEguYO/Rsbgm1lHJoG4arfZvjrpw2e7M86ooetVI134eY+uv3FWQTjeXlRCEB3yyhBc+emtPSVcp3p0dQjSFV+j69emqOo62U76bP/zmdQRW59dTbtBVkW81PykPnEbh2T2iup+ZLWft+/SsTrQVQVZfvqRFLOeQ9Y9vaQ8s69hedzCVs9xEy6r/C1+Qdevi3uZBihHL01v1L4IwRvxR3kOyp4zoW0pZUrEUw/AD1N6Wn5kxOWKnFW1WoAzEF9l+jzMV7ljLedtQungdaFvkup/fNBYNK+S6IZ2Lirph7zb8RPjJHK+UQ97Az7s1lLroRRhbIY0VLPhvcZHjpmwtJqKUcGvAJLZHTeZnl9dQc5FIOve2DmHGGusntqTnYpRzy3pLC/1vM3lxIGvtGNGbz97w81HTyNheSICeVSkn0YHjP6AI9NWcBNHRYnpXIbY2SR/LATmDsH1ASTTNLyU97EmkHdgJrU0o5lNaN6b1dpx3YiXjGlHJokJbjVVv4oj01B3joUEJqT6anYcw6sBNYAw8dSjilJroFj5t5YCcCOj8sK+OPIQAN+pgGLs82cxO+n5Eu3NtLuZ6aAz0/LC3zvgQSLffATmS5B8lJgfS74p367xfkH9gJaJgflpdzXTOFYUQHdiLahg6lrHIyV/YWKNNTc8wt5Uju5fkKAgQlNxeSdA4dygnyL6BiGR0KHNiJ9Aw/GL9zBNcgv4HsXh25npqDMKkkQXgZcqfj0j01x/xSjmzEl1L6SKhCT83RP3Qoq8iNv8w7TKWeOq7jqGyzgBW6IrvYM8at1FNzJhhDh9IKFHSoLVrHy0rFo+QBcVJJyvvxaTbbytxYPg4dFY+SpzqVcqTUPawzOg9+4v/6u7s5eyoXEGl+uCJBy526lOP2utUatdaTsZrHSFzdSjmyE1+YPviTSpIW2Cv3x4RJJUmV33FVWdSylCMH7MWLjC1zxhskTMVXCM+YSSVZWcdWGi1+sRehMh95CTsGTSrJK/7mAsGsSSV5EtMxynj1L+UHNduAEmzf4DPRstS+AhfWlFJ+QFlFw4YOq9O/iuYNHVan+75o4NChAlVP28vR8vNoCJJfLABj9KRSNV+61tDsSaWKNO1GNLWUH1wNS6jplw4xgbc6jS7lJ+BNHX2/dIjqCLiEH1DKT5VmhPNo/aVDbEOYNazH0KE6qsaTYuoydKjQVfUa1mfoUCW1OxKfVspPB3VLWMdJJVWKjjCK1HNSSRkVOzs1H29QofKBajN3X8uqNDrWcQz/cpk2S/FiZeg16zyvGrltifaupnObUOalRxknFlVykugLgfxfoR9g52uoWcGHTGfU//i2Js/MEX5toOeb8CuHplstM2+QW++racMhgI4np8VtmNnrhT8MGnueDMndTwc3vx+6SUMIIYQQQgghhBBCCCGEEEIIIYQQQgjB8B/gH0Snt6V15wAAAABJRU5ErkJggg==" class="w-full h-full object-cover" alt="Company Logo">
            </div>
        </div>
        
        </div>

<center> 
        <h1 class="font-bold pb-2 transform">
      <span class="text-3xl text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
        Up Swipe
      </span><br>
      <span class="text-transparent text-2xl bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        All about us
      </span>
    </h1>
    </center>
              
      <article class="hover:animate-background rounded-xl p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border-8" >
        <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-lg text-gray-500 dark:text-gray-400">
                Vision
            </time>
            <a href="#">
                <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                    Visibility to make trade-offs between cost, latency, and quality. 
                </h3>
            </a>
    
            <div class="mt-3 flex flex-wrap gap-1">
                
            </div>
        </div>
    </article>
    
      

      <br>

      <article class="hover:animate-background rounded-xl bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border-8" style="border-color: #110B11;">
      <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-lg text-white dark:text-gray-400">
                Unique Selling Point (USP)
            </time>
            <a href="#">
                <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                    Developer productivity.
                </h3>
            </a>
    
            <div class="mt-3 flex flex-wrap gap-1">
                
            </div>
        </div>
    </article>
    

      <br>

      <article class="hover:animate-background rounded-xl bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border-8" style="border-color: #110B11;">
        <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-lg text-gray-500 dark:text-gray-400">
                Motivation
            </time>
            <a href="#">
                <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                    Changing the world of investments.
                </h3>
            </a>
    
            <div class="mt-3 flex flex-wrap gap-1">
                
            </div>
        </div>
    </article>
    
<br>
<article class="hover:animate-background rounded-xl bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border-8" style="border-color: #110B11;">
    <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
        <time datetime="2022-10-10" class="block text-lg text-gray-500 dark:text-gray-400">
            Target Market
        </time>
        <a href="#">
            <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
               Students aiming to secure an investment.
            </h3>
        </a>

        <div class="mt-3 flex flex-wrap gap-1">
            
        </div>
    </div>
</article>
      
<section style="background-color: #110B11;">
    <div class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 md:py-2 lg:px-8">
      
  
      <div class="mt-8 sm:mt-12">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div class="flex flex-col rounded-lg bg-black px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
          
            <h1 class="text-5xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        2019
      </span>
    </h1>
    <h1 class="text-2xl font-bold pb-2 transform">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
          Founding Year
      </span> 
    </h1>
          </div>
  
          <div class="flex flex-col rounded-lg bg-black px-4 py-8 text-center">
          <h1 class="text-5xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        1M+
      </span>
    </h1>
    <h1 class="text-2xl font-bold pb-2 transform">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
          Customers
      </span> 
    </h1>
          </div>
  
          <div class="flex flex-col rounded-lg bg-black px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
          <h1 class="text-5xl font-bold pb-2 transform">
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll">
        50K+
      </span>
    </h1>
    <h1 class="text-2xl font-bold pb-2 transform">
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll">
         Revenue
      </span> 
    </h1>
          </div>
        </dl>
      </div>
    </div>
  </section>
  

  



      </div>
      <br>
      <ul role="list" class="divide-y divide-gray-100">
       
        

        <br>
        
        
        <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between bg-[#110B11] rounded-lg shadow">
          
  
          <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between bg-gradient-to-r from-[#667EEA] to-[#764BA2] rounded-lg shadow">
            <!-- Cross (Cancel) Button on the Left -->
            <button class="p-2 rounded-full bg-red-500 text-white"class="btn swipe-btn" id="reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
  
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

   <!-- Bottom Navigation Bar -->
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