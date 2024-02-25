<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
    <style>
        body {
            font-family:sans-serif;
            background-color: #110B11;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-black text-white flex flex-col items-center justify-center pt-2 pb-5">
        <div class="w-full max-w-xs">
            <div class="flex flex-col items-start justify-center mb-5">
                <h1 class="text-5xl font-bold pb-2">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4F4F4F] to-[#CACACA]">
                        Profile
                    </span>
                </h1>
                <h1 class="text-5xl font-bold">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#667EEA] to-[#764BA2]">
                        Edit
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
                    placeholder="Edit name"
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
                    placeholder="Edit email"
                    style="color: white; border-color: #595959;"
                />
            </div>
            <div>
                <label class="text-sm font-medium text-white" for="phone">
                    Phone Number
                </label>
                <div class="flex">
                    <select name="country_code" class="h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 rounded-l-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white w-11.5">
                        <!-- Populate this with options for different country codes -->
                        <option value="+1">+1</option>
                        <option value="+44">+44</option>
                        <option value="+91">+91</option>
                        <!-- Add other country codes as needed -->
                    </select>
                    <input
                        type="tel" name="phone"
                        class="flex-1 h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-r-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                        id="phone"
                        placeholder="Edit phone"
                        pattern="^\+[0-9]{1,14}$"
                        title="Phone number must start with a + and include up to 14 digits."
                        style="color: white; border-color: #595959; border-left: none;"
                    />
                </div>
            </div>
            <div>
                <label class="text-sm font-medium text-white" for="location">
                    Location
                </label>
                <input
                    type="location" name="location"
                    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                    id="location"
                    placeholder="Edit Location"
                    style="color: white; border-color: #595959;"
                />
            </div>
            <div>
                <label class="text-sm font-medium text-white" for="role">
                    Current Role
                </label>
                <input
                    type="role" name="role"
                    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                    id="role"
                    placeholder="Edit Role"
                    style="color: white; border-color: #595959;"
                />
            </div>
            <div>
                <label class="text-sm font-medium text-white" for="experience">
                    Experience
                </label>
                <input
                    type="experience" name="experience"
                    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                    id="role"
                    placeholder="Edit Experience"
                    style="color: white; border-color: #595959;"
                />
            </div>
                <div>
                    <label class="text-sm font-medium text-white" for="expertise">
                        Expertise
                    </label>
                    <textarea type="expertise" name="expertise" 
                    class="flex h-10 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 w-full rounded-md border bg-gradient-to-r from-gray-500 to-gray-600 border-white text-white"
                    id="expertise"
                    placeholder="Edit Expertise"
                    style="color: white; border-color: #595959;">
                </textarea>
                </div>
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full bg-gradient-to-r from-[#667EEA] to-[#764BA2] hover:from-[#764BA2] hover:to-[#667EEA] text-white">
                    Save
                   </button>
                 </form>
                 
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