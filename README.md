# 🛋️ Furniture Store Sales and Management System
A lightweight sales and back-end management system for a furniture store, developed using PHP, MySQL, and native HTML/CSS/JavaScript. It supports dual-role logins for **Customers** and **Staff/Administrators**. The system features comprehensive product browsing, dynamic inventory calculation, a shopping cart checkout process, order history management (including deletion), and personalized customer settings. It also includes a full-featured **staff back-end management system**—covering product listing and deletion (`stpd.html`), real-time updates for order status and quantities (`strp.html`), inventory monitoring, the addition of new products/raw materials, and operational sales reporting [cite: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29].

---

## 🚀 Project Features
* **Dual-Role Authentication System**: The system automatically identifies the user account (Staff `sid` or Customer `cid`) and redirects the user to their respective, dedicated homepage.
* **Product Browsing and Dynamic Inventory Calculation**:
* **Furniture Catalog (`fp.html` / `fp.php`)**: Dynamically loads all furniture items and their prices in a tabular format [cite: 4, 10]. * **Detailed Specifications and Real-Time Inventory (`detail.html` / `detail.php`)**: The system automatically calculates the maximum quantity of an item that can be produced or purchased by comparing the required raw materials—defined in the Bill of Materials (BOM)—against current stock levels in the `Materials` inventory [cite: 6, 9].
* **Shopping Cart and Checkout System (`cart.html` / `cart_pay.php`)**:
* Utilizes the browser's `localStorage` to manage the addition and removal of items in the shopping cart. 
* Automatically populates the checkout form with the logged-in customer's information (name, phone number, and default delivery address) [cite: 5, 8]. 
* Employs database transactions during checkout; when an order is created, the system automatically deducts the necessary raw materials from the `Materials` inventory based on the item's Bill of Materials (`FurnitureMaterials`) [cite: 3, 7].
* **Customer Order Management (`rp.html` / `delete_order.php`)**:
* Supports sorting by multiple fields, with options for ascending or descending order [cite: 11]. 
* **Intelligent Deletion Restrictions**: To prevent operational issues, the system prohibits the deletion of orders if the scheduled delivery date is less than 2 days away. Upon successful deletion, the system automatically restores the corresponding raw materials to the inventory [cite: 11, 21].
* **Customer Profile Settings (`setting.html` / `update_profile.php`)**:
* Allows logged-in customers to view and update their personal password, contact phone number, and delivery address [cite: 12, 14, 25].
* **Staff Administrative Dashboard**:
* **Product Management (`stpd.html` / `stpd.php`)**: Provides an overview of all products and supports the secure deletion of furniture items (permitted only if no associated orders exist) [cite: 22, 26, 28]. * **Employee Order Records and Status Updates (`strp.html` / `update_order.php`)**: Allows for the viewing of detailed customer order information, real-time updates to order quantities, and the management of various order statuses (Open, Processing, Approved, Pending delivery, Completed, Rejected). It also enables real-time monitoring of raw material consumption and remaining inventory levels for each order [cite: 24, 27, 29]. 
* **Product and Material Association (`addpd.html` / `addpd.php`)**: Supports the creation of furniture products by defining the associated raw materials (Bill of Materials, or BOM) and their respective consumption quantities [cite: 15, 19]. 
* **Raw Material Management (`mt.html` / `addmt.html` / `addmt.php`)**: Provides an overview of current raw material inventory and units of measurement, with functionality to add new raw material items [cite: 16, 18, 20]. 
* **Sales and Operational Reports (`report.html` / `report.php`)**: Compiles detailed sales data and total revenue across all orders, facilitating the tracking of operational metrics by administrators [cite: 17, 23]. ---

## 🛠️ Tech Stack
* **Frontend**: HTML5, CSS3, JavaScript (Fetch API, dynamic DOM rendering)
* **Backend**: PHP (Session management, secure queries via prepared statements, JSON API responses, database transaction handling with rollback mechanisms)
* **Database**: MySQL (InnoDB engine, supporting foreign key constraints and transaction rollbacks)

---


