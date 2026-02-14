---
sidebar_position: 2
---

# Custom Command

You can extend Ayuco with your own commands.

1. Create a command class (extend Ayuco's base if needed).
2. Register it in the `ayuco` file (between `// BEGIN - Custom commands` and `// END - Custom commands`):

```php
$ayuco->register(new MyCustomCommand());
```

3. Run with `php ayuco my:custom-command`.

See the [Ayuco repo](https://github.com/10quality/ayuco) for advanced extension guidelines.