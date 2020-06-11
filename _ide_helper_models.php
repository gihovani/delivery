<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App{
/**
 * App\Transaction
 *
 * @property int $id
 * @property string $type
 * @property string $payment_method
 * @property float $value
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereValue($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App{
/**
 * App\Product
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $pieces
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $category_id
 * @property-read \App\Category $category
 * @property-read mixed $image
 * @property-read mixed $image_path
 * @property-read mixed $image_url
 * @property-read mixed $price_formated
 * @property-read mixed $variation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Variation[] $variations
 * @property-read int|null $variations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePieces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $expected_at
 * @property string $status
 * @property string $payment_method
 * @property float $subtotal
 * @property float $amount
 * @property float $additional_amount
 * @property float $discount
 * @property float $shipping_amount
 * @property float $cash_amount
 * @property float $back_change
 * @property string $customer_name
 * @property string $customer_telephone
 * @property string|null $deliveryman_name
 * @property string|null $deliveryman_telephone
 * @property string|null $address_zipcode
 * @property string|null $address_street
 * @property string|null $address_number
 * @property string|null $address_city
 * @property string|null $address_state
 * @property string|null $address_neighborhood
 * @property string|null $address_complement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $address_id
 * @property int|null $customer_id
 * @property int|null $deliveryman_id
 * @property int|null $address_distance
 * @property-read \App\Address|null $address
 * @property-read mixed $additional_amount_formated
 * @property-read mixed $address_distance_formated
 * @property-read mixed $amount_formated
 * @property-read mixed $back_change_formated
 * @property-read mixed $cash_amount_formated
 * @property-read mixed $discount_formated
 * @property-read mixed $is_late
 * @property-read mixed $shipping_amount_formated
 * @property-read mixed $subtotal_formated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAdditionalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAddressZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereBackChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCashAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCustomerTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliverymanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliverymanName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliverymanTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereExpectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereShippingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App{
/**
 * App\Address
 *
 * @property int $id
 * @property string $zipcode
 * @property string|null $street
 * @property string|null $number
 * @property string $city
 * @property string $state
 * @property string|null $neighborhood
 * @property string|null $complement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int|null $distance
 * @property int|null $duration
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int $is_google_distance
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereIsGoogleDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereZipcode($value)
 */
	class Address extends \Eloquent {}
}

namespace App{
/**
 * App\OrderItem
 *
 * @property int $id
 * @property string $name
 * @property float $quantity
 * @property float $price
 * @property string|null $description
 * @property string|null $observation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $product_id
 * @property int $order_id
 * @property-read \App\Order $order
 * @property-read \App\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereUpdatedAt($value)
 */
	class OrderItem extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $roles
 * @property string $telephone
 * @property string|null $observation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read mixed $roles_translated
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model query()
 */
	class Model extends \Eloquent {}
}

namespace App{
/**
 * App\Config
 *
 * @property int $id
 * @property string $store
 * @property string|null $address
 * @property string $zipcode
 * @property string $telephone
 * @property string|null $google_maps
 * @property int $is_open
 * @property int $waiting_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $shipping_tax
 * @property int $free_distance
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $google_api_key
 * @property-read mixed $image
 * @property-read mixed $image_path
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereFreeDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereGoogleApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereGoogleMaps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereShippingTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereWaitingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Config whereZipcode($value)
 */
	class Config extends \Eloquent {}
}

namespace App{
/**
 * App\Variation
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image
 * @property-read mixed $image_path
 * @property-read mixed $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Item[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Variation whereUpdatedAt($value)
 */
	class Variation extends \Eloquent {}
}

namespace App{
/**
 * App\Item
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Item whereUpdatedAt($value)
 */
	class Item extends \Eloquent {}
}

