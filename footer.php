            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById("menu-toggle");
    const wrapper = document.getElementById("wrapper");

    if (menuToggle && wrapper) {
        menuToggle.addEventListener("click", function() {
            wrapper.classList.toggle("toggled");
        });
    }

    if (window.innerWidth > 768) {
        wrapper.classList.add("toggled");
    }
});
</script>
</body>
</html>