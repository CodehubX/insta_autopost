<?php 
// Defining a name space is not required,
// But it's a good practise.
namespace Plugins\SampleModule;

// Disable direct access
if (!defined('APP_VERSION')) 
    die("Yo, what's up?"); 


/**
 * Event: plugin.install
 * We will bind this call back function to the plugin.install event,
 * So when the end user installs this module this callback function will be called
 * We should do some stuff here which must be done before using the module actually
 *
 * Event is being triggered when user selects the ZIP archive and click the "INSTALL" button on /plugins/install page
 * For example, we can create necessary database tables in this function
 *
 * When an event is being fired, $Plugin model will be passed into this function
 */
function install($Plugin)
{
    // First thing must be done in this function is to check the $Plugin model data, 
    // This is very important. Otherwise this function will be call everytime 
    // any other plugin is being installed 
    if ($Plugin->get("idname") != "sample-module") {
        // sample-module is the idname for our module 
        // which has been defined in the config.php file
        // If the $Plugin->get("idname") is not equal to our modules' idname, 
        // then it means system is trying to install some other module,
        // So we shouldn't run the rest of this function
        return false;
    }


    // Do some stuff here 
    $sql = "CREATE TABLE `".TABLE_PREFIX."sample_module` ( 
                `id` INT NOT NULL AUTO_INCREMENT , 
                `foo` INT NOT NULL , 
                `bar` INT NOT NULL , 
                `baz` TEXT NOT NULL , 
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB;";


    // This is how you can get PDO instance 
    // which is already initialized by system
    $pdo = \DB::pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

// Now we bind our install callback function to the plugin.install event
// This event is being fired when any module is being installed
// 
// Since we've defined the namespace in this file, 
// our function is only available in this name space
// 
// We can use __NAMESPACE__ magic PHP constant to get 
// the name of current namespace automatically
\Event::bind("plugin.install", __NAMESPACE__ . '\install');



/**
 * Event: plugin.remove
 * We will bind this call back function to the plugin.remove event,
 * So when the end user remove this module this callback function will be called
 * We should do some stuff here which must be done after admin removes the module
 * 
 * For example, we can remove the data tables which belongs to this module
 *
 * When an event is being fired, $Plugin model will be passed into this function
 */
function uninstall($Plugin)
{
    // First thing must be done in this function is to check the $Plugin model data, 
    // This is very important. Otherwise this function will be call everytime 
    // any other plugin is being removed
    if ($Plugin->get("idname") != "sample-module") {
        // sample-module is the idname for our module 
        // which has been defined in the config.php file
        // If the $Plugin->get("idname") is not equal to our modules' idname, 
        // then it means system is trying to remove some other module,
        // So we shouldn't run the rest of this function
        return false;
    }

    $sql = "DROP TABLE `".TABLE_PREFIX."sample_module`;";

    $pdo = \DB::pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
\Event::bind("plugin.remove", __NAMESPACE__ . '\uninstall');


/**
 * It's possible to add the module only for admin, or only for regular users,
 * all users, only some packages etc. This is generally controlled by the module controllers.
 *
 * If you want to add a new option to the package settings,
 * you can use package.add_module_option event as this event. 
 * This callback function should echo the html for the checkbox
 * 
 * @param array $package_modules An array of currently active 
 *                               modules of the package
 */
function add_module_option($package_modules)
{
    ?>
        <div class="mt-15">
            <label>
                <input type="checkbox" 
                       class="checkbox" 
                       name="modules[]" <?php // input name must be modules[] ?>
                       value="sample-module"
                       <?= in_array("sample-module", $package_modules) ? "checked" : "" ?>>
                <span>
                    <span class="icon unchecked">
                        <span class="mdi mdi-check"></span>
                    </span>
                    <?= __('Sample Module') ?>
                </span>
            </label>
        </div>
    <?php
}
\Event::bind("package.add_module_option", __NAMESPACE__ . '\add_module_option');




/**
 * router.map
 * This event is being fired just before system parses the routes.
 * You should define the new URI routes for your module controllers
 * 
 * @param  string $global_variable_name Name of the global router variable
 */
function route_maps($global_variable_name)
{
    // PLUGINS_PATH is the predefined contants which returns the path of the plugins directory
    // PLUGINGS_PATH = /path/to/website/directory/inc/plugins

    // When you go to http://yourwebsite.com/e/sample-module
    // system will include the PLUGINS_PATH . "/sample-module/controllers/IndexController.php" file
    // and call the process method of this file: IndexController::process()
    $GLOBALS[$global_variable_name]->map("GET|POST", "/e/sample-module/?", [
        PLUGINS_PATH . "/sample-module/controllers/IndexController.php",
        __NAMESPACE__ . "\IndexController"
    ]);
}
\Event::bind("router.map", __NAMESPACE__ . '\route_maps');



/**
 * Event: navigation.add_special_menu
 */
/**
 * Event: navigation.add_special_menu
 * @param  \stdCalss $Nav     
 * @param  \UserModel $AuthUser Authenticated User or false
 * @return NULL           
 */
function navigation($Nav, $AuthUser)
{
    include __DIR__."/views/fragments/navigation.fragment.php";
}
\Event::bind("navigation.add_special_menu", __NAMESPACE__ . '\navigation');
// \Event::bind("navigation.add_menu", __NAMESPACE__ . '\navigation');
// \Event::bind("navigation.add_admin_menu", __NAMESPACE__ . '\navigation');



/**
 * Add new cron task
 */
function addCronTask()
{
    // Do something here to be called once in each minute (everytime cron task runs)
}
\Event::bind("cron.add", __NAMESPACE__."\addCronTask");




/**
 * Event: user.signup
 * You can use this event to send a verification email to your new users
 * 
 * @param  \UserModel $User New registered user data model
 * @return NULL       
 */
function userVerify($User)
{
    $firstname = $User->get("firstname");
    $lastname = $User->get("lastname");
    $email = $User->get("email");

    // Deactivate the account
    $User->get("is_active", 0)->save();

    // Do necessary actions here and send the mail to the 
    // user's email address
    // 
}
\Event::bind("user.signup", __NAMESPACE__."\userVerify");