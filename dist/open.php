<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upswipe Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        align-content: center;
    }

    .swipe-up {
        animation: swipeUpAnimation 3s ease forwards; /* Adjust duration as needed */
    }

    @keyframes swipeUpAnimation {
        0% {
            transform: translateY(0);
            opacity: 1;
        }
        100% {
            transform: translateY(-400%); /* Ensure it moves completely out of view */
            opacity: 0; /* Fade out as it moves up */
        }
    }
</style>

</head>
<body>

<div class="flex h-screen w-full flex-col items-center justify-center bg-[#0D0D0D] text-white ">
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
<script>
  document.addEventListener('click', function() {
    const swipeUpElement = document.getElementById('swipeUpElement');
    swipeUpElement.classList.add('swipe-up');

    // Listen for the end of the animation, then redirect
    swipeUpElement.addEventListener('animationend', () => {
      window.location.href = 'index.php'; // Redirect after animation
    });
  }, {once : true}); // Ensure the listener is added only once to prevent multiple redirects
</script>

</body>
</html>