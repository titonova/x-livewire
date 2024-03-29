
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

> ⚠️ Still in beta phase. Do not use in production environments (without testing) yet 
> Contributions are highly welcomed

# X-livewire

[![Latest Version on Packagist](https://img.shields.io/packagist/v/titonova/x-livewire.svg?style=flat-square)](https://packagist.org/packages/titonova/x-livewire)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/titonova/x-livewire/run-tests?label=tests)](https://github.com/titonova/x-livewire/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/titonova/x-livewire/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/titonova/x-livewire/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/titonova/x-livewire.svg?style=flat-square)](https://packagist.org/packages/titonova/x-livewire)

This package allows you to render livewire components like a blade component, giving it attributes, slots etc.

Assuming you wanted to create a livewire component, `alert`, usually you would render the component by: 
`<livewire:alert/>`. However, there a few problems. 
1. You can't allow slots within the component. That is, this is invalid: `<livewire:alert>Alert</livewire:alert>`.
2. You can't access the `$attributes` bag. Thus, can't access the  `$attributes` variable directly.
 That is, if you do this:  `<livewire:alert title="Alert!"/>`, you can't access the `$title` attribute by `$attributes->get('title')`. Instead, you'd have to make `$title` a public property in the component. Not to mention, other methods  on `$attributes` are not accessible. Such as `->merge([])`, `->whereStartsWith()`, etc.

The creator  of livewire, Caleb Porzio has made it clear that [adding slots, attributes etc are not currently on the roadmap](https://github.com/livewire/livewire/issues/68#issuecomment-599012420).

That's why I created X-livewire.

With X-Livewire, you can do:

        <x-livewire _="alert">
            My alert message
        </x-livewire>
And, just like with Blade, you can:
1. Access the `$attributes` variable:
        `{{ $attributes->get('title') }}`,
2. Access the `$slot` variable:
        `{{ $slot }}`
## Installation

You can install the package via composer:

    composer require titonova/x-livewire

## Usage

1. After creating your livewire component, make it extend `XLivewireBaseComponent` rather than `Component`.
ie: `class Alert extends XLivewireBaseComponent{`
2. If you want to access the `$attributes` bag in your x-livewire component's backend, add `$this->setProps()` as the first line in your component's `mount()` method.
3. In the view file of the component, e.g `alert.blade.php` add `@setUpXLivewire` to the top of the file.
4. When you want to render the component:
        ```Blade
        <x-livewire _="alert" title="Warning">
            My alert message
        </x-livewire>
        ```
-------------------------------------------------------------------------------------
You can access the `$slot` and `$attributes` variables just like you would in a Blade component:
    ```
    {{ $slot }}
    {{ $attributes->get('title') }}
    ```


You can also access the array of attributes that were passed to the x-livewire's component's tag but were not explicitedly declared in the class as 
`$tagAttributes` property. 
    ```
    {{ $tagAttributes->get('href') }}
    ```
    For example, attributes like `primary`, `lg` etc that don't need corresponding properties declarations in the class.
    E.g
    ```HTML
        <x-livewire _="link" href="https://google.com" primary>Google </x-livewire>
        ....

        <span>
        <a href="{{ $tagAttributes->get('href') }}>{{ $slot }}</a>
        </span>
    ```


You can add and access named slots as such:
```        <x-livewire _="alert" title="Warning">
            My alert message
            <x-slot name="footer">My custom footer </x-slot>
        </x-livewire>
        
        ....

        <div class="alert ...">
            {{ $slot }}
            <div class="alert-footer">
                {{ $footer ?? 'Default footer content' }}
            </div>
        </div>
```

If you want to access the slots directly as their ` Illuminate\View\ComponentSlot ` class, you can use the following:
 `$this->laravelSlots()['footer']`.
Which would return an instance of `Illuminate\View\ComponentSlot`.
E.g:
``` "footer" => Illuminate\View\ComponentSlot {#1385 ▼
    +attributes: Illuminate\View\ComponentAttributeBag {#1379 ▼
      #attributes: []
    }
    #contents: "<b>&lt;i&gt;hello!!!    &lt;/i&gt; </b>"
```
With available methods such as

```public __construct($contents = '', $attributes = array()): void Create a new slot instance.
public withAttributes(array $attributes): $this Set the extra attributes that the slot should make available.
public toHtml(): string Get the slot's HTML string.
public isEmpty(): bool Determine if the slot is empty.
public isNotEmpty(): bool Determine if the slot is not empty.
public __toString(): string Get the slot's HTML string.
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## TODO/Roadmap
[ ] Add Tests

[ ] Shorten tag declartion to `<x-livewire:alert>`

## Contributing

Please see [CONTRIBUTING](https://github.com/titonova/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tito](https://github.com/titonova)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
