<?php require_once __DIR__ . '/admin-header.php'; ?>
<?php require_once __DIR__ . '/admin-sidebar.php'; ?>

<!-- Bootstrap JS -->
<script src="/essystore/public/assets/js/bootstrap.bundle.min.js"></script>

<!-- Main Content Area -->
<div class="admin-main">
    <main class="admin-content">
        <?php echo $content ?? ''; ?>
    </main>
</div>

<!-- Footer -->
<footer class="admin-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; <?php echo date('Y'); ?> EssyStore Admin. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Admin JS -->
<script src="/essystore/public/assets/js/admin.js"></script>

</body>
</html>
