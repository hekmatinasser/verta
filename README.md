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


<h2>Installations</h2>

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

<h2>Transformation</h2>
<p>change jalali to gregorian and reverse</p>

```php
echo verta('2022-08-15'); //1401-05-24 00:00:00
echo Verta::parse('1395-10-07 14:12:32')
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

<h2>Diffrense</h2>
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

<p align="center">This package has been created by Nasser Hekmati under the license of MIT.</p>

