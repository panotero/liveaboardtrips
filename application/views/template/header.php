<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/tailwind-scrollbar@3.1.0/src/index.min.js"></script>
    <!-- Swiper CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.5.2/flowbite.min.css" rel="stylesheet" />



    <style>
        /* Custom scrollbar styles */
        .custom-scrollbar {
            scrollbar-width: thin;
            /* For Firefox */
            scrollbar-color: #E3C692 #E5E7EB;
            /* Thumb color and track color */
            border-radius: 9999px;
        }

        /* For Chrome, Safari, and Edge */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            /* Width of the vertical scrollbar */
            height: 8px;
            /* Height of the horizontal scrollbar */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #E3C692;
            /* Thumb color */
            border-radius: 9999px;
            /* Rounded scrollbar thumb */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background-color: #E5E7EB;
            /* Track color */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>