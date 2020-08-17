# Fudamiku API

[![Fork](https://img.shields.io/github/forks/abuazis/Fudamiku-Service-API?style=social)](https://github.com/abuazis/Fudamiku-Service-API/fork)&nbsp; [![Star](https://img.shields.io/github/stars/abuazis/Fudamiku-Service-API?style=social)](https://github.com/abuazis/Fudamiku-Service-API/star)&nbsp; [![Watches](https://img.shields.io/github/watchers/abuazis/Fudamiku-Service-API?style=social)](https://github.com/abuazis/Fudamiku-Service-API/)&nbsp;

## Description
Fudamiku API adalah projek web service api yang dibuat untuk menyediakan resource data dan kebutuhan fitur authentikasi dan transaksi yang sudah terintegrasi dengan payment gateway Midtrans. Dan nantinya akan diconsume oleh projek aplikasi mobile Fudamiku menggunakan Flutter.

![alt text](https://i.ibb.co/Zmv94q9/image.png)

API ini berfungsi sebagai back-end api aplikasi fudamiku yang mempunyai fitur:
- Create User Account
- Login User Account
- CRUD Resource Food
- Process Order & Transaction
- Cancel Order
- Check History Order
- Payment Method (Credit Card & Gopay)
- Apikey System (Bearer Token)

# Installation
1. Pastikan kalian telah menginstall composer
2. Lakukan clone projek ini
   ```
   https://github.com/abuazis/Fudamiku-Service-API.git
   ```
3. Install vendor laravel
   ```
   composer install
   ```
4. Buat database baru di MySQL/PostgreSQL dengan nama "fudamiku"
5. Duplikat file ```.env.example``` menjadi ```.env```
6. Setting info database kalian di ```.env```
   ```php
   DB_CONNECTION=<YOUR_DATABASE_CONNECTION>
   DB_HOST=<YOUR_DATABASE_HOST>
   DB_PORT=<YOUR_DATABASE_PORT>
   DB_DATABASE=<YOUR_DATABASE_NAME>
   DB_USERNAME=<YOUR_DATABASE_USERNAME>
   DB_PASSWORD=<YOUR_DATABASE_PASSWORD>
   ```
7. Lakukan migrasi database kalian
   ```
   php artisan migrate
   ```
8. Lakukan generate passport key data
   ```
   php artisan passport:install
   ```
9. Setting client key dan server key midtrans kalian
   ```php
   MIDTRANS_SERVER_KEY=<YOUR_SERVER_KEY>
   MIDTRANS_CLIENT_KEY=<YOUR_CLIENT_KEY>
   MIDTRANS_BASE_URL=https://api.sandbox.midtrans.com/v2

# API Creator 
```
Author: Abu Toyib Al Aziz
Version: v1.0
Website: www.abuazis.com
```

# API Requirements
| Features | Methods | Bearer Token |
| :--------: | :--------: | :---------: |
| Create Account   | POST   | No |
| Login Account   | POST   | No |
| Ambil Data Makanan   | GET   | Yes |
| Ambil Data Bahan Makanan  | GET   | Yes |
| Process Order   | POST   | Yes |
| Process Transaction   | POST   | Yes |
| Cancel Order   | POST   | Yes |
| Check History order   | GET   | Yes |

# API Usage List
__Create User Account__
---
```
Rute ini berfungsi untuk membuat akun pengguna.
Pastikan semua parameter diisikan.
```

| Methods | Parameter | Data Type |
| :--------: | :--------: | :---------: |
| POST   | name   | String |
| POST   | email   | String |
| POST   | password   | String |
| POST   | password_confirmation   | String |
| POST   | phone_number   | Number |
| POST   | address   | String |
| POST   | house_number   | String |
| POST   | city   | String |
| POST   | photo   | File |

__URL String__
```
http://127.0.0.1:8000/api/auth/register
```

__Code Backend__
```php
$input = $request->all();
$user = $this->user->where('email', $input['email'])->first();

if (!$user) {
    $input['uuid'] = Uuid::generate(4)->string;
    $input['password'] = Hash::make($input['password']);

    if ($request->has('photo')) {
        $input['path_photo'] = $this->fileManager->saveData($request->file('photo'), $input['name'], '/images/users/');
        $input['photo'] = '/images/users/' . $this->fileManager->fileResult;
    }

    $user = $this->user->create($input);

    $token = $user->createToken('nApp')->accessToken;
    return $this->respHandler->authenticate(200, "Success Sign Up", $token, new UserResource($user));
}
else {
    return $this->respHandler->exists("User");
}
```

__API Response__

![alt text](https://i.ibb.co/qWNHRgJ/image.png)
---

__Login User Account__
---
```
Rute ini untuk melakukan validasi login.
Pastikan kalian memasukan data user, karena
kita tidak ingin validasi ini digunakan sembarangan orang.
```

| Methods | Parameter | Data Type |
| :--------: | :--------: | :---------: |
| POST   | email   | String |
| POST   | password   | String |

__URL String__
```
http://127.0.0.1:800/api/auth/login
```

__Code Backend__
```php
if ($user) {
    if (Hash::check($input['password'], $user->password)) {
        $token = $user->createToken('nApp')->accessToken;
        return $this->respHandler->authenticate(200, "Success Sign In", $token, new UserResource($user));
    }
    else {
        return $this->respHandler->badCredential();
    }
}
else {
    return $this->respHandler->notFound("Users");
}
```

__API Response__

![alt text](https://i.ibb.co/kBZcSXT/image.png)

__Get Data Makanan__
---
```
Rute ini untuk mendapatkan semua data makanan dari database.
```

__URL String__
```
http://127.0.0.1:8000/api/foods
```

__Code Backend__
```php
$foods = $this->food->with('foodIngredient')->get();

if ($foods->count() > 0) {
    return $this->respHandler->send(200, "Successfuly Get Foods", FoodResource::collection($foods));
}
else {
    return $this->respHandler->notFound("Foods");
}
```

__API Response__

![alt text](https://i.ibb.co/WBt3pRj/image.png)

__Process Order__
---
```
Rute ini untuk melakukan order makanan yang dipilih.
Pastikan bahwa parameter valid dan benar.
```

| Methods | Parameter | Data Type |
| :--------: | :--------: | :---------: |
| POST   | user_id   | Number |
| POST   | food_id   | Number |
| POST   | quantity   | Number |
| POST   | status   | String |

__URL String__
```
http://127.0.0.1:5000/api/orders
```

__Code Backend__
```php
if ($this->order->isExistsByUserId($userId)) {
    $order = $this->order->where('user_id', $userId)->get();
    return $this->respHandler->send(200, "Successfuly Get Order", OrderResource::collection($order));
}
else {
    $this->respHandler->notFound("Order");
}
```

__API Response__

![alt text](https://i.ibb.co/k04jvQ8/image.png)

__Cancel Order__
---
```
Rute ini berfungsi untuk melakukan pembatalan order yang telah dibuat.
Pastikan bahwa parameter status bernilai "Cancelled".
```

| Methods | Parameter | Data Type |
| :--------: | :--------: | :---------: |
| POST   | status   | String |

__URL String__
```
http://127.0.0.1:5000/api/orders/{order_id}
```

__Code Backend__
```php
$order = $this->order->find($id);
$updateStatus = $order->update(['status' => $request->status]);

if ($updateStatus) {
    return $this->respHandler->send(200, "Successfully Update Status Order");
}
else {
    return $this->respHandler->internalError();
}
```

__API Response__

![alt text](https://i.ibb.co/Tcjg4tG/image.png)

__Check History Order__
---
```
Rute ini berfungsi untuk melihat history order berdasarkan user.
```

__URL String__
```
http://127.0.0.1:5000/api/orders/{user_id}
```

__Code Backend__
```php
if ($this->order->isExistsByUserId($userId)) {
    $order = $this->order->where('user_id', $userId)->get();
    return $this->respHandler->send(200, "Successfuly Get Order", OrderResource::collection($order));
}
else {
    $this->respHandler->notFound("Order");
}
```

__API Response__

![alt text](https://i.ibb.co/crzCfCn/image.png)


# Donations
Bagi yang mau berbaik hati mendonasikan saldonya pada saya atas script ini, silahkan melakukan transfer ke rekening berikut:
```
Transfer Rekening => 5771095268 A/N Abu Toyib Al Aziz | Bank BCA
```
