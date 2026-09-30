# E-Commerce Platform

A Laravel-based e-commerce platform for managing products, customers, shopping carts, discounts, and store content. The project includes a customer-facing storefront and an administration panel for managing the store.

## Tech Stack

* **Backend:** PHP, Laravel
* **Database:** MySQL
* **Authentication:** Mobile number and OTP
* **Frontend:** [Add frontend technology]
* **API:** RESTful API
* **Testing:** [Add testing framework]
* **Development Environment:** Docker

## Features

### Storefront

* Home page and About Us page
* Product catalog with:

  * Search
  * Category filtering
  * Stock availability filtering
  * Price sorting
  * Pagination
* Product details with recommended products
* Product sale pricing with configurable date ranges
* Product primary and additional images
* Mobile number authentication with one-time passwords (OTP)
* OTP resend and logout
* SMS integration with a test mode
* Shopping cart for authenticated users:

  * Add products
  * Update item quantities
  * Remove items
  * Clear the cart
* Discount codes with validation and expiration handling
* User profile management
* Address management
* Wishlist
* Contact Us form with message management

### Admin Panel

* Dashboard
* Product management
* Category management
* Slider management
* Product attribute management
* Discount code management
* User management
* About Us content management
* Footer content management
* Contact message management

## Security

* Authentication using mobile number and OTP
* Role-based access control for administrative features
* Server-side request validation
* Authorization checks for protected resources
* Protection of sensitive administrative functionality
* Secure handling of authentication and user data

## Future Improvements

* Order management and order lifecycle
* Payment gateway integration
* Transaction management
* Purchase and payment status tracking
* Sales statistics and reporting
* Advanced admin dashboard analytics
* Improved product listing and search experience
* Automated testing and expanded test coverage
* Production-ready SMS integration
* Additional security hardening and performance optimization
