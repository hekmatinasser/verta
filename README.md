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
<a href="https://hekmatinasser.github.io/verta">Document</a>
</p>

<p align="center">The Verta is package for change solar calendar and gregorian together and provide helper function to use date and time.</p>
<p align="center">Verta extend class PHP Datetime and Jalali, compatible with Carbon Package.</p>


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
- [Modification](#modification)
- [Boundaries](#boundaries)
- [Compression](#compression)
  - [Difference](#difference)
  - [Difference for Humans](#difference-for-humans)
- [Validation](#validation)
- [Localization](#localization)
- [Validation Request](#validation-request)
- [Licence](#licence)
- [Contributors](#contributors)

## Installations

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
        <td>8.x</td>
    </tr>
    <tr>
        <td>9.0</td>
        <td>8.x</td>
    </tr>
    </tbody>
</table>

## Usage
<p>use verta datetime jalali</p>

```php
echo verta(); //1401-05-24 00:00:00
```

### Gregorian to Jalali
<p>change gregorian to jalali and reverse</p>

```php
echo verta('2022-08-15'); //1401-05-24 00:00:00
```

### jalali to Gregorian
<p>change jalali to gregorian and reverse</p>

```php
echo Verta::parse('1401-05-24 14:12:32')->datetime(); //2022-08-15 00:00:00
```

### Carbon to Jalali
<p>change carbon to jalali and reverse</p>

```php
echo now()->toJalali(); //1401-05-24 00:00:00
```

### Jalali to Carbon
<p>change jalali to gregorian and reverse</p>

```php
echo verta()->toCarbon(); //2022-08-15 00:00:00
```

<h2>Property</h2>
<p>access part of jalali datetime</p>

```php
$v = verta(); // 1396-03-14 14:18:23
echo $v->year; // 1396
...
```

<h2>Formation</h2>
<p>show datetime variant datetime</p>

```php
echo verta('-13 month')->formatDifference(); // 1 سال قبل
echo verta()->formatWord('l dS F'); // دوشنبه بیست و چهارم مرداد
...
```

<h2>Modification</h2>
<p>manipulate jalali datetime</p>

```php
echo verta()->addWeeks(3); 
...
```

<h2>Boundaries</h2>
<p>get boundary jalali datetime</p>

```php
echo verta()->startWeek(3); 
...
```

<h2>Difference</h2>
<p>calculate diff two jalali datetime</p>

```php
echo verta('+13 day')->diffMonths('2022-08-15'); 
...
```

<h2>Compression</h2>
<p>get boundary jalali datetime</p>

```php
echo verta('+2 day')->gte('2022-08-15'); 
...
```


<h2>Validation Request</h2>
<p>validation input form</p>

```php
'birthday' => ['required', 'jdate_before_equal']
...
```
## Licence

This package has been created by Nasser Hekmati under the license of MIT.

## Contributors
Thanks to people who contributed for grow varta.

<a href="https://github.com/hekmatinasser/verta/graphs/contributors"><img src="https://opencollective.com/verta/contributors.svg?button=false" /></a>
