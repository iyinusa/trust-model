		</div>
        <!-- /st-content-inner -->

      </div>
      <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

    <!-- Footer -->
    <footer class="footer">
      <strong><?php echo app_name; ?></strong> &copy; Copyright <?php echo date('Y'); ?> | By Steve Aderibigbe
    </footer>
    <!-- // Footer -->

  </div>
  <!-- /st-container -->
  
  <!-- Inline Script for colors and config objects; used by various external scripts; -->
  <script>
    var colors = {
      "danger-color": "#e74c3c",
      "success-color": "#81b53e",
      "warning-color": "#f0ad4e",
      "inverse-color": "#2c3e50",
      "info-color": "#2d7cb5",
      "default-color": "#6e7882",
      "default-light-color": "#cfd9db",
      "purple-color": "#9D8AC7",
      "mustard-color": "#d4d171",
      "lightred-color": "#e15258",
      "body-bg": "#f6f6f6"
    };
    var config = {
      theme: "social-2",
      skins: {
        "default": {
          "primary-color": "#16ae9f"
        },
        "orange": {
          "primary-color": "#e74c3c"
        },
        "blue": {
          "primary-color": "#4687ce"
        },
        "purple": {
          "primary-color": "#af86b9"
        },
        "brown": {
          "primary-color": "#c3a961"
        },
        "default-nav-inverse": {
          "color-block": "#242424"
        }
      }
    };
  </script>

  <script src="<?php echo base_url(); ?>js/vendor/all.js"></script>
  <script src="<?php echo base_url(); ?>js/app/app.js"></script>
  
  <script src="<?php echo base_url(); ?>plugins/jquery-1.11.1.min.js"></script>
  
  <!-- page script -->
	<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.js"></script>
	<script src="<?php echo base_url(); ?>js/bootstrap-datatables.js"></script>
    <script src="<?php echo base_url(); ?>js/datatables.js"></script>
    <!-- /page script -->
    
    <!-- page script -->
    <script src="<?php echo base_url(); ?>plugins/stepy/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/stepy/jquery.stepy.js"></script>
    <script src="<?php echo base_url(); ?>plugins/fuelux/wizard.js"></script>
    <script src="<?php echo base_url(); ?>js/form-wizard.js"></script>
    <!-- /page script -->
</body>

</html>