<?php

if (!defined('PHORUM_ADMIN')) return;

// Handle copying a rule.
if (isset($_GET['id']))
{
    if (empty($PHORUM['mod_postcount_tagging']['rules'][$_GET['id']])) {
        phorum_admin_error("Cannot copy rule: rule id " .
                           htmlspecialchars($_GET['id']) .
                           " not found");
    } else {
        $rule = $PHORUM['mod_postcount_tagging']['rules'][$_GET['id']];
        $rule['id'] = 0;
        $rule['name'] .= ' (copy)';
        postcount_tagging_store_rule($rule);
        phorum_admin_okmsg("The rule was successfully copied");
    }
}

include("./mods/postcount_tagging/settings/list_rules.php");

?>
