<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <script>
        const refCode = '<?php echo $ref_code; ?>';
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {})
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <h1 class="text-3xl font-semibold text-blue-600">Thank You!</h1>
        <p class="text-gray-700 mt-4">You payent is now under verification. You may now close this window.</p>
        <div class="mt-6 text-gray-600">
            <p class="font-medium">Your Reference Code:</p>
            <p class="text-lg text-blue-500 font-semibold"><?php echo $ref_code; ?></p>
        </div>

        <button onclick="closeWindow()" class="mt-6 px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">Close Window</button>
    </div>
    <script>
        function closeWindow() {
            window.close();
        }
    </script>
</body>

</html>