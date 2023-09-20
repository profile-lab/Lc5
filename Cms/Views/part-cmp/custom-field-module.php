<?php
// 
$fake_item = [
    'entity' => null,
    'custom_fields_keys' => null
];
extract($fake_item);
extract($item);
?>
<?php
// d($custom_fields_keys)
?>
<!-- CAMPI CUSTOM FIELD -->
<?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['name' => 'entity_free_values', 'value' => (isset($entity->entity_free_values)) ? $entity->entity_free_values : '', 'input_class' => 'entity_free_values']]) ?>
    <div class="entity_custom_items_cnt row">
        <?php if (isset($custom_fields_keys) && is_iterable($custom_fields_keys)) { ?>
            <?php foreach ($custom_fields_keys as $custom_fields_key_item) { ?>
                <div class="custom_field-row_item custom_field-row_item-fix" style="display: block;">
                    <?= view('Lc5\Cms\Views\form-cmp/hidden', ['item' => ['label' => 'Chiave', 'name' => 'custom_field_key', 'input_class' => 'custom_field_key', 'value' =>  $custom_fields_key_item->val]]) ?>
                    <?php switch($custom_fields_key_item->type ){ 
                        case 'string':
                            echo view('Lc5\Cms\Views\form-cmp/text', [
                                'item' => [
                                    'label' => $custom_fields_key_item->nome,
                                    'name' => 'custom_field_value',
                                    'input_class' => 'custom_field_value',
                                    'value' => (isset($entity->entity_free_values_object[$custom_fields_key_item->val])) ? $entity->entity_free_values_object[$custom_fields_key_item->val]->value : '',
                                    'width' => 'col-md-12',
                                    'placeholder' => 'Valore'
                                ]
                                ]);
                            break;
                        case 'text':
                            echo view('Lc5\Cms\Views\form-cmp/text-area', [
                                'item' => [
                                    'label' => $custom_fields_key_item->nome,
                                    'name' => 'custom_field_value',
                                    'input_class' => 'custom_field_value',
                                    'value' => (isset($entity->entity_free_values_object[$custom_fields_key_item->val])) ? $entity->entity_free_values_object[$custom_fields_key_item->val]->value : '',
                                    'width' => 'col-md-12',
                                    'placeholder' => 'Valore'
                                ]
                                ]);
                            break;
                        case 'html-editor':
                            echo view('Lc5\Cms\Views\form-cmp/html-editor', [
                                'item' => [
                                    'label' => $custom_fields_key_item->nome,
                                    'name' => 'custom_field_value',
                                    'input_class' => 'custom_field_value',
                                    'value' => (isset($entity->entity_free_values_object[$custom_fields_key_item->val])) ? $entity->entity_free_values_object[$custom_fields_key_item->val]->value : '',
                                    'width' => 'col-md-12',
                                    'placeholder' => 'Valore'
                                ]
                                ]);
                            break;
                        case 'bool':

                            echo view('Lc5\Cms\Views\form-cmp/select', [
                                'item' => [
                                    'label' => $custom_fields_key_item->nome,
                                    'name' => 'custom_field_value',
                                    'input_class' => 'custom_field_value',
                                    'value' => (isset($entity->entity_free_values_object[$custom_fields_key_item->val])) ? $entity->entity_free_values_object[$custom_fields_key_item->val]->value : 0,
                                    'width' => 'col-md-12',
                                    'placeholder' => 'Valore',
                                    'sources' => $bool_values,
                                    'no_empty' => true
                                ]
                                ]);
                            break;
                     } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

<!-- CAMPI CUSTOM FIELD -->