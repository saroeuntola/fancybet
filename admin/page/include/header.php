<?php
$userLib = new User();
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header("Location: login");
    exit;
}
$user = $userLib->getUser($userId);
?>
<header class="header bg-gray-800">
        <div class="header-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
            <div class="logo">
              Admin System
            </div>
        </div>
        
        <div class="header-right">
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <span class="search-icon">🔍</span>
            </div>
     
     <div class="relative inline-block text-right">
    <a href="/admin/page/user/profile.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-700 transition">
        
        <!-- Avatar -->
        <?php if (!empty($user['profile'])): ?>
            <img 
                src="/admin/page/user/user_image/<?= htmlspecialchars($user['profile']); ?>" 
                alt="Avatar" 
                class="w-10 h-10 rounded-full object-cover border-2 border-white"
            />
        <?php else: ?>
            <div class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
        <?php endif; ?>

        <!-- Username -->
        <div class="flex flex-col">
            <h6 class="text-sm font-semibold text-white">
                <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
            </h6>
        </div>
    </a>
</div>


            
        </div>
    </header>