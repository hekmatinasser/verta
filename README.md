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
return Verta::today(); //1396-03-02 00:00:00
return Verta::tomorrow(); // 1396-03-03 00:00:00
return Verta::yesterday(); // 1396-03-01 00:00:00

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

// create from a specific date and time
return Verta::create();  // 1395-12-14 11:17:01 equal now()
return Verta::create(2016,12,25,15,20,15);  // 1395-10-05 15:20:15
return Verta::createDate(2016,12,25); // 1395-10-05 21:35:49 set time now
return Verta::createTime(15,51,5); // 1396-02-31 15:51:05 set date now
return Verta::createTimestamp(1488614023); // 1395-12-14 11:23:43

return Verta::createGregorian(2016,12,25,15,20,15);  // 1395-10-05 15:20:15
return Verta::createGregorianDate(2016,12,25); // 1395-10-05 21:35:49 set time now
return Verta::createGregorianTime(15,51,5); // 1396-02-31 15:51:05 set date now

return Verta::createJalali(1394,12,29,15,51,5);  // 1394-12-29 15:51:05
return Verta::createJalaliDate(1394,12,29); // 1394-12-29 11:18:29 set time now
return Verta::createJalaliTime(15,51,5); // 1395-12-14 15:51:05 set date now
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
return $dt->formatJalaliDatetime(); // 1395/12/10 23:46:09
return $dt->formatJalaliDate(); // 1395/12/10

// get gregorain datetime
return $dt->DateTime()->format('Y-m-d H:i:s'); // 2017-05-23 23:21:02
return $dt->formatGregorian('Y-m-d H:i:s'); // 2017-05-23 23:21:02

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
#### Calculation
```php
// add and sub unit datetime
$dt = Verta::parse('1395-10-07 14:12:32');
return $dt->addYear(); // 1396-10-07 14:12:32
return $dt->addYears(4); // 1399-10-07 14:12:32
return $dt->subYear(); // 1394-10-07 14:12:32
return $dt->subYears(2); // 1393-10-07 14:12:32

return $dt->addMonth(); // 1395-11-07 14:12:32
return $dt->addMonths(5); // 1396-03-07 14:12:32
return $dt->subMonth(); // 1395-09-07 14:12:32
return $dt->subMonths(2); // 1395-08-07 14:12:32

return $dt->addWeek(); // 1395-10-12 14:12:32
return $dt->addWeeks(3); // 1395-10-26 14:12:32
return $dt->subWeek(); // 1395-09-30 14:12:32
return $dt->subWeeks(2); // 1395-09-27 14:12:32

return $dt->addDay(); // 1395-10-08 14:12:32
return $dt->addDays(3); // 1395-10-11 14:12:32
return $dt->subDay(); // 1395-10-06 14:12:32
return $dt->subDays(2); // 1395-09-05 14:12:32

return $dt->addHour(); // 1395-10-07 15:12:32
return $dt->addHours(5); // 1395-10-07 19:12:32
return $dt->subHour(); // 1395-10-07 13:12:32
return $dt->subHours(2); // 1395-10-07 12:12:32

return $dt->addMinute(); // 1395-10-07 14:13:32
return $dt->addMinutes(3); // 1395-10-07 14:15:32
return $dt->subMinute(); // 1395-10-07 14:11:32
return $dt->subMinutes(2); // 1395-10-07 14:10:32

return $dt->addSecond(); // 1395-10-07 14:12:33
return $dt->addSeconds(3); // 1395-10-07 14:12:35
return $dt->subSecond(); // 1395-10-07 14:12:31
return $dt->subSeconds(2); // 1395-10-07 14:12:30

```

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

// is valid time
echo Verta::isValideTime(15, 62, 50); // false
echo Verta::isValideTime(15, 12, 30); // true
```

---
#### Exchange n2w
```php
// get word of number  
// max number size 39 digit
echo Verta::getWords('455000000000000000000000000000000000000'); // چهارصد و پنجاه و پنج دسیلیون
echo Verta::getWords('4550000'); // چهار میلیون و پانصد و پنجاه هزار
echo Verta::getWords('4550000', 'fa'); // چهار میلیون و پانصد و پنجاه هزار
echo Verta::getPersianWords('4550000'); // چهار میلیون و پانصد و پنجاه هزار
echo Verta::getWords('4550000', 'en'); // four million and five hundred and fifty thousand
echo Verta::getEnglishWords('4550000'); // four million and five hundred and fifty thousand

// add currency persian
echo Verta::getRial('4550000'); // چهار میلیون و پانصد و پنجاه هزار ریال
echo Verta::getToman('4550000'); // چهار میلیون و پانصد و پنجاه هزار تومان
```

---
## License ##
-  This package was created and modified by [Nasser Hekmati](https://github.com/hekmatinasser) for Laravel >= 5 and is released under the MIT License.
