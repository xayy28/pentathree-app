<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Test - Pentathree</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-700 transform transition duration-500 hover:scale-105">
        <div class="p-8 sm:p-12">
            <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-tr from-blue-500 to-purple-600 rounded-full mb-8 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 mb-4 tracking-tight">
                Tailwind is Working!
            </h1>
            
            <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                If you can see this beautiful, modern card with gradients, custom fonts, and smooth hover animations, your Tailwind CSS integration in Laravel via Vite is perfectly configured.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-gray-900">
                    Back to Home
                </a>
                <button class="inline-flex justify-center items-center px-6 py-3 border border-gray-600 text-base font-medium rounded-xl text-gray-300 bg-transparent hover:bg-gray-700 hover:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 focus:ring-offset-gray-900">
                    Explore More
                </button>
            </div>
        </div>
        
        <div class="bg-gray-700/50 px-8 py-4 sm:px-12 border-t border-gray-700 flex justify-between items-center">
            <span class="text-sm text-gray-400 font-medium">Laravel + Vite + Tailwind</span>
            <div class="flex space-x-2">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
            </div>
        </div>
    </div>

</body>
</html>
