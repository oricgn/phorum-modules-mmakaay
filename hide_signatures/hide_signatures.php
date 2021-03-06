<?php

if(!defined("PHORUM")) return;

function phorum_mod_hide_signatures_common()
{
    $PHORUM = $GLOBALS["PHORUM"];

    // Do module installation if that wasn't done yet.
    if (! isset($PHORUM["mod_hide_signatures_installed"]) ||
        ! $PHORUM["mod_hide_signatures_installed"]) {
        include("./mods/hide_signatures/install.php");
    }
}

function phorum_mod_hide_signatures_tpl_cc_usersettings($profile)
{
    // Add a control center option in case the board settings are shown.
    if (isset($profile["BOARDSETTINGS"]))
    {
        global $PHORUM;

        $PHORUM["DATA"]["DO_HIDE_SIGNATURES"] =
            !empty($GLOBALS["PHORUM"]["user"]["mod_hide_signatures"]);

        include(phorum_get_template("hide_signatures::control_center"));
    }
    return $profile;
}

function phorum_mod_hide_signatures_cc_save_user($userdata)
{
    // Put the hide signatures setting in the user.
    if (isset($_POST["process_mod_hide_signatures"]))
    {
        unset($_POST["process_mod_hide_signatures"]);
        $value = isset($_POST["mod_hide_signatures"]) ? 1 : 0;
        $userdata["mod_hide_signatures"] = $value;
    }
    return $userdata;
}

function phorum_mod_hide_signatures_read_user_info($users)
{
    if (! $GLOBALS["PHORUM"]["DATA"]["LOGGEDIN"] ||  // not for anonymous users
        ! phorum_page == 'read'                  ||  // only for read page
        ! is_array($users)                           // paranoia ;-)
       ) return $users;

    // Remove the signature from the users, except for the current user
    // (to prevent error reports about their signature not being visible ;).
    if (isset($GLOBALS["PHORUM"]["user"]["mod_hide_signatures"]) &&
        $GLOBALS["PHORUM"]["user"]["mod_hide_signatures"]) {
        foreach ($users as $id => $userdata) {
            if ($userdata["user_id"] != $GLOBALS["PHORUM"]["user"]["user_id"])
                $users[$id]["signature"] = "";
        }
    }

    return $users;
}

?>
