
# Php api with authentication.

## Sqlite Structure

- **uid** = _integer_
- **name** = _string_
- **desc** = _string_
- **public** = _boolean_
- **category** = _string_
- **content** = _json_
- **token** = _string_
- **date** = _timestamp_
- **updated** = _timestamp_

----

## Url Structure

With authentication we get all content but if not exists auth we get only rows with public true.

**Config: data/config.php**
````Php
    "url" => "", // url of Php api
    "token" => "", // echo bin2hex(random_bytes((50 - (50 % 2)) / 2));
    "dbType" => "sqlite",
    "dbFile" => __DIR__ .'/data.db',
    "dbUser" => "",
    "dbPass" => "",
````

**Use api.js**
```Javascript
// Config
const Api =  new Api({
    url: "url of api", 
    token: "php api config token",
});
```

**Create table:**

```Javascript
Api.create('dbname').then(r => A.debug('Create Table',r));
```

```Javascript
Api.insert('testing',{title: 'hello world',public: 1}).then(r => A.debug('Insert data',r));
```

**Update data:**

```Javascript
Api.update('testing',1,{title: 'Hello World}).then(r => A.debug('Update data',r));
```

**Get data:** 

```Javascript
Api.get('testing','uid=1').then((r) => A.debug('Get data',r));
Api.get('testing','public=1').then((r) => A.debug('Get data',r));
Api.get('testing','category=demo').then((r) => A.debug('Get data',r));
Api.get('testing','updated=2022').then((r) => A.debug('Get data',r));
```

**Filter data:** 

```Javascript
Api.filter('testing','created').then(r=> A.debug('Get all created date',r));
Api.filter('testing','category').then(r=> A.debug('Get all category',r));
```

**Delete data:**

```Javascript
Api.delete('testing',1).then(r => A.debug('Delete data',r));
```

**Export table:**

```Javascript
Api.export('testing').then(r =>console.log(r))
```

**Drop table:**

```Javascript
Api.drop('testing').then(r =>console.log(r))
```

