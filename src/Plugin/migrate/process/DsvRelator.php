<?php

namespace Drupal\migrate_islandora_csv\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Unpacks nested DSV (delimiter separated value) relators,
 * eg "dpc=Ralph Hotere|pht=Marti Friedlander".
 *
 * @codingStandardsIgnoreStart
 *
 * Examples:
 * @code
 * process:
 *   field_linked_agent:
 *     -
 *       plugin: dsvrelator
 *       source: relators
 *     -
 *       plugin: sub_process
 *       process:
 *         target_id:
 *           plugin: entity_generate
 *           entity_type: taxonomy_term
 *           value_key: name
 *           bundle_key: vid
 *           bundle: subject
 *           source: target_name
 *         rel_type: rel_type
 * @endcode
 *
 * @codingStandardsIgnoreEnd
 *
 * @MigrateProcessPlugin(
 *  id = "dsvrelator"
 * )
 */
class DsvRelator extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $results = [];
    $relationships = explode('|', $value);
    foreach ($relationships as $relationship) {
      $relation = explode('=', $relationship);
      $results[] = [
        'rel_type' => $relation[0],
        'target_name' => $relation[1],
      ];
    }

    return $results;
  }

}
