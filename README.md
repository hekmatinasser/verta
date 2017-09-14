hekmatinasser/verta
======

Document [English](https://hekmatinasser.github.io/verta/)
[فارسی](https://www.parsclick.net/articles?subject=11&article=132)

- This package compatible with Laravel `>=5` & `< 6.0`

- Verta is a jalali calendar that was used in persian datetime

- Calendar conversion is based on the algorithm provided by Morteza Parvini, Vahid Sohrablou, Roozbeh Pournader and Mohammad Tou'si.

Run the Composer update comand

    $ composer require hekmatinasser/verta

In your `config/app.php` add `Hekmatinasser\Verta\VertaServiceProvider::class,` to the `providers` array and add `'Verta' => Hekmatinasser\Verta\Verta::class,` to the `alias` array.

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
use Verta;
```

#### Constructors
create object with datetime now
```php
$v = new Verta(); //1396-02-02 15:32:08
$v = verta(); //1396-02-02 15:32:08
$v = Verta::now(); //1396-02-02 15:32:08
$v = Verta::today(); //1396-03-02 00:00:00
$v = Verta::tomorrow(); // 1396-03-03 00:00:00
$v = Verta::yesterday(); // 1396-03-01 00:00:00
```

create object with pass string
```php
$v = new Verta('2016-12-27 14:12:32');
$v = Verta::instance('2016-12-25 11:12:36');
$v = Facades\Verta::instance('2016-12-25 11:12:36');
```

create object with timestamp
```php
$v = new Verta(1333857600);
```

create object with Datetime
```php
$dt = new \Datetime();
return new Verta($dt); // 1395-12-09 15:05:56
```

create object with Carbon
```php
$c = \Carbon::now();
return verta($c); // 1395-12-09 15:05:56
```

create object string persian datetime
```php
$v = Verta::parse('1395-10-07 14:12:32');
```

create object specific datetime
```php
// get Gregorian datetime
return Verta::create();  // 1395-12-14 11:17:01 equal now()
return Verta::create(2016,12,25,15,20,15);  // 1395-10-05 15:20:15
return Verta::createDate(2016,12,25); // 1395-10-05 21:35:49 set time now
return Verta::createTime(15,51,5); // 1396-02-31 15:51:05 set date now
return Verta::createTimestamp(1488614023); // 1395-12-14 11:23:43

// alias create functions
return Verta::createGregorian(2016,12,25,15,20,15);  // 1395-10-05 15:20:15
return Verta::createGregorianDate(2016,12,25); // 1395-10-05 21:35:49 set time now
return Verta::createGregorianTime(15,51,5); // 1396-02-31 15:51:05 set date now

// get Jalali datetime
return Verta::createJalali(1394,12,29,15,51,5);  // 1394-12-29 15:51:05
return Verta::createJalaliDate(1394,12,29); // 1394-12-29 11:18:29 set time now
return Verta::createJalaliTime(15,51,5); // 1395-12-14 15:51:05 set date now
```
---
#### Geter
get part of datetime
```php
$v = verta(); // 1396-03-14 14:18:23
return $v->year; // 1396
return $v->quarter // 1
return $v->month; // 3
return $v->day; // 14
return $v->hour; // 14
return $v->minute; // 18
return $v->second; // 23
return $v->micro; // 0
return $v->dayOfWeek; // 1
return $v->dayOfYear; // 107
return $v->weekOfYear; // 16
return $v->daysInMonth; // 31
return $v->timestamp; // 1496557661
return $v->timezone; // Asia/Tehran
```
---
#### Setter
set each part of the time
```php
$v = verta();
$v->year = 1395;
$v->month = 4; // set 13 for next year first month
$v->day = 25;
$v->hour = 16;
$v->minute = 50;
$v->second = 42;
$v->timestamp = 1496557661;
$v->timezone = 'Asia/Baku';
```
set each part of the time with method
```php
$v = $v->year(1395);
$v = $v->month(4); // set 13 for next year first month
$v = $v->day(25);
$v = $v->hour(16);
$v = $v->minute(50);
$v = $v->second(42);
$v = $v->timestamp(1496557661);
$v = $v->timezone('Asia/Baku');
```
set datetime together
```php
//
$v = $v->setDateTime(1395, 4, 25, 16, 50, 42);
$v = $v->setDateTime(1395, 4, 25, 16, 50, 42, 1569856);
$v = $v->setDate(1395, 4, 25);
$v = $v->setTimeString('12:25:48');
```
---
#### Isset
check set each part of time
```php
$v = verta();
echo isset($v->year); // true
echo isset($v->month); // true
echo empty($v->day); // false
echo empty($v->hour); // false
echo empty($v->minute); // false
echo empty($v->second); // false
echo isset($v->timestamp); // true
echo isset($v->timezone); // true
```
---
#### Formating
format with php standard 
```php
$v = verta();
return $v->format('Y-n-j H:i'); // 1395-10-7 14:12
return $v->format('%B %d، %Y'); // دی 07، 1395
return $v; //1395-10-07 14:12:32
```
use predefined format
```php
return $v->format('datetime'); // 1395-12-10 23:25:12
return $v->format('date'); // 1395-12-10
return $v->format('time'); // 23:26:35
```
use predefined format method
```php
return $v->formatDatetime(); // 1395-12-10 23:37:26
return $v->formatDate(); // 1395-12-10
return $v->formatTime(); // 23:26:35
return $v->formatJalaliDatetime(); // 1395/12/10 23:46:09
return $v->formatJalaliDate(); // 1395/12/10
```
get Gregorian format
```php
return $v->DateTime()->format('Y-m-d H:i:s'); // 2017-05-23 23:21:02
return $v->formatGregorian('Y-m-d H:i:s'); // 2017-05-23 23:21:02
```
set default format
```php
// set default format
Verta::setStringformat('Y/n/j H:i:s');
return verta(); // 1395/12/12 00:11:35

// reset default format
Verta::resetStringFormat();
return verta(); // 1395-12-12 00:18:04
```
difference format 
```php
return $v1->diffFormat($v2); // 12 ماه بعد
return $v1->diffFormat($v3); // 1 سال قبل
return $v1->addDays(25)->diffFormat(); // 4 هفته بعد compare with now
return $v1->subDays(6)->diffFormat(); // 6 روز قبل
```
change number
```php
$v = verta();
return Verta::persianNumbers($v); // ۱۳۹۶-۱۰-۰۷ ۱۴:۱۲:۳۲
```
For help in building your formats, checkout the [PHP strftime() docs](http://php.net/manual/en/function.strftime.php).

---
#### Modify
add and sub each part of datetime
```php
$v = verta();
return $v->addYear(); // 1396-10-07 14:12:32
return $v->addYears(4); // 1399-10-07 14:12:32
return $v->subYear(); // 1394-10-07 14:12:32
return $v->subYears(2); // 1393-10-07 14:12:32

return $v->addMonth(); // 1395-11-07 14:12:32
return $v->addMonths(5); // 1396-03-07 14:12:32
return $v->subMonth(); // 1395-09-07 14:12:32
return $v->subMonths(2); // 1395-08-07 14:12:32

return $v->addWeek(); // 1395-10-12 14:12:32
return $v->addWeeks(3); // 1395-10-26 14:12:32
return $v->subWeek(); // 1395-09-30 14:12:32
return $v->subWeeks(2); // 1395-09-27 14:12:32

return $v->addDay(); // 1395-10-08 14:12:32
return $v->addDays(3); // 1395-10-11 14:12:32
return $v->subDay(); // 1395-10-06 14:12:32
return $v->subDays(2); // 1395-09-05 14:12:32

return $v->addHour(); // 1395-10-07 15:12:32
return $v->addHours(5); // 1395-10-07 19:12:32
return $v->subHour(); // 1395-10-07 13:12:32
return $v->subHours(2); // 1395-10-07 12:12:32

return $v->addMinute(); // 1395-10-07 14:13:32
return $v->addMinutes(3); // 1395-10-07 14:15:32
return $v->subMinute(); // 1395-10-07 14:11:32
return $v->subMinutes(2); // 1395-10-07 14:10:32

return $v->addSecond(); // 1395-10-07 14:12:33
return $v->addSeconds(3); // 1395-10-07 14:12:35
return $v->subSecond(); // 1395-10-07 14:12:31
return $v->subSeconds(2); // 1395-10-07 14:12:30
```
change start or end each part of date
```php
$v = verta(); // 1396-04-29 14:25:48
return $v->startDay(); // 1396-04-29 00:00:00
return $v->endDay(); // 1396-04-29 23:59:59
return $v->startWeek(); // 1396 1396-04-24 00:00:00
return $v->endWeek(); // 1396-04-30 23:59:59
return $v->startMonth(); // 1396-04-01 00:00:00
return $v->endMonth(); // 1396-04-31 00:00:00
return $v->startQuarter(); // 1396-04-01 23:59:59
return $v->endQuarter(); // 1396-06-31 23:59:59
```
---
#### Comparisons
validation 
```php
echo Verta::isLeapYear(1394); // false
echo Verta::isValideDate(1394, 12, 30); // false
echo Verta::isValideTime(15, 12, 30); // true
```
difference objects together
```php
// diff objects together 
$v1 = verta(); // 1396-03-31 22:21:40
$v2 = verta('2017-06-21 01:21:40'); // 1396-03-31 01:21:40
$v3 = verta('2017-06-20'); // 1396-03-30 15:24:53

return $v1->diffYears($v3); // -1
return $v1->diffMonths($v2); // 11
return $v2->diffMonths(); // -11 compare with now
return $v1->diffWeeks($v2); // 51
return $v1->diffDays($v3); // -372
return $v3->diffMinutes(); // 536548
return $v3->diffMinutes(); // 536548
```
compare objects together
```php
echo $v1->eq($v2); // false equalTo()
echo $v1->ne($v2); // true notEqualTo()
echo $v1->gt($v2); // true greaterThan()
echo $v1->gte($v2); // true greaterThanOrEqualTo()
echo $v1->lt($v2); // false lessThan()
echo $v1->lte($v2); // false lessThanOrEqualTo()
echo $v1->between($v2, $v3); // false

echo $v1->closest($v2, $v3); // return $v2 object
echo $v1->farthest($v2, $v3); // return $v3 object
echo $v1->min($v2); // return $v2 object minimum()
echo $v1->max($v2); // return $v1 object maximum()
```
compare object with is 
```php
echo $v1->isWeekday(); // true
echo $v1->isWeekend(); // false
echo $v1->isYesterday(); // false
echo $v1->isToday(); // true
echo $v1->isTomorrow(); // false
echo $v1->isNextWeek(); // false
echo $v1->isLastWeek(); // false
echo $v1->isNextMonth(); // false
echo $v1->isLastMonth(); // false
echo $v1->isNextYear(); // false
echo $v1->isLastYear(); // false
echo $v1->isFuture(); // false
echo $v1->isPast(); // false
echo $v1->isPast(); // false

echo $v1->isCurrentYear(); // true
echo $v1->isSameAs('y', $v2); // true isSameYear()
echo $v1->isCurrentMonth(); // true
echo $v1->isSameMonth($v2); // true
echo $v1->isSameDay($v2); // true
echo $v1->isBirthday(); // true compare with today
echo $v1->isBirthday($v2); // true

echo $v1->isSaturday(); // false
echo $v1->isSunday(); // false
echo $v1->isMonday(); // false
echo $v1->isTuesday(); // false
echo $v1->isWednesday(); // false
echo $v1->isThursday(); // true
echo $v1->isFriday(); // false
```
---
#### Transformations
Gregorian to Jalali date
```php
return Verta::getJalali(2015,12,25); // [1394,10,4]
```
Jalali to Gregorian date
```php
return Verta::getGregorian(1394,10,4); // [2015,12,25]
```
Verta to Datatime PHP
```php
$v = verta();
$dt = $v->DateTime();
```
Verta to Carbon
```php
$c = Carbon::instance($v->DateTime());
```

---
## License ##
-  This package was created and modified by [Nasser Hekmati](https://github.com/hekmatinasser) for Laravel >= 5 and is released under the MIT License.
