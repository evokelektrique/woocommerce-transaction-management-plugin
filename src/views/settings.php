<?php global $wtm_plugin; ?>

<div class="wrap">
   <h3><?php esc_html_e("Settings", "wtm-plugin"); ?></h3>
   <hr>

   <span wtm-plugin-tab="settings" class="wtm-plugin-nav-tab active">
      <?php esc_html_e("General", "wtm-plugin"); ?>
   </span>

   <form id="panel_settings">
      <div class="left_side">
         <div id="settings" class="wtm-plugin-tab active">
            <div class="wtm-plugin-form-row">
               <label for="wtm-plugin_authoriazation">
                  <?php esc_html_e("Authorization Key:", "wtm-plugin"); ?>
               </label>
               <input type="text" class="wtm-plugin_input" name="wtm-plugin_authoriazation" id="wtm-plugin_authoriazation" value="<?php echo esc_html($_ENV["API_KEY"]) ?>" placeholder="<?php esc_html_e("Authorization Key", "wtm-plugin"); ?>" readonly="" />
            </div>
         </div>
      </div>
      <div class="right_side">
         <button class="button-primary"><?php esc_html_e("Submit", "wtm-plugin") ?></button>
      </div>
   </form>
</div>