<?php 
    // Disable direct access
    if (!defined('APP_VERSION')) 
        die("Yo, what's up?");  

    // $idname comes from \Controller::view() method,
    // We've set this variable in \Plugins\SampleModule\IndexController::process() method

    // Check is this plugin is active
    if (!isset($GLOBALS["_PLUGINS_"][$idname]["config"]))
          return null;

    // Get this module's config data
    $config = $GLOBALS["_PLUGINS_"][$idname]["config"]; 

    // Get authenticated user's active moduless
    $user_modules = $AuthUser->get("settings.modules");
    if (empty($user_modules)) {
        $user_modules = [];
    }

    // Check if this module is active for authenticated user
    if (!in_array($idname, $user_modules)) {
        return null;
    }
?>
<li class="<?= $Nav->activeMenu == $idname ? "active" : "" ?>">
    <a href="<?= APPURL."/e/".$idname ?>">
        <span class="special-menu-icon" style="<?= empty($config["icon_style"]) ? "" : $config["icon_style"] ?>">
            <span class="sli sli-reload"></span>
        </span>

        <?php $name = empty($config["plugin_name"]) ? $idname : $config["plugin_name"]; ?>
        <span class="label"><?= $name ?></span>

        <span class="tooltip tippy" 
              data-position="right"
              data-delay="100" 
              data-arrow="true"
              data-distance="-1"
              title="<?= $name ?>"></span>
    </a>
</li>