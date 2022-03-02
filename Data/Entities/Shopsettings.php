<?php

namespace Lc5\Data\Entities;

use CodeIgniter\Entity\Entity;

class Shopsettings extends Entity
{
    protected $attributes = [
        'id' => null,
        'id_app' => null,
        'email' => null,
        'phone' => null,
        'shop_home' => null,
        'discount_type' => 'PRICE',
        'products_has_childs' => 0,
        'only_digitals_products' => 0,
        'shipment_active' => 1,
        'pickup_attivo' => 0,
        'paypal_account' => null,
        'stripe_account' => null,
        'sumup_account' => null,
        'seo_title' => null,
        'entity_free_values' => null,
    ];
}