## 📂 Database Schema
The core database for this system, `ProjectDB`, consists of the following 7 primary tables[cite: 3]:
1. **`Customers`**: Stores customer personal information, passwords, and shipping addresses[cite: 3].
2. **`Staffs`**: Stores information regarding staff and administrators, including their assigned roles and permissions[cite: 3].
3. **`Furnitures`**: A catalog of furniture products (including names, descriptions, and prices)[cite: 3].
4. **`Materials`**: Inventory of raw materials (such as wood, hardware, etc., including quantities and units)[cite: 3].
5. **`Orders`**: The master table for customer orders (including total amount, delivery date, and status)[cite: 3].
6. **`OrderFurnitures`**: A detailed association table linking orders to specific products[cite: 3].
7. **`FurnitureMaterials`**: A Bill of Materials (BOM) association table linking furniture items to the raw materials required for their production[cite: 3].

------------------------------------------------------------------------------------------------------------------------------------------------

## 📂 Project Structure
```text
├── login/
│   ├── login.html          # Login interface for customers and staff[cite: 1]
├── php/
│   ├── login.php           # Authentication and session management[cite: 2]
│   ├── fp.php              # API to retrieve the furniture list[cite: 10]
│   ├── detail.php          # API to retrieve furniture details and calculate dynamic inventory[cite: 9]
│   ├── cart.php            # API to retrieve data for the currently logged-in customer[cite: 8]
│   ├── cart_pay.php        # API to process checkout, create orders, and deduct material inventory[cite: 7]
│   ├── rp.php              # API to retrieve customer order history and report data[cite: 13]
│   ├── update_profile.php  # API to update customer profiles and passwords[cite: 14, 25]
│   ├── stpd.php            # API to retrieve the furniture list for staff[cite: 26]
│   ├── strp.php            # API to retrieve all orders and material consumption details for staff[cite: 27]
│   ├── update_order.php    # API for staff to update order quantities and statuses[cite: 24]
│   ├── addpd.php           # API for the backend to add furniture items and link them to BOM (Bill of Materials) components[cite:
``` 19]
│   ├── addmt.php           # API for adding raw materials (admin-side)[cite: 20]
│   ├── delete_order.php    # API for deleting orders and automatically restocking raw materials[cite: 21]
│   ├── delete_furniture.php# API for deleting furniture items[cite: 22]
│   └── report.php          # API for generating sales and order statistics reports[cite: 13, 23]
├── frontpage/
│   ├── fp.html             # Frontend: Furniture listing homepage[cite: 4]
│   ├── detail.html         # Frontend: Furniture details page with quantity selection[cite: 6]
│   ├── cart.html           # Frontend: Shopping cart and checkout page[cite: 5]
│   ├── rp.html             # Frontend: Order history and management page[cite: 11]
│   └── setting.html        # Frontend: Customer account settings page[cite: 12]
├── backend/ (or Staff Management Interface)
│   ├── stpd.html           # Staff Backend: Furniture management list[cite: 28]
│   ├── strp.html           # Staff Backend: Order management (status/quantity updates)[cite: 29]
│   ├── addpd.html          # Staff Backend: Add furniture and define material requirements[cite: 15]
│   ├── mt.html             # Staff Backend: Raw material inventory list[cite: 18]
│   ├── addmt.html          # Staff Backend: Add raw materials[cite: 16]
│   └── report.html         # Staff Backend: Operational and sales reports[cite: 17]
└── projectdb.sql           # MySQL database schema and initial test data



----------------------------------------------------------------------------------------------------------------------------------------------
## ⚙️ Quick Installation & Setup

1. **Environment Requirements**:
* It is recommended to use [XAMPP](https://www.apachefriends.org/) or a similar local development environment (supporting PHP and MySQL).

2. **Importing the Database**:
* Start the MySQL service, then import the `projectdb.sql` file included in the project using phpMyAdmin or your terminal:
```sql
-- The system will automatically create 'ProjectDB' and import default test data.
```

3. **Configuring the Project Path**:
* Place the project files in your web server's root directory (e.g., the `htdocs` folder in XAMPP). 
* Ensure that the database connection settings (defined within the PHP files—defaulting to `127.0.0.1`, `root`, and no password) match your local environment configuration [cite: 2].

4. **Launching the System**:
* Open `login.html` in your web browser to access the login page [cite: 1, 2].
