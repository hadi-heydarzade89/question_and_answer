# Question and Answer package

1- Please pull and clone a LEMP docker environment, you can use <a href="https://github.com/hadi-heydarzade89/docker-lemp-server/tree/php81mysql">this link</a>.

```
git clone -b php81mysql https://github.com/hadi-heydarzade89/docker-lemp-server/
```
after please follow the repository instructions

2- Install package on your laravel  
```
composer require hadi-heydarzade89/question-and-answer
```
3- Install all dependencies
### Warning: 
#### we have our handler class and after following command App\Exceptions\Handler replaced with a new one
```
php artisan vendor:publish --provider="HadiHeydarzade89\QuestionAndAnswer\QuestionAndAnswerServiceProvider"
```


4- Add three following classes on config/app.php on providers key of array 

````
    Spatie\Permission\PermissionServiceProvider::class,
    App\Providers\QuestionAndAnsweProvider::class,
    L5Swagger\L5SwaggerServiceProvider::class,
````

5- You can use the app with swagger. The address is <base domain>/api/documentation 
