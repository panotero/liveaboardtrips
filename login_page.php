<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white/70 backdrop-blur-md border border-gray-200 rounded-lg p-8 shadow-lg max-w-md w-full">
        <div class="text-center mb-6">
            <!-- Logo -->
            <img src="your-logo-url-here" alt="Logo" class="w-24 mx-auto mb-4">
            <h2 class="text-2xl font-bold">Log in to Live Aboard Trips Admin site</h2>
        </div>
        <!-- Display Error Message -->
        <?php if (isset($error)) : ?>
            <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <!-- Form -->
        <form action="<?= site_url('user/login'); ?>" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 mb-2">Username or Email</label>
                <input type="text" name="username" id="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your username or email" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors">Log In</button>
        </form>
        <!-- Sign Up Button -->
        <div class="text-center mt-4">
            <button class="text-blue-500 hover:underline">Sign Up</button>
        </div>
    </div>
</body>

</html>