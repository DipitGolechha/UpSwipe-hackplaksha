<?php
session_start();

if ($_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
$userId = $_SESSION["id"];

$pdo = new PDO('sqlite:upswipe.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check if this is an AJAX request to fetch new content

if (isset($_POST['fetchNew']) && $_POST['fetchNew'] == 'true') {
    $lastId = isset($_POST['lastId']) ? intval($_POST['lastId']) : 0;

    // Prepare SQL to fetch next set of content
    $stmt = $pdo->prepare("SELECT ii.*, l.name FROM information_investor ii INNER JOIN login l ON ii.investor_id = l.id WHERE ii.investor_id > :lastId ORDER BY ii.investor_id ASC LIMIT 1");
    $stmt->execute(['lastId' => $lastId]);
    $newContent = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if new content is available
    if ($newContent) {
        // Assuming you have 'name', 'location', etc. in your $newContent
        $html = "<div class='content-item' data-id='{$newContent['investor_id']}'>
                    <h2>{$newContent['name']}</h2>
                    <p>Location: {$newContent['location']}</p>
                    <!-- More content fields here -->
                </div>";

        // Respond with new content and the last ID
        echo json_encode(['success' => true, 'html' => $html, 'lastId' => $newContent['investor_id']]);
    } else {
        // No more content
        echo json_encode(['success' => false]);
    }
    exit; // Important to prevent the rest of the page from processing
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>feeds vcs </title>
  <script src="https://cdn.tailwindcss.com"></script>
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

<body class="bg-[#110B11] min-h-screen pt-8 pb-16 px-4">
     
<div class="wrapper max-w-2xl mx-auto bg-[#110B11] rounded-xl overflow-hidden shadow-lg">

    <div class="max-w-2xl mx-auto  bg-[#110B11]

    rounded-xl overflow-hidden shadow-lg">

    <div class="max-w-2xl mx-auto bg-[#110B11] rounded-xl overflow-hidden shadow-lg">
        <div class="p-0 items-center">
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 text-white p-2 rounded-md mb-4 shadow w-auto max-w-xs mx-auto">
  
                <h2 class="font-semibold text-center">FINANCIAL TECHNOLOGY</h2>
            </div>
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 text-white p-2 rounded-md mb-4 shadow w-auto max-w-xs mx-auto">
  
                <p class="text-center">CHANDIGARH, INDIA</p>
            </div>

        </div>
        <!-- Image Placeholder -->
        <div class="flex justify-center items-center mt-4">
            <div class="w-44 h-26 bg-gray-300 rounded-lg overflow-hidden">
                <img src="data:image/png;base64,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" class="w-full h-full object-cover" alt="Company Logo">
            </div>
        </div>
        


            <center>
                <h2 class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2] animate-pulse-scroll text-6xl font-semibold pt-2">
                    Upswipe
                </h2>
                
              </center>       
              
              <div class="max-w-4xl mx-auto text-center pt-4">
                <!-- Title -->
                <h2 class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA] animate-pulse-scroll text-2xl font-semibold pt-2">
                  All About Us
                </h2>
              </div>
              <br>
              
              <article class="hover:animate-background rounded-xl bg-gradient-to-r from-[#110B11] to-[#110B11] p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border" style="border-color: #667EEA;">

        <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-3xl text-gray-500 dark:text-gray-400">
                Vision
            </time>
            <a href="#">
                <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                    Visibility plays a crucial role in business decision-making, especially concerning cost, latency, and quality trade-offs. It enables organizations to assess the implications of their choices and find the right balance. Understanding the true cost of options, evaluating latency considerations, and maintaining high-quality standards are essential. With visibility, businesses can optimize their operations effectively, driving efficiency and competitiveness in today's dynamic market.
                </h3>
            </a>
    
            <div class="mt-3 flex flex-wrap gap-1">
                
            </div>
        </div>
    </article>
    
      

      <br>

      <article class="hover:animate-background rounded-xl bg-gradient-to-r from-[#110B11] to-[#110B11] p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border" style="border-color: #667EEA;">
 
        <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-3xl text-gray-500 dark:text-gray-400">
                Unique Selling Point (USP)
            </time>
            <a href="#">
                <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                    A unique selling proposition (USP) centered around developer productivity can significantly impact a company's success. By prioritizing tools, workflows, and environments that enhance developer efficiency, businesses can streamline development processes and accelerate time-to-market. This focus on productivity not only improves internal operations but also enhances product quality and innovation, ultimately driving customer satisfaction and market differentiation. 
                    
                </h3>
            </a>
    
            <div class="mt-3 flex flex-wrap gap-1">
                
            </div>
        </div>
    </article>
    

      <br>

      <article class="hover:animate-background rounded-xl bg-gradient-to-r from-[#110B11] to-[#110B11] p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border" style="border-color: #667EEA;">

        <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
            <time datetime="2022-10-10" class="block text-3xl text-gray-500 dark:text-gray-400">
                Motivation
            </time>
            <a href="#">
                <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                    Motivated by the aspiration to revolutionize the realm of investments, businesses are propelled to innovate and disrupt traditional paradigms. This ambition drives them to develop novel approaches, technologies, and strategies that reshape how investments are perceived, accessed, and managed. By challenging conventional wisdom and embracing change, these companies pave the way for a more inclusive, transparent, and dynamic investment landscape.





                </h3>
            </a>
    
            <div class="mt-3 flex flex-wrap gap-1">
                
            </div>
        </div>
    </article>
    
<br>
<article class="hover:animate-background rounded-xl bg-gradient-to-r from-[#110B11] to-[#110B11] p-0.5 shadow-xl transition hover:bg-[length:400%_400%] hover:shadow-sm hover:[animation-duration:_4s] dark:shadow-gray-700/25 border" style="border-color: #667EEA;">
 
    <div class="rounded-[10px] bg-white p-3 sm:p-4 dark:bg-gray-900">
        <time datetime="2022-10-10" class="block text-3xl text-gray-500 dark:text-gray-400">
            Target Market
        </time>
        
        <a href="#">
            <h3 class="mt-0.5 text-base font-medium text-gray-900 dark:text-white">
                Targeting students aspiring to secure investments, businesses tailor their offerings to address the unique needs and preferences of this demographic. By providing accessible and educational resources, they empower students to embark on their investment journey with confidence and knowledge.
            </h3>
        </a>

        <div class="mt-3 flex flex-wrap gap-1">
            
        </div>
    </div>
</article>
      
<section style="background-color: #110B11;">
    
      
  
      <div class="mt-8 sm:mt-12">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div class="flex flex-col rounded-lg bg-gradient-to-r from-gray-500 to-gray-600 px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
            <dt class="order-last text-lg font-medium text-gray-500 dark:text-white/75">
              Founding Year
            </dt>
  
            <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl dark:text-blue-50">2019</dd>
          </div>
  
          <div class="flex flex-col rounded-lg bg-gradient-to-r from-gray-500 to-gray-600 px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
            <dt class="order-last text-lg font-medium text-gray-500 dark:text-white/75">
             Customers
            </dt>
  
            <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl dark:text-blue-50">1M+</dd>
          </div>
  
          <div class="flex flex-col rounded-lg bg-gradient-to-r from-gray-500 to-gray-600 px-4 py-8 text-center dark:from-gray-700 dark:to-gray-800">
            <dt class="order-last text-lg font-medium text-gray-500 dark:text-white/75">
              Revenue
            </dt>
  
            <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl dark:text-blue-50">50K+</dd>
          </div>
        </dl>
      </div>
    </div>
  </section>
</div>



      </div>
      <br>
      <ul role="list" class="divide-y divide-gray-100">
       
        

        <br>
        
        
        <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between bg-[#110B11] rounded-lg shadow">
          
  
          <div class="w-full max-w-2xl mx-auto p-4 flex items-center justify-between [#667EEA] rounded-lg shadow">
            <!-- Cross (Cancel) Button on the Left -->
            <button class="p-2 rounded-full bg-red-500 text-white" id="reset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
  
          <!-- Tick (Check) Button on the Right -->
          <button class="p-2 rounded-full bg-green-500 text-white" id="run">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </button>
    </div>

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
  
    
  <script>
document.addEventListener("DOMContentLoaded", function() {
    fetchNewContent(); // Fetch initial content on page load

    document.getElementById("run").addEventListener("click", function() {
        swipeCard('up');
    });

    document.getElementById("reset").addEventListener("click", function() {
        swipeCard('down');
    });
});

function swipeCard(direction) {
    var wrapper = document.getElementById('contentWrapper');
    wrapper.className = direction === 'up' ? 'wrapper swipe-up' : 'wrapper swipe-down';

    setTimeout(function() {
        fetchNewContent();
        wrapper.className = 'wrapper'; // Reset class
    }, 500); // Adjust timing as needed
}

function fetchNewContent() {
    var lastId = document.getElementById('contentWrapper').getAttribute('data-last-id') || 0;

    fetch(window.location.href, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `fetchNew=true&lastId=${lastId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('contentWrapper').innerHTML += data.html;
            document.getElementById('contentWrapper').setAttribute('data-last-id', data.lastId);
        } else {
            alert('No more content.');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>


</body>

</html>