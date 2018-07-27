
<footer>
	<script type="text/javascript" src="/js/scripts.js"></script>
    <?php if (!empty($_SESSION['userdata']) && $_SESSION['userdata']['type'] == 'administrator'): ?>
        <script type="text/javascript" src="/js/admin.scripts.js"></script>
    <?php endif; ?>
</footer>
    </div>
</body>
</html>