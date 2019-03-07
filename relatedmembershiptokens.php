<?php

require_once 'relatedmembershiptokens.civix.php';
use CRM_Relatedmembershiptokens_ExtensionUtil as E;

/**
 * implements hook_civicrm_tokens().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tokens/
 */
function relatedmembershiptokens_civicrm_tokens(&$tokens) {

  $tokens['primarymembership'] = array(
    'primarymembership.id' => ts('Primary Membership: Membership ID'),
    'primarymembership.contact_id' => ts('Primary Membership: Contact ID'),
    'primarymembership.contact_display_name' => ts('Primary Membership: Contact Display Name'),
    'primarymembership.contact_address_block' => ts('Primary Membership: Contact Address Block'),
    'primarymembership.contact_phone' => ts('Primary Membership: Contact Phone'),
    'primarymembership.contact_email' => ts('Primary Membership: Contact Email'),
  );
}

/**
 * implements hook_civicrm_tokenValues().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tokenValues/
 */
function relatedmembershiptokens_civicrm_tokenValues(&$values, $cids, $job = null, $tokens = array(), $context = null) {

  if (!empty($tokens['primarymembership'])) {
    $contacts = implode(',', $cids);

    $dao = CRM_Core_DAO::executeQuery("SELECT rc.id, pm.id AS membership_id, pm.contact_id, pc.display_name, a.street_address, a.supplemental_address_1, a.supplemental_address_2, a.supplemental_address_3, a.city, sp.abbreviation, a.postal_code, p.phone, e.email
      FROM civicrm_contact rc
      INNER JOIN civicrm_membership rm ON rm.contact_id = rc.id
      INNER JOIN civicrm_membership pm ON pm.id = rm.owner_membership_id
      INNER JOIN civicrm_contact pc ON pc.id = pm.contact_id
      LEFT JOIN civicrm_address a ON a.contact_id = pc.id AND a.is_primary=1
      LEFT JOIN civicrm_state_province sp ON sp.id = a.state_province_id
      LEFT JOIN civicrm_phone p ON p.contact_id = pc.id AND p.is_primary=1
      LEFT JOIN civicrm_email e ON e.contact_id = pc.id AND e.is_primary=1
      WHERE rc.id IN ($contacts)
    ");

    while ($dao->fetch()) {
      $address = array();
      if ($dao->street_address) {
        $address[] = $dao->street_address;
      }
      if ($dao->supplemental_address_1) {
        $address[] = $dao->supplemental_address_1;
      }
      if ($dao->supplemental_address_2) {
        $address[] = $dao->supplemental_address_2;
      }
      if ($dao->supplemental_address_3) {
        $address[] = $dao->supplemental_address_3;
      }
      $address[] = ($dao->city ? "{$dao->city}, " : '') . ($dao->abbreviation ? "{$dao->abbreviation} " : '') . ($dao->postal_code ?: '');

      $values[$dao->id]['primarymembership.id'] = $dao->membership_id;
      $values[$dao->id]['primarymembership.contact_id'] = $dao->contact_id;
      $values[$dao->id]['primarymembership.contact_display_name'] = $dao->display_name;
      $values[$dao->id]['primarymembership.contact_address_block'] = implode("\n", $address);
      $values[$dao->id]['primarymembership.contact_phone'] = $dao->phone;
      $values[$dao->id]['primarymembership.contact_email'] = $dao->email;
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function relatedmembershiptokens_civicrm_config(&$config) {
  _relatedmembershiptokens_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function relatedmembershiptokens_civicrm_xmlMenu(&$files) {
  _relatedmembershiptokens_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function relatedmembershiptokens_civicrm_install() {
  _relatedmembershiptokens_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function relatedmembershiptokens_civicrm_postInstall() {
  _relatedmembershiptokens_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function relatedmembershiptokens_civicrm_uninstall() {
  _relatedmembershiptokens_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function relatedmembershiptokens_civicrm_enable() {
  _relatedmembershiptokens_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function relatedmembershiptokens_civicrm_disable() {
  _relatedmembershiptokens_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function relatedmembershiptokens_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _relatedmembershiptokens_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function relatedmembershiptokens_civicrm_managed(&$entities) {
  _relatedmembershiptokens_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function relatedmembershiptokens_civicrm_caseTypes(&$caseTypes) {
  _relatedmembershiptokens_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function relatedmembershiptokens_civicrm_angularModules(&$angularModules) {
  _relatedmembershiptokens_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function relatedmembershiptokens_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _relatedmembershiptokens_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function relatedmembershiptokens_civicrm_entityTypes(&$entityTypes) {
  _relatedmembershiptokens_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function relatedmembershiptokens_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function relatedmembershiptokens_civicrm_navigationMenu(&$menu) {
  _relatedmembershiptokens_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _relatedmembershiptokens_civix_navigationMenu($menu);
} // */
