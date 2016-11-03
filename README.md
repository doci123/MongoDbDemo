# MongoDbDemo

is a Demo with Symfony 3, MongoDB and PHP 7 

## Note
### PHP 7

Check is the PHP Extension [MongoDB Driver](http://php.net/manual/en/book.mongo.php) activated:
```
php -i | grep mongo         # Linux
php -i | findstr "mongo"    # Windows
```

#### Problem

The "doctrine/mongodb-odm" required the [Mongo driver (legacy)](http://php.net/manual/en/book.mongo.php) Extension ^1.3 
he is deprecated and do not work with PHP 7, dammit!  

The new [MongoDB Driver](http://php.net/manual/en/book.mongo.php) works with PHP 7 but not the "doctrine/mongodb-odm".

The solution is the Adapter here: ["alcaeus/mongo-php-adapter"](https://github.com/alcaeus/mongo-php-adapter) 
```
composer require alcaeus/mongo-php-adapter
```
then install the MongoDB Doctrine packages
```
composer require doctrine/mongodb-odm doctrine/mongodb-odm-bundle 
```

<br />
