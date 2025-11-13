<?php // footer.php - scripts comunes del layout moderno ?>
  </main>
</div> <!-- /layout -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (function(){
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    const targets = document.querySelectorAll('.rise, .reveal, .lift');
    if (reduced || !('IntersectionObserver' in window)) {
      targets.forEach(el => el.classList.add('show'));
      return;
    }
    const obs = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(e.isIntersecting){
          e.target.classList.add('show');
          obs.unobserve(e.target);
        }
      });
    }, { threshold: .15 });
    targets.forEach(el => obs.observe(el));
  })();
</script>
</body>
</html>


