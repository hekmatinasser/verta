
hekmatinasser/verta
======
- This package compatible with Laravel `>=5` & `< 6.0`

- Verta is a jalali calendar that was used in persian datetime

- Calendar conversion is based on the algorithm provided by Morteza Parvini, Vahid Sohrablou, Roozbeh Pournader and Mohammad Tou'si.

Run the Composer update comand

    $ composer require hekmatinasser/verta

In your `config/app.php` add `'Hekmatinasser\Verta\VertaServiceProvider::class'` to the end of the `$providers` array

```php
'providers' => [

    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    ...
    Hekmatinasser\Verta\VertaServiceProvider::class,

],


'alias' => [
    ...
    'Verta' => Hekmatinasser\Verta\Verta::class,
]
```

<a name="basic-usage"></a>
## Basic Usage

### Verta
You can use verta
`use \Verta as Verta ;`
#### `$dt = new Verta();`
``` php
// default timestamp is now
$dt = new Verta();

// pass timestamps
$dt = new Verta(1333857600);

// pass string datetime
$dt = new Verta('2016-12-27 14:12:32');

//pass datetime object
$dt = new \Datetime();
return new Verta($dt); // 1395-12-09 15:05:56

// pass carbon object
$c = \Carbon::now();
return new Verta($c); // 1395-12-09 15:05:56

// access static 
return Verta::instance('2016-12-25 11:12:36'); //1395-10-05 11:12:36

// pass strings persian date
$dt = Verta::parse('1395-10-07 14:12:32');

// format the timestamp
$dt = new Verta('2016-12-27 14:12:32');
return $dt->format('Y-n-j H:i'); //1395-10-7 14:12
return $dt->format('%B %d، %Y'); // دی 07، 1395
return $dt; //1395-10-07 14:12:32

// get a diffrent time with now
$dt = Verta::parse('1395-10-07 14:12:32');
return $dt->diffrentNow(); // 2 ماه پیش

$dt = Verta::parse('1396-10-07 14:12:32');
return $dt->diffrentNow(); // 10 ماه بعد
```

---
#### `getJalali($gYear, $gMonth, $gDay)`
```php
return Verta::getJalali(2015,12,25); // [1394,10,4]
```
---
#### `getGregorian($jYear, $jMonth, $jDay)`
```php
return Verta::getGregorian(1394,10,4);; // [2015,12,25]
```

---
#### `DateTime()`
```php
$dt = Verta::parse('1395/01/05 23:50:25');
return Carbon::instance($dt->DateTime());

```
---
#### `isLeapYear($int)`
```php
echo Verta::isLeapYear(1394); // false
echo Verta::isLeapYear(1395); // true
```
---
#### `isValideDate($jYear, $jMonth, $jDay)`
```php
echo Verta::isValideDate(1394, 12, 30); // false
echo Verta::isValideDate(1395, 12, 30); // true
```
---
#### `persianNumbers($string)`
```php
$dt = Verta::parse('1396-10-07 14:12:32');
return Verta::persianNumbers($dt); // ۱۳۹۶-۱۰-۰۷ ۱۴:۱۲:۳۲
```
---
## Formatting ##

For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

## License ##
-  This package was created and modified by [Nasser Hekmati](https://github.com/hekmatinasser) for Laravel >= 5 and is released under the MIT License.
