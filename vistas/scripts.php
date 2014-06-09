<!-- JavaScript's Frameworks -->
<script src="/static/js/vendor/jquery.js"></script>
<script src="/static/js/vendor/fastclick.js"></script>
<script src="/static/js/foundation.min.js"></script>
<script>
    $(document).foundation();
    <?php if(isset($_GET['addp'])): ?>
        $('#ModalProductos').foundation('reveal', 'open');
    <?php elseif(isset($_GET['vaciar'])): ?>
        $('#ModalVaciar').foundation('reveal', 'open');
    <?php endif; ?>
</script>
<script src="/static/js/jquery-migrate-1.2.1.js"></script>
<script src="/static/js/jquery.form.js"></script>
<script src="/static/js/formsper.js"></script>
