# Shopping Cart

## Overview

Users can add products to their shopping cart,
update quantities, and remove products.

## Actors

- Customer

## Features

- Add product to cart
- Update cart item quantity
- Remove product from cart
- View cart

## Business Rules

- Only authenticated customers can manage a cart.
- Only active products can be added to the cart.
- Product quantity must be at least 1.
- Requested quantity cannot exceed available stock.
- A customer can only modify their own cart.
- Product price is taken from the current product price when added.
- An out-of-stock product cannot be added to the cart.

## Add Product

### Input

- product_id
- quantity

### Success

Given an active product with sufficient stock,
when the customer adds the product,
the product should be added to their cart.

### Errors

- Product does not exist → 404
- Product is inactive → 422
- Product is out of stock → 422
- Quantity is less than 1 → 422
- Quantity exceeds stock → 422
- User is unauthenticated → 401

## Test Scenarios

### Happy Path

- Add an available product to an empty cart.
- Add an available product to an existing cart.

### Validation

- Quantity is zero.
- Quantity is negative.
- Product ID is missing.
- Quantity is missing.

### Business Rules

- Add inactive product.
- Add out-of-stock product.
- Add more items than available stock.

### Authorization

- Unauthenticated user attempts to add a product.
- User attempts to modify another user's cart.

## Out of Scope

- Guest cart
- Coupon codes
- Cart expiration