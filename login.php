<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('./admin/page/library/auth.php');
$auth = new Auth();

// Initialize error message
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if ($auth->login($username, $password, $remember)) {
        $result = dbSelect('users', 'role_id', "username=" . $auth->db->quote($username));
        if ($result && count($result) > 0) {
            $user = $result[0];
            if ($user['role_id'] == 1) {
                header('Location: ./admin');
                exit();
            } elseif ($user['role_id'] == 2) {
                header('Location: ./');
                exit();
            } elseif ($user['role_id'] == 3) {
                header('Location: ./admin/players_record');
                exit();
            }
        }
    } else {
        // Set the error message to show in HTML
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="relative overflow-hidden bg-gray-900 font-sans">

    <!-- Centered login card -->
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md">
            <div class=" rounded-3xl shadow-2xl bg-gray-700 p-8">

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-white mb-2">Login</h1>
                    <p class="text-white text-sm">Welcome back! Please login to your account.</p>
                </div>

                <!-- Login Form -->
                <form action="login" method="POST" class="space-y-6 bg-gry">

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-white/80 text-sm mb-1">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-3 rounded-xl bg-white/10 text-white placeholder-white/60 border border-white/30 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition duration-300">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-white/80 text-sm mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl bg-white/10 text-white placeholder-white/60 border border-white/30 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition duration-300">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-white/80 text-sm">
                            <input type="checkbox" id="remember" name="remember" class="checkbox-custom mr-2">
                            Remember me
                        </label>

                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-purple-500 hover:bg-purple-600 text-white font-semibold transition-all shadow-lg hover:shadow-2xl">
                        Sign In
                    </button>

                    <!-- Error Message -->
                    <?php if (isset($error_message)): ?>
                        <div class="bg-red-500/80 text-white text-center rounded-lg mt-3">
                            <p><?= htmlspecialchars($error_message) ?></p>
                        </div>
                    <?php endif; ?>
                </form>


            </div>
        </div>
    </div>

</body>


</html>