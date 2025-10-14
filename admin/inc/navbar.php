<?php
/**
 * Footer Component
 * Displays the footer with copyright info
 */
$current_year = date('Y');
?>

<footer class="footer">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-600">
            © <?= $current_year; ?> <strong>Doorstep Technology Co.,Ltd</strong>. All rights reserved.
        </p>
        <div class="flex items-center gap-6">
            <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-colors">Privacy Policy</a>
            <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-colors">Terms of Service</a>
            <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-colors">Contact Us</a>
        </div>
    </div>
</footer>