  <footer>
    <p>Copyright <?php echo date('Y'); ?> </p>
  </footer>

  <script src="<?php echo url_for('/js/bootstrap.js'); ?>"></script>

  </body>
</html>

<?php
  db_disconnect($db);
?>
