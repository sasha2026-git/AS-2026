</main>

<!-- Footer -->
<footer class="w-full py-16 mt-32 bg-surface-container-lowest border-t border-outline-variant/10">
    <div class="flex flex-col md:flex-row justify-between items-center px-margin-desktop gap-gutter container-max">
        <div class="font-headline-md text-headline-md text-on-surface tracking-tighter">AuraAI</div>
        <div class="flex gap-8 my-8 md:my-0">
            <a class="font-label-caps text-label-caps text-on-surface-variant/60 hover:text-secondary transition-colors" href="#">Privacy</a>
            <a class="font-label-caps text-label-caps text-on-surface-variant/60 hover:text-secondary transition-colors" href="#">Terms</a>
            <a class="font-label-caps text-label-caps text-on-surface-variant/60 hover:text-secondary transition-colors" href="#">Shipping</a>
            <a class="font-label-caps text-label-caps text-on-surface-variant/60 hover:text-secondary transition-colors" href="#">Contact</a>
        </div>
        <div class="font-label-caps text-label-caps text-on-surface-variant/60">
            &copy; <?php echo date('Y'); ?> AuraAI. The Future of Fragrance.
        </div>
    </div>
</footer>

<!-- Mobile menu toggle script -->
<script>
    document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

<!-- Scroll reveal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);
        document.querySelectorAll('.scroll-reveal').forEach(function(el) {
            observer.observe(el);
        });
        
        // Aura mist mouse interaction
        const aura = document.getElementById('aura-mist');
        if (aura) {
            document.addEventListener('mousemove', function(e) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                aura.style.background = 
                    'radial-gradient(circle at ' + (x * 100) + '% ' + (y * 100) + '%, #d7c6fe 0%, transparent 40%), ' +
                    'radial-gradient(circle at 80% 20%, #d3e5f1 0%, transparent 40%), ' +
                    'radial-gradient(circle at 10% 80%, #f1f9ff 0%, transparent 40%)';
            });
        }
    });
</script>

<?php wp_footer(); ?>
</body>
</html>
