<?php

namespace Drupal\Tests\range_slider\FunctionalJavascript;

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * RangeSlider tests.
 *
 * @group range_slider
 */
class RangeSliderWidgetTest extends WebDriverTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'node',
    'field',
    'field_ui',
    'range_slider',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * The name of the field to use for testing.
   *
   * @var string
   */
  protected $fieldName = 'field_amount';

  /**
   * The bundle used in this test.
   *
   * @var string
   */
  protected $bundle = 'range_slider_test';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->drupalLogin($this->drupalCreateUser([
      'administer site configuration',
      'administer content types',
      'administer node fields',
      'administer node form display',
      'bypass node access',
    ]));

    $this->createContentType([
      'type' => $this->bundle,
      'name' => 'Range Slider',
    ]);

    $storage_settings = [
      'unsigned' => FALSE,
      'size' => 'normal',
    ];

    $field_settings = [
      'min' => 0,
      'max' => 100,
      'prefix' => '',
      'suffix' => '',
      'default_value' => 50,
    ];

    $widget_settings = [
      'orientation' => 'horizontal',
      'output' => 'above',
    ];

    $field = $this->createRangeSliderField('Amount', $storage_settings, $field_settings, $widget_settings);
    $this->drupalGet('admin/structure/types/manage/' . $this->bundle . '/fields/' . $field->id());
    $this->assertSession()->fieldValueEquals('settings[min]', 0);
    $this->assertSession()->fieldValueEquals('settings[max]', 100);
  }

  /**
   * Test range slider widget via form display.
   */
  public function testRangeSliderWidget() {

    $this->drupalGet('node/add/' . $this->bundle);
    $this->assertSession()->waitForText(50);

    $edit = [
      'title[0][value]' => 'Test Range Slider Widget',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('Range Slider ' . $edit['title[0][value]'] . ' has been created.');
    $this->assertSession()->pageTextContains(50);
  }

  /**
   * Add a node field for the Range Slider widget.
   *
   * @param $field_label
   *  Field label.
   * @param $storage_settings
   *  Field storage settings.
   * @param $field_settings
   *  Field settings.
   * @param $widget_settings
   *  Field widget settings.
   *
   * @return \Drupal\Core\Entity\EntityBase|\Drupal\Core\Entity\EntityInterface|FieldConfig
   *  The field config obj.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createRangeSliderField($field_label, $storage_settings = [], $field_settings = [], $widget_settings = []) {

    FieldStorageConfig::create([
      'field_name' => $this->fieldName,
      'entity_type' => 'node',
      'type' => 'integer',
      'settings' => $storage_settings,
      'cardinality' => $storage_settings['cardinality'] ?? 1,
    ])->save();

    $field_config = FieldConfig::create([
      'field_name' => $this->fieldName,
      'label' => $field_label,
      'entity_type' => 'node',
      'bundle' => $this->bundle,
      'required' => $field_settings['required'] ?? FALSE,
      'settings' => $field_settings,
    ]);

    $field_config->save();

    /** @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface $display_repository */
    $display_repository = \Drupal::service('entity_display.repository');
    $display_repository
      ->getFormDisplay('node', $this->bundle)
      ->setComponent($this->fieldName, [
        'type' => 'range_slider',
        'region' => 'content',
        'weight' => 0,
        'settings' => $widget_settings,
      ])
      ->save();

    $display_repository
      ->getViewDisplay('node', $this->bundle)
      ->setComponent($this->fieldName, [
        'label' => 'above',
        'type' => 'number_integer',
        'region' => 'content',
        'settings' => [
          'thousand_separator' => '',
          'prefix_suffix' => TRUE,
        ],
      ])
      ->save();

    return $field_config;
  }

}
