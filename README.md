# Php api with authentication.

## Sqlite Structure

- **uid** = _integer_
- **name** = _string_
- **desc** = _string_
- **public** = _boolean_
- **category** = _string_
- **content** = _json_
- **token** = _string_
- **created** = _timestamp_
- **updated** = _timestamp_

---

## Url Structure

With authentication we get all content but if not exists auth we get only rows with public true.

**Config: v1**
file: v1/data/config.php

```Php
    "url" => "", // url of Php api
    "token" => "", // echo bin2hex(random_bytes((50 - (50 % 2)) / 2));
    "dbType" => "sqlite",
    "dbFile" => __DIR__ .'/data.db',
    "dbUser" => "",
    "dbPass" => "",
```

**Config: v2**
index.php

```Php
    /* Token & url */
    define("URL","http://localhost/api/v1");
    define("TOKEN","1234567890");

    /* Database connection values */
    define("DB_TYPE", "mysql");// sqlite,mysql
    define("DB_FILE", 'folder/data.db');
    define('DB_HOST', "localhost:3306"); //only for mysql
    define('DB_NAME', "demo"); //only for mysql
    define('DB_USER', 'root');//only for mysql
    define('DB_PASS', 'root');//only for mysql
    define('DB_CHARSET', 'utf8mb4');//only for mysql
```

**Use api.js**

```Javascript
// Config
const Api =  new Api({
    url: "url of api",
    token: "php api config token",
})
```

**Create table:**

```Javascript
// Create test table
Api.create('test').then(r =>console.log(r))
```

```Javascript
// Insert data
Api.insert('test',{title: 'hello world',public: 1}).then(r =>console.log(r))
```

**Update data:**

```Javascript
// Update data
Api.update('testing',1,{title: 'Hello World'}).then(r =>console.log(r))
```

**Get data:**

```Javascript
// Get data
Api.get('testing','uid=1').then(r =>console.log(r))
Api.get('testing','public=1').then(r =>console.log(r))
Api.get('testing','category=demo').then(r =>console.log(r))
Api.get('testing','updated=2022').then(r =>console.log(r))
```

**Filter data:**

```Javascript
// Filter [created,updated,name,title,category,description]
Api.filter('testing','created').then(r =>console.log(r))
Api.filter('testing','updated').then(r =>console.log(r))
Api.filter('testing','category').then(r =>console.log(r))
Api.filter('testing','name').then(r =>console.log(r))
```

**Delete data:**

```Javascript
// Delete row
Api.delete('testing',{id: '1',token:'12345'}).then(r =>console.log(r))
```

**Export table:**

```Javascript
// Export csv
Api.export('testing').then(r =>console.log(r))
```

**Drop table:**

```Javascript
// Delete table
Api.drop('testing').then(r =>console.log(r))
```