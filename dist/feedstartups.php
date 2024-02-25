<!DOCTYPE html>
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
      <img class="w-full h-30 pb-10 " src="/images/logo.png" alt="Upswipe Background">
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
            <!-- Location -->
            <div class="bg-gradient-to-r from-[#667EEA] to-[#764BA2] text-white p-2 rounded-md mb-6 shadow w-auto max-w-xs mx-auto">
                <p class="text-center">CHANDIGARH, INDIA</p>
            </div>
            <!-- Image Placeholder -->
            <div class="flex justify-center items-center mt-4">
                <div class="w-24 h-24 bg-gray-300 rounded-full overflow-hidden">
                    <img src="https://encrypted-tbn1.gstatic.com/licensed-image?q=tbn:ANd9GcSb5YTP_Zfb9Aj9h3n79iDjofIAWbIRCn2mbRxjP04h8I7nDF1tj5DP_oCVy4xqRAyd5fxaiA9eZGJ0W4I" class="w-full h-full object-cover" alt="Profile Picture">
                </div>
            </div>
            <!-- Name -->
            <center>
                <h2 class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll text-4xl font-semibold pt-2">
                    John Doe
                </h2>
            </center>
    
            <div class="max-w-4xl mx-auto text-center pt-4">
                <!-- Title -->
                <h2 class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll text-2xl font-semibold pt-2">
                    All About Me
                </h2>
            </div>
        </div>
    </div>
    
    
              
      <article class="hover:animate-background rounded-xl bg-gradient-to-r from-green-300 via-blue-500 to-purple-600 p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border-8" style="border-color: #110B11;">
        <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-lg text-gray-500 dark:text-gray-400">
                My Story
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
            <time datetime="2022-10-10" class="block text-lg text-gray-500 dark:text-gray-400">
                Current role
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
                My experience and expertise
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
            My education
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


      
<section style="background-color: #110B11;">
    <div class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 md:py-2 lg:px-8">
      
  
      <div class="mt-8 sm:mt-12">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div class="flex flex-col rounded-lg bg-gradient-to-r from-gray-500 to-gray-600 px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
            <dt class="order-last text-lg font-medium text-gray-500 dark:text-white/75">
              In This Industry Since
            </dt>
  
            <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl dark:text-blue-50">2009</dd>
          </div>
  
          <div class="flex flex-col rounded-lg bg-gradient-to-r from-gray-500 to-gray-600 px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
            <dt class="order-last text-lg font-medium text-gray-500 dark:text-white/75">
             Companies Invested In
            </dt>
  
            <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl dark:text-blue-50">50+</dd>
          </div>
  
          <div class="flex flex-col rounded-lg bg-gradient-to-r from-gray-500 to-gray-600 px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
            <dt class="order-last text-lg font-medium text-gray-500 dark:text-white/75">
              Revenue Generated
            </dt>
  
            <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl dark:text-blue-50">50M+</dd>
          </div>
        </dl>
      </div>
    </div>
  </section>
  



      
      <br>
      <ul role="list" class="divide-y divide-gray-100">
       
        

        <br>
        
        
        <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between bg-[#110B11] rounded-lg shadow">
          
  
          <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between bg-gradient-to-r from-[#667EEA] to-[#764BA2] rounded-lg shadow">
            <!-- Cross (Cancel) Button on the Left -->
            <button class="p-2 rounded-full bg-red-500 text-white" class="btn swipe-btn" id="reset" >
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
    <a href="#" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 2a1 1 0 0 1 .755.344l7.5 9a1 1 0 1 1-1.51 1.312L10 4.796 3.755 12.656a1 1 0 1 1-1.51-1.312l7.5-9A1 1 0 0 1 10 2zM5.293 13.707a1 1 0 0 1 0-1.414A1 1 0 0 1 6.707 13.707L10 17l3.293-3.293a1 1 0 1 1 1.414 1.414l-4 4a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
      </svg>
    </a>
    <!-- Chat Icon -->
    <a href="#" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
        <path d="M3 6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6zm2-2v2h10V4H5zm1 4v2h8V8H6zm0 3v2h8v-2H6z" />
      </svg>
    </a>
    <!-- Profile Icon -->
    <a href="#" class="text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
        <path d="M10 2a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 18v-2a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1h1z" />
      </svg>
    </a>
  </nav>
  
    
   

</body>

</html>