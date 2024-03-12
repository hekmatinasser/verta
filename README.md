<p align="center">
<img src="https://raw.githubusercontent.com/hekmatinasser/verta/master/logo.png" alt="jalali">
</p>
<h1 align="center">hekmatinasser/verta</h1>
<p align="center">
<a href="https://packagist.org/packages/hekmatinasser/verta"><img src="https://poser.pugx.org/hekmatinasser/verta/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/hekmatinasser/verta"><img src="https://poser.pugx.org/hekmatinasser/verta/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hekmatinasser/verta"><img src="https://poser.pugx.org/hekmatinasser/verta/license" alt="License"></a>
</p>

<p align="center">
<a href="https://hekmatinasser.github.io/verta">English Document</a>
</p>

<p align="center">The Verta is package for change solar calendar and gregorian together and provide helper function to use date and time.</p>
<p align="center">Verta extend class PHP Datetime and Jalali, compatible with Carbon Package.</p>
<p align="center">This package has been created by Nasser Hekmati under the license of MIT.</p>


## Quick view
     
- [Installation](#installation)
- [Usage](#usage)
    - [Jalali to Gregorian](#jalali-to-gregorian)
    - [Gregorian to Jalali](#gregorian-to-jalali)
    - [Jalali to Carbon](#jalali-to-carbon)
    - [Carbon to Jalali](#carbon-to-jalali)
- [Getters](#getters)
- [Setters](#setters)
  - [Fluent Setters](#fluent-setters)
- [Formatting](#formatting)
  - [Common Formats](#common-formats)
  - [Difference for Humans](#difference-for-humans)
- [Modification](#modification)
- [Boundaries](#boundaries)
- [Compression](#compression)
  - [Difference](#difference)
- [Validation](#validation)
- [Localization](#localization)
- [Validation Request](#validation-request)
- [Licence](#licence)
- [Contributors](#contributors)

### Installation

```shell
composer require hekmatinasser/verta
```

<table>
    <thead>
    <tr>
        <th>Laravel Version</th>
        <th>Package Version</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>8.0</td>
        <td>8.0</td>
    </tr>
    <tr>
        <td>9.0</td>
        <td>8.2</td>
    </tr>
    <tr>
        <td>10.0</td>
        <td>8.3</td>
    </tr>
    <tr>
        <td>11.0</td>
        <td>8.4</td>
    </tr>
    </tbody>
</table>

### Usage
<p>use verta datetime jalali</p>

```php
echo verta(); //1401-05-24 00:00:00
```

#### Gregorian to Jalali
<p>change gregorian to jalali and reverse</p>

```php
echo verta('2022-08-15'); //1401-05-24 00:00:00
```

#### jalali to Gregorian
<p>change jalali to gregorian and reverse</p>

```php
echo Verta::parse('1401-05-24 14:12:32')->datetime(); //2022-08-15 00:00:00
```

#### Carbon to Jalali
<p>change carbon to jalali and reverse</p>

```php
echo now()->toJalali(); //1401-05-24 00:00:00
```

#### Jalali to Carbon
<p>change jalali to gregorian and reverse</p>

```php
echo verta()->toCarbon(); //2022-08-15 00:00:00
```
[view more function](https://hekmatinasser.github.io/verta/#instantiate)

### Getters
<p>access part of jalali datetime</p>

```php
$v = verta(); // 1396-03-14 14:18:23
echo $v->year; // 1396
```
[view more getter](https://hekmatinasser.github.io/verta/#getter)

### Setters
<p>set part of jalali datetime</p>

```php
$v = verta(); // 1396-03-14 14:18:23
echo $v->year = 1395;
```
[view more setter](https://hekmatinasser.github.io/verta/#setter)


#### Fluent Setters
<p>set multiple part of jalali datetime</p>

```php
$v = verta(); // 1396-03-14 14:18:23
echo $v->setTimeString('12:25:45');
```
[view more fluent setter](https://hekmatinasser.github.io/verta/#set_date_time)


### Formatting
<p>show datetime variant datetime</p>

```php
echo verta()->format('Y.m.d'); // 1401.05.24
echo verta()->formatWord('l dS F'); // دوشنبه بیست و چهارم مرداد
```
[view more format](https://hekmatinasser.github.io/verta/#formatting)


#### Common Formats
<p>show common datetime variant datetime</p>

```php
echo verta()->formatJalaliDatetime(); // output 1395/10/07 14:12:25
```
[view more common format](https://hekmatinasser.github.io/verta/#format_date_time)


### Difference for Humans
<p>show difference format readable humans</p>

```php
echo verta('-13 month')->formatDifference(); // 1 سال قبل
```
[view more format difference](https://hekmatinasser.github.io/verta/#format_difference)

### Modification
<p>manipulate jalali datetime</p>

```php
echo verta()->addWeeks(3); 
...
```
[view more modifications](https://hekmatinasser.github.io/verta/#modification)

### Boundaries
<p>get boundary jalali datetime</p>

```php
echo verta()->startWeek(3); 
```
[view more boundaries](https://hekmatinasser.github.io/verta/#boundaries)

### Compression
<p>get compression jalali datetime</p>

```php
echo verta('+2 day')->gte('2022-08-15');
```
[view more compression](https://hekmatinasser.github.io/verta/#comparison)


### Difference
<p>calculate difference two jalali datetime</p>

```php
echo verta('+13 day')->diffMonths('2022-08-15'); 
```
[view more differences](https://hekmatinasser.github.io/verta/#difference)

### Validation
<p>check datetime check is valid </p>

```php
echo Verta::isLeapYear(1394); // false
```
[view more validations](https://hekmatinasser.github.io/verta/#validation)


### Localization
<p>set language for formatting datetime</p>

```php
Verta::setLocale('ar');
```
[view more localizations](https://hekmatinasser.github.io/verta/#localization)


### Validation Request
<p>validation input form</p>

```php
'birthday' => ['required', 'jdate_before_equal']
```
[view more localizations](https://hekmatinasser.github.io/verta/#laravel_validation)


## Licence

This package has been created by Nasser Hekmati under the license of MIT.

## Contributors
Thanks to people who contributed for grow verta.

<a href="https://github.com/hekmatinasser/verta/graphs/contributors"><img src="https://opencollective.com/verta/contributors.svg?button=false" /></a>
