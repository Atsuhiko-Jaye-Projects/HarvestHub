<?php 
$pageFile = basename(parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH)); 
$isFarmRegistered = (isset($_SESSION['is_farm_registered']) && $_SESSION['is_farm_registered'] == "1");
?>

<style>
    :root {
        --cyber-bg: #05080a;
        --neon-emerald: #10b981;
        --glass-border: rgba(255, 255, 255, 0.08);
        --text-dim: #64748b;
    }

    /* 1. THE INFINITE HEIGHT FIX */
    /* Gagawa tayo ng "fake" background na laging sagad sa baba */
    .sidebar-wrapper {
        position: relative;
        background-color: var(--cyber-bg);
        min-height: 100vh;
    }

    /* Ito yung magic: Kahit bitin ang content, laging itim ang background hanggang dulo */
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

    /* 2. SCROLLABLE CONTENT AREA */
    #sidebarNavContent {
        flex: 1;
        overflow-y: auto;
        padding: 0 1.2rem 3rem;
        scrollbar-width: none;
    }
    #sidebarNavContent::-webkit-scrollbar { display: none; }

    .sidebar-brand-wrapper {
        padding: 2.5rem 1.5rem;
        flex-shrink: 0;
        text-align: center;
    }

    .section-tag {
        font-size: 0.6rem;
        font-weight: 800;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: 2.5px;
        margin: 1.8rem 0.8rem 0.6rem;
        display: block;
    }

    /* 3. NAV LINK STYLES */
    .glass-nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 18px;
        color: var(--text-dim);
        text-decoration: none !important;
        border-radius: 16px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 6px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .glass-nav-item:hover {
        background: rgba(255, 255, 255, 0.03);
        color: #fff;
    }

    .glass-nav-item.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
        color: #fff;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .glass-nav-item.active i {
        color: var(--neon-emerald);
        filter: drop-shadow(0 0 8px var(--neon-emerald));
    }
</style>

<aside class="col-xl-2 p-0 sidebar-wrapper d-none d-xl-block">
    <div class="sidebar-glass">
        <div class="sidebar-brand-wrapper">
            <a href="#" class="text-decoration-none">
                <img src="<?= $base_url ?>libs/images/logo.png" width="55" height="55" class="rounded-circle mb-2 shadow-lg">
                <h5 class="text-white fw-bold m-0">Harvest<span style="color:var(--neon-emerald)">Hub</span></h5>
            </a>
        </div>

        <div id="sidebarNavContent">
            <span class="section-tag">Insights</span>
            <a href="<?= $base_url ?>user/farmer/index.php" class="glass-nav-item <?= $pageFile=='index.php' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?= $base_url ?>user/farmer/farm/farm_crop_analytics.php" class="glass-nav-item <?= $pageFile=='farm_crop_analytics.php' ? 'active' : '' ?>">
                <i class="bi bi-graph-up-arrow"></i> Analytics
            </a>

            <?php if($isFarmRegistered): ?>
            <span class="section-tag">Operations</span>
            <a href="<?= $base_url ?>user/farmer/farm/farm_resource.php" class="glass-nav-item <?= $pageFile=='farm_resource.php' ? 'active' : '' ?>">
                <i class="bi bi-archive"></i> Farm Inputs
            </a>
            <a href="<?= $base_url ?>user/farmer/farm/daily_crop_log.php" class="glass-nav-item <?= $pageFile=='daily_crop_log.php' ? 'active' : '' ?>">
                <i class="bi bi-journal-text"></i> Daily Log
            </a>

            <span class="section-tag">Warehouse</span>
            <a href="<?= $base_url ?>user/farmer/management/manage_crop.php" class="glass-nav-item <?= $pageFile=='manage_crop.php' ? 'active' : '' ?>">
                <i class="bi bi-flower1"></i> My Crops
            </a>
            <a href="<?= $base_url ?>user/farmer/management/manage_harvest.php" class="glass-nav-item <?= $pageFile=='manage_harvest.php' ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Harvested
            </a>
            <a href="<?= $base_url ?>user/farmer/management/manage_product.php" class="glass-nav-item <?= $pageFile=='manage_product.php' ? 'active' : '' ?>">
                <i class="bi bi-tag"></i> Product List
            </a>

            <span class="section-tag">Market</span>
            <a href="<?= $base_url ?>user/farmer/order/order.php" class="glass-nav-item <?= in_array($pageFile, ['order.php', 'process_order.php']) ? 'active' : '' ?>">
                <i class="bi bi-cart-check"></i> Orders
            </a>
            <a href="<?= $base_url ?>user/farmer/message/message.php" class="glass-nav-item <?= $pageFile=='message.php' ? 'active' : '' ?>">
                <i class="bi bi-chat-left-text"></i> Messages
            </a>
            <a href="<?= $base_url ?>user/farmer/review/feedback.php" class="glass-nav-item <?= $pageFile=='feedback.php' ? 'active' : '' ?>">
                <i class="bi bi-chat-square-heart"></i> Feedback
            </a>
            <?php endif; ?>
        </div>
    </div>
</aside>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const nav = document.getElementById("sidebarNavContent");
    const scrollPos = sessionStorage.getItem("sidebar_scroll_pos");
    if (scrollPos) nav.scrollTop = parseInt(scrollPos);

    document.querySelectorAll(".glass-nav-item").forEach(link => {
        link.addEventListener("click", function() {
            sessionStorage.setItem("sidebar_scroll_pos", nav.scrollTop);
        });
    });
});
</script>