<?php
namespace Plugins\SampleModule;

// Disable direct access
if (!defined('APP_VERSION')) 
    die("Yo, what's up?");

/**
 * Index Controller
 */
class IndexController extends \Controller
{

    /**
     * Process
     */
    public function process()
    {
        $AuthUser = $this->getVariable("AuthUser");
        $this->getVariable("idname", "sample-module")

        // Auth
        if (!$AuthUser){
            // User is not authenticated
            // So user has not got an access to this page,
            // Redirect it to the login page
            header("Location: ".APPURL."/login");
            exit;
        } else if ($AuthUser->isExpired()) {
            // User account is expired
            // Redirect to the expired page
            header("Location: ".APPURL."/expired");
            exit;
        }

        // Get the list of modules which is accessible for this authenticated user
        $user_modules = $AuthUser->get("settings.modules");
        if (!is_array($user_modules) || !in_array($this->getVariable("idname"), $user_modules)) {
            // Module is not accessible to this user
            header("Location: ".APPURL."/post");
            exit;
        }

        // Include view file
        // Pass second parameter as NULL, so first parameter 
        // will be accepted as full path of the view file
        $this->view(PLUGINS_PATH."/".$this->getVariable("idname")."/views/index.php", null);
    }
}