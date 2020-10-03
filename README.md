# MyShop
Initial Shop using PHP with full features.
![image](https://user-images.githubusercontent.com/65598953/94992834-80d1ff00-0584-11eb-9591-8148f9cc8b48.png)

# Admin Page
Access the admin page using: 
```[YOURLINK]/admin/```
![image](https://user-images.githubusercontent.com/65598953/94992905-238a7d80-0585-11eb-9538-62e3445d2cf0.png)
Default ADMIN login credentials: 
```admin:admin```

Add/Edit Staff credentials from the database.
Use ```[YOURLINK]/admin/hash.php``` to hash the password before adding it to the ```staff``` table.

# Database Setup
Create your database (in my project, named ```myshop```), then upload the ```upload.sql``` file into it to create all tables instantly, ```upload.sql``` can be found at: 
```[YOURLINK]/admin/upload.sql```

# Payment Gateway
My project is using [Paypal Express Checkout][pec] as a payment gateway, accepting both PayPal payments and Bank Cards payment, **SANDBOX** mode (testing) enabled by default, it's up to you to make it **LIVE**.

[pec]: <https://www.paypal.com/re/webapps/mpp/express-checkout>
