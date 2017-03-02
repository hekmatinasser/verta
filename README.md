
hekmatinasser/verta
======
- This package compatible with Laravel `>=5` & `< 6.0`

- Verta is a jalali calendar that was used in persian datetime

- Calendar conversion is based on the algorithm provided by Morteza Parvini, Vahid Sohrablou, Roozbeh Pournader and Mohammad Tou'si.

Run the Composer update comand

    $ composer require hekmatinasser/verta

In your `config/app.php` add `Hekmatinasser\Verta\VertaServiceProvider::class,` to the end of the `providers` array and add `'Verta' => Hekmatinasser\Verta\Verta::class,` to the end of the `alias` array.

```php
'providers' => [

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
You can use verta in project
```php
use \Verta as Verta ;`
```

#### Constructors
```php
// default timestamp is now
$dt = new Verta();
// OR
$dt = Verta::now();

// pass string datetime
$dt = new Verta('2016-12-27 14:12:32');
// OR
$dt = Verta::instance('2016-12-25 11:12:36');

// pass timestamps
$dt = new Verta(1333857600);

//pass datetime object
$dt = new \Datetime();
return new Verta($dt); // 1395-12-09 15:05:56

// pass carbon object
$c = \Carbon::now();
return new Verta($c); // 1395-12-09 15:05:56

// pass strings persian date
$dt = Verta::parse('1395-10-07 14:12:32');
```
---
#### Formating
```php
// format the timestamp
$dt = new Verta('2016-12-27 14:12:32');
return $dt->format('Y-n-j H:i'); // 1395-10-7 14:12
return $dt->format('%B %d، %Y'); // دی 07، 1395
return $dt; //1395-10-07 14:12:32

// use predefined format
$dt = new Verta();
return $dt->format('datetime'); // 1395-12-10 23:25:12
return $dt->format('date'); // 1395-12-10
return $dt->format('time'); // 23:26:35

// use predefined format method
$dt = new Verta();
return $dt->formatDatetime(); // 1395-12-10 23:37:26
return $dt->formatDate(); // 1395-12-10
return $dt->formatTime(); // 23:26:35
return $dt->formatPersianDatetime(); // 1395/12/10 23:46:09
return $dt->formatPersianDate(); // 1395/12/10

// set default format
Verta::setStringformat('Y/n/j H:i:s');
return new Verta(); // 1395/12/12 00:11:35

// reset default format
Verta::resetStringFormat();
return new Verta(); // 1395-12-12 00:18:04

// change english number to persian
$dt = Verta::parse('1396-10-07 14:12:32');
return Verta::persianNumbers($dt); // ۱۳۹۶-۱۰-۰۷ ۱۴:۱۲:۳۲
```
For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

---
#### Differences
```php
// get a diffrent time with now
$dt = Verta::parse('1395-10-07 14:12:32');
return $dt->diffNow(); // 2 ماه پیش

$dt = Verta::parse('1395/12/12 14:13:50');
return $dt->diffNow(); // 5 ثانیه بعد
```

---
#### Transformations
```php
// get jalali a gregorian date
return Verta::getJalali(2015,12,25); // [1394,10,4]

// get gregorian a jalali date
return Verta::getGregorian(1394,10,4); // [2015,12,25]

// export to datetime object
$dt = Verta::parse('1395/01/05 23:50:25');
$dt = $v->DateTime();

// export to carbon object
$dt = Verta::parse('1395/01/05 23:50:25');
$c = Carbon::instance($v->DateTime());
```

---
#### Comparisons
```php
// is leap year 
echo Verta::isLeapYear(1394); // false
echo Verta::isLeapYear(1395); // true

// is valid date
echo Verta::isValideDate(1394, 12, 30); // false
echo Verta::isValideDate(1395, 12, 30); // true
```

---
## License ##
-  This package was created and modified by [Nasser Hekmati](https://github.com/hekmatinasser) for Laravel >= 5 and is released under the MIT License.
