hekmatinasser/notowo
======
- This package compatible with Laravel `>=5` & `< 6.0`

- notowo is package for change number to word

Run the Composer update comand

    $ composer require hekmatinasser/notowo

In your `config/app.php` add `Hekmatinasser\Notowo\NotowoServiceProvider::class,` to the end of the `providers` array and add `'Notowo' => Hekmatinasser\Notowo\Notowo::class,` to the end of the `alias` array.

```php
'providers' => [

    ...
    Hekmatinasser\Notowo\NotowoServiceProvider::class,

],

'alias' => [

    ...
    'Notowo' => Hekmatinasser\Notowo\Notowo::class,
]
```

<a name="basic-usage"></a>
## Basic Usage

### Notowo
You can use Notowo in project
```php
use Notowo;
```

#### Constructors
```php
return notowo('125000'); // one hundred and twenty and five thousand
return new Notowo('125000'); // one hundred and twenty and five thousand
return Notowo::parse(125000); // one hundred and twenty and five thousand

//max 39 digit
return notowo('653484112849950468404684114841147284520', 'fa');
ششصد و پنجاه و سه دسیلیون و چهارصد و هشتاد و چهار نونیلیون و صد و دوازده اکتریلیون و هشتصد و چهل و نه سپتریلیون و نهصد و پنجاه سکستریلیون و چهارصد و شصت و هشت کوینتریلیون و چهارصد و چهار کادریلیون و ششصد و هشتاد و چهار تریلیون و صد و چهارده بیلیون و هشتصد و چهل و یک میلیارد و صد و چهل و هفت میلیون و دویست و هشتاد و چهار هزار و پانصد و بیست
```
---
#### Localization
```php
return new Notowo('125000', 'fa'); // صد و بیست و پنج هزار
$w = notowo('125000');
return $w->setLang('fa'); // صد و بیست و پنج هزار
return $w->getLang(); // fa
return $w->resetLang(); // one hundred and twenty and five thousand
```

---
#### Currency
```php
$w = Notowo::parse(125000, 'fa');
return $w->currency(); // صد و بیست و پنج هزار ریال
return $w->currency('تومان');

return $w->setCurrency('تومان'); 
return $w->getCurrency(); // تومان
return $w->resetCurrency(); // صد و بیست و پنج هزار
```

---
## License ##
-  This package was created and modified by [Nasser Hekmati](https://github.com/hekmatinasser) for Laravel >= 5 and is released under the MIT License.
