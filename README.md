##  Guideline
Though Laravel is a well organized framework, and it follows all the
community standards we should also follow some standards to make
the code more readable and understandable.
We will follow the [PSR-2](https://www.php-fig.org/psr/psr-2/) and [PSR-12](https://www.php-fig.org/psr/psr-12/) standard as well.
We will also make sure that we are following 
"[SOLID](https://www.freecodecamp.org/news/solid-principles-explained-in-plain-english/) [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) [KISS](https://dev.to/kwereutosu/the-k-i-s-s-principle-in-programming-1jfg)" 
method and/or principles.

### An excellent example of DRY method in Laravel:
```injectablephp
public function store()
{
      $data = request()->validate([
            'id' => 'required|integer',
            'name' => 'required',
            'email' => 'email',
            'password' => 'required',
            'role' => 'string'
        ]);

        \App\User::create($data);

        return redirect('/users');
 }


public function update(\App\User $user)
    {
        $data = request()->validate([
            'id' => 'required|integer',
            'name' => 'required',
            'email' => 'email',
            'role' => 'string'
        ]);

        $user->update($data);

        return redirect('/users');
    }
```
We can use Laravel Form Request to make this class more clean and make sure this is following DRY method.
We can create a form request here. ```php artisan make:request UserRequest```

And for the rules we can add this:
```injectablephp
public function rules()
{
    $rules = [
            'id' => 'required|integer',
            'name' => 'required',
            'email' => 'email',
            'role' => 'string'
        ];

    if ($this->isMethod('post'))
    {
        $rules['password'] = 'required';
    }


    return $rules;
}
```
Then our method signatures will be changed:
```injectablephp
use App\Http\Requests\UserRequest;

public function store(UserRequest $request)
{
    \App\User::create($request->all());

    return redirect('/users');
}

public function update(UserRequest $request, \App\User $user)
{
    $user->update($request->all());
    
    return redirect('/users');
}
```


### [Some naming conventions and best practices](https://devdojo.com/alpdetails/laravel-best-practice-coding-standards-part-01)

#### Naming Conventions. ✊
Here we will talk about naming conventions about PHP. 
Following conventions accepted by the Laravel community.

##### 01.01 Controller 👈
- Name should be in singular form.
- Should use PascalCase.
```injectablephp
//Should Do
"CustomerController.php"

//Shouldn't Do
"CustomersController.php"
```

##### 01.02 Route 👈
###### 01.02.01 Route Url 👈
- Url should be in plural form.
- Can use kebab-case if there are two words in a single part For Best Practice.
```injectablephp
//Should Do
"https://devdojo.com/customers/25"
"https://devdojo.com/customers/password-reset"

//Shouldn't Do
"https://devdojo.com/customer/25"
"https://devdojo.com/customers/passwordReset"
```

###### 01.02.02 Route Name 👈
- Should use snake_case with dot notation.
- Better to use the same name as in the URL.
```injectablephp
//Should Do
->('customers.view');
->('customers.password_reset');

//Should't Do
->('customers-view');
->('customers_view');
->('customers.password.reset');
->('customers.password-reset');
->('customer-password-reset');
```

##### 01.03 DataBase Related 👈
###### 01.03.01 Migration 👈
- Should use the name as what you want to do with snake_case.
```injectablephp
//Should Do
"2021_03_19_033513_create_customers_table.php"
"2021_03_19_033513_add_image_id_to_customers_table.php"
"2021_03_19_033513_drop_image_id_from_customers_table.php"

//Shouldn't Do
"2021_03_19_033513_customers.php"
"2021_03_19_033513_add_image_id_customers.php"
"2021_03_19_033513_remove_image_id_customers.php"
```

###### 01.03.02 Table 👈
- Table name must be in plural form.
- Should use snake_case.
```injectablephp
//Should Do
"customers","cart_items"

//Shouldn't Do
"customer" ,"cartItems","CartItems","Cart_item"
```

###### 01.03.03 Pivot Table 👈
- Table name must be in singular form.
- Should use snake_case
- Names should be in alphabetical Order.
```injectablephp
//Should Do
"course_student"

//Shouldn't Do
"student_courses","students_courses","course_students",
```

###### 01.03.04 Table Columns 👈
- Should use snake_case.
- Should not use table name with column names.
- Readable name can be used for better practice.
```injectablephp
//Should Do
"first_name"

//Shouldn't Do
"user_first_name","FirstName"
```

###### 01.03.05 Foreign key 👈
- Should use snake_case.
- Should use singular table name with id prefix.
```injectablephp
//Should Do
"course_id"

//Shouldn't Do
"courseId","id","courses_id","id_course"
```

###### 01.03.06 Primary key 👈
- Only use the name as the id.
```injectablephp
//Should Do
"id"

//Shouldn't Do
"custom_name_id"
```

###### 01.03.07 Model 👈
- Model name must be in singular form.
- Should Use PascalCase
- Model name must be a singular form or table name.
```injectablephp
//Should Do
"Customer"

//Shouldn't Do
"Customers" ,"customer"
```

###### 01.03.08 Model Single relations [Has One, Belongs To] 👈
- Method name must be in singular form.
- Should Use camalCase
```injectablephp
//Should Do
"studentCourse"

//Shouldn't Do
"StudentCourse" ,"student_course" ,"studentCourses"
```

###### 01.03.09 Model all other relations and methods [Has Many, other] 👈
- Method name must be in plural form.
- Should use camalCase
```injectablephp
//Should Do
"cartItems"

//Shouldn't Do
"CartItem" ,"cart_item" ,"cartItem"
```

##### 01.04 Functions 👈
- Should Use snake_case
```injectablephp
//Should Do
"show_route"

//Shouldn't Do
"showRoute" ,"ShowRoute"
```

##### 01.05 Methods in resources controller 👈
- Should use camelCase
- Must use singles words related to action
```injectablephp
//Should Do
"store"
//Shouldn't Do
"saveCustomer"

//Should Do
"show"
//Shouldn't Do
"viewCustomer"

//Should Do
"destroy"
//Shouldn't Do
"deleteCustomer"

//Should Do
"index"
//Shouldn't Do
"allCustomersPage"
```

##### 01.06 Variables 👈
- Should use camelCase
- Must use readable words which describe the value.
```injectablephp
//Should Do
$customerMessages;
//Should't Do
$CustomerMessages;
$customer_messages;
$c_messages;
$c_m;
```

##### 01.07 Collection 👈
- Must describe the value.
- Must be plural
```injectablephp
//Should Do
$verifiedCustomers = $customer->verified()->get();
//Should't Do
$verified;
$data;
$resp;
$v_c;
```

##### 01.07 Object 👈
- Must describe the value.
- Must be singular
```injectablephp
//Should Do
$verifiedCustomer = $customer->verified()->first();
//Should't Do
$verified;
$data;
$resp;
$v_c;
```

##### 01.08 Configs 👈
- Should use snake_case
- Must describe the value.
```injectablephp
//Should Do
"comments_enabled"
//Should't Do
"CommentsEnabled"
"comments"
"c_enabled"
```

##### 01.09 Traits 👈
- Should be an adjective.
```injectablephp
//Should Do
"Utility"
//Shouldn't Do
"UtilityTrait"
"Utilities"
```

##### 01.10 Interface 👈
- Should be an adjective or a noun.
```injectablephp
//Should Do
"Authenticable"
//Shouldn't Do
"AuthenticationInterface"
"Authenticate"
```

## Primary Installation

```bash
$ git clone repo
$ sudo chmod 777 -R storage
$ sudo chmod 777 -R bootstrap/cache
```

## Copy .env files

```bash
$ cp .env .env.example
```

## Running the app
#  The app will run on port 8000

```bash
$ php artisan serve 

```

## Run seeder
#  this will run the user seeder and country seeder

```bash
$ php artisan db:seed 

```

## Login Credentials
#  use the below credentials for login

```bash
$ username : ashraf@admin.com
$ password : secret123

```

## Update .env
#  update app url if using port and file disk

```bash
$ APP_URL= http://localhost:8000
$ FILESYSTEM_DISK=public

```

## generate jwt secret
#  this command will generate jwt secret and will update the .env

```bash
$ php artisan jwt:secret

```

