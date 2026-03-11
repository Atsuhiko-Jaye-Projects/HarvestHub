<?php 
// Kukunin ang kasalukuyang file name para sa active state ng links
$pageFile = basename(parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH)); 
?>

<style>
    :root {
        --cyber-bg: #05080a;
        --neon-emerald: #10b981;
        --glass-border: rgba(255, 255, 255, 0.08);
        --text-dim: #64748b;
        --nav-hover: rgba(255, 255, 255, 0.03);
    }

    /* Sidebar Wrapper & Glass Effect */
    .sidebar-wrapper {
    
        background-color: var(--cyber-bg);
        min-height: 100vh;
    }

    .sidebar-glass {
        background-color: var(--cyber-bg);
        height: 100vh;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--glass-border);
        font-family: 'Plus Jakarta Sans', sans-serif;
        z-index: 100;
        overflow: hidden;
    }

    /* Brand/Logo Section */
    .sidebar-brand-wrapper {
        padding: 2.5rem 1.5rem;
        flex-shrink: 0;
        text-align: center;
    }

    .brand-logo {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 2px solid var(--glass-border);
        transition: transform 0.3s ease;
    }

    .brand-logo:hover {
        transform: scale(1.05);
        border-color: var(--neon-emerald);
    }

    /* Navigation Content */
    #sidebarNavContent {
        flex: 1;
        overflow-y: auto;
        padding: 0 1.2rem 2rem;
        scrollbar-width: none; /* Firefox */
    }
    #sidebarNavContent::-webkit-scrollbar { display: none; } /* Chrome/Safari */

    .section-tag {
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 1.8rem 0.8rem 0.6rem;
        display: block;
    }

    /* Navigation Items */
    .glass-nav-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 18px;
        color: var(--text-dim);
        text-decoration: none !important;
        border-radius: 14px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 4px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .glass-nav-item i {
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .glass-nav-item:hover {
        background: var(--nav-hover);
        color: #fff;
        padding-left: 22px;
    }

    /* Active State */
    .glass-nav-item.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(16, 185, 129, 0.03) 100%);
        color: #fff;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }

    .glass-nav-item.active i {
        color: var(--neon-emerald);
        filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.6));
    }

    /* Cart Badge Style */
    .cart-counter {
        background: var(--neon-emerald);
        color: var(--cyber-bg);
        font-size: 0.7rem;
        font-weight: 800;
        padding: 1px 8px;
        border-radius: 8px;
        margin-left: auto;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
    }

    /* Sidebar Footer */
    .sidebar-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--glass-border);
        text-align: center;
    }

    .version-text {
        font-size: 0.7rem;
        color: var(--text-dim);
        opacity: 0.6;
        letter-spacing: 1px;
    }
</style>

<aside class="col-xl-2 p-0 sidebar-wrapper d-none d-xl-block">
    <div class="sidebar-glass">
        
        <div class="sidebar-brand-wrapper">
            <a href="<?= $base_url ?>index.php" class="text-decoration-none">
                <img src="<?= $base_url ?>libs/images/logo.png" class="brand-logo rounded-circle mb-2 shadow-lg">
                <h5 class="text-white fw-bold m-0 tracking-tight">Harvest<span style="color:var(--neon-emerald)">Hub</span></h5>
            </a>
        </div>

        <div id="sidebarNavContent">
            
            <span class="section-tag">Marketplace</span>
            <a href="<?= $base_url ?>index.php" class="glass-nav-item <?= ($pageFile=='index.php' || $pageFile=='') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Browse Crops
            </a>
            
            <a href="<?= $base_url ?>user/consumer/order/cart.php" class="glass-nav-item <?= $pageFile=='cart.php' ? 'active' : '' ?>">
                <i class="bi bi-cart-fill"></i> My Cart
                <span class="cart-counter" id="cartCountBadge">0</span>
            </a>

            <span class="section-tag">Activity</span>
            <a href="<?= $base_url ?>user/consumer/order/order.php" class="glass-nav-item <?= in_array($pageFile, ['order.php', 'order_details.php']) ? 'active' : '' ?>">
                <i class="bi bi-bag-check-fill"></i> My Purchase
            </a>
            <a href="<?= $base_url ?>user/consumer/message/message.php" class="glass-nav-item <?= $pageFile=='message.php' ? 'active' : '' ?>">
                <i class="bi bi-chat-left-text-fill"></i> Messages
            </a>

            <span class="section-tag">Settings</span>
            <a href="<?= $base_url ?>user/consumer/profile/settings.php" class="glass-nav-item <?= $pageFile=='settings.php' ? 'active' : '' ?>">
                <i class="bi bi-person-fill-gear"></i> Account Settings
            </a>
            <a href="<?= $base_url ?>user/consumer/support/help.php" class="glass-nav-item <?= $pageFile=='help.php' || $pageFile=='test.php' ? 'active' : '' ?>">
                <i class="bi bi-question-circle-fill"></i> Help & Support
            </a>

        </div>

        <div class="sidebar-footer">
            <div class="version-text">HARVESTHUB CONSUMER v2.0</div>
            <div class="mt-1">
                <i class="bi bi-shield-lock-fill text-success small opacity-50"></i>
            </div>
        </div>

    </div>
</aside>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const navContent = document.getElementById("sidebarNavContent");
    
    // Restore scroll position
    const sidebarScroll = sessionStorage.getItem("consumer_sidebar_scroll");
    if (sidebarScroll) navContent.scrollTop = parseInt(sidebarScroll);

    // Save scroll position on click
    document.querySelectorAll(".glass-nav-item").forEach(item => {
        item.addEventListener("click", () => {
            sessionStorage.setItem("consumer_sidebar_scroll", navContent.scrollTop);
        });
    });

    // Halimbawa ng Cart Counter Logic (Optional)
    // Maaari mong i-update ito gamit ang AJAX o PHP session count
    // document.getElementById('cartCountBadge').innerText = '3';
});
</script>