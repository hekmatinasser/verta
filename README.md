[![Latest Stable Version](https://poser.pugx.org/hekmatinasser/verta/v/stable)](https://packagist.org/packages/hekmatinasser/verta)
[![Total Downloads](https://poser.pugx.org/hekmatinasser/verta/downloads)](https://packagist.org/packages/hekmatinasser/verta)
[![License](https://poser.pugx.org/hekmatinasser/verta/license)](https://packagist.org/packages/hekmatinasser/verta)

hekmatinasser/verta
======

 [official page](https://hekmatinasser.github.io/verta/) ,
[English](https://github.com/hekmatinasser/verta/blob/master/README.en.md) ,
[فارسی](https://github.com/hekmatinasser/verta/blob/master/README.md)

<div lang="fa" dir="rtl">
 
- ورتا پکیجی برای تبدیلات تاریخ شمسی و میلادی به یکدیگر و شامل توابع کمکی که کاربران به راحتی بتوانند تبدیلات تاریخ خود را انجام دهند
- زبان پی اچ پی دارای کلاسی برای تاریخ و زمان است که ورتا از همین کلاس ارث بری کرده است
- ورتا از الگوریتم تبدیل تاریخ شمسی به میلادی و بالعکس استفاده می کند. الگوریتم مبدل تاریخ بر اساس الگوریتم تاریخ جلالی وحید سهراب لو، روزبه پورنادر و محمد توسی می باشد
</div>


##  نصب 

برای نصب دستور زیر را وارد کنید

    $ composer require hekmatinasser/verta

حال باید پکیج را درون پروژه خود اضافه کنید برای این کار دستور زیر را وارد کنید

```php
// config/app.php
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
## نحوه استفاده 

### افزودن کلاس 
 در بالای هر فایل خود از کلاس ورتا استفاده میکند، از دستور زیر استفاده کنید
```php
use Verta;
// or
use Hekmatinasser\Verta\Verta;
```

### ایجاد کردن 
برای بدست آوردن تاریخ و زمان کنونی شمسی، از دستور زیر استفاده کنید
```php
$v = new Verta(); //1396-02-02 15:32:08
$v = verta(); //1396-02-02 15:32:08
```
برای بدست آوردن تاریخ و زمان به نسبت اکنون، از دستور زیر استفاده کنید
```php
$v = Verta::now(); //1396-02-02 15:32:08
$v = Verta::today(); //1396-03-02 00:00:00
$v = Verta::tomorrow(); // 1396-03-03 00:00:00
$v = Verta::yesterday(); // 1396-03-01 00:00:00
```

برای تبدیل تاریخ میلادی خود به شمسی، از دستور زیر استفاده کنید
```php
$v = new Verta('2016-12-27 14:12:32');
$v = Verta::instance('2016-12-25 11:12:36');
$v = Facades\Verta::instance('2016-12-25 11:12:36');
```

برای استفاده از عدد تایم استمپ به شمسی، از دستور زیر استفاده کنید
```php
$v = new Verta(1333857600);
```

برای استفاده از کلاس تاریخ و زمان پی اچ پی به شمسی، از دستور زیر استفاده کنید
```php
$dt = new \Datetime();
return new Verta($dt); // 1395-12-09 15:05:56
```

برای استفاده از کلاس کربن به شمسی، از دستور زیر استفاده کنید
```php
$c = \Carbon::now();
return verta($c); // 1395-12-09 15:05:56
```

برای استفاده از تاریخ شمسی به صورت رشته، از دستور زیر استفاده کنید
```php
$v = Verta::parse('1395-10-07 14:12:32');
$v = Verta::parse('1396 مهر 17'); 
$v =  Verta::parseFormat('Y n j','1396 مهر 17');
```

در صورتی مقادیر تاریخ میلادی به صورت جداگانه باشد، از دستورات زیر استفاده کنید
```php
return Verta::create();  // 1395-12-14 11:17:01 equal now()
return Verta::create(2016,12,25,15,20,15);  // 1395-10-05 15:20:15
return Verta::createDate(2016,12,25); // 1395-10-05 21:35:49 set time now
return Verta::createTime(15,51,5); // 1396-02-31 15:51:05 set date now
return Verta::createTimestamp(1488614023); // 1395-12-14 11:23:43
```

```php
// alias create functions
return Verta::createGregorian(2016,12,25,15,20,15);  // 1395-10-05 15:20:15
return Verta::createGregorianDate(2016,12,25); // 1395-10-05 21:35:49 set time now
return Verta::createGregorianTime(15,51,5); // 1396-02-31 15:51:05 set date now
```

در صورتی مقادیر تاریخ شمسی به صورت جداگانه باشد، از دستورات زیر استفاده کنید
```php
// get Jalali datetime
return Verta::createJalali(1394,12,29,15,51,5);  // 1394-12-29 15:51:05
return Verta::createJalaliDate(1394,12,29); // 1394-12-29 11:18:29 set time now
return Verta::createJalaliTime(15,51,5); // 1395-12-14 15:51:05 set date now
```
---
###  دریافت خصوصیات 
برای دریافت مقادیر خصوصیات، از دستورات زیر استفاده کنید
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
### مقدار دهی خصوصیات 
برای مقدار دهی خصوصیات، از دستورات زیر استفاده کنید
```php
$v = verta();
$v->year = 1395;
$v->month = 4; // عدد 13 برای ثبت سال آینده اولین ماه
$v->day = 25;
$v->hour = 16;
$v->minute = 50;
$v->second = 42;
$v->timestamp = 1496557661;
$v->timezone = 'Asia/Baku';
```
برای مقدار دهی خصوصیات با استفاده از تابع، از دستورات زیر استفاده کنید
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
برای مقدار دهی خصوصیات با یکدیگر، از دستورات زیر استفاده کنید
```php
//
$v = $v->setDateTime(1395, 4, 25, 16, 50, 42);
$v = $v->setDateTime(1395, 4, 25, 16, 50, 42, 1569856);
$v = $v->setDate(1395, 4, 25);
$v = $v->setTimeString('12:25:48');
```
---
### بررسی مقدار دهی 
برای بررسی وجود خصوصیات، از دستورات زیر استفاده کنید
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
### فرمت نمایش 
برای تعیین فرمت خروجی پیش فرض، از دستور زیر استفاده کنید
```php
Verta::setStringformat('Y/n/j H:i:s');
return verta(); // 1395/12/12 00:11:35
```
برای تنظیم مجددفرمت خروجی به حالت اولیه، از دستور زیر استفاده کنید
```php
Verta::resetStringFormat();
return verta(); // 1395-12-12 00:18:04
```
برای نمایش تاریخ به شمسی، از دستور زیر استفاده کنید
```php
$v = verta();
return $v->format('Y-n-j H:i'); // 1395-10-7 14:12
return $v->format('%B %d، %Y'); // دی 07، 1395
return $v; //1395-10-07 14:12:32
```
برای ساخت فرمت نمایش مورد نظر خود راهنمای پی اچ پی را مطالعه کنید

[strftime()](http://php.net/manual/en/function.strftime.php)
[date()](http://php.net/manual/en/function.date.php)


برای نمایش تاریخ با فرمت های متعارف، از دستور زیر استفاده کنید
```php
return $v->formatDatetime(); // 1395-12-10 23:37:26
return $v->formatDate(); // 1395-12-10
return $v->formatTime(); // 23:26:35
return $v->formatJalaliDatetime(); // 1395/12/10 23:46:09
return $v->formatJalaliDate(); // 1395/12/10
```
برای نمایش تاریخ به صورت میلادی، از دستور زیر استفاده کنید
```php
return $v->DateTime()->format('Y-m-d H:i:s'); // 2017-05-23 23:21:02
return $v->formatGregorian('Y-m-d H:i:s'); // 2017-05-23 23:21:02
```
برای نمایش اختلاف تاریخ به صورت واحد زمانی، از دستور زیر استفاده کنید
درصورتی که تاریخ را وارد نکنید، اختلاف با زمان کنونی محاسبه می شود.
```php
return $v1->formatDifference($v2); // 12 ماه بعد
return $v1->formatDifference($v3); // 1 سال قبل
return $v1->addDays(25)->formatDifference(); // 4 هفته بعد
return $v1->subDays(6)->formatDifference(); // 6 روز قبل
return verta()->formatDifference(); // الان
```
برای نمایش اعداد به صورت حروف، از دستور زیر استفاده کنید
```php
return $v->formatWord('Y'); // یک هزار و سیصد و نود و شش
return $v->formatWord('l dS F'); // چهارشنبه بیست و نه ام شهریور
return $v->formatWord('d F Y'); // بیست و نه شهریور یک هزار و سیصد و نود و شش
return $v->formatWord('r'); // چهارشنبه یک هزار و سیصد و نود و شش, شش, بیست و نه, بیست و دو:چهل و نه:سی و هشت +04:30
return $v->formatWord('d F ') . $v->year; // بیست و نه شهریور 1396
``` 
برای تبدیل اعداد به فارسی، از دستور زیر استفاده کنید
```php
return Verta::persianNumbers($v); // ۱۳۹۶-۱۰-۰۷ ۱۴:۱۲:۳۲
```


---
###  تغییر دادن 
برای اضافه یا کم کردن از تاریخ خود، از دستور زیر استفاده کنید
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
برای بدست آوردن تاریخ شروع و پایان هر بازه زمانی، از دستور زیر استفاده کنید
```php
$v = verta(); // 1396-04-29 14:25:48
return $v->startDay(); // 1396-04-29 00:00:00
return $v->endDay(); // 1396-04-29 23:59:59
return $v->startWeek(); // 1396 1396-04-24 00:00:00
return $v->endWeek(); // 1396-04-30 23:59:59
return $v->startMonth(); // 1396-04-01 00:00:00
return $v->endMonth(); // 1396-04-31 00:00:00
return $v->startQuarter(); // 1396-04-01 00:00:00
return $v->endQuarter(); // 1396-06-31 23:59:59
return $v->startYear(); // 1396-01-01 00:00:00
return $v->endYear(); // 1396-12-29 23:59:59
```
---
#### بررسی 
برای اعتبار سنجی تاریخ، از دستور زیر استفاده کنید
```php
echo Verta::isLeapYear(1394); // false
echo Verta::isValideDate(1394, 12, 30); // false
echo Verta::isValideTime(15, 12, 30); // true
```
برای محاسبه اختلاف تاریخ ها با یکدیگر، از دستور زیر استفاده کنید
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
return $v3->diffSeconds(); // 12261931
```
برای مقایسه تاریخ ها با یکدیگر، از دستور زیر استفاده کنید
```php
echo $v1->eq(); // ture alias equalTo()
echo $v1->ne($v2); // true alias notEqualTo()
echo $v1->gt($v2); // true alias greaterThan()
echo $v1->gte($v2); // true alias greaterThanOrEqualTo()
echo $v1->lt($v2); // false alias lessThan()
echo $v1->lte($v2); // false alias lessThanOrEqualTo()
echo $v1->between($v2, $v3); // false
```
برای بررسی تاریخ از لحاظ نزدیکتر یا دورتر بودن و یا کوچکتر و بزرگتر بودن، از دستور زیر استفاده کنید
```php
echo $v1->closest($v2, $v3); // return $v2 object
echo $v1->farthest($v2, $v3); // return $v3 object
echo $v1->minimum($v2); // return $v2
echo $v1->min($v2); // return $v2
echo $v1->maximum($v2); // return $v1
echo $v1->max($v2); // return $v1
```
برای بررسی تاریخ با تاریخ فعلی، از دستور زیر استفاده کنید
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
##### اعتبار سنجی 
شما می توانید از کلاس اعتبار سنجی لاراول در ورتا استفاده کنید
 
###### تعریف پیام های خطا 

شما باید پیام های خطا برای اعتبار سنجی خود در در مسیر فایل های ترجمه خود اضافه کنید
برای نمونه کد هایی که درون پکیج برای پیام خطا وجود دارد در فایل ترجمه خود قرار دهید
برای مثال در فایل ترجمه پیام خطا به آرایه عبارات زیر را اضافه کنید
```php
    'jdate' => ':attribute' . ' تاریخ شمسی معتبر نمی باشد.',
    'jdate_equal' => ':attribute' . ' تاریخ شمسی برابر ' . ':fa-date' . ' نمی باشد.',
    'jdate_not_equal' => ':attribute' . ' تاریخ شمسی نامساوی ' . ':fa-date' . ' نمی باشد.',
    'jdatetime' => ':attribute' . ' تاریخ و زمان شمسی معتبر نمی باشد.',
    'jdatetime_equal' => ':attribute' . ' تاریخ و زمان شمسی مساوی ' . ':fa-date' . ' نمی باشد.',
    'jdatetime_not_equal' => ':attribute' . ' تاریخ و زمان شمسی نامساوی ' . ':fa-date' . ' نمی باشد.',
    'jdate_after' => ':attribute' . ' تاریخ شمسی باید بعد از ' . ':fa-date' . ' باشد.',
    'jdate_after_equal' => ':attribute' . ' تاریخ شمسی باید بعد یا برابر از ' . ':fa-date' . ' باشد.',
    'jdatetime_after' => ':attribute' . ' تاریخ و زمان شمسی باید بعد از ' . ':fa-date' . ' باشد.',
    'jdatetime_after_equal' => ':attribute' . ' تاریخ و زمان شمسی باید بعد یا برابر از ' . ':fa-date' . ' باشد.',
    'jdate_before' => ':attribute' . ' تاریخ شمسی باید قبل از ' . ':fa-date' . ' باشد.',
    'jdate_before_equal' => ':attribute' . ' تاریخ شمسی باید قبل یا برابر از ' . ':fa-date' . ' باشد.',
    'jdatetime_before' => ':attribute' . ' تاریخ و زمان شمسی باید قبل از ' . ':fa-date' . ' باشد.',
    'jdatetime_before_equal' => ':attribute' . ' تاریخ و زمان شمسی باید قبل یا برابر از ' . ':fa-date' . ' باشد.',
    
'attributes' => [
    'start_date' => 'تاریخ شروع',
    'expire_datetime' => 'تاریخ انقضا',
],
```
###### شرط های اعتبار سنجی 
jdate[:Y/m/d]

اگر تاریخ شمسی با فرمت معین درست باشد

فرمت پیش فرض می باشد  Y/m/d

jdate_equal[[:1388/01/01],Y/m/d]

اگر تاریخ شمسی با فرمت معین مساوی باشد

فرمت پیش فرض می باشد  Y/m/d


jdate_not_equal[[:1388/01/01],Y/m/d]

اگر تاریخ شمسی با فرمت معین نامساوی باشد

فرمت پیش فرض می باشد  Y/m/d


jdatetime[:Y/m/d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین درست باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s

jdatetime_equal[:Y/m/d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین مساوی باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s


jdatetime_not_equal[[:1380/1/1 12:00:00],Y/m/d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین درست باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s

jdate_after[[:1388/01/01],Y/m/d]

اگر تاریخ شمسی با فرمت معین درست باشد و بعد از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید بعد از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d

jdate_after_equal[[:1388/01/01],Y/m/d]

اگر تاریخ شمسی با فرمت معین درست باشد و بعد یا مساوی از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید بعد از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d

jdatetime_after[[:1380/1/1 12:00:00],Y/m/d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین درست باشد و بعد از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید بعد از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s

jdatetime_after_equal[[:1380/1/1 12:00:00],Y/m/d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین درست باشد و بعد یا مساوی از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید بعد از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s

jdate_before[[:1395-01-01],Y-m-d]

اگر تاریخ شمسی با فرمت معین درست باشد و قبل از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید قبل از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d

jdate_before_equal[[:1395-01-01],Y-m-d]

اگر تاریخ شمسی با فرمت معین درست باشد و قبل یا مساوی از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید قبل از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d

jdatetime_before[[:1395-01-01 12:00:00],Y-m-d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین درست باشد و قبل از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید قبل از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s

jdatetime_before_equal[[:1395-01-01 12:00:00],Y-m-d H:i:s]

اگر تاریخ و زمان شمسی با فرمت معین درست باشد و قبل یا مساوی از تاریخ تعیین شده باشد

درصورتی که تاریخ وارد کنید قبل از تاریخ فعلی باشد باشد

فرمت پیش فرض می باشد  Y/m/d H:i:s

```php
$validate = Validator::make([
        'start_date' => '1389/01/31',
        'expire_datetime' => '1397/02/16 12:10:00',
    ],
    [
        'start_date' => 'required|jdate:Y/m/d|jdate_after:1388/01/01,Y/m/d|jdate_before:1390/01/01',
        'expire_datetime' => 'required|jdatetime|jdatetime_after:1397/02/16 12:09:50,Y/m/d H:i:s|jdatetime_before:1397/02/16 12:11:00',
    ]);

    if ($validate->fails()) {
        dd($validate->messages()->toArray());
    }
    
    //output
array:2 [
  "start_date" => array:1 [
    0 => "تاریخ شروع تاریخ شمسی باید قبل از ۱۳۹۰/۰۱/۰۱ باشد."
  ]
  "expire_datetime" => array:1 [
    0 => "تاریخ انقضا تاریخ و زمان شمسی باید قبل از ۱۳۹۷/۰۲/۱۶ ۱۲:۱۰:۰۰ باشد."
  ]
]

```
---
#### تبدیلات 
برای تبدیل از شمسی به میلادی به صورت ساده، از دستور زیر استفاده کنید
```php
return Verta::getJalali(2015,12,25); // [1394,10,4]
```
برای تبدیل از میلادی به شمسی به صورت ساده، از دستور زیر استفاده کنید
```php
return Verta::getGregorian(1394,10,4); // [2015,12,25]
```
برای تبدیل تاریخ از ورتا به تاریخ و زمان پی اچ پی، از دستور زیر استفاده کنید
```php
$v = verta();
$dt = $v->DateTime();
```
برای تبدیل تاریخ از ورتا به کربن، از دستور زیر استفاده کنید
```php
$c = Carbon::instance($v->DateTime());
```

---
## License ##
-  این پکیج توسط [ناصر حکمتی](https://github.com/hekmatinasser) تحت مجوز 
ام ای تی
 منتشر شده است.
